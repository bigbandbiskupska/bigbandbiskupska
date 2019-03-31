<?php

namespace App\AdminModule\Forms;

use Nette;
use Tulinkry\Application\UI\Form;
use Nette\Security\User;

class SignFormFactory extends Nette\Object
{
    /** @var User */
    private $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * @return Form
     */
    public function create($callback)
    {
        $form = new Form;
        $form->addText('username', 'Email:')
            ->setRequired('Prosím zadejte svůj email.');

        $form->addPassword('password', 'Heslo:')
            ->setRequired('Prosím zadejte své heslo.');

        $form->addCheckbox('remember', 'Zapamatovat si mě');

        $form->addSubmit('send', 'Přihlásit');

        $form->onSuccess[] = [$this, 'formSucceeded'];
        $form->onSuccess[] = $callback;
        return $form;
    }


    public function formSucceeded(Form $form, $values)
    {
        if ($values->remember) {
            $this->user->setExpiration('14 days', FALSE);
        } else {
            $this->user->setExpiration('20 minutes', TRUE);
        }

        try {
            $this->user->login($values->username, $values->password);
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError($e->getMessage());
        }
    }

}
