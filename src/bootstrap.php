<?php
/**
 * Set the error reporting and the time zone
 */
date_default_timezone_set('America/Argentina/Buenos_Aires');

define('ROOT_PATH', realpath(__DIR__.'/..'));

/*
Setup log4php
*/
include_once ROOT_PATH . '/vendor/apache/log4php/src/main/php/Logger.php';
\Logger::configure(ROOT_PATH . '/config/log4php.ini');

$loader = require_once(__DIR__.'/../vendor/autoload.php');