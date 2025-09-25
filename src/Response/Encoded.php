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
     * Create a new Encoded instance.
     *
     * @param string $encoded The encoded image data.
     * @param string $mimeType
     * @param string $extension
     * @param int $width
     * @param int $height
     * @param null|int|float $size
     * @param ActionsInterface $actions
     */
    public function __construct(
        protected string $encoded,
        protected string $mimeType,
        protected string $extension,
        protected int $width,
        protected int $height,
        protected null|int|float $size,
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
     * Returns the extension such as "jpg".
     *
     * @return string
     */
    public function extension(): string
    {
        return $this->extension;
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
     * @return null|int|float
     */
    public function size(): null|int|float
    {
        return $this->size;
    }
    
    /**
     * Returns a human-readable size.
     *
     * @param int $precision
     * @return string
     * @psalm-suppress InvalidOperand
     */
    public function humanSize(int $precision = 2): string
    {
        $bytes = $this->size();
        
        if (is_null($bytes)) {
            $bytes = 0;
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        for ($i = 0; ($bytes / 1024) > 0.9 && ($i < count($units) - 1); $i++) {
            $bytes /= 1024;
        }
        
        return sprintf('%s %s', round($bytes, $precision), $units[$i] ?? '');
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