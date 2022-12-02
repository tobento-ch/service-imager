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
use Psr\Http\Message\StreamInterface;

/**
 * Stream resource.
 */
class Stream implements ResourceInterface
{
    /**
     * Create a new Stream.
     *
     * @param StreamInterface $stream
     */
    public function __construct(
        protected StreamInterface $stream
    ) {}

    /**
     * Returns the stream.
     *
     * @return StreamInterface
     */
    public function stream(): StreamInterface
    {
        return $this->stream;
    }
}