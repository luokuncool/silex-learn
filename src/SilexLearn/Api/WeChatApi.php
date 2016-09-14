<?php
namespace SilexLearn\Api;

use EasyWeChat\Message\Image;
use EasyWeChat\Message\News;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use EasyWeChat\Foundation\Application as WeChatApplication;

class WeChatApi implements ControllerProviderInterface
{
    /** @var Application $app */
    private $app = null;
    private $options = array(
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
        //https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx0243cccf60129301&redirect_uri=http%3A%2F%2Fsilex-learn.luokuncool.com%2Fauth_callback&response_type=code&scope=SCOPE&state=STATE#wechat_redirect
    );

    /** @var WeChatApplication $wechat */
    private $wechat = null;

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $this->wechat = new WeChatApplication($this->options);
        $this->app    = $app;
        $controllers  = $app['controllers_factory'];
        $controllers->match('/index', array($this, 'indexAction'));
        $controllers->match('/broadcast', array($this, 'broadcastAction'));
        return $controllers;
    }

    public function indexAction()
    {
        $server = $this->wechat->server;
        $server->setMessageHandler(array($this, 'messageHandler'));
        $response = $server->serve();
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');
        return $response;
    }

    public function messageHandler($message)
    {
        $this->app['monolog']->addDebug(print_r($message, true));
        switch ($message->MsgType) {
            case 'event':
                return $this->handEventMsg($message);
                # 事件消息...
                break;
            case 'text':
                return $this->handlerTextMsg($message->Content);
                break;
            case 'image':
                $app             = new WeChatApplication($this->options);
                $material        = $app->material_temporary;
                $res             = $material->uploadImage(__DIR__ . '/../../../web/images/symfony.jpg');
                $image           = new Image();
                $image->media_id = $res->media_id;
                return $image;
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

    public function materialAction()
    {
        $material = $this->wechat->material_temporary;
        $res      = $material->uploadImage(__DIR__ . '/../../../web/images/symfony.jpg');
        $res->media_id;
        dump($res);
    }

    public function broadcastAction()
    {
        $broadcast = $this->wechat->broadcast;
        $broadcast->sendText("大家好！这是一个群发的广播信息。");
    }

    private function handlerTextMsg($content)
    {
        if ($content == '设置菜单') {
            $setMenu = array(
                array(
                    'name'       => '扫码',
                    'sub_button' =>
                        array(
                            array(
                                'type'       => 'scancode_waitmsg',
                                'name'       => '扫码带提示',
                                'key'        => 'rselfmenu_0_0',
                                'sub_button' =>
                                    array(),
                            ),
                            array(
                                'type'       => 'scancode_push',
                                'name'       => '扫码推事件',
                                'key'        => 'rselfmenu_0_1',
                                'sub_button' =>
                                    array(),
                            ),
                        ),
                ),
                /*array(
                    'name'       => '发图',
                    'sub_button' =>
                        array(
                            array(
                                'type'       => 'pic_sysphoto',
                                'name'       => '系统拍照发图',
                                'key'        => 'rselfmenu_1_0',
                                'sub_button' =>
                                    array(),
                            ),
                            array(
                                'type'       => 'pic_photo_or_album',
                                'name'       => '拍照或者相册发图',
                                'key'        => 'rselfmenu_1_1',
                                'sub_button' =>
                                    array(),
                            ),
                            array(
                                'type'       => 'pic_weixin',
                                'name'       => '微信相册发图',
                                'key'        => 'rselfmenu_1_2',
                                'sub_button' =>
                                    array(),
                            ),
                        ),
                ),*/
                array(
                    'type'       => 'location_select',
                    'name'       => '发送位置',
                    'key'        => 'rselfmenu_2_0',
                    'sub_button' =>
                        array(),
                ),
                array(
                    'type'       => 'view',
                    'name'       => '点我',
                    'url'        => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx0243cccf60129301&redirect_uri=http%3A%2F%2Fsilex-learn.luokuncool.com%2Fauth_callback&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect',
                    'key'        => 'my_click1',
                    'sub_button' =>
                        array(),
                )
            );
            $this->wechat->menu->add($setMenu);
            $menuAll = $this->wechat->menu->all();
            return var_export($menuAll->all(), true);
        }

        if ($content == '菜单') {
            $menuAll = $this->wechat->menu->all();
            return var_export($menuAll->all(), true);
        }
        $semantic = $this->wechat->semantic;
        $res      = $semantic->query($content, 'flight,hotel', array('city' => '北京', 'uid' => '123456'));
        return var_export($res, true);
        return '你好, 这个是默认消息！';
    }

    private function handEventMsg($message)
    {
        return $message->EventKey;
    }
}