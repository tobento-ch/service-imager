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

namespace Tobento\Service\Imager\Calculator;

/**
 * Size
 */
final class Size
{
    /**
     * Create a new Size.
     *
     * @param int $width
     * @param int $height
     */
    public function __construct(
        protected int $width,
        protected int $height
    ) {}

    /**
     * Returns the width.
     *
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }
    
    /**
     * Returns the height.
     *
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }
    
    /**
     * Returns the ratio.
     *
     * @return float
     */
    public function getRatio(): float
    {
        return $this->width / $this->height;
    }
    
    /**
     * Returns a new instance calculated with the specified width.
     *
     * @param null|int $width
     * @param float $ratio
     * @return static
     */
    public function width(null|int $width, float $ratio = 1): static
    {
        $width = $width ?: $this->width;
        
        if ($ratio <= 0) {
            return new static($width, $this->height);
        }
        
        $height = $this->calculateSize($width, $this->width, $this->height);
        
        if ($ratio == 1) {
            return new static($width, $height);
        }
        
        return new static($width, (int)round($height*$ratio));
    }
    
    /**
     * Returns a new instance calculated with the specified height.
     *
     * @param null|int $height
     * @param float $ratio
     * @return static
     */
    public function height(null|int $height, float $ratio = 1): static
    {
        $height = $height ?: $this->height;
        
        if ($ratio <= 0) {
            return new static($this->width, $height);
        }
        
        $width = $this->calculateSize($height, $this->height, $this->width);

        if ($ratio == 1) {
            return new static($width, $height);
        }        

        return new static((int)round($width*$ratio), $height);
    }
    
    /**
     * Returns a new instance calculated with the resized parameters.
     *
     * @param null|int $width
     * @param null|int $height
     * @param bool $keepRatio
     * @param null|float $upsize The upsize max number.
     * @return static
     */
    public function resize(
        null|int $width = null,
        null|int $height = null,
        bool $keepRatio = true,
        null|float $upsize = null,
    ): static {
        
        $ratio = $keepRatio ? 1 : 0;
        $size = $this->width($width, $ratio)->height($height, $ratio);        
        $sizeH = $this->height($height, $ratio)->width($width, $ratio);        
        
        // decide which size to use:
        if ($sizeH->fitsInto($this)) {
            $size = $sizeH;
        }
        
        // handle upsize:
        if (!is_null($upsize) && !$size->fitsInto($this)) {
            if ($keepRatio) {
                $size = $size->width((int)round($this->getWidth()*$upsize));
            } else {
                if ($width) {
                    $size = $size->width((int)round($this->getWidth()*$upsize), 0);
                }
                if ($height) {
                    $size = $size->height((int)round($this->getHeight()*$upsize), 0);
                }
            }
        }
        
        return new static($size->getWidth(), $size->getHeight());
    }
    
    /**
     * Returns a new instance calculated the specified size to best fitting size of current size.
     *
     * @param Size $size
     * @return static
     */
    public function fit(Size $size): static
    {
        // create size with auto height:
        $autoHeight = $size->resize(width: $this->width);

        // decide which version to use:
        if ($autoHeight->fitsInto($this)) {
            return $autoHeight;
        }
            
        // create size with auto width:
        return $size->resize(height: $this->height);
    }
    
    /**
     * Returns true if given size fits into current size, otherwise false.
     *
     * @param Size $size
     * @return bool
     */
    public function fitsInto(Size $size): bool
    {
        return ($this->width <= $size->getWidth()) && ($this->height <= $size->getHeight());
    }
    
    /**
     * Calculates the the given target size.
     *
     * @param int $targetSize
     * @param int $sizeA
     * @param int $sizeB
     * @return int
     */
    protected function calculateSize(int $targetSize, int $sizeA, int $sizeB): int
    {
        $ratio = $sizeB / $sizeA;
        return (int) round($targetSize * $ratio);
    }
}