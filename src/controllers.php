<?php
use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\Response as Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundHttpException;

$app->error(function(\ArComMiura\OAuthWeb\Exception\NotLoggedInException $exception) use ($app) {
    $app->redirect('/login');
});

$app->error(function(NotFoundHttpException $exception) use ($app) {
    return $app['twig']->render('error/404.html');
});

$app['controller.default'] = $app->share(function() use ($app) {
  return (new \ArComMiura\OAuthWeb\Web\DefaultController($app));

});

$app['controller.security'] = $app->share(function() use ($app) {
  return (new \ArComMiura\OAuthWeb\Web\SecurityController($app));
});

$app['controller.oauth2'] = $app->share(function() use ($app) {
    return (new \ArComMiura\OAuthWeb\Web\OAuth2Controller($app));
});

$beforeCb = function(Request $request) use ($app) {
    $answer = true;
    try{
        $user = $app['session']->get('user', null);
        $answer = $app['helper.security']->processAuth($request, $user);
    }catch(\ArComMiura\OAuthWeb\Exception\NotLoggedInException $exception) {
        $app->redirect('/login');
    }
};

$app->get('/oauth2callback','controller.oauth2:handleOAuth2Cb')->before($beforeCb);

//Use the traditional login form with the db backend in the application
/* 
$app->get('/', 'controller.default:defaultAction')->before($beforeCb);
$app->get('/login', 'controller.security:showLoginForm')->before($beforeCb);
$app->get('/logout', 'controller.security:doLogout')->before($beforeCb);
$app->post('/do-login', 'controller.security:doLogin')->before($beforeCb);
*/

//Use the OAuth2 credentials here
$app->get('/', 'controller.default:defaultAction');//->before($beforeCb);
$app->get('/login', 'controller.oauth2:showLoginForm');//->before($beforeCb);
$app->get('/logout', 'controller.oauth2:doLogout');
$app->get('/main', 'controller.default:mainAction');//->before($beforeCb);
$app->get('/invalidated','controller.oauth2:userLoggedOut');//->before($beforeCb);;
