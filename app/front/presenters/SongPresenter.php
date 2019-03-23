<?php

namespace App\FrontModule\Presenters;

use App\Model\SongsModel;
use Tulinkry;
use Tulinkry\Poll\Control\FormPollControl;

class SongPresenter extends BasePresenter
{

    /**
     * @var SongsModel
     * @inject
     */
    public $songs;

    /**
     * @var Tulinkry\Poll\Services\NeonPollProvider
     * @inject
     */
    public $polls;

    public function actionDefault()
    {
        $this->template->songsByName = $this->songs->by([], ["name" => "ASC"]);
        $this->template->songsByInterpreter = $this->songs->by([], ["author" => "ASC"]);
    }

    protected function createComponentFormPollControl()
    {
        return (new FormPollControl($this->polls, 1));
    }

}
