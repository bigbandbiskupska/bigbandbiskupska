<?php

namespace App\Model;

class VisibleVideosModel extends VideosModel
{
    protected $defaultWhere = array(
        'hidden' => false
    );
}
