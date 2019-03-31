<?php

namespace App\AdminModule\Presenters;

abstract class BasePresenter extends \App\FrontModule\Presenters\BasePresenter
{
    public function startup()
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in', ['backlink' => $this->storeRequest()]);
        }
    }
}
