<?php

namespace App\FrontModule\Presenters;

use App\Model\SongModel;
use Tulinkry;
use Tulinkry\Poll\Control\FormPollControl;

class SongPresenter extends BasePresenter {

    /**
     * @var SongModel
     * @inject
     */
    public $songs;

    /**
     * @var Tulinkry\Poll\Services\NeonPollProvider
     * @inject
     */
    public $polls;

    public function actionDefault() {
        $this->template->songsByName = $this->songs->by([], ["name" => "ASC"]);
        $this->template->songsByInterpreter = $this->songs->by([], ["interpreter" => "ASC"]);
    }

    protected function createComponentFormPollControl() {
        return (new FormPollControl($this->polls, 1));
    }

}
