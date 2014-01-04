<?php

namespace ArComMiura\OAuthWeb\Web;

use ArComMiura\OAuthWeb\Exception\ApplicationException as ApplicationException;
use ArComMiura\OAuthWeb\Exception\InvalidCredentials as InvalidCredentialException;

class OAuth2Controller extends AbstractController
{
    public function defaultAction()
    {

    }

    public function showLoginForm()
    {
        $oauth2Logger = \Logger::getLogger('MyLogger');
        $app = $this->getApplication();
        $session = $app['session'];
        $client = $app['oauth2.client'];
        $state = $app['random.generator']->getString();

        $id = $session->getId();
        $session->set('state', $state);
    
        $authenticationEndPoint = $client->generateAuthorizationEndPoint(
            $state
        );

        return $app->redirect($authenticationEndPoint);
    }

    public function doLogout()
    {
        /**
         * @todo remove
         */
        $logger = \Logger::getLogger('MyLogger');

        $app = $this->getApplication();
        $session = $app['session'];

        /**
         * @todo remove
         */
        $id = $session->getId();
        $accessCode = $app['oauth2.client']->getAccessCode($id);
        $message = 'The access code is :'.$accessCode;
        $logger->debug('The access code is :'.$accessCode);
    
        $token = $session->get('accessToken', null);
        if (is_string($token)) {

            try{
                
                $answer = $client = $app['oauth2.client']->revokeToken($token);
                /**
                 * Remove from the storage the accessCode, accessToken and
                 * user information
                 */
                $client = $app['oauth2.client'];
                $success = $client->removeAccessCode($id);
                $success = $success && ($client->removeAccessToken($id));
                $success = $success && ($client->removeUserInformation($id));
            
            }catch(\Exception $exception) {
                $logger->debug('An exception happened with the token revoke');
            }
            
            $asString = print_r($answer, true);
            $logger->debug('The access token has been revoked: '.$asString);
        } else {
            $logger->debug('The access token is null');
        }

        $session->clear();
        $session->invalidate();

        return $app->redirect('/invalidated');
    }

    public function userLoggedOut()
    {
        $app = $this->getApplication();

        return $app['twig']->render('user/loggedOut.html', array());
    }

    private function _userDeniedAccess($errorMessage) 
    {
        $app = $this->getApplication();

        /**
         * @todo move this to the OAuth2Client
         * @var array
         */
        $detailedMessageArray = array(
            'access_denied'=>'The user did not authorize the application to access the information'
        );
        if (isset($detailedMessageArray[$errorMessage])) {
            $detailedMessage = $detailedMessageArray[$errorMessage];
        } else {
            $detailedMessage = 'An error happened with the authorization process';
        }
    
        $config = array(
            'errorTitle'=>'OAuth2 error',
            'errorDetail'=>$detailedMessage
        );
        return $app['twig']->render('error/genericError.html', $config);
    }

    /**
     * 
     * @param  String $code Authorization code to get the access token
     * @return void      
     */
    private function _userAllowedAccess($code)
    {
        $app = $this->getApplication();
        $client = $app['oauth2.client'];
        $oauth2Logger = $client->getLoggerForTokenRequest();

        $success = false;
        $badRequest = null;
        $exception = null;
        try{
            $success = true;
            $answer = $client->requestAccessToken($code);
        } catch(\Guzzle\Http\Exception\BadResponseException\ClientErrorResponseException 
            $clientException) {
            
            $badRequest = $clientException->getRequest();
            $exception = $clientException;

        } catch(\Guzzle\Http\Exception\BadResponseException $badResponseException) {

            $badRequest = $badResponseException->getRequest();
            $exception = $badResponseException;

        } catch(\Guzzle\Http\Exception\RequestException $requestException) {

            $badRequest = $requestException->getRequest();
            $exception = $requestException;
        }

        if ($success) {
            $asString = print_r($answer, true);
            $oauth2Logger->debug('The answer from the token request is :'.$asString);
            return $this->_onSuccessTokenRequest($code, $answer);
        } else {

            return $this->_onFailureTokenRequest($exception);
        }
    }

    private function _onFailureTokenRequest(\RuntimeException $exception) 
    {
        $badRequest = $exception->getRequest();

        $config = array(
            'errorTitle'=>'Error getting the token with the authentication code',
            'errorDetail'=>'Bad response'
        );

        return $app['twig']->render('error/genericError.html', $config);
    }

