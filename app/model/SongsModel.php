<?php

namespace App\Model;

class SongModel extends VisibleBaseModel
{
    protected $defaultOrder = array(
        'name' => 'DESC'
    );
}
