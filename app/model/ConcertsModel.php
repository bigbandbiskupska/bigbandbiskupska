<?php

namespace App\Model;

use Nette\Utils\DateTime;
use Nette\Utils\Strings;

class ConcertsModel extends BaseModel implements Hideable
{
    protected $defaultOrder = array(
        'start' => 'DESC',
        'end' => 'DESC',
    );

    public function newest($limit, $offset = 0)
    {
        return $this->applyDefaultOrder(
            $this->table()
                ->where('start > ?', new DateTime)
                ->order('start ASC')
                ->limit($limit, $offset)
        )->fetchPairs('id');
    }

    public function groupByMonth($limit, $offset = 0, $by = array(), $order = array())
    {
        $myconcerts = $this->limit($limit, $offset, $by, $order);
        $concerts = array();
        $actuals = array();
        $previous = null;
        foreach ($myconcerts as $key => $concert) {
            if (!$previous) {
                $actuals [] = $previous = $concert;
                continue;
            }

            if ($previous->start->format('Y:n') !== $concert->start->format('Y:n')) {
                if ($actuals && count($actuals)) {
                    $concerts [] = $actuals;
                }
                $actuals = array();
            }
            $actuals [] = $concert;
            $previous = $concert;
        }
        if ($actuals && count($actuals)) {
            $concerts [] = $actuals;
        }
        return $concerts;
    }

    public function findBySlug($slug)
    {
        foreach ($this->all() as $id => $concert) {
            if (isset($concert->slug) && $concert->slug === $slug)
                return $concert;
            if (Strings::webalize($concert->name) === $slug)
                return $concert;
        }
    }

}
