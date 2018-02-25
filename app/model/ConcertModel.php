<?php

namespace App\Model;

use Nette\Utils\DateTime;
use Nette\Utils\Strings;
use Tulinkry\Model\BaseModel;

class ConcertModel extends BaseModel {

    const ALBUM_ID = "6297830325684432193";

    private $concerts;

    public function __construct() {
        $this->concerts = array_map(function($o) {
            return (object) $o;
        }, \Nette\Neon\Neon::decode(file_get_contents(__DIR__ . '/models/concerts.neon')));
    }

    public function item($id) {
        foreach ($this->concerts as $concert) {
            if ($id == $concert->id) {
                return $concert;
            }
        }
        return NULL;
    }

    public function limit($limit = 10, $offset = 0, $by = array(), $order = array()) {
        uasort($this->concerts, function($a, $b) {
            return $b->date->getTimestamp() - $a->date->getTimestamp();
        });

        $limited = [];
        $it = 0;
        foreach ($this->concerts as $key => $concert) {
            if ($it >= $offset && $it < $offset + $limit)
                $limited [] = $concert;
            $it ++;
        }
        return $limited;
    }

    public function count($by = array(), $order = array()) {
        return count($this->concerts);
    }

    public function all() {
        uasort($this->concerts, function($a, $b) {
            return $b->date->getTimestamp() - $a->date->getTimestamp();
        });
        return $this->concerts;
    }

    public function newest($limit, $offset = 0) {
        uasort($this->concerts, function($a, $b) {
            return $b->date->getTimestamp() - $a->date->getTimestamp();
        });

        $filtered = [];
        foreach ($this->concerts as $concert)
            if ($concert->date > new DateTime)
                array_unshift($filtered, $concert);

        $limited = [];
        for ($i = $offset; $i < $limit + $offset; $i ++)
            if (isset($filtered[$i]))
                $limited [] = $filtered[$i];
        return $limited;
    }

    public function groupByMonth($limit, $offset = 0, $by = array(), $order = array()) {
        $myconcerts = $this->limit($limit, $offset, $by, $order);
        $concerts = array();
        $actuals = array();
        $previous = null;
        foreach ($myconcerts as $key => $concert) {
            if (!$previous) {
                $actuals [] = $previous = $concert;
                continue;
            }

            if ($previous->date->format('Y:n') !== $concert->date->format('Y:n')) {
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

    public function findBySlug($slug) {
        foreach ($this->concerts as $concert) {
            if (isset($concert->slug) && $concert->slug === $slug)
                return $concert;
            if (Strings::webalize($concert->name) === $slug)
                return $concert;
        }
    }

}
