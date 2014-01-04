<?php

$userAgentEnum = new \ArComMiuraOAuth2Component\OAuth2\Http\UserAgentEnum();
$app['userAgent.enum'] = $userAgentEnum;

$randomGenerator = new \ArComMiura\OAuthWeb\Domain\Security\RandomGenerator();
$app['random.generator'] = $randomGenerator;

/**
 * Bootstrap the OAuth2 component
 */
$appConfig = $app['config'];
$oauth2Config = $appConfig['oauth2'];
//storage helper using the session of the user
$storageHelper = new \ArComMiuraOAuth2Component\OAuth2\Storage\SessionStorage(
    $app
);
//storage helper to save the data in the table parameters of the table
$parametersDao = new \ArComMiuraOAuth2Component\OAuth2\Storage\MySql\ParametersDao(
    $app
);
$mySqlStorage = new ArComMiuraOAuth2Component\OAuth2\Storage\MySql\MySqlStorage(
    $parametersDao);

//http client
$httpClient = \ArComMiuraOAuth2Component\OAuth2\OAuth2Client::createHttpClient(
    $oauth2Config['httpClientInfoRetrieverPath']
);

$logger = \Logger::getLogger('InformationEndPointGetter');
$endPointRetriever = new \ArComMiuraOAuth2Component\OAuth2\InformationEndPoint\GooglePlusImpl(
    $oauth2Config, 
    $httpClient,
    $logger
);

/**
 * Create the OAuth2 Client
 */
$oauth2Client = new \ArComMiuraOAuth2Component\OAuth2\OAuth2Client($oauth2Config, 
    $userAgentEnum, $endPointRetriever, $mySqlStorage);

$app['oauth2.client'] = $oauth2Client;



