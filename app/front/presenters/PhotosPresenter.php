<?php

namespace App\FrontModule\Presenters;

use App\Model\VisibleConcertsModel;
use Nette\Utils\Json;

class PhotosPresenter extends BasePresenter
{

    /** @var VisibleConcertsModel @inject */
    public $concerts;

    public function actionDefault()
    {
        $this->template->concertGalleryId = isset($this->parameters->params['flickr']['concertAlbum']) ? $this->parameters->params['flickr']['concertAlbum'] : 'invalidId';
        $this->template->flickrUser = isset($this->parameters->params['flickr']['user']) ? $this->parameters->params['flickr']['user'] : 'invalidUser';
        $this->template->flickrApiKey = isset($this->parameters->params['flickr']['APIkey']) ? $this->parameters->params['flickr']['APIkey'] : 'invalidKey';

        // transform the concerts to array of photo => list of concerts
        $this->template->assignedPhotos = Json::encode(array_reduce(
            $this->concerts->all(),
            function ($acc, $concert) {
                if ($concert->photo_id === null) {
                    return $acc;
                }

                if (!isset($acc[$concert->photo_id])) {
                    $acc[$concert->photo_id] = [];
                }

                array_push($acc[$concert->photo_id], array_merge($concert->toArray(), ['link' => $this->link(':Front:Concert:detail', ['id' => $concert->id])]));
                return $acc;
            }, []));
    }
}
