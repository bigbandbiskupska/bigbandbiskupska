<?php

namespace App\Model;

use Tulinkry\Model\BaseModel;

class MemberModel extends BaseModel {

    private $sections;
    private $oldmembers;

    public function __construct() {

        $lorem = ""; /* "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident, sunt in culpa qui officia deserunt mollit anim id est laborum."; */

        $members = \Nette\Neon\Neon::decode(file_get_contents(__DIR__ . '/models/members.neon'));

        $this->sections = array_map(function($o) {
            return array_map(function($o) {
                return (object) $o;
            }, $o);
        }, $members['sections']);
        $this->oldmembers = array_map(function($o) {
            return (object) $o;
        }, $members['oldmembers']);
    }

    public function item($id) {
        return isset($this->sections[$id]) ? $this->sections[$id] : NULL;
    }

    public function limit($limit = 10, $offset = 0, $by = array(), $order = array()) {
        $limited = [];
        for ($i = $offset; $i < $limit + $offset; $i ++)
            if (isset($this->sections[$i]))
                $limited [] = $this->sections[$i];
        return $limited;
    }

    public function all() {
        return $this->sections;
    }

    public function by($by = array(), $order = array()) {
        if (isset($by["old"]) && $by["old"] === true)
            return $this->oldmembers;
        return [];
    }

}

;
