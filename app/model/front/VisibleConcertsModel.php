<?php

namespace App\Model;

class VisibleConcertsModel extends ConcertsModel
{
    protected $defaultWhere = array(
        'hidden' => false
    );
}
