<?php
/**
 * This file is part of the doctrine-manager package, a StreamCommon open software project.
 *
 * @copyright (c) 2019 StreamCommon Team
 * @see https://github.com/streamcommon/doctrine-manager
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Streamcommon\Test\Doctrine\Manager;

use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use Streamcommon\Doctrine\Manager\ORM\Factory\EntityResolver as EntityResolverFactory;

/**
 * Class EntityResolverFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Manager
 */
class EntityResolverFactoryTest extends AbstractFactoryTest
{
    /**
     * Default entity resolver factory creation
     *
     * @return void
     */
    public function testEntityResolverFactoryCreation(): void
    {
        $factory        = new EntityResolverFactory('orm_default');
        $entityResolver = $factory($this->getContainer(), 'doctrine.entity_resolver.orm_default');

        $this->assertInstanceOf(ResolveTargetEntityListener::class, $entityResolver);
    }
}
