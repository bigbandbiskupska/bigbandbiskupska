<?php

use Nette\Database\Context;
use Nette\DI\Container;
use Tester\TestCase;


class TestCaseWithDatabase extends TestCase
{
    /** @var Container */
    protected $container;

    /** @var Context */
    protected $database;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->database = $this->container->getByType(Context::class);
    }
}
