<?php

use Nette\Application\Request;
use Nette\DI\Container;
use Tester\Assert;
use Tester\DomQuery;

$container = require __DIR__ . "/../../bootstrap.php";

class ContactPresenterTest extends TestCaseWithDatabase
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
        $this->presenter = $factory->createPresenter('Front:Contact');
        $this->presenter->autoCanonicalize = false;
    }

    public function testRender()
    {
        $request = new Request('Front:Contact', 'GET', array());
        $response = $this->presenter->run($request);

        Assert::type('Nette\Application\Responses\TextResponse', $response);
        Assert::type('Nette\Bridges\ApplicationLatte\Template', $response->getSource());

        $html = (string)$response->getSource();

        $dom = DomQuery::fromHtml($html);

        Assert::true($dom->has('#' + $this->presenter->translator->translate('front.presenters.contact.default.hash.contact')));
        Assert::true($dom->has('#' + $this->presenter->translator->translate('front.layout.hash.top')));
    }

}

# Spuštění testovacích metod
run(new ContactPresenterTest($container));
