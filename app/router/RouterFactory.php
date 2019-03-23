<?php

namespace App;

use Nette\Application\IRouter;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use Nette\Utils\Strings;
use App\Model\ConcertsModel;

class RouterFactory {

    /**
     * @var ConcertsModel
     */
    private $concerts;

    public function __construct(ConcertsModel $concerts) {
        $this->concerts = $concerts;
    }

    /**
     * @return IRouter
     */
    public function createRouter() {
        $router = new RouteList;

        $router[] = new Route('[<locale cs|en>/][home]', 'Front:Homepage:default');
        $router[] = new Route('[<locale cs|en>/]kapela', 'Front:Band:default');
        $router[] = new Route('[<locale cs|en>/]kontakt', 'Front:Contact:default');
        $router[] = new Route('[<locale cs|en>/]historie', 'Front:History:default');
        $router[] = new Route('[<locale cs|en>/]repertoar', 'Front:Song:default');
        $router[] = new Route('[<locale cs|en>/]videa', 'Front:Video:default');
        $router[] = new Route('[<locale cs|en>/]koncerty[/<paginator-page=1>]', 'Front:Concert:default');
        $router[] = new Route('[<locale cs|en>/]koncert/<id>[/<slug>]', array(
            'module' => 'Front',
            'presenter' => 'Concert',
            'action' => 'detail',
            NULL => array(
                Route::FILTER_IN => function($params) {
                    if (isset($params['id']) && ($concert = $this->concerts->find($params['id'])) !== NULL) {
                        $params['slug'] = isset($concert->slug) ? $concert->slug : Strings::webalize($concert->name);
                    }
                    return $params;
                },
                Route::FILTER_OUT => function($params) {
                    if (isset($params['id']) && ($concert = $this->concerts->find($params['id'])) !== NULL) {
                        $params['slug'] = isset($concert->slug) ? $concert->slug : Strings::webalize($concert->name);
                    }
                    return $params;
                }
            ))
        );
        $router[] = new Route('[<locale=cs cs|en>/]galerie', 'Front:Gallery:default');
        $router[] = new Route('[<locale=cs cs|en>/]galerie/<id>', 'Front:Gallery:detail');

        $router[] = new Route('[<locale=cs cs|en>/]photos', 'Front:Photos:default');

        #$router[] = new Route('<presenter>/<action>[/<id>]', 'Front:Homepage:default');
        return $router;
    }

}
