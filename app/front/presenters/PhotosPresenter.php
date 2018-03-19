<?php

namespace App\FrontModule\Presenters;

use Tulinkry;

class PhotosPresenter extends BasePresenter {

    public function actionDefault() {
        $this->template->concertGalleryId = isset($this->parameters->params['flickr']['concertAlbum']) ? $this->parameters->params['flickr']['concertAlbum'] : 'invalidId';
        $this->template->flickrUser = isset($this->parameters->params['flickr']['user']) ? $this->parameters->params['flickr']['user'] : 'invalidUser';
        $this->template->flickrApiKey = isset($this->parameters->params['flickr']['APIkey']) ? $this->parameters->params['flickr']['APIkey'] : 'invalidKey';
    }
}
