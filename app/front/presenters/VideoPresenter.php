<?php

namespace App\FrontModule\Presenters;

use App;
use App\Model\VideosModel;

class VideoPresenter extends BasePresenter
{

    /**
     * @var VideosModel
     * @inject
     */
    public $videos;

    public function actionDefault()
    {
        $this->template->videos = $this->videos->by([], ["name" => "DESC"]);
    }

}
