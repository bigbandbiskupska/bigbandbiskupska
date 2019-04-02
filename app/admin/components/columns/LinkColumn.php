<?php

namespace App\AdminModule\Components;

class LinkColumn extends TextColumn
{
    protected $openInNewTab;

    /**
     * DateColumn constructor.
     * @param $openInNewTab
     */
    public function __construct($entity, $key, $heading, $openInNewTab)
    {
        parent::__construct($entity, $key, $heading);
        $this->openInNewTab = $openInNewTab;
    }

    protected function fillTemplate()
    {
        parent::fillTemplate();
        $this->template->openInNewTab = $this->openInNewTab;
    }
}