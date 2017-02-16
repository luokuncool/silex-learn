<?php
namespace Acme\Api;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserApi implements ControllerProviderInterface, AuthInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->post('/create', array($this, 'createAction'));
        return $controllers;
    }

    public function createAction()
    {
        //todo
        $response = new JsonResponse(array('status' => 0));
        return $response;
    }
}