<?php
namespace ArComMiura\OAuthWeb\Web;

use Silex\Application as Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class AbstractController
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getApplication()
    {
        return $this->app;
    }

}