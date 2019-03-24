<?php

namespace App\FrontModule\Presenters;

use App;
use App\Model\ConcertsModel;

class HomepagePresenter extends BasePresenter
{

    /**
     * @var ConcertsModel
     * @inject
     */
    public $concerts;

    public function actionDefault()
    {
        $this->template->concerts = $this->concerts->newest(3, 0);
    }

}
