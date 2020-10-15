<?php

use Composer\Autoload\ClassLoader;

include_once __DIR__.'/../vendor/autoload.php';

$classLoader = new ClassLoader();
$classLoader->addPsr4("Dummy\\", __DIR__.'/DummyClasses', true);
$classLoader->register();


