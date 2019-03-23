<?php

namespace App\Model;

class SongsModel extends VisibleBaseModel
{
    protected $defaultOrder = array(
        'name' => 'DESC'
    );
}
