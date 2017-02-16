<?php
namespace Acme\Controller;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class PostController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->get('/index', array($this, 'indexAction'));
        $controllers->match('/create', array($this, 'createAction'));
        $controllers->match('/{id}/edit', array($this, 'editAction'));
        $controllers->get('/{id}/show', array($this, 'showAction'));
        return $controllers;
    }

    public function indexAction(Application $app)
    {
        $query  = $app['db']->createQueryBuilder()
            ->select('*')
            ->from('post')
            ->setMaxResults(100);
        $posts = $app['db']->executeQuery($query)->fetchAll();
        return $app['twig']->render('Post/index.html.twig', ['posts' => $posts]);
    }

    public function createAction(Application $app)
    {
        return $app['twig']->render('Post/create.html.twig');
    }

    public function editAction($id, Application $app)
    {
        return $app['twig']->render('Post/edit.html.twig');
    }

    public function showAction($id, Application $app)
    {
        return $app['twig']->render('Post/show.html.twig');
    }

    public function deleteAction($id, Application $app)
    {

    }
}