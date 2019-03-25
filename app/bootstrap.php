<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

define("APP_DIR", __DIR__);

$configurator->setDebugMode(array('172.18.0.1', '127.0.0.1', '85.70.17.135', '213.220.225.67')); // enable for your remote IP
$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
    ->addDirectory(__DIR__)
    ->register();

$configurator->addConfig(__DIR__ . '/config/config.neon', Nette\Configurator::AUTO);
$configurator->addConfig(__DIR__ . '/config/config.local.neon', Nette\Configurator::AUTO);

$container = $configurator->createContainer();

return $container;
