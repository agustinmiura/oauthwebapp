<?php

use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

$app->register(new Silex\Provider\SessionServiceProvider());

$app['session.db_options'] = array(
    'db_table'      => 'session',
    'db_id_col'     => 'session_id',
    'db_data_col'   => 'session_value',
    'db_time_col'   => 'session_time',
);

$app['session.db_options'] = array(
    'db_table'      => 'session',
    'db_id_col'     => 'session_id',
    'db_data_col'   => 'session_value',
    'db_time_col'   => 'session_time',
);

$app['session.storage.handler'] = $app->share(function () use ($app) {
    return new PdoSessionHandler(
        $app['db']->getWrappedConnection(),
        $app['session.db_options'],
        $app['session.storage.options']
    );
});
