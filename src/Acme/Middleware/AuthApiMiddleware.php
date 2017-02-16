<?php
namespace Acme\Middleware;

use Silex\Application;
use Acme\Api\AuthInterface;
use Symfony\Component\HttpFoundation\Request;

class AuthApiMiddleware
{
    public function __invoke(Request $request, Application $app)
    {
        $controller = $request->get('_controller');
        if ($controller[0] instanceof AuthInterface) {
            //todo 验证接口访问权限

        }
    }
}