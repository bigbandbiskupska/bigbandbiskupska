<?php
/**
 * Created by PhpStorm.
 * User: ktulinger
 * Date: 2019-03-31
 * Time: 14:54
 */

namespace App\AdminModule\Components;


use App\Model\BaseModel;
use Nette\Application\UI\Multiplier;
use Nette\Http\Request;
use Tulinkry\Application\UI\Control;
use Tulinkry\Forms\Form;


class Grid extends Control
{
    /**
     * @var Request
     */
    private $httpRequest;

    /**
     * @var BaseModel
     */
    private $model;

    /**
     * @var callable
     */
    private $formFactory;

    public $columns = array();
    public $editable;
    public $confirmDelete = '';

    protected $fromValues;
    protected $toValues;

    /**
     * Grid constructor.
     * @param Request $httpRequest
     */
    public function __construct(Request $httpRequest)
    {
        parent::__construct(null, null);
        $this->httpRequest = $httpRequest;
    }


    /**
     * @param BaseModel $model
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param Form $containerFactory
     */
    public function setFormFactory($containerFactory)
    {
        $this->formFactory = $containerFactory;
        return $this;
    }

    /**
     * @param mixed $fromValues
     */
    public function setConvertFromValues($fromValues)
    {
        $this->fromValues = $fromValues;
        return $this;
    }

    /**
     * @param mixed $toValues
     */
    public function setConvertToValues($toValues)
    {
        $this->toValues = $toValues;
        return $this;
    }

    public function addTextColumn($key, $heading)
    {
        return $this->columns[$key] = new TextColumnFactory($key, $heading);
    }

    public function addDateColumn($key, $heading)
    {
        return $this->columns[$key] = new DateColumnFactory($key, $heading);
    }

    public function addSelectColumn($key, $heading, $options)
    {
        return $this->columns[$key] = new SelectColumnFactory($key, $heading, $options);
    }

    public function addLinkColumn($key, $heading)
    {
        return $this->columns[$key] = new LinkColumnFactory($key, $heading);
    }

    public function createComponentGridRow($name)
    {
        return $this[$name] = new Multiplier(function ($id) {
            $control = new GridRow($this->model->entity($id), $this);
            return $control;
        });
    }

    public function createComponentUpdate($name)
    {
        $id = $this->httpRequest->getUrl()->getQueryParameter(GridDetailUpdate::QUERY_PARAM);
        return $this[$name] = new GridDetailUpdate($this->model->entity($id), $this->model, $this->formFactory, $this->toValues, $this->fromValues);
    }

    public function createComponentInsert($name)
    {
        return $this[$name] = new GridDetailInsert($this->model, $this->formFactory, $this->toValues, $this->fromValues);
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/templates/grid.latte');

        $id = $this->httpRequest->getUrl()->getQueryParameter(GridDetailUpdate::QUERY_PARAM);
        $isInsert = $this->httpRequest->getUrl()->getQueryParameter(GridDetailInsert::QUERY_PARAM);
        $this->template->renderUpdate = $id !== null;
        $this->template->renderInsert = !!$isInsert;
        $this->template->columns = $this->columns;
        $this->template->entities = $this->model->all();
        $this->template->grid = $this;
        $this->template->render();
    }

    /**
     * @param mixed $editable
     */
    public function setEditable($editable = true)
    {
        $this->editable = $editable;
        return $this;
    }

    /**
     * @param string $confirmDelete
     */
    public function setConfirmDelete($confirmDelete = 'Are you sure you want to delete this item?')
    {
        $this->confirmDelete = $confirmDelete;
        return $this;
    }
}