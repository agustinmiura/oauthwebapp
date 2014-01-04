<?php

$currentPath = realpath(__DIR__);
$rootPath = realpath($currentPath.'/..');

define('ROOT_PATH',$rootPath);

$loader = require_once(ROOT_PATH.'/vendor/autoload.php');

use OAuth\Config\DoctrineConfigurator;
use Doctrine\ORM\Tools\Console\ConsoleRunner as ConsoleRunner;

$app = array();
$app['config'] = parse_ini_file(ROOT_PATH.'/config/parameters.ini');
$ormConfigurator = new OAuth\Config\DoctrineConfigurator($app['config']['doctrine.proxyDirectory']);

$helperSet = $ormConfigurator->createHelperSet($app['config']);

ConsoleRunner::run($helperSet);