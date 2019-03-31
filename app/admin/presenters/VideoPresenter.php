<?php

namespace App\AdminModule\Presenters;

use App\Model\AdminSongsModel;
use App\Model\AdminVideosModel;
use Nette\Forms\Container;

class VideoPresenter extends DataGridBasePresenter
{


    /**
     * @var AdminVideosModel
     * @inject
     */
    public $videos;

    public function getModel()
    {
        return $this->videos;
    }

    public function getColumns(Container $container)
    {
        // inline add/edit
        $container->addText('name', '');
        $container->addText('link', '');
        $container->addText('url', '');
        $container->addText('date', '');
    }

    public function hydrateDate($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'link' => $item->link,
            'url' => $item->url,
            'date' => $item->date,
        ];
    }

    public function onNewRecord($values)
    {
        $values['hidden'] = true;
        $values['tags'] = json_encode([]);
        return parent::onNewRecord($values);
    }

    public function createComponentExamplesGrid($name)
    {
        /**
         * @var DataGrid
         */
        $grid = $this->createBasicGrid($name);
        $grid->setAutoSubmit(true);

        /**
         * Columns
         */
        $grid->addColumnNumber('id', 'Id');

        $grid->addColumnText('name', 'Jméno')
            ->setSortable()
            ->setEditableCallback($this->onPropertyChange('name'))
            ->addAttributes(['class' => 'text-center']);


        $grid->addColumnText('link', 'Odkaz')
            ->setEditableCallback($this->onPropertyChange('link'))
            ->setSortable();

        $grid->addColumnText('url', 'Video')
            ->setEditableCallback($this->onPropertyChange('url'))
            ->setSortable();

        $grid->addColumnText('date', 'Datum')
            ->setEditableCallback($this->onPropertyChange('date'))
            ->setSortable();

        $grid->addColumnStatus('hidden', 'Viditelnost')
            ->setSortable()
            ->addOption(0, 'Viditelné')
            ->setClass('btn-success')
            ->endOption()
            ->addOption(1, 'Schované')
            ->setClass('btn-danger')
            ->endOption()
            ->onChange[] = $this->onPropertyChange('hidden');

        /**
         * Filters
         */
        $grid->addFilterText('name', 'Filtrovat', ['name'])
            ->setPlaceholder('Hledej ...');
    }

}
