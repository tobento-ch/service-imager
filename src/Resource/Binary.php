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
 * Binary resource.
 */
class Binary implements ResourceInterface
{
    /**
     * Create a new Binary.
     *
     * @param string $data
     */
    public function __construct(
        protected string $data
    ) {}

    /**
     * Returns the data.
     *
     * @return string
     */
    public function data(): string
    {
        return $this->data;
    }
}