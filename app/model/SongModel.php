<?php

namespace App\Model;

use Nette\Utils\Strings;
use Tulinkry\Model\BaseModel;

class SongModel extends BaseModel
{

    private $songs;

    public function __construct() {
        $this->songs = array_map(function($o) {
            return (object) $o;
        }, \Nette\Neon\Neon::decode(file_get_contents(__DIR__ . '/models/songs.neon')));
    }

    public function all ( $order = [ ] ) {
        uasort( $this->songs, function($a, $b) {
            return Strings::toAscii( $a -> name ) > Strings::toAscii( $b -> name );
        } );
        return array_filter($this->songs, function($song) {
            return $song->visible;
        });
    }

    public function by ( $by = array (), $order = array () ) {
        $order = array_keys( $order )[ 0 ];
        uasort( $this->songs, function($a, $b) use ($order) {
            return Strings::toAscii( $a -> $order ) > Strings::toAscii( $b -> $order );
        } );
        return array_filter($this->songs, function($song) {
            return $song->visible;
        });
    }

}

;
