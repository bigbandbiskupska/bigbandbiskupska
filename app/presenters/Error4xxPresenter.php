<?php

namespace App\Presenters;

use Nette;
use Tracy\Debugger;

class Error4xxPresenter extends \App\FrontModule\Presenters\BasePresenter
{

    public function startup () {
        parent::startup();
        if ( ! $this -> getRequest() -> isMethod( Nette\Application\Request::FORWARD ) ) {
            $this -> error();
        }
    }

    public function renderDefault ( Nette\Application\BadRequestException $exception ) {
        // load template 403.latte or 404.latte or ... 4xx.latte
        $file = __DIR__ . "/templates/Error/{$exception -> getCode()}.latte";
        Debugger::log(
            sprintf("%s '%s%s' -> 404 from '%s' (%s) at '%s'",
                $_SERVER['REQUEST_METHOD'],
                $_SERVER['HTTP_HOST'],
                $_SERVER['REQUEST_URI'],
                isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'uknown referer',
                isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'uknown agent',
                date('Y-n-d H:i:s', $_SERVER['REQUEST_TIME'])),
            Debugger::ERROR );
        $this -> template -> setFile( is_file( $file ) ? $file : __DIR__ . '/templates/Error/4xx.latte'  );
    }

}
