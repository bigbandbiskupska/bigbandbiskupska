<?php

namespace App\AdminModule\Presenters;

use Nette\Forms\Container;
use Ublaboo\DataGrid\DataGrid;

abstract class DataGridBasePresenter extends BasePresenter
{
    public abstract function getColumns(Container $container);

    public abstract function hydrateDate($item);

    public abstract function getModel();

    public function createBasicGrid($name)
    {
        /**
         * @var DataGrid
         */
        $grid = new DataGrid($this, $name);

        $grid->setDataSource($this->getModel()->all());

        /**
         * Big inline editing
         */
        $grid->addInlineEdit()
            ->onControlAdd[] = [$this, 'getColumns'];

        $grid->addInlineAdd()
            ->onControlAdd[] = [$this, 'getColumns'];

        $grid->getInlineAdd()->onSubmit[] = [$this, 'onNewRecord'];

        $grid->getInlineEdit()->onSetDefaults[] = function ($container, $item) {
            $container->setDefaults($this->hydrateDate($item));
        };

        $grid->getInlineEdit()->onSubmit[] = [$this, 'onUpdateRecord'];


        $grid->addAction('delete', '', 'delete!')
            ->setIcon('trash')
            ->setTitle('Smazat')
            ->setClass('btn btn-xs btn-danger ajax')
            ->setConfirm('Opravdu chcete smazat koncert %s?', 'name');

        $grid->setItemsPerPageList([100, 200]);
        //$grid->setPagination(false);

        return $grid;
    }

    public function addGridItemDetail(DataGrid $grid, $template, $callback)
    {
        $grid->setItemsDetail($template);
        $grid->setItemsDetailForm($callback);
    }


    public function handleDelete($id)
    {
        $this->getModel()->delete($id);
        $this->flashMessage('Záznam byl smazán', 'success');
        $this->redrawControl('flashes');

        $this['examplesGrid']->setDataSource($this->getModel()->all());
        $this['examplesGrid']->redrawControl();
    }

    public function onNewRecord($values)
    {
        $this->getModel()->create($values);
        $this->flashMessage("Nový záznam byl přidán", 'success');
        $this->redrawControl('flashes');

        $this['examplesGrid']->setDataSource($this->getModel()->all());
        $this['examplesGrid']->redrawControl();
    }

    public function onUpdateRecord($id, $values)
    {
        $this->getModel()->update($id, $values);
        $this->flashMessage('Záznam byl upraven', 'success');
        $this->redrawControl('flashes');

        $this['examplesGrid']->setDataSource($this->getModel()->all());
        $this['examplesGrid']->redrawItem($id);
    }

    public function onPropertyChange($property)
    {
        $presenter = $this;
        return function ($id, $value) use ($presenter, $property) {
            $this->getModel()->update($id, [
                $property => $value,
            ]);
            $this->flashMessage('Záznam byl upraven na ' . $property . ' => ' . $value, 'success');
            $this->redrawControl('flashes');

            $presenter['examplesGrid']->setDataSource($this->getModel()->all());
            $presenter['examplesGrid']->redrawItem($id);
        };
    }
}
