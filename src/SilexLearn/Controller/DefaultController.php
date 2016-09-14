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
        $controllers->get('/auth_callback', array($this, 'authCallbackAction'));
        return $controllers;
    }

    public function indexAction(Application $app)
    {
        $app['session']->getFlashBag()->add('warning', 'Warning flash message');
        $app['session']->getFlashBag()->add('info', 'Info flash message');
        $app['session']->getFlashBag()->add('success', 'Success flash message');
        $app['session']->getFlashBag()->add('danger', 'Danger flash message');
        return $app['twig']->render('Default/index.html.twig');
    }

    public function dbAction(Application $app)
    {
        $query  = $app['db']->createQueryBuilder()
            ->select('*')
            ->from('groups')
            ->setMaxResults(100);
        $groups = $app['db']->executeQuery($query)->fetchAll();
        return $app['twig']->render('Default/read.html.twig', ['groups' => $groups]);
    }

    public function authCallbackAction()
    {
        return '成功啦';
    }
}