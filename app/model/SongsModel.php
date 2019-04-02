<?php

namespace App\Model;

class SongsModel extends BaseModel implements Hideable
{
    protected $defaultOrder = array(
        'name' => 'ASC',
        'author' => 'ASC',
    );
}
