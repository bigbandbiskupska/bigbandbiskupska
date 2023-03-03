<?php

namespace App\AdminModule\Presenters;

use App\Model\AdminConcertsModel;
use Nette\Http\Request;
use Nette\Utils\DateTime;
use Tulinkry\Components\Grid;

class ConcertPresenter extends BasePresenter
{

    /**
     * @var AdminConcertsModel
     * @inject
     */
    public $concerts;

    /**
     * @var Request
     * @inject
     */
    public $httpRequest;

    public function createComponentGrid($name)
    {
        $grid = new Grid($this->httpRequest);

        $grid->setModel($this->concerts)
            ->setFormFactory(function (\Tulinkry\Forms\Container $container) {
                $container->addText('name', 'Jméno');
                $container->addDateTime('start', 'Začátek')
                    ->setFormat('j. n. Y H:i')
                    ->setDefaultValue(new DateTime());
                //$container->addText('end', 'Konec');
                $container->addSelect('hidden', 'Viditelnost', [
                    0 => 'Viditelný',
                    1 => 'Schovaný'
                ]);

                $container->addText('place', 'Místo');
                $container->addText('address', 'Adresa');

                $container->addText('latitude', 'Latitude');
                $container->addText('longitude', 'Longitude');

                $container->addText('photo_id', 'Identifikátor fotky koncert');
                $container->addText('album_id', 'Identifikátor alba pro fotku koncertu')
                          ->setDefaultValue('72157689366932494');

                $container->addTextArea('description', 'Popis')
                    ->setAttribute('rows', 10);
            })
            ->setConvertToValues(function ($concert) {
                $concert = (object)$concert->toArray();
                $concert->start = $concert->start->format('j. n. Y H:i');
                return (array)$concert;
            });

        $grid->addTextColumn('id', '#');
        $grid->addTextColumn('name', 'Jméno')
            ->setSortable();
        $grid->addDateColumn('start', 'Datum')
            ->setFormat('j. n. Y H:i')
            ->setSortable();
        $grid->addTextColumn('place', 'Místo')
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
            return $this->concerts->update($id, [
                'hidden' => $value
            ]);
        })->setSortable();

        $grid->setEditable();
        $grid->setConfirmDelete('Opravdu chcete smazat tento záznam?');

        return $grid;
    }
}
