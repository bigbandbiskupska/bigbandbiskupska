<?php
/**
 * Created by PhpStorm.
 * User: ktulinger
 * Date: 2019-03-23
 * Time: 14:52
 */

namespace App\Model;

use Nette\Application\BadRequestException;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use Nette\Database\Table\Selection;
use Nette\Reflection\ClassType;
use Nette\Utils\Strings;

class BaseModel
{
    /**
     * @var Context
     */
    protected $database;

    /**
     * @var string
     */
    protected $table;

    protected $defaultWhere = array();
    protected $defaultOrder = array();

    public function __construct(Context $database, $table = NULL)
    {
        $this->database = $database;
        $name = str_replace('Model', '', ClassType::from($this)->getShortName());
        $name = str_replace('Admin', '', $name);
        $name = str_replace('Visible', '', $name);
        $this->table = $table ?: Strings::lower($name);
    }

    public function all()
    {
        return $this->findRows()->fetchPairs('id');
    }

    public function create($parameters)
    {
        return $this->table()->insert($parameters);
    }

    public function update($id, $parameters)
    {
        if (($entity = $this->table()->get($id)) === false) {
            throw new BadRequestException("Neznámé $id pro {$this->table}");
        }
        $entity->update($parameters);
        return $entity;
    }

    public function delete($id)
    {
        if (($entity = $this->table()->get($id)) === false) {
            throw new BadRequestException("Neznámé $id pro {$this->table}");
        }
        $entity->delete();
    }

    public function find($id)
    {
        if (($entity = $this->table()->get($id)) === false) {
            throw new BadRequestException("Neznámé $id pro {$this->table}");
        }
        return $entity;
    }

    public function by($clauses = [], $orderBy = [])
    {
        return $this->findRows($clauses, $orderBy)->fetchPairs('id');
    }

    public function limit($limit = 10, $offset = 0, $by = array(), $order = array())
    {
        return $this->findRows($by, $order)->limit($limit, $offset)->fetchPairs('id');
    }

    public function count($by = array(), $order = array())
    {
        return $this->findRows($by, $order)->count();
    }

    /**
     * Get the active row of this table by a primary key.
     *
     * @param $id mixed the primary key
     * @return IRow the active row; or null if entity does not exist
     */
    public function entity($id)
    {
        return $this->table()->get($id) ?: null;
    }

    protected function findRows($clauses = array(), $orderBy = array())
    {
        $table = $this->table();
        foreach ($clauses as $column => $value) {
            $table->where("`{$column}` = ?", $value);
        }

        foreach ($orderBy as $column => $order) {
            $table->order($column . ' ' . $order);
        }

        return $this->applyDefaultOrder($table);
    }

    protected function table()
    {
        return $this->applyDefaultWhere($this->database->table($this->table));
    }

    protected function applyDefaultWhere(Selection $selection)
    {
        foreach ($this->defaultWhere as $column => $value) {
            $selection->where("`{$column}` = ?", $value);
        }

        return $selection;
    }

    protected function applyDefaultOrder(Selection $selection)
    {
        foreach ($this->defaultOrder as $column => $order) {
            $selection->order($column . ' ' . $order);
        }

        return $selection;
    }
}
