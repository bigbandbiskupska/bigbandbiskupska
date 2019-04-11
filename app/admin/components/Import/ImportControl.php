<?php
/**
 * Created by PhpStorm.
 * User: ktulinger
 * Date: 2019-04-09
 * Time: 10:50
 */

namespace App\AdminModule\Components;


use App\AdminModule\Components\Import\Forms\ImportFormStep1Factory;
use App\AdminModule\Components\Import\Forms\ImportFormStep2Factory;
use App\Model\AdminSongsModel;
use Nette\Application\UI\Control;
use Nette\Http\Session;
use Nette\Http\SessionSection;

class ImportControl extends Control
{
    const SESSION_SECTION = ImportControl::class;

    /**
     * @var AdminSongsModel
     */
    protected $songs;

    /**
     * @var ImportFormStep1Factory
     */
    protected $step1Factory;

    /**
     * @var ImportFormStep2Factory
     */
    protected $step2Factory;

    /**
     * @var SessionSection
     */
    protected $session;

    /**
     * Create the import control for the songs model and http session.
     *
     * @param Session $session http session
     * @param AdminSongsModel $songs song model
     */
    public function __construct(Session $session, AdminSongsModel $songs)
    {
        parent::__construct();
        $this->songs = $songs;
        $this->step1Factory = new ImportFormStep1Factory();
        $this->step2Factory = new ImportFormStep2Factory($songs);
        $this->session = $session->getSection(self::SESSION_SECTION)->setExpiration('+15 minutes');
    }

    public function createComponentStep1($name)
    {
        return $this[$name] = $this->step1Factory->create(function ($data) {
            $this->session->data = $data;
        });
    }

    public function createComponentStep2($name)
    {
        $form = $this->step2Factory->create($this->session->data ?: [], function ($song) {
            $this->songs->create(array_merge(
                (array)$song,
                [
                    'hidden' => true,
                    'tags' => '',
                ]
            ));
        });

        $form->onSuccess[] = function () {
            $this->session->remove();
        };

        return $this[$name] = $form;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/templates/import.latte');
        $this->template->step = $this->getCurrentStep();
        $this->template->render();
    }

    private function getCurrentStep()
    {
        if (!isset($this->session->data) || $this->session->data === null) {
            return 1;
        }

        if ($this['step1']->success || ($this['step2']->submitted && !$this['step2']->success)) {
            return 2;
        }

        return 1;
    }
}