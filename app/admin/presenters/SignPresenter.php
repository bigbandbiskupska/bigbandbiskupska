<?php
/**
 * Created by PhpStorm.
 * User: ktulinger
 * Date: 2019-03-30
 * Time: 18:30
 */

namespace App\AdminModule\Presenters;

use App\AdminModule\Forms;
use App\FrontModule;

final class SignPresenter extends FrontModule\Presenters\BasePresenter
{
    /** @persistent */
    public $backlink = '';

    /** @var Forms\SignFormFactory */
    private $signInFactory;

    public function __construct(Forms\SignFormFactory $signInFactory)
    {
        $this->signInFactory = $signInFactory;
    }

    /**
     * Sign-in form factory.
     */
    protected function createComponentSignInForm()
    {
        return $this->signInFactory->create(function () {
            $this->restoreRequest($this->backlink);
            $this->redirect('Homepage:');
        });
    }

    public function actionOut()
    {
        $this->getUser()->logout();
        $this->redirect(':Front:Homepage:');
    }
}
