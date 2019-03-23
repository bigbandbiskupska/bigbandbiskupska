<?php

namespace App\FrontModule\Presenters;

use Nette;
use App;

class HomepagePresenter extends BasePresenter {

    /**
     * @var App\Model\ConcertsModel
     * @inject
     */
    public $concerts;

    public function actionDefault() {
        $this->template->concerts = $this->concerts->newest(3, 0);
    }

}
