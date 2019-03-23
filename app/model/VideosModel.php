<?php

namespace App\Model;

class VideosModel extends VisibleBaseModel
{
    protected $defaultOrder = array(
        'name' => 'DESC'
    );
}
