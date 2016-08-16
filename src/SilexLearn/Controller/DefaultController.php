<?php
namespace SilexLearn\Controller;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class DefaultController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->get('/', array($this, 'indexAction'));
        $controllers->get('/read', array($this, 'readAction'));
        return $controllers;
    }

    public function indexAction()
    {
        return 'hello silex!';
    }

    public function readAction(Application $app)
    {
        $query  = $app['db']->createQueryBuilder()
            ->select('*')
            ->from('adm_users')
            ->setMaxResults(100);
        $groups = $app['db']->executeQuery($query)->fetchAll();
        return $app['twig']->render('Default/index.html.twig', ['groups' => $groups]);
    }
}