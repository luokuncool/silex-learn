<?php

use SilexLearn\Api\UserApi;
use SilexLearn\Controller\DefaultController;
use SilexLearn\Controller\PostController;

$app = require __DIR__ . '/../bootstrap.php';
$app->mount('/', new DefaultController());
$app->mount('/post', new PostController());
$app->mount('/api/user', new UserApi());
$app->run();