<?php

namespace App\Model;

class MemberModel extends VisibleBaseModel {

    private $sections;
    private $oldmembers;

    public function __construct() {
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
