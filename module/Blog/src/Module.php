<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 11/18/16
 */

namespace Blog;


use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}