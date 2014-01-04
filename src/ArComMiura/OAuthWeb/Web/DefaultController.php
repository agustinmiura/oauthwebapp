<?php
namespace ArComMiura\OAuthWeb\Web;

use Silex\Application as Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Validator\Constraints as Assert;

class DefaultController extends AbstractController
{
    /**
     * Read the user information and 
     * show it in the main page 
     * 
     * @return 
     */
    public function mainAction() 
    {
        /**
         * @todo use the OAuth2Logger
         * @var \Logger
         */
        $logger = \Logger::getLogger('MyLogger');

        $app = $this->getApplication();
        $session = $app['session'];

        $currentUser = $session->get('user', null);
        $name = $currentUser->getName();
        $currentUser = array(
            'name'=>$name,
            'password'=>'XXXX',
            'role'=>'user'
        );

        $userInformation = $session->get('userInformation', new \StdClass());

        /**
         * @todo remove
         */
        $asString = print_r($userInformation, true);
        $logger->debug('The user information is :'.$asString);

        $parsed = $this->_parseInformation($userInformation);

        return $app['twig']->render('user/index.html', array(
            'user'=>$currentUser,
            'userInformation'=>$parsed
        ));
    }

    /**
     * @todo move to the information getter
     * @param  StdClass $information [description]
     * @return [type]                [description]
     */
    private function _parseInformation(\StdClass $information) 
    {
        $answer = array();

        $parameters = array('kind', 'gender', 'etag', 'objectType',
         'id', 'displayName', 'url', 'isPlusUser', 'verified', 'email');

        $arrayParameters = array('name', 'image');

        foreach ($parameters as $value) {
            //$answer[$value] = $information->$value;
            $answer[] = array(
                'name'=>$value,
                'value'=>$information->$value
            );
        }
        $rawProperty;
        $asString = '';
        foreach ($arrayParameters as $value) {
            $rawProperty = $information->$value;
            $asString = print_r($rawProperty, true);
            //$answer[$value] = $asString;
            $answer[] = array(
                'name'=>$value,
                'value'=>$asString
            );
        }

        return $answer;
    }

    public function defaultAction()
    {
        $logger = \Logger::getLogger('MyLogger');

        $app = $this->getApplication();
        $session = $app['session'];
        $currentUser = $session->get('user', null);
        $userInformation = $session->get('userInformation', new \StdClass());

        $asString = (is_object($currentUser))
            ? (print_r($currentUser->toArray(), true)) : 'NULL';
        $logger->debug('The user found is '.$asString);

        if (is_null($currentUser)) {
            return $app->redirect('/login');
        }
        return $this->mainAction();
    }
}