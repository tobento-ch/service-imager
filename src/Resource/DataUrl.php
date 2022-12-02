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
 * DataUrl resource.
 */
class DataUrl implements ResourceInterface
{
    /**
     * Create a new DataUrl.
     *
     * @param string $data
     */
    public function __construct(
        protected string $data
    ) {}

    /**
     * Returns the data url.
     *
     * @return string
     */
    public function data(): string
    {
        return $this->data;
    }
}