# doctrine-manager
[![Latest Stable Version](https://poser.pugx.org/streamcommon/doctrine-manager/v/stable)](https://packagist.org/packages/streamcommon/doctrine-manager)
[![Total Downloads](https://poser.pugx.org/streamcommon/doctrine-manager/downloads)](https://packagist.org/packages/streamcommon/doctrine-manager)
[![License](https://poser.pugx.org/streamcommon/doctrine-manager/license)](./LICENSE)

This package provide [Doctrine 2](https://github.com/doctrine) factories for [PRS-11](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-11-container.md) container standard.

# Branches
[![Master][Master branch image]][Master branch] [![Build Status][Master image]][Master] [![Coverage Status][Master coverage image]][Master coverage]

[![Develop][Develop branch image]][Develop branch] [![Build Status][Develop image]][Develop] [![Coverage Status][Develop coverage image]][Develop coverage]

## Installation
Console run:
```console
    composer require streamcommon/factory-container-interop
```
Or add into your `composer.json`:
```json
    "require": {
        "streamcommon/factory-container-interop": "*"
    }
```

## Please check doctrine documentation for more info
* [ORM version 2.6](https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/index.html)
* [DBAL version 2.9](https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/index.html)
* [Event Manager version 1.0](https://www.doctrine-project.org/projects/doctrine-event-manager/en/latest/index.html)
* [Metadata driver](https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/metadata-drivers.html#metadata-drivers)
* [ORM Events](https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/events.html)
* [Doctrine Annotation >1.6](https://www.doctrine-project.org/projects/doctrine-annotations/en/1.6/index.html)
* [Caching](https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/caching.html)
* [Entity Manager](https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/working-with-objects.html)

## Example
> `Psr\Container\ContainerInterface` container MUST have `config` key

Configure your project config file: 

1. Configure doctrine configuration like: 
    ```php
    'config' => [
        'doctrine' => [
            'configuration' => [
            // If you use single connection
                'orm_default' => [
                    'result_cache' => 'array',
                    'metadata_cache' => 'array',
                    'query_cache' => 'array',
                    'hydration_cache' => 'array',
                    'driver' => 'orm_default',
                ],
             
            // If you want to add a second connection
                'orm_custom' => [
                    'result_cache' => 'memcached',
                    'metadata_cache' => 'memcached',
                    'query_cache' => 'memcached',
                    'hydration_cache' => 'memcached',
                    'driver' => 'orm_custom',
                ],
            ],
    ```
2. Configure connection options like: 
    ```php
            'connection' => [
            // If you use single connection
            // Default using MySql connection
                'orm_default' => [
                    'configuration' => 'orm_default',
                    'event_manager' => 'orm_default',
                    'params' => [
                        'dbname' => 'name',
                        'user' => 'user',
                        'password' => 'password',
                        'host' => 'localhost',
                    ],
                ],
             
            // If you want to add a second connection
            // Alternative Postgress connection
                'orm_custom' => [
                    'configuration' => 'orm_custom',
                    'event_manager' => 'orm_custom',
                    'driver_class_name' => \Doctrine\DBAL\Driver\PDOPgSql\Driver::class
                    'params' => [
                        'dbname' => 'name',
                        'user' => 'user',
                        'password' => 'password',
                        'host' => 'localhost_custom',
                    ],
                ]
            ],
    ```
3. Configure entity|event manager:
    ```php
            'entity_manager' => [
                'orm_default' => [
                    'connection' => 'orm_default',
                    'configuration' => 'orm_default',
                ],
                'orm_custom' => [
                    'connection' => 'orm_custom',
                    'configuration' => 'orm_custom',
                ]
            ],
            'event_manager' => [
                'orm_default' => [
                    'subscribers' => [],
                ],
                'orm_custom' => [
                    'subscribers' => [],
                ]
            ],
            'entity_resolver' => [
                'orm_default' => [
                    'resolvers' => [],
                ],
                'orm_custom' => [
                    'resolvers' => [],
                ],
            ],
    ```
4. Configure orm driver, for example:
    ```php
            'driver' => [
             // If you use single connection
             // Annotation driver example 
             //@see https://www.doctrine-project.org/projects/doctrine-annotations/en/1.6/index.html
                'orm_default' => [
                    'class_name' => \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                    'drivers' => [
                       'Annotation\Entity' => 'Annotation\Entity' 
                    ],
                ],
                'Annotation\Entity' => [
                    'class_name' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                    'paths' => [
                        __DIR__ . '/Annotation/Entity'
                    ]
                ],      
          
            // If you want to add a second connection
            // Php driver for example
                'orm_custom' => [
                    'class_name' => \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                    'drivers' => [
                        'PHPDriver\Entity' => 'PHPDriver\Entity'
                    ],
                ],
                'PHPDriver\Entity' => [
                    'class_name' => \Doctrine\Common\Persistence\Mapping\Driver\PHPDriver::class,
                    'paths' => [
                        __DIR__ . '/PHPDriver/Entity'
                    ]
                ], 
            ],
    ```
5. Configure doctrine cache:
    ```php
    //@see https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/caching.html
            'cache' => [
                'array' => [
                    'class_name' => Doctrine\Common\Cache\ArrayCache::class,
                    'namespace' => 'Streamcommon\Doctrine\Manager\Interop',
                ]
            ],
        ]
    ],
    ```
6. Configure your project dependencies:
    ```php
    use Streamcommon\Doctrine\Manager\Factory\{
       DriverFactory,
       EventManagerFactory,
       ConfigurationFactory,
       ConnectionFactory,
       EntityResolverFactory,
       EntityManagerFactory,
       CacheFactory};
    
    'dependencies' => [
       'factories' => [
       // If you use single connection
            'doctrine.driver.orm_default'          => DriverFactory::class,
            'doctrine.event_manager.orm_default'   => EventManagerFactory::class,
            'doctrine.configuration.orm_default'   => ConfigurationFactory::class,
            'doctrine.connection.orm_default'      => ConnectionFactory::class,
            'doctrine.entity_resolver.orm_default' => EntityResolverFactory::class,
            'doctrine.entity_manager.orm_default'  => EntityManagerFactory::class,
            'doctrine.cache.array'                 => CacheFactory::class,
        
       // If you want to add a second connection
            'doctrine.driver.orm_custom'          => [DriverFactory::class, 'orm_custom'],
            'doctrine.event_manager.orm_custom'   => [EventManagerFactory::class, 'orm_custom'],
            'doctrine.configuration.orm_custom'   => [ConfigurationFactory::class, 'orm_custom'],
            'doctrine.connection.orm_custom'      => [ConnectionFactory::class, 'orm_custom'],
            'doctrine.entity_resolver.orm_custom' => [EntityResolverFactory::class, 'orm_custom'],
            'doctrine.entity_manager.orm_custom'  => [EntityManagerFactory::class, 'orm_custom'],
        ],
    ]
    ```
7. Use in your project:
    ```php
    $em = $container->get('doctrine.entity_manager.orm_default');
    $connection = $container->get('doctrine.connection.orm_default');
    ```
    
[Master branch]: https://github.com/streamcommon/doctrine-container-manager/tree/master
[Master branch image]: https://img.shields.io/badge/branch-master-blue.svg
[Develop branch]: https://github.com/streamcommon/doctrine-container-manager/tree/develop
[Develop branch image]: https://img.shields.io/badge/branch-develop-blue.svg
[Master image]: https://travis-ci.org/streamcommon/doctrine-container-manager.svg?branch=master
[Master]: https://travis-ci.org/streamcommon/doctrine-container-manager
[Master coverage image]: https://coveralls.io/repos/github/streamcommon/doctrine-container-manager/badge.svg?branch=master
[Master coverage]: https://coveralls.io/github/streamcommon/doctrine-container-manager?branch=master
[Develop image]: https://travis-ci.org/streamcommon/doctrine-container-manager.svg?branch=develop
[Develop]: https://travis-ci.org/streamcommon/doctrine-container-manager
[Develop coverage image]: https://coveralls.io/repos/github/streamcommon/doctrine-container-manager/badge.svg?branch=develop
[Develop coverage]: https://coveralls.io/github/streamcommon/doctrine-container-manager?branch=develop