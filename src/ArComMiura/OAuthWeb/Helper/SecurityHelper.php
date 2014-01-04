<?php

namespace ArComMiura\OAuthWeb\Helper;

use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\Response as Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundHttpException;

use ArComMiura\OAuthWeb\Exception\NotLoggedInException as NotLoggedInException;

class SecurityHelper 
{
    /**
     * Array containing regular expressions
     * of the path that can be accessed without
     * being logged in
     * @var array
     */
    protected $_anonymousAccess;

    /**
     * Array containing regular expressions
     * of the path that can be accessed
     * with an user
     * @var array
     */
    protected $_protectedAccess;

    public function __construct()
    {
        /**
         * The user does not need to be logged in
         * for the access
         * 
         * Receive the answer from the google plus code 
         * without being logged in
         */
        $this->_anonymousAccess = array('/^\/login/', '/^\/oauth2callback/');
        $this->_protectedAccess = array('/^\//','/^\/*/');
    }

    public function processAuth(Request $request, $currentUser) 
    {
        /**
         * @todo remove
         */
        $logger = \Logger::getLogger('MyLogger');
        $logger->debug('Logger started');
        /*
        $asString = (is_object($currentUser) ? ($currentUser->toArray()) : '');
        $logger->debug('The current user is :'.$asString);
        */

        $url = $request->getRequestUri();

        $anonymousAccess = false;

        $anonymousUrls = $this->_anonymousAccess;
        $protectedUrls = $this->_protectedAccess;
        $regularExpression;
        foreach($anonymousUrls as $eachPattern) {

            if (preg_match($eachPattern, $url)) {
                $anonymousAccess = true;
                break;
            }
        }

        foreach ($protectedUrls as $eachPattern) {
            if (preg_match($eachPattern, $url)) {
                $anonymousAccess = false;
                break;
            }
        }

        if ( (!$anonymousAccess) && (!is_null($currentUser)) ) {
            $message = 'Cannot access to the url '.$url.' because you need';
            $message .= ' to be logged in ';
            throw new \ArComMiura\OAuthWeb\Exception\NotLoggedInException($message);
        }

        return true;
    }

}