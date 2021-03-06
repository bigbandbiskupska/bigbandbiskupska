<?php

namespace App\AdminModule\Presenters;

use App\Model\AdminVideosModel;
use Nette\Http\Request;
use Nette\Utils\DateTime;
use Tulinkry\Components\Grid;

class VideoPresenter extends BasePresenter
{
    /**
     * @var AdminVideosModel
     * @inject
     */
    public $videos;

    /**
     * @var Request
     * @inject
     */
    public $httpRequest;


    public function createComponentGrid($name)
    {
        $grid = new Grid($this->httpRequest);

        $grid->setModel($this->videos)
            ->setFormFactory(function (\Tulinkry\Forms\Container $container) {
                $container->addText('name', 'Jméno');
                $container->addText('link', 'Odkaz');
                $container->addText('url', 'Url');
                $container->addDateTime('date', 'Datum')
                    ->setFormat('j. n. Y')
                    ->setDefaultValue(new DateTime());
                $container->addSelect('hidden', 'Viditelnost', [
                    0 => 'Viditelný',
                    1 => 'Schovaný'
                ]);
            })
            ->setConvertToValues(function ($video) {
                $video = (object)$video->toArray();
                $video->date = $video->date->format('j. n. Y');
                return (array)$video;
            });

        $grid->addTextColumn('id', '#');
        $grid->addTextColumn('name', 'Jméno')
            ->setSortable();
        $grid->addLinkColumn('link', 'Link')
            ->openInNewTab()
            ->setSortable();
        $grid->addLinkColumn('url', 'Url')
            ->openInNewTab()
            ->setSortable();
        $grid->addDateColumn('date', 'Datum')
            ->setFormat('j. n. Y')
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
            return $this->videos->update($id, [
                'hidden' => $value
            ]);
        })->setSortable();

        $grid->setEditable();
        $grid->setConfirmDelete('Opravdu chcete smazat tento záznam?');

        return $grid;
    }
}
