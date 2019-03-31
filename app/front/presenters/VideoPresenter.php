<?php

namespace App\FrontModule\Presenters;

use App;
use App\Model\VideosModel;
use App\Model\AdminVideosModel;
use App\Model\VisibleVideosModel;

class VideoPresenter extends BasePresenter
{

    /**
     * @var VisibleVideosModel
     * @inject
     */
    public $videos;

    public function actionDefault()
    {
        $this->template->videos = $this->videos->by([], ["name" => "DESC"]);
    }

}
