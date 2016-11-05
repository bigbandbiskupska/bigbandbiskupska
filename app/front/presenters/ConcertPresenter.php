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
        if ( ! $this -> template -> concert = $this -> concerts -> item ( $id ) )
            $this -> presenter -> redirect ( "Concert:default" );
    }

}
