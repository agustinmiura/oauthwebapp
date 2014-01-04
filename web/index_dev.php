<?php
use Symfony\Component\ClassLoader\DebugClassLoader;
use Symfony\Component\HttpKernel\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\Debug\ExceptionHandler;

$app = require __DIR__.'/../src/app.php';

require __DIR__.'/../src/controllers.php';
require __DIR__.'/../src/services.php';

$app->run();