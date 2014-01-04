<?php
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider as SessionServiceProvider;
use Silex\Provider\DoctrineServiceProvider as DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider as MonologProvider;
use Silex\Provider\ValidatorServiceProvider as ValidatorProvider;
use Monolog\Logger as MonologLogger;
use Symfony\Component\HttpFoundation\Request as Request;

/*
Setup log4php
*/
include_once ROOT_PATH . '/vendor/apache/log4php/src/main/php/Logger.php';
\Logger::configure(ROOT_PATH . '/config/log4php.ini');
/**
 * Load the configuration
 */
$config = parse_ini_file(ROOT_PATH . '/config/parameters.ini');

$app = new \Silex\Application();
$app['config'] = $config;

$app["debug"] = true;

$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());

$app->register(new ValidatorProvider());

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => $config['monolog.file'],
    'monolog.lvel' => $config['monolog.level']
));

/**
 * Register twig service
 */
$debugTwig = ($app["debug"]===true);
$optimizeTwig = ($app["debug"]===false);
$app->register(new TwigServiceProvider(), array(
    'twig.path' => array(ROOT_PATH.'/templates'),
    'twig.options' => array(
        'cache' => $config['twig.cache'],
        'debug' => $debugTwig,
        'strict_variables' => true,
        /*Autoreload template whenever the src changes set TRUE for development*/
        'auto_reload'=>$debugTwig,
        //0 to disable , -1 all optimizations enabled
        'optimizations'=>-1
    ),
));

$defaultConfig = array(
    'driver' => 'pdo_mysql',
    'dbname' => $config['dbName'],
    'host' => $config['dbUrl'],
    'user' => $config['dbUser'],
    'password' => $config['dbPassword'],
    'charset' => 'UTF8',
    'port'=>$config['dbPort']
);

$app->register(new DoctrineServiceProvider(), array(
    'db.options' => $defaultConfig
));

$app['doctrine.orm.em'] = $app->share(function() use ($app) {
    $config = $app["config"];
    $doctrineConfigurator = new \ArComMiura\OAuthWeb\Config\DoctrineConfigurator(
        $config["doctrine.proxyDirectory"]
    );
    $em = $doctrineConfigurator->createEm($app['config']);
    return $em;
});

/* Do not use the default session that has too many bugs
require_once(ROOT_PATH.'/src/defaultSession.php');
*/

/**
 * Store the sessions in the database
 */
require_once(ROOT_PATH.'/src/pdoSession.php');


/*code to sample authentication
$securityConfig = array(
    'secured_area' => array(
    'pattern' => '^.*$',
    'anonymous' => true,
    'form' => array(
        'login_path' => '/user/login',
        'check_path' => '/user/login_check',
    ),
    'logout' => array(
        'logout_path' => '/user/logout',
    ),
    'users' => $app->share(function($app) { 
        return $app['user.manager']; 
    }),
));

$app->register(new \Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls'=>$securityConfig
));

// Register SimpleUser services
$userServiceProvider = new SimpleUser\UserServiceProvider();
$app->register($userServiceProvider);

// Mount SimpleUser routes.
$app->mount('/user', $userServiceProvider);
*/

/* Code to use custom security provider
$customUserProvider = new \OAuth\Domain\Services\CustomServiceProvider(
    $app['db']
);
$app['user.manager'] = $app->share(function($app) use ($customUserProvider) {
    return $customUserProvider;
});

$securityConfig = array(
    // Login URL is open to everybody.
    'login' => array(
        'pattern' => '^/login$',
        'anonymous' => true,
    ),
    // Any other URL requires auth.
    'secured_area' => array(
    'pattern' => '^.*$',
    'anonymous' => false,
    'form' => array(
        'login_path' => '/login',
        'check_path' => '/login_check'
    ),
    'logout' => array(
        'logout_path' => '/logout',
    ),
    'users' => $app->share(function($app) { 
        return $app['user.manager']; 
    }),
));
$app->register(new \Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls'=>$securityConfig
));
*/

return $app;



