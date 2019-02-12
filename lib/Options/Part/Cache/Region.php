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

namespace Streamcommon\Doctrine\Container\Interop\Options\Part\Cache;

use Zend\Stdlib\AbstractOptions;

/**
 * Class Region
 *
 * @package Streamcommon\Doctrine\Container\Interop\Options\Part\Cache
 */
class Region extends AbstractOptions
{
    /** @var string|null */
    protected $name;
    /** @var int */
    protected $lifetime = 3600;
    /** @var int */
    protected $lockLifetime = 60;

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string|null $name
     * @return Region
     */
    public function setName(?string $name): Region
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get lifetime
     *
     * @return int
     */
    public function getLifetime(): int
    {
        return $this->lifetime;
    }

    /**
     * Set lifetime
     *
     * @param int $lifetime
     * @return Region
     */
    public function setLifetime(int $lifetime): Region
    {
        $this->lifetime = $lifetime;
        return $this;
    }

    /**
     * Get lockLifetime
     *
     * @return int
     */
    public function getLockLifetime(): int
    {
        return $this->lockLifetime;
    }

    /**
     * Set lockLifetime
     *
     * @param int $lockLifetime
     * @return Region
     */
    public function setLockLifetime(int $lockLifetime): Region
    {
        $this->lockLifetime = $lockLifetime;
        return $this;
    }
}