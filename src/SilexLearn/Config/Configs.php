<?php
namespace SilexLearn\Config;


class Configs
{
    static public function getViewPath()
    {
        return realpath(__DIR__ . '/../Resources/views');
    }
}