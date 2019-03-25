<?php

use Nette\Utils\Finder;
use Tester\Assert;

$container = require __DIR__ . DIRECTORY_SEPARATOR . "bootstrap.php";

$appDir = $container->parameters['appDir'];
$testDir = $container->parameters['testDir'];
$tempDir = $container->parameters['tempDir'];

foreach (Finder::findFiles('*.php*')->from($appDir, $testDir)->exclude($tempDir) as $path => $splfile) {
    if (($content = @file_get_contents($path)) === FALSE) {
        Assert::fail("The file '$path' should be readable");
    }

    Assert::type('string', $content, 'The file content should be a string');

    foreach (['DEV', 'REMOVE', 'DEBUG'] as $action) {
        // "//" like comment
        $pattern = "/[ \\t]*\\/\\/[ \\t]*" . $action . "(:|[ \\t])(([ \\t]*\\S*)*?)[\\r\\n][\\n]?/";
        if (preg_match_all($pattern, $content, $matches)) {
            $fail = $action . ": " . trim($matches[2][0]);
            Assert::fail("File '$path' contains prohibited action '$action' with message:\n" . $fail);
        }
        // "/* ... */" like comment
        $pattern = "/\\/\\*\\S*\\s*.*?" . $action . "(:|[ \\t])(([ \\t]*\\S*)*)((\\s|\\S)*?)\\*\\//m";
        if (preg_match_all($pattern, $content, $matches)) {
            $fail = $action . ": " . trim($matches[2][0]);
            Assert::fail("File '$path' contains prohibited action '$action' with message:\n" . $fail);
        }
    }
}

