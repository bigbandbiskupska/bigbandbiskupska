<?php

namespace App\AdminModule\Presenters;

use App\Model\AdminMembersModel;
use Nette\Forms\Container;
use Nette\Neon\Neon;
use Nette\Utils\Json;

class BandPresenter extends DataGridBasePresenter
{


    /**
     * @var AdminMembersModel
     * @inject
     */
    public $members;

    public function getModel()
    {
        return $this->members;
    }

    public function getColumns(Container $container)
    {
        // inline add/edit
        $container->addText('name', '');
        $container->addText('instrument', '');
        $container->addText('group', '');
    }

    public function hydrateDate($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'instrument' => $item->instrument,
            'group' => $item->group,
            'gender' => $item->gender,
            'active' => $item->active,
        ];
    }

    public function onNewRecord($values)
    {
        $values['hidden'] = true;
        $values['extra'] = json_encode((object) array());
        $values['photo_coords'] = json_encode(array());
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


        $grid->addColumnText('instrument', 'Instrument')
            ->setEditableCallback($this->onPropertyChange('instrument'))
            ->setSortable();

        $grid->addColumnText('group', 'Sekce')
            ->setEditableCallback($this->onPropertyChange('group'))
            ->setSortable();

        $grid->addColumnStatus('active', 'Aktivita')
            ->setSortable()
            ->addOption(1, 'Aktivní')
            ->setClass('btn-success')
            ->endOption()
            ->addOption(0, 'Neaktivní')
            ->setClass('btn-danger')
            ->endOption()
            ->onChange[] = $this->onPropertyChange('active');

        $grid->addColumnStatus('gender', 'Pohlaví')
            ->setSortable()
            ->addOption('male', 'Muž')
            ->setClass('btn-info')
            ->endOption()
            ->addOption('female', 'Žena')
            ->setClass('btn-info')
            ->endOption()
            ->onChange[] = $this->onPropertyChange('gender');

        $this->addGridItemDetail(
            $grid,
            __DIR__ . '/templates/Band/detail.latte',
            function (Container $container) use ($grid) {
                $container->addHidden('id');
                $container->addTextArea('description', 'Popis', 100, 10)
                    ->setAttribute('class', 'form-control');

                $container->addTextArea('extra', 'Extra info', 100, 10)
                    ->setAttribute('class', 'form-control');

                $container->addSubmit('save', 'Uložit')
                    ->setAttribute('class', 'ajax btn-primary form-control')
                    ->onClick[] = function ($button) use ($grid) {
                    $values = $button->getParent()->getValues();
                    $values->extra = Json::encode(Neon::decode($values->extra));
                    $this->onUpdateRecord($values->id, $values);
                };
            }
        );

        /**
         * Filters
         */
        $grid->addFilterText('name', 'Filtrovat', ['name', 'group'])
            ->setPlaceholder('Hledej ...');
    }

}
