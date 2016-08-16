<?php

use SilexLearn\Controller\DefaultController;

$app = require __DIR__ . '/../bootstrap.php';
$app->mount('/', new DefaultController());
$app->run();