<?php

namespace App\AdminModule\Presenters;

use App\Model\AdminMembersModel;
use Nette\Http\Request;
use Nette\Neon\Neon;
use Nette\Utils\Json;
use Tulinkry\Components\Grid;

class BandPresenter extends BasePresenter
{
    /**
     * @var AdminMembersModel
     * @inject
     */
    public $members;

    /**
     * @var Request
     * @inject
     */
    public $httpRequest;

    public function createComponentGrid($name)
    {
        $grid = new Grid($this->httpRequest);

        $grid->setModel($this->members)
            ->setFormFactory(function (\Tulinkry\Forms\Container $container) {
                $container->addText('name', 'Jméno');
                $container->addText('instrument', 'Instrument');
                $container->addText('group', 'Sekce');
                $container->addSelect('active', 'Aktivita', [
                    0 => 'Neaktivní',
                    1 => 'Aktivní'
                ]);
                $container->addSelect('gender', 'Pohlaví', [
                    'male' => 'Muž',
                    'female' => 'Žena'
                ]);
                $container->addTextArea('description', 'Popis')
                    ->setAttribute('rows', 10);
                $container->addTextArea('extra', 'Extra')
                    ->setAttribute('rows', 10);
            })
            ->setConvertToValues(function ($member) {
                $member = (object)$member->toArray();
                $member->extra = Neon::encode(Json::decode($member->extra, true), Neon::BLOCK);
                return (array)$member;
            })->setConvertFromValues(function ($values) {
                $values['extra'] = Json::encode(Neon::decode($values->extra));
                return $values;
            });

        $grid->addTextColumn('id', '#');
        $grid->addTextColumn('name', 'Jméno');
        $grid->addTextColumn('instrument', 'Instrument');
        $grid->addTextColumn('group', 'Sekce');
        $grid->addSelectColumn('active', 'Aktivita', [
            1 => [
                'class' => 'btn-success',
                'label' => 'Aktivní',
            ],
            0 => [
                'class' => 'btn-danger',
                'label' => 'Neaktivní',
            ],
        ])
            ->setDataCallback(function ($id, $value) {
                $this->redrawControl('flashes');
                return $this->members->update($id, [
                    'active' => $value
                ]);
            });

        $grid->addSelectColumn('gender', 'Pohlaví', [
            'male' => [
                'class' => 'btn-info',
                'label' => 'Muž',
            ],
            'female' => [
                'class' => 'btn-info',
                'label' => 'Žena',
            ],
        ])->setDataCallback(function ($id, $value) {
            $this->redrawControl('flashes');
            return $this->members->update($id, [
                'gender' => $value
            ]);
        });

        $grid->setEditable();
        $grid->setConfirmDelete('Opravdu chcete smazat tento záznam?');

        return $grid;
    }
}
