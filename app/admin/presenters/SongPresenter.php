<?php

namespace App\AdminModule\Presenters;

use App\Model\AdminSongsModel;
use Nette\Forms\Container;

class SongPresenter extends DataGridBasePresenter
{


    /**
     * @var AdminSongsModel
     * @inject
     */
    public $songs;

    public function getModel()
    {
        return $this->songs;
    }

    public function getColumns(Container $container)
    {
        // inline add/edit
        $container->addText('name', '');
        $container->addText('author', '');
        $container->addText('link', '');
    }

    public function hydrateDate($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'author' => $item->author,
            'link' => $item->link,
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


        $grid->addColumnText('author', 'Autor')
            ->setEditableCallback($this->onPropertyChange('author'))
            ->setSortable();

        $grid->addColumnText('link', 'Odkaz')
            ->setEditableCallback($this->onPropertyChange('link'))
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
        $grid->addFilterText('name', 'Filtrovat', ['name', 'author'])
            ->setPlaceholder('Hledej ...');
    }

}
