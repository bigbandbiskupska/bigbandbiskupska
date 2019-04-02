<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Grid;
use App\Model\AdminSongsModel;
use Nette\Http\Request;

class SongPresenter extends BasePresenter
{
    /**
     * @var AdminSongsModel
     * @inject
     */
    public $songs;


    /**
     * @var Request
     * @inject
     */
    public $httpRequest;


    public function createComponentGrid($name)
    {
        $grid = new Grid($this->httpRequest);

        $grid->setModel($this->songs)
            ->setFormFactory(function (\Tulinkry\Forms\Container $container) {
                $container->addText('name', 'Jméno');
                $container->addText('author', 'Interpret');
                $container->addText('link', 'Odkaz');
                $container->addSelect('hidden', 'Viditelnost', [
                    0 => 'Viditelný',
                    1 => 'Schovaný'
                ]);
            });

        $grid->addTextColumn('id', '#');
        $grid->addTextColumn('name', 'Jméno');
        $grid->addTextColumn('author', 'Interpret');
        $grid->addLinkColumn('link', 'Odkaz')
            ->openInNewTab();
        $grid->addSelectColumn('hidden', 'Viditelnost', [
            0 => [
                'class' => 'btn-success',
                'label' => 'Viditelný',
            ],
            1 => [
                'class' => 'btn-danger',
                'label' => 'Schovaný',
            ],
        ])->setDataCallback(function ($id, $value) {
            $this->redrawControl('flashes');
            return $this->songs->update($id, [
                'hidden' => $value
            ]);
        });

        $grid->setEditable();
        $grid->setConfirmDelete('Opravdu chcete smazat tento záznam?');

        return $grid;
    }
}
