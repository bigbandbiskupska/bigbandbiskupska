<?php

namespace App\AdminModule\Components;

class TextColumn extends Column
{
    protected function fillTemplate()
    {
        $this->template->text = $this->entity[$this->key];
    }
}