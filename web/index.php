<?php

use Acme\Api\UserApi;
use Acme\Api\WeChatApi;
use Acme\Controller\DefaultController;
use Acme\Controller\PostController;

$app = require __DIR__ . '/../bootstrap.php';
$app->mount('/', new DefaultController());
$app->mount('/post', new PostController());
$app->mount('/api/user', new UserApi());
$app->mount('/api/wechat', new WeChatApi());
$app->run();