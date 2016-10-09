<?php

use Nette\Application\Request;
use Nette\DI\Container;
use Tester\Assert;
use Tester\DomQuery;
use Tester\TestCase;

$container = require __DIR__ . "/../../bootstrap.php";

class GalleryPresenterTest extends TestCase
{

    protected $presenter;
    protected $container;

    public function __construct ( Container $container ) {
        $this -> container = $container;
    }

    public function setUp () {
        $factory = $this -> container -> getByType( 'Nette\Application\IPresenterFactory' );
        $this -> presenter = $factory -> createPresenter( 'Front:Gallery' );
        $this -> presenter -> autoCanonicalize = false;
    }

    public function testRenderDefault () {
        // TODO: Tests are not working because of JS
        $request = new Request( 'Front:Gallery', 'GET', array ( 'action' => 'default' ) );
        $response = $this -> presenter -> run( $request );

        Assert::type( 'Nette\Application\Responses\TextResponse', $response );
        Assert::type( 'Nette\Bridges\ApplicationLatte\Template', $response -> getSource() );

        $html = (string) $response -> getSource();
        $dom = DomQuery::fromHtml( $html );

        Assert::true( $dom->has('#' + $this->presenter->translator->translate('front.layout.hash.gallery')) );
        Assert::true( $dom->has('#' + $this->presenter->translator->translate('front.layout.hash.top')) );
    }

    public function testRenderDetail () {
        $request = new Request( 'Front:Gallery', 'GET', array ( 'action' => 'detail', 'id' => 1 ) );
        $response = $this -> presenter -> run( $request );

        Assert::type( 'Nette\Application\Responses\TextResponse', $response );
        Assert::type( 'Nette\Bridges\ApplicationLatte\Template', $response -> getSource() );

        $html = (string) $response -> getSource();
        $dom = DomQuery::fromHtml( $html );

        Assert::true( $dom->has('#' + $this->presenter->translator->translate('front.layout.hash.gallery')) );
        Assert::true( $dom->has('#' + $this->presenter->translator->translate('front.layout.hash.top')) );
    }

}

# Spuštění testovacích metod
run( new GalleryPresenterTest( $container ) );
