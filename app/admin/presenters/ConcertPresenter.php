<?php

namespace App\AdminModule\Presenters;

use App\Model\AdminConcertsModel;
use Nette\Forms\Container;
use Ublaboo\DataGrid\DataGrid;

class ConcertPresenter extends DataGridBasePresenter
{

    /**
     * @var AdminConcertsModel
     * @inject
     */
    public $concerts;

    public function getModel()
    {
        return $this->concerts;
    }

    public function getColumns(Container $container)
    {
        // inline add/edit
        $container->addText('name', '');
        $container->addText('start', '');
        $container->addText('place', '');
    }

    public function hydrateDate($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'start' => $item->start->format('j. n. Y H:i'),
            'place' => $item->place,
        ];
    }

    public function onNewRecord($values)
    {
        $values['description'] = '';
        $values['latitude'] = 0;
        $values['longitude'] = 0;
        $values['address'] = $values['place'];
        $values['hidden'] = true;
        return parent::onNewRecord($values);
    }

    public function createComponentExamplesGrid($name)
    {
        /**
         * @var DataGrid
         */
        $grid = $this->createBasicGrid($name);

        /**
         * Columns
         */
        $grid->addColumnNumber('id', 'Id');

        $grid->addColumnText('name', 'Jméno')
            ->setSortable()
            ->setEditableCallback($this->onPropertyChange('name'))
            ->addAttributes(['class' => 'text-center']);


        $grid->addColumnText('start', 'Datum')
            ->setEditableCallback($this->onPropertyChange('start'))
            ->setSortable();

        $grid->addColumnText('place', 'Místo')
            ->setEditableCallback($this->onPropertyChange('place'))
            ->setSortable();

        $grid->addColumnStatus('hidden', 'Viditelnost')
            ->addOption(0, 'Viditelné')
            ->setClass('btn-success')
            ->endOption()
            ->addOption(1, 'Schované')
            ->setClass('btn-danger')
            ->endOption()
            ->onChange[] = $this->onPropertyChange('hidden');

        $this->addGridItemDetail(
            $grid,
            __DIR__ . '/templates/Concert/detail.latte',
            function (Container $container) use ($grid) {
                $container->addHidden('id');

                $container->addText('place', 'Místo')
                    ->setAttribute('class', 'form-control');
                $container->addText('address', 'Adresa')
                    ->setAttribute('class', 'form-control');

                $container->addText('latitude', 'Latitude')
                    ->setAttribute('class', 'form-control');
                $container->addText('longitude', 'Longitude')
                    ->setAttribute('class', 'form-control');

                $container->addTextArea('description', 'Popis', 100, 10)
                    ->setAttribute('class', 'form-control');

                $container->addSubmit('save', 'Uložit')
                    ->setAttribute('class', 'ajax btn-primary form-control')
                    ->onClick[] = function ($button) use ($grid) {
                    $values = $button->getParent()->getValues();
                    $this->onUpdateRecord($values->id, $values);
                };
            }
        );

        /**
         * Filters
         */
        $grid->addFilterText('name', 'Filtrovat', ['name'])
            ->setPlaceholder('Hledej ...');
    }
}
