<?php

namespace App\FrontModule\Presenters;

use App\Model\ConcertsModel;
use App\Model\VisibleConcertsModel;
use Nette\Http\IResponse;
use Nette\Utils\Strings;

class ConcertPresenter extends BasePresenter
{

    /**
     * @var VisibleConcertsModel
     * @inject
     */
    public $concerts;

    public function actionDefault()
    {
        $paginator = $this->getPaginator();
        $paginator->itemCount = $this->concerts->count();
        $this->template->concerts = $this->concerts->groupByMonth($paginator->itemsPerPage, $paginator->offset);
        if ($this->isAjax()) {
            $this->invalidateControl("concerts");
        }
    }

    public function actionDetail($id, $slug)
    {
        if (isset($this->parameters->params['google']['maps']['APIkey']))
            $this->template->APIkey = $this->parameters->params['google']['maps']['APIkey'];
        else
            $this->template->APIkey = NULL;

        if (!$this->template->concert = $this->concerts->find($id)) {
            $this->notFoundException("Trying to access detail of concert with id " . $id);
        }

        if (isset($this->template->concert->slug) && $this->template->concert->slug !== $slug) {
            $this->redirect(IResponse::S301_MOVED_PERMANENTLY, 'this', array(
                'id' => $this->template->concert->id,
                'slug' => $this->template->concert->slug));
        }

        if (Strings::webalize($this->template->concert->name) !== $slug) {
            $this->redirect(IResponse::S301_MOVED_PERMANENTLY, 'this', array(
                'id' => $this->template->concert->id,
                'slug' => Strings::webalize($this->template->concert->name)));
        }
    }

}
