<?php

use Nette\Application\Request;
use Nette\DI\Container;
use Tester\Assert;
use Tester\DomQuery;
use Tester\TestCase;

$container = require __DIR__ . "/../../bootstrap.php";

class SongPresenterTest extends TestCaseWithDatabase
{
    /** @var Presenter */
    protected $presenter;

    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function setUp () {
        $factory = $this -> container -> getByType( 'Nette\Application\IPresenterFactory' );
        $this -> presenter = $factory -> createPresenter( 'Front:Song' );
        $this -> presenter -> autoCanonicalize = false;
    }

    public function testRender () {
        $request = new Request( 'Front:Song', 'GET', array () );
        $response = $this -> presenter -> run( $request );

        Assert::type( 'Nette\Application\Responses\TextResponse', $response );
        Assert::type( 'Nette\Bridges\ApplicationLatte\Template', $response -> getSource() );

        $html = (string) $response -> getSource();

        $dom = DomQuery::fromHtml( $html );

        Assert::true( $dom->has('#' + $this->presenter->translator->translate('front.presenters.song.default.hash.filter') ) );
        Assert::true( $dom->has('#' + $this->presenter->translator->translate('front.presenters.song.default.hash.songs')) );
        Assert::true( $dom->has('#' + $this->presenter->translator->translate('front.presenters.song.default.hash.author')) );
        Assert::true( $dom->has('#' + $this->presenter->translator->translate('front.layout.hash.top')) );
    }

}

# Spuštění testovacích metod
run( new SongPresenterTest( $container ) );
