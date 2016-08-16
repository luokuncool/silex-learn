<?php

namespace SilexLearn\Twig;

use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class MyExtension extends Twig_Extension
{
    public function getName()
    {
        return 'silex_learn';
    }

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('demo_filter', array($this, 'demoFilter')),
            new Twig_SimpleFilter('dump', array($this, 'dump')),
        );
    }

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('demo_custom_func', array($this, 'demoCustomFunc'))
        );
    }

    public function demoFilter()
    {
        return 'demo_filter';
    }

    public function demoCustomFunc()
    {
        return 'demo_custom_func';
    }

    public function dump($args)
    {
        return dump($args);
    }
}