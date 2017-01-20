# entity-manager-module

A Zend Framework 3 module for [EntityManager](https://github.com/boxspaced/entity-manager).

### Config

For full config examples, please see the EntityManager [README](https://github.com/boxspaced/entity-manager/blob/master/README.md).

```php
namespace Application;

return [
    'entity_manager' => [
        'db' => [
            // Database config
        ],
        'types' => [
            Model\User::class => [
                'mapper' => [
                    // Mapper config
                ],
                'entity' => [
                    // Entity config
                ],
            ],
        ],
    ],
];
```

### Factory

The module adds a factory to the service manager under the following key:

```
Boxspaced\EntityManager\EntityManager
```

### Custom mapper strategies

If you want to add custom mapper strategies, the best way is to create your own factory and override the one this module provides in the config:

```php
namespace Application;

use Boxspaced\EntityManager\EntityManager;

return [
    'service_manager' => [
        'factories' => [
            EntityManager::class => Service\EntityManagerFactory::class,
            // The custom (non SQL) mapper strategy:
            Model\CustomerMapperStrategy::class => Service\CustomerMapperStrategyFactory::class,
        ],
    ],
];
```

The new factory:

```php
namespace Application\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Boxspaced\EntityManager\EntityManager;
use Application\Model\CustomerMapperStrategy;

class EntityManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->has('config') ? $container->get('config') : [];

        $em = new EntityManager(isset($config['entity_manager']) ? $config['entity_manager'] : []);
        $em->addMapperStrategy($container->get(CustomerMapperStrategy::class));

        return $em;
    }

}
```
