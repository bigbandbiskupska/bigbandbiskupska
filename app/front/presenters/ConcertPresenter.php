<?php

namespace App\FrontModule\Presenters;

use App\Model\ConcertModel;

class ConcertPresenter extends BasePresenter
{

    /**
     * @var ConcertModel
     * @inject
     */
    public $concerts;

    public function actionDefault () {
        $paginator = $this -> getPaginator();
        $paginator -> itemCount = $this -> concerts -> count( [ "visible" => true ], [ "start" => "DESC", "end" => "DESC" ] );
        $this -> template -> concerts = $this -> concerts -> groupByMonth($paginator -> itemsPerPage, $paginator -> offset, [ "visible" => true ], [ "start" => "DESC", "end" => "DESC" ]);
        if ( $this -> isAjax() ) {
            $this -> invalidateControl( "concerts" );
        }
    }

    public function actionDetail ( $id ) {
        if ( isset ( $this -> parameters -> params['google']['maps']['APIkey'] ) )
            $this -> template -> APIkey = $this -> parameters -> params['google']['maps']['APIkey'];
        else
            $this -> template -> APIkey = NULL;
        if ( ! $this -> template -> concert = $this -> concerts -> item ( $id ) )
            $this -> notFoundException ( "Trying to access detail of concert with id ".$id );
    }

}
