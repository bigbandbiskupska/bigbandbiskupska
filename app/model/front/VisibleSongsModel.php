<?php

namespace App\Model;

class VisibleSongsModel extends SongsModel
{
    protected $defaultWhere = array(
        'hidden' => false
    );
}