    private function _onSuccessTokenRequest($code, array $tokenResponse)
    {
        $app = $this->getApplication();
        $session = $app['session'];
        $client = $app['oauth2.client'];
        
        $informationLogger = $client->getLoggerForInformationGetter();

        /**
         * Decode the answer 
         */
        $code = $tokenResponse['code'];
        $codeMessage = $tokenResponse['codeMessage'];
        $isError = $tokenResponse['isError'];
        $isSuccessfull = $tokenResponse['isSuccessfull'];
        $body = $tokenResponse['body'];

        /**
         * Decode the answer
         */
        $decodedResponse = json_decode($body);
        $accessToken = $decodedResponse->access_token;
        $tokenType = $decodedResponse->token_type;
        $expiresIn = $decodedResponse->expires_in;
        $idToken = $decodedResponse->id_token;

        $this->_persistsToken($code, $decodedResponse);

        $informationEndPoint = array(
            'v1'=>'https://www.googleapis.com/oauth2/v2/userinfo?access_token=%s',
            'v2'=>'https://www.googleapis.com/plus/v1/people/me?access_token=%s'
        );

        /**
         * Save the access token
         */
        $id = $session->getId();
        $client->saveAccessToken($id, $accessToken);

        $userInformation = $client->getInformation( 
            $informationEndPoint,
            $accessToken
        );

        /**
         * Save the user information
         */
        $client->saveUserInformation($id, $userInformation);

        $name = $userInformation->displayName;
        $password = $userInformation->id;
        $role = 'role';
        $user = new \ArComMiura\OAuthWeb\Domain\Entities\User($name, 
            $password, $role);
        $session->set('user', $user);
        $session->set('userInformation', $userInformation);
        $session->set('accessToken', $accessToken);
        $session->set('code', $code);

        return $app->redirect('/');
    }

    private function _persistsToken($authorizationCode, \StdClass $tokenResponse) 
    {
        $app = $this->getApplication();
        $client = $app['oauth2.client'];
        $logger = $client->getLoggerForTokenPersist();

        $message = ' Persist the token with the authorization code :';
        $message .= ' %s and the token response is : %s ';
        $asString = print_r($tokenResponse, true);
        $message = sprintf(
            $message, 
            (string)$authorizationCode, 
            (string)$asString
        );

        $logger->debug($message);

        $client->persistTokenInformation($authorizationCode, $tokenResponse);
    }

    public function showMain() 
    {

    } 

    /**
     * Error when the state does not match the original
     * one
     * @param  array  $information Array with ['currentState'] = actual state
     *                                        ['beforeState'] = before state
     *                                        ['code']=Auhtorization code
     * @return [type]              [description]
     */
    private function _invalidState(array $information)
    {
        $app = $this->getApplication();
        
        $errorTitle = 'The state string received does not match the one sent';
        $errorMessage = ' Received before as state %s , now %s with ';
        $errorMessage .= ' authorization code %s ';
        $errorMessage = sprintf($errorMessage, $information['beforeState'],
            $information['currentState'], $information['code']);

        $config = array(
            'errorTitle'=>$errorTitle,
            'errorDetail'=>$errorMessage
        );

        return $app['twig']->render('error/genericError.html', $config);
    }

    public function handleOAuth2Cb()
    {
        /**
         * Loggers have started
         */
        $oauth2Logger = \Logger::getLogger('MyLogger');
        $oauth2Logger->debug('Called the method handleOAuth2Cb');

        $app = $this->getApplication();
        $request = $app['request'];
        $session = $app['session'];
        $client = $app['oauth2.client'];

        $beforeState = $session->get('state', '');
        $currentState = $request->get('state', '');

        /**
         * @todo remove
         * 
         */
        $message = ' With session id : %s i see the state : %s';
        $message = sprintf($message, $session->getId(), $beforeState);
        $oauth2Logger->debug($message);

        $code = $request->get('code', '');
        $error = $request->get('error', '');        
        
        /**
         * Save the access code with the
         * client
         */
        $id = $session->getId();
        $client->saveAccessCode($id, $code);

        $validState = (strcasecmp($currentState, $beforeState)===0);

        $withError = (strcasecmp($error, '') != 0);

         /**
         * @todo verify state of the request here
         */
        $oauth2Logger->debug('The state is :'.$currentState);
        $oauth2Logger->debug('The code is :'.$code);
        $oauth2Logger->debug('The error is :'.$error);

        if ( (!$validState) && (!$withError) ) {
            $message = ' The before state : %s , current state %s ';
            $message = sprintf($message, $beforeState, $currentState);
            $oauth2Logger->debug($message);

            $information = array(
                'currentState'=>$currentState,
                'beforeState'=>$beforeState,
                'code'=>$code
            );
            return $this->_invalidState($information);
        }

        if ($withError) {

            return $this->_userDeniedAccess($error);
        
        } else {
            return $this->_userAllowedAccess($code);
        }
    }
}