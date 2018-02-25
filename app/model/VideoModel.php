<?php

namespace App\Model;

use Tulinkry\Model\BaseModel;
use Nette\DateTime;

class VideoModel extends BaseModel
{

    protected $videos;

    public function __construct() {
        $this->videos = array_map(function($o) {
            return (object) $o;
        }, \Nette\Neon\Neon::decode(file_get_contents(__DIR__ . '/models/videos.neon')));
    }

    public function item ( $id ) {
        return isset( $this -> videos[ $id ] ) ? $this -> videos[ $id ] : NULL;
    }

    public function limit ( $limit = 10, $offset = 0, $by = array (), $order = array () ) {
        $limited = [ ];
        for ( $i = $offset; $i < $limit + $offset; $i ++ )
            if ( isset( $this -> videos[ $i ] ) )
                $limited [] = $this -> videos[ $i ];
        return $limited;
    }

    public function by ( $by = [ ], $order = [ ] ) {
        return $this -> all();
    }

    public function all () {
        return $this -> videos;
    }

}

;
