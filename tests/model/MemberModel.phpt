<?php

use Nette\DI\Container;
use Tester\Assert;

$container = require __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "bootstrap.php";

class MemberModel extends TestCaseWithDatabase
{

    /** @var BaseModel */
    protected $model;

    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function setUp()
    {
        $this->model = $this->container->getByType('App\Model\VisibleMembersModel');
    }

    public function testAll()
    {
        Assert::true(count($this->model->all()) > 0);
    }

}

# Spuštění testovacích metod
run(new MemberModel($container));
