<?php

$container = require __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "bootstrap.php";

use Tester\Assert;

class MissingTranslationsTest extends Tester\TestCase
{
    const MESSAGE_MISSING = "MESSAGE_MISSING";
    const MESSAGE_DEFINED = "MESSAGE_DEFINED";
    const MESSAGE_EQUALS_FALLBACK = "MESSAGE_EQUALS_FALLBACK";

    /**
     * @var Kdyby\Translation\Translator
     */
    private $translator;
    /**
     * @var \Symfony\Component\Translation\Extractor\ChainExtractor
     */
    private $extractor;
    /**
     * @var Kdyby\Translation\IResourceLoader
     */
    private $loader;
    /**
     * @var Nette\DI\Container
     */
    protected $container;


	public function __construct(Nette\DI\Container $container) {
		$this->container = $container;
	}


    public function setUp() {
        $this->translator = $this->container->getByType('Kdyby\Translation\Translator');
        $this->extractor = $this->container->getByType('Symfony\Component\Translation\Extractor\ChainExtractor');
        $this->loader = $this->container->getByType('Kdyby\Translation\IResourceLoader');
    }

    public function tearDown() {
    }

    public function testDefaultTranslations() {
        $defaultLang = "cs_CZ";
        $catalogues = [ "en_US" ];

        $translatorCatalogue = $this->translator->getCatalogue($defaultLang);

        foreach($catalogues as $lang) {
            $catalogue = $this->translator->getCatalogue($lang);
            foreach($translatorCatalogue->all() as $domain => $bunch) {
                foreach($bunch as $id => $single) {
                    Assert::equal(true, $catalogue->defines($id, $domain), 
                        sprintf("Catalogue \"%s\" does not define message \"%s.%s\"", $lang, $domain, $id) );
                }
            }
        }
    }

    public function testFindMissingTranslations() {
        $catalogues = [ "cs_CZ", "en_US" ];


        foreach ($catalogues as $lang) {
            $counts = [
                self::MESSAGE_MISSING => 0,
                self::MESSAGE_DEFINED => 0,
                self::MESSAGE_EQUALS_FALLBACK => 0,
            ];

            // extract the messages from latte
            $catalogue = new Kdyby\Translation\MessageCatalogue($lang);
            $this->extractor->extract(APP_DIR, $catalogue);

            $translatorCatalogue = $this->translator->getCatalogue($lang);

            foreach($catalogue->all() as $domain => $bunch) {
                foreach ($bunch as $id => $single) {
                    $id = explode(".", $id);
                    $tmpDomain = count($id) <= 1 ? $domain : array_shift($id);
                    $id = implode(".", $id);

                    // TODO: temporary fix for looped translations
                    // see #61
                    $id = preg_replace('/(.*)\.\$i$/', '\1.1', $id);

                    if ($translatorCatalogue->defines($id, $tmpDomain)) {
                       $counts [ self::MESSAGE_DEFINED ] ++; 
                    } else if ($translatorCatalogue->has($id, $tmpDomain)) {
                        $counts [ self::MESSAGE_EQUALS_FALLBACK  ] ++;
                    } else {
                        $counts [ self::MESSAGE_MISSING  ] ++;
                    }
                }
            }

            Assert::same( 0, $counts[self::MESSAGE_MISSING], "There should be no missing translation" );
            Assert::same( 0, $counts[self::MESSAGE_EQUALS_FALLBACK], "There should be no fallback translation" );
        }
    }
}

# Spuštění testovacích metod
run(new MissingTranslationsTest($container));
