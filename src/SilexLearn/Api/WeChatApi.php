<?php
namespace SilexLearn\Api;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use EasyWeChat\Foundation\Application as WeChatApplication;

class WeChatApi implements ControllerProviderInterface
{

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->match('/index', array($this, 'indexAction'));
        return $controllers;
    }

    public function indexAction()
    {
        if ($_GET['echostr']) {
            return $_GET['echostr'];
        }

        $options   = array(
            /**
             * Debug 模式，bool 值：true/false
             *
             * 当值为 false 时，所有的日志都不会记录
             */
            'debug'  => true,
            /**
             * 账号基本信息，请从微信公众平台/开放平台获取
             */
            'app_id' => 'wx0243cccf60129301',
            'secret' => '57df18c794809b8424f24344d76097fb',
            'token'  => 'weixin',
            //'aes_key' => '',
        );
        $weChatApp = new WeChatApplication($options);
        $server    = $weChatApp->server;
        $server->setMessageHandler(array($this, 'messageHandler'));
        return $server->serve();
    }

    public function messageHandler($message)
    {
        switch ($message->MsgType) {
            case 'event':
                # 事件消息...
                break;
            case 'text':
                return "您好！欢迎关注我!";
                break;
            case 'image':
                # 图片消息...
                break;
            case 'voice':
                # 语音消息...
                break;
            case 'video':
                # 视频消息...
                break;
            case 'location':
                # 坐标消息...
                break;
            case 'link':
                # 链接消息...
                break;
            // ... 其它消息
            default:
                return "您好！";
                break;
        }
    }
}