<?php

namespace App;

use App\Model\ConcertsModel;
use App\Model\VisibleConcertsModel;
use Nette\Application\IRouter;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use Nette\Utils\Strings;

class RouterFactory
{

    /**
     * @var VisibleConcertsModel
     */
    private $concerts;

    public function __construct(VisibleConcertsModel $concerts)
    {
        $this->concerts = $concerts;
    }

    /**
     * @return IRouter
     */
    public function createRouter()
    {
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
                    Route::FILTER_IN => function ($params) {
                        if (isset($params['concert'])) {
                            /*
                             * We passed a concert directly as a route parameter, read/generate the slug from it to save db queries.
                             */
                            $params['id'] = $params['concert']->id;
                            $params['slug'] = isset($params['concert']->slug) ? $params['concert']->slug : Strings::webalize($params['concert']->name);
                            unset($params['concert']);
                            return $params;
                        }

                        if (isset($params['id']) && ($concert = $this->concerts->find($params['id'])) !== NULL) {
                            $params['slug'] = isset($concert->slug) ? $concert->slug : Strings::webalize($concert->name);
                        }

                        return $params;
                    },
                    Route::FILTER_OUT => function ($params) {
                        if (isset($params['concert'])) {
                            /*
                             * We passed a concert directly as a route parameter, read/generate the slug from it to save db queries.
                             */
                            $params['id'] = $params['concert']->id;
                            $params['slug'] = isset($params['concert']->slug) ? $params['concert']->slug : Strings::webalize($params['concert']->name);
                            unset($params['concert']);
                            return $params;
                        }

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

        $router[] = new Route('[<locale cs|en>/]sign', 'Admin:Sign:in');
        $router[] = new Route('[<locale cs|en>/][admin/]signout', 'Admin:Sign:out');
        $router[] = new Route('[<locale cs|en>/]admin/[home]', 'Admin:Homepage:default');
        $router[] = new Route('[<locale cs|en>/]admin/kapela', 'Admin:Band:default');
        $router[] = new Route('[<locale cs|en>/]admin/kontakt', 'Admin:Contact:default');
        $router[] = new Route('[<locale cs|en>/]admin/historie', 'Admin:History:default');
        $router[] = new Route('[<locale cs|en>/]admin/repertoar', 'Admin:Song:default');
        $router[] = new Route('[<locale cs|en>/]admin/videa', 'Admin:Video:default');
        $router[] = new Route('[<locale cs|en>/]admin/koncerty[/<paginator-page=1>]', 'Admin:Concert:default');
        #$router[] = new Route('<presenter>/<action>[/<id>]', 'Front:Homepage:default');
        return $router;
    }

}
