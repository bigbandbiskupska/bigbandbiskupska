<?php

namespace App\AdminModule\Components;

class DateColumn extends Column
{
    protected $format;

    /**
     * DateColumn constructor.
     * @param $openInNewTab
     */
    public function __construct($entity, $key, $heading, $openInNewTab)
    {
        parent::__construct($entity, $key, $heading);
        $this->format = $openInNewTab;
    }

    protected function fillTemplate()
    {
        $this->template->date = $this->entity[$this->key];
        $this->template->format = $this->format;
    }
}