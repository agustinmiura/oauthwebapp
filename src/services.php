<?php
/**
 * Register the user service
 */
$app['service.user'] = $app->share(function() use ($app) {
    $em = $app['doctrine.orm.em'];
    return new \ArComMiura\OAuthWeb\Domain\Services\UserServiceImpl($em);
});

$app['helper.security'] = $app->share(function() use ($app) {
    return new \ArComMiura\OAuthWeb\Helper\SecurityHelper();
});
