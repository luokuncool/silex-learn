<?php
namespace SilexLearn\Config;


class Configs
{
    static public $dbs = array(
        'dbs.options' => array(
            'default' => array(
                'driver'   => 'pdo_mysql',
                'host'     => 'localhost',
                'dbname'   => 'easy-workflow',
                'user'     => 'root',
                'password' => 'root',
                'charset'  => 'utf8mb4',
            ),
            'sqlsrv'        => array(
                'driver'   => 'pdo_sqlsrv',
                'host'     => 'localhost',
                'dbname'   => 'easy-workflow',
                'user'     => 'sa',
                'password' => '123456',
                'charset'  => 'utf8mb4',
            )
        ),
    );

    static public function getViewPath()
    {
        return realpath(__DIR__ . '/../Resources/views');
    }
}