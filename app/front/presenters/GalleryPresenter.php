<?php

namespace App\FrontModule\Presenters;

class GalleryPresenter extends BasePresenter {

    public function beforeRender() {
        $this->template->flickrUser = isset($this->parameters->params['flickr']['user']) ? $this->parameters->params['flickr']['user'] : 'invalidUser';
        $this->template->flickrApiKey = isset($this->parameters->params['flickr']['APIkey']) ? $this->parameters->params['flickr']['APIkey'] : 'invalidKey';
    }

    public function actionDetail($id) {
        //if ( ( $gallery = $this -> galleries -> item ( $id ) ) == NULL )
        //    $this -> notFoundException ();
        //$images = $this -> galleries -> images ( $gallery );

        $this->template->gallery = (object) ["id" => $id];
        //$this -> template -> images = $images;
    }

    public function handleLogError($id) {
        $this->notFoundException("Error handling " . $id);
    }

}
