<?php

namespace App\FrontModule\Presenters;

use Tulinkry;

class PhotosPresenter extends BasePresenter {

    public function actionDefault() {
        $this->template->concertGalleryId = "72157689366932494";
    }
}
