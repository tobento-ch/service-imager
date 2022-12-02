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

namespace Tobento\Service\Imager\Action;

use Tobento\Service\Imager\ImagerInterface;
use Tobento\Service\Imager\Calculator\Size;
use Tobento\Service\Imager\ActionException;

/**
 * Resize image by the specified parameters.
 */
class Resize extends Action implements Calculable
{
    /**
     * @var null|int
     */
    protected null|int $srcWidth = null;
    
    /**
     * @var null|int
     */
    protected null|int $srcHeight = null;    
    
    /**
     * Create a new Resize.
     *
     * @param null|int $width
     * @param null|int $height
     * @param bool $keepRatio
     * @param null|float $upsize
     */
    public function __construct(
        protected null|int $width = null,
        protected null|int $height = null,
        protected bool $keepRatio = true,
        protected null|float $upsize = null,
    ) {}

    /**
     * Calculates the action with the specified parameters.
     *
     * @param ImagerInterface $imager
     * @param int $srcWidth
     * @param int $srcHeight
     * @return void
     * @throws ActionException
     */
    public function calculate(ImagerInterface $imager, int $srcWidth, int $srcHeight): void
    {
        $size = new Size(width: $srcWidth, height: $srcHeight);
        
        $size = $size->resize(
            width: $this->width,
            height: $this->height,
            keepRatio: $this->keepRatio,
            upsize: $this->upsize
        );
        
        $this->width = $size->getWidth();
        $this->height = $size->getHeight();
        $this->srcWidth = $srcWidth;
        $this->srcHeight = $srcHeight;
    }
    
    /**
     * Returns the width.
     *
     * @return null|int
     */
    public function width(): null|int
    {
        return $this->width;
    }
    
    /**
     * Returns the height.
     *
     * @return null|int
     */
    public function height(): null|int
    {
        return $this->height;
    }
    
    /**
     * Returns the keepRation.
     *
     * @return bool
     */
    public function keepRatio(): bool
    {
        return $this->keepRatio;
    }
    
    /**
     * Returns the upsize.
     *
     * @return null|float
     */
    public function upsize(): null|float
    {
        return $this->upsize;
    }
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'width' => $this->width,
            'height' => $this->height,
            'keepRatio' => $this->keepRatio,
            'upsize' => $this->upsize,
            'srcWidth' => $this->srcWidth,
            'srcHeight' => $this->srcHeight,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Resized image from :srcWidthx:srcHeightpx to :widthx:heightpx.';
    }
}