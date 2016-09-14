<?php
namespace SilexLearn\Controller;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

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

    public function authCallbackAction(Request $request)
    {
        $code = $request->get('code');
        $json = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx0243cccf60129301&secret=57df18c794809b8424f24344d76097fb&code={$code}&grant_type=authorization_code");
        $json = json_decode($json, true);
        dump($json);

        $userInfo = file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token={$json['access_token']}&openid=wx0243cccf60129301&lang=zh_CN");
        $userInfo = json_decode($userInfo, true);
        dump($userInfo);
        return "<img src='{$userInfo['headimgurl']}' />";
    }
}