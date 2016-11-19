<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 11/19/16
 */

namespace Blog\Factory;


use Blog\Model\ZendDbSqlCommand;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ZendDbSqlCommandFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ZendDbSqlCommand($container->get(AdapterInterface::class));
    }
}