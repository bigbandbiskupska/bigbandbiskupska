<?php

namespace App\FrontModule\Presenters;

use App;
use App\Model\ConcertsModel;
use App\Model\VisibleConcertsModel;

class HomepagePresenter extends BasePresenter
{

    /**
     * @var VisibleConcertsModel
     * @inject
     */
    public $concerts;

    public function actionDefault()
    {
        $this->template->concerts = $this->concerts->newest(3, 0);
    }

}
