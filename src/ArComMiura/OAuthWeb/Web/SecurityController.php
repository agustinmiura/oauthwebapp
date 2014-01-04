<?php

namespace ArComMiura\OAuthWeb\Web;

use ArComMiura\OAuthWeb\Exception\ApplicationException as ApplicationException;
use ArComMiura\OAuthWeb\Exception\InvalidCredentials as InvalidCredentialException;

class SecurityController extends AbstractController{

    /**
     * Show the traditional login form
     * 
     * @return [type] [description]
     */
    public function showLoginForm() 
    {
        $app = $this->getApplication();
        $request = $app['request'];
       
        $error = '';

        return $app['twig']->render('security/form.html', array(
            'error' => $error,
            'last_username' => '',
        ));

    }
    
    public function doLogin()
    {
        $app = $this->getApplication();
        $request = $app['request'];

        $name = $request->get('_username', '', false);
        $password = $request->get('_password', '', false);

        $userService = $app['service.user'];
        $user = $userService->findByUserPassword($name, $password);

        if ($user!=null) {
            $session = $app['session'];
            $session->set('user', $user);
        } else {
            throw new InvalidCredentialException('Invalid credentials');
        }

        return $app->redirect('/');
        
    }
    

    public function doLogout()
    {
        $app = $this->getApplication();
        $session = $app['session'];

        $currentUser = $app['service.user']->getCurrentUser($session);
        if ($currentUser!=null) {
            $session->invalidate();
        }

        return ($app->redirect('/login'));
    }


}
