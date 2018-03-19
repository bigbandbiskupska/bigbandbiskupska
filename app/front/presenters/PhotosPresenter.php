<?php

namespace App\FrontModule\Presenters;

use Tulinkry;

class PhotosPresenter extends BasePresenter {

    public function actionDefault() {
        $this->template->concertGalleryId = isset($this->parameters->params['flickr']['concertAlbum']) ? $this->parameters->params['flickr']['concertAlbum'] : 'invalidId';
    }
}
