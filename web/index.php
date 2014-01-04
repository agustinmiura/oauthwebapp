<?php

include_once(__DIR__.'/../src/bootstrap.php');

include_once(ROOT_PATH.'/src/phpDebug.php');

include_once(ROOT_PATH.'/src/app.php');

include_once(ROOT_PATH.'/src/oauth2Bootstrap.php');

include_once(ROOT_PATH.'/src/services.php');

include_once(ROOT_PATH.'/src/controllers.php');

include_once(ROOT_PATH.'/src/webBootstrap.php');

$app->run();
