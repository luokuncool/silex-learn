<?php
namespace Acme\Config;


class Configs
{
    static public $dbs = array(
        'dbs.options' => array(
            'default' => array(
                'driver'   => 'pdo_mysql',
                'host'     => 'localhost',
                'dbname'   => 'silex-learn',
                'user'     => 'root',
                'password' => 'root',
                'charset'  => 'utf8mb4',
            )
        ),
    );

    static public function getViewPath()
    {
        return realpath(__DIR__ . '/../Resources/views');
    }
}