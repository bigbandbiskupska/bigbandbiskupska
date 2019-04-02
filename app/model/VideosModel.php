<?php

namespace App\Model;

class VideosModel extends BaseModel implements Hideable
{
    protected $defaultOrder = array(
        'name' => 'DESC'
    );
}
