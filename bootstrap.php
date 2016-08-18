<?php

use Doctrine\DBAL\Logging\DebugStack;
use Knp\Provider\ConsoleServiceProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;
use SilexLearn\Config\Configs;
use SilexLearn\Middleware\AuthApiMiddleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$loader = require __DIR__ . '/vendor/autoload.php';
$app    = new Application();

$app['debug'] = true;

$app->register(
    new DoctrineServiceProvider(),
    Configs::$dbs
);
$app->register(
    new MonologServiceProvider(),
    array(
        'monolog.logfile' => __DIR__ . "/var/logs/development.log",
    )
);
$app->register(
    new TwigServiceProvider(),
    array(
        'twig.path' => Configs::getViewPath(),
    )
);

$app->extend(
    "twig",
    function (\Twig_Environment $twig, Silex\Application $app) {
        $twig->addExtension(new \SilexLearn\Twig\MyExtension($app));
        return $twig;
    }
);

$app->register(
    new ConsoleServiceProvider(),
    array(
        'console.name'              => 'SilexLearn',
        'console.version'           => '1.0.0',
        'console.project_directory' => __DIR__ . '/..'
    )
);

$app->before(new AuthApiMiddleware());
//记录sql日志
if ($app['debug']) {
    $logger = new DebugStack();
    $app['db.config']->setSQLLogger($logger);
    $app->error(
        function (Exception $e, $code) use ($app, $logger) {
            if ($e instanceof PDOException and count($logger->queries)) {
                // We want to log the query as an ERROR for PDO exceptions!
                $query = array_pop($logger->queries);
                $app['monolog']->err(
                    $query['sql'],
                    array(
                        'params' => $query['params'],
                        'types'  => $query['types']
                    )
                );
            }
        }
    );
    $app->after(
        function (Request $request, Response $response) use ($app, $logger) {
            // Log all queries as DEBUG.
            foreach ($logger->queries as $query) {
                $app['monolog']->debug(
                    $query['sql'],
                    array(
                        'params' => $query['params'],
                        'types'  => $query['types']
                    )
                );
            }
        }
    );

    $app->register(new \Silex\Provider\HttpFragmentServiceProvider());
    $app->register(new \Silex\Provider\ServiceControllerServiceProvider());
    $app->register(new \Silex\Provider\WebProfilerServiceProvider(), array(
        'profiler.cache_dir' => __DIR__.'/var/cache/profiler',
        'profiler.mount_prefix' => '/_profiler', // this is the default
    ));
    $app->register(new \Sorien\Provider\DoctrineProfilerServiceProvider());
}

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Sorien\Provider\PimpleDumpProvider());

return $app;