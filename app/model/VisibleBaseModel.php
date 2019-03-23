<?php
/**
 * Created by PhpStorm.
 * User: ktulinger
 * Date: 2019-03-23
 * Time: 14:52
 */

namespace App\Model;

class VisibleBaseModel extends BaseModel
{
    protected $defaultWhere = array(
        'hidden' => false
    );
}
