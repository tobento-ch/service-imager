<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Imager\Resource;

use Tobento\Service\Imager\ResourceInterface;

/**
 * Url resource.
 */
class Url implements ResourceInterface
{
    /**
     * Create a new url.
     *
     * @param string $url
     */
    public function __construct(
        protected string $url
    ) {}

    /**
     * Returns the url.
     *
     * @return string
     */
    public function url(): string
    {
        return $this->url;
    }
}