<?php
/**
 * This file is part of the Common package, a StreamCommon open software project.
 *
 * @copyright (c) 2019 StreamCommon Team.
 * @see https://github.com/streamcommon/doctrine-container-interop
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Streamcommon\Doctrine\Container\Interop\Factory;

use Doctrine\Common\Cache\{FilesystemCache, PredisCache, MemcachedCache, RedisCache, CacheProvider};
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Container\Interop\Options\Cache as CacheOptions;
use Streamcommon\Doctrine\Container\Interop\Exception\{RuntimeException};

/**
 * Class CacheFactory
 *
 * @package Streamcommon\Doctrine\Container\Interop\Factory
 */
class CacheFactory extends AbstractFactory
{
    /**
     * CacheFactory constructor.
     *
     * @param string $name
     */
    public function __construct(string $name = 'array')
    {
        parent::__construct($name);
    }

    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return CacheProvider
     */
    public function __invoke(ContainerInterface $container, string $requestedName, ?array $options = null): object
    {
        $options = new CacheOptions($this->getOptions($container, 'cache'));

        $className = $options->getClassName();
        if ($className === null) {
            throw new RuntimeException('Missing className config key');
        }
        if ($container->has($className)) {
            return $container->get($className);
        }

        $instance = $options->getInstance();
        if ($instance !== null && $container->has($instance)) {
            $instance = $container->get($instance);
        }

        switch ($options->getClassName()) {
            case FilesystemCache::class:
                $cache = new $className($options->getPath());
                break;
            case PredisCache::class:
                $cache = new $className($instance);
                break;
            default:
                if (!class_exists($className)) {
                    throw new RuntimeException(sprintf('Class with name "%s" not exists', $className));
                }
                $cache = new $className();
                break;
        }
        if ($cache instanceof MemcachedCache) {
            $cache->setMemcached($instance);
        }
        if ($cache instanceof RedisCache) {
            $cache->setRedis($instance);
        }
        if ($cache instanceof CacheProvider && $options->getNamespace() !== null) {
            $cache->setNamespace($options->getNamespace());
        }
        return $cache;
    }
}