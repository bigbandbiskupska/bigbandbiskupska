<?php

namespace App\AdminModule\Presenters;

use App\Model\AdminSongsModel;
use Nette\Http\Request;
use Nette\Utils\Json;
use Tulinkry\Components\Grid;

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
                $container->addText('tags', 'Žánry');
            })
            ->setConvertToValues(function ($song) {
                $song = (object)$song->toArray();
                $song->tags = implode(', ', Json::decode($song->tags, true));
                return (array)$song;
            })->setConvertFromValues(function ($values) {
                $values['tags'] = Json::encode(array_map(function ($e) {
                    return trim($e);
                }, explode(',', $values->tags)));
                return $values;
            });

        $grid->addTextColumn('id', '#');
        $grid->addTextColumn('name', 'Jméno')
            ->setSortable();
        $grid->addTextColumn('author', 'Interpret')
            ->setSortable();
        $grid->addLinkColumn('link', 'Odkaz')
            ->openInNewTab()
            ->setSortable();
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
        })->setSortable();

        $grid->setEditable();
        $grid->setConfirmDelete('Opravdu chcete smazat tento záznam?');

        return $grid;
    }
}
