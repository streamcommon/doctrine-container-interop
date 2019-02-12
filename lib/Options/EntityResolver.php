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

namespace Streamcommon\Doctrine\Container\Interop\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class EntityResolver
 *
 * @package Streamcommon\Doctrine\Container\Interop\Options
 */
class EntityResolver extends AbstractOptions
{
    /** @var array */
    protected $resolvers = [];

    /**
     * Get resolvers
     *
     * @return array
     */
    public function getResolvers(): array
    {
        return $this->resolvers;
    }

    /**
     * Set resolvers
     *
     * @param array $resolvers
     * @return EntityResolver
     */
    public function setResolvers(array $resolvers): EntityResolver
    {
        $this->resolvers = $resolvers;
        return $this;
    }
}