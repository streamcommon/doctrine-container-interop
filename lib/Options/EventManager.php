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

namespace Streamcommon\Doctrine\Manager\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Class EventManager
 *
 * @package Streamcommon\Doctrine\Manager\Options
 */
class EventManager extends AbstractOptions
{
    /** @var array<string> */
    protected $subscribers = [];
    /** @var string */
    protected $entityResolver = 'orm_default';

    /**
     * Get subscribers
     *
     * @return array<string>
     */
    public function getSubscribers(): array
    {
        return $this->subscribers;
    }

    /**
     * Set subscribers
     *
     * @param array<string> $subscribers
     * @return EventManager
     */
    public function setSubscribers(array $subscribers): EventManager
    {
        $this->subscribers = $subscribers;
        return $this;
    }

    /**
     * Get entityResolver
     *
     * @return string
     */
    public function getEntityResolver(): string
    {
        return $this->entityResolver;
    }

    /**
     * Set entityResolver
     *
     * @param string $entityResolver
     * @return EventManager
     */
    public function setEntityResolver(string $entityResolver): EventManager
    {
        $this->entityResolver = $entityResolver;
        return $this;
    }
}
