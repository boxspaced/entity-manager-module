<?php
namespace Boxspaced\EntityManagerModule;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Boxspaced\EntityManager\EntityManager;

class EntityManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->has('config') ? $container->get('config') : [];
        return new EntityManager(isset($config['entity_manager']) ? $config['entity_manager'] : []);
    }

}