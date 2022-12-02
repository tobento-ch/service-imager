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

namespace Tobento\Service\Imager\Response;

use Tobento\Service\Imager\ResponseInterface;
use Tobento\Service\Imager\ActionsInterface;
use Tobento\Service\Imager\ImageFormats;
use Stringable;

/**
 * Encoded
 */
class Encoded implements ResponseInterface, Stringable
{    
    /**
     * Create a new File.
     *
     * @param string $encoded The encoded image data.
     * @param string $mimeType
     * @param int $width
     * @param int $height
     * @param null|int $size
     * @param ActionsInterface $actions
     */
    public function __construct(
        protected string $encoded,
        protected string $mimeType,
        protected int $width,
        protected int $height,
        protected null|int $size,
        protected ActionsInterface $actions
    ) {}
        
    /**
     * Returns the encoded image data.
     *
     * @return string
     */
    public function encoded(): string
    {
        return $this->encoded;
    }
    
    /**
     * Returns the mimeType.
     *
     * @return string
     */
    public function mimeType(): string
    {
        return $this->mimeType;
    }
    
    /**
     * Returns the width.
     *
     * @return int
     */
    public function width(): int
    {
        return $this->width;
    }
    
    /**
     * Returns the height.
     *
     * @return int
     */
    public function height(): int
    {
        return $this->height;
    }
    
    /**
     * Returns the size.
     *
     * @return null|int
     */
    public function size(): null|int
    {
        return $this->size;
    }
    
    /**
     * Returns the base 64 encoded image.
     *
     * @return string
     */
    public function base64(): string
    {
        return base64_encode($this->encoded);
    }
    
    /**
     * Returns the data url.
     *
     * @return string
     */
    public function dataUrl(): string
    {
        return sprintf('data:%s;base64,%s', $this->mimeType(), $this->base64());        
    }
    
    /**
     * Returns the actions processed.
     *
     * @return ActionsInterface
     */
    public function actions(): ActionsInterface
    {
        return $this->actions;
    }
    
    /**
     * Returns the encoded image data.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->encoded();
    }
}