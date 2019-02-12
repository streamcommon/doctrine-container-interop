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

use Psr\Container\ContainerInterface;
use Streamcommon\Factory\Container\Interop\FactoryInterface;
use Streamcommon\Doctrine\Container\Interop\Exception\{RuntimeException};

/**
 * Class AbstractFactory
 *
 * @package Streamcommon\Doctrine\Container\Interop\Factory
 */
abstract class AbstractFactory implements FactoryInterface
{
    /** @var string */
    protected $ormName;

    /**
     * AbstractFactory constructor.
     *
     * @param string $ormName
     */
    public function __construct(string $ormName = 'orm_default')
    {
        $this->ormName = $ormName;
    }

    /**
     * Gets options from configuration based on name.
     *
     * @param ContainerInterface $container
     * @param string $key
     * @param string|null $ormName
     * @return array
     * @throws RuntimeException
     */
    public function getOptions(ContainerInterface $container, string $key, string $ormName = null): array
    {
        if ($ormName === null) {
            $ormName = $this->ormName;
        }
        $config = $container->has('config') ? $container->get('config') : [];
        $doctrineConfig = !empty($config['doctrine']) ? $config['doctrine'] : [];
        $ormConfig = !empty($doctrineConfig[$key]) ? $doctrineConfig[$key] : [];

        if (empty($ormConfig[$ormName])) {
            throw new RuntimeException(sprintf(
                'Options with name %s could not be found in doctrine.%s.',
                $ormName,
                $key
            ));
        }

        return $ormConfig[$ormName];
    }
}