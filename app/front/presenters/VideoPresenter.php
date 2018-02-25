<?php

namespace App\FrontModule\Presenters;

use Nette;
use App;

class VideoPresenter extends BasePresenter {

    /**
     * @var App\Model\VideoModel
     * @inject
     */
    public $videos;

    public function actionDefault() {
        $this->template->videos = $this->videos->by([], ["name" => "ASC"]);
    }

}
