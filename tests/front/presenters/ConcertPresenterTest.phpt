<?php

use Nette\Application\Request;
use Nette\Application\UI\Presenter;
use Nette\DI\Container;
use Nette\Http\IResponse;
use Nette\Utils\Strings;
use Tester\Assert;
use Tester\DomQuery;

$container = require __DIR__ . "/../../bootstrap.php";

class ConcertPresenterTest extends TestCaseWithDatabase
{
    /** @var Presenter */
    protected $presenter;

    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function setUp()
    {
        $factory = $this->container->getByType('Nette\Application\IPresenterFactory');
        $this->presenter = $factory->createPresenter('Front:Concert');
        $this->presenter->autoCanonicalize = false;
    }

    public function testRender()
    {
        $request = new Request('Front:Concert', 'GET', array());
        $response = $this->presenter->run($request);

        Assert::type('Nette\Application\Responses\TextResponse', $response);
        Assert::type('Nette\Bridges\ApplicationLatte\Template', $response->getSource());

        $html = (string)$response->getSource();

        $dom = DomQuery::fromHtml($html);

        Assert::true($dom->has('#' + $this->presenter->translator->translate('front.presenters.concert.default.hash.concerts')));
        Assert::true($dom->has('#' + $this->presenter->translator->translate('front.layout.hash.top')));
    }

    public function testRedirectDetailBadSlug()
    {
        $request = new Request('Front:Concert', 'GET', array('action' => 'detail', 'id' => 1, 'slug' => 'bad_slug'));
        $response = $this->presenter->run($request);
        $concerts = $this->container->getService('concerts');

        Assert::notEqual(NULL, $concert = $concerts->find(1));

        Assert::type('Nette\Application\Responses\RedirectResponse', $response);
        Assert::equal(IResponse::S301_MOVED_PERMANENTLY, $response->code);

        $slug = isset($concert->slug) ? $concert->slug : Strings::webalize($concert->name);
        Assert::contains($slug, $response->url);
    }


    public function testRedirectDetailNoSlug()
    {
        $request = new Request('Front:Concert', 'GET', array('action' => 'detail', 'id' => 1));
        $response = $this->presenter->run($request);
        $concerts = $this->container->getService('concerts');

        Assert::notEqual(NULL, $concert = $concerts->find(1));

        Assert::type('Nette\Application\Responses\RedirectResponse', $response);
        Assert::equal(IResponse::S301_MOVED_PERMANENTLY, $response->code);

        $slug = isset($concert->slug) ? $concert->slug : Strings::webalize($concert->name);
        Assert::contains($slug, $response->url);
    }

    public function testRenderDetail()
    {
        $concerts = $this->container->getService('concerts');
        Assert::notEqual(NULL, $concert = $concerts->find(1));
        $slug = isset($concert->slug) ? $concert->slug : Strings::webalize($concert->name);

        $request = new Request('Front:Concert', 'GET', array('action' => 'detail', 'id' => 1, 'slug' => $slug));
        $response = $this->presenter->run($request);

        Assert::type('Nette\Application\Responses\TextResponse', $response);
        Assert::type('Nette\Bridges\ApplicationLatte\Template', $response->getSource());

        $html = (string)$response->getSource();
        $dom = DomQuery::fromHtml($html);

        Assert::true($dom->has('#' . $slug));
        Assert::true($dom->has('#' + $this->presenter->translator->translate('front.layout.hash.top')));
    }
}

# Spuštění testovacích metod
run(new ConcertPresenterTest($container));
