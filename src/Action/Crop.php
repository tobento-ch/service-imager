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
use Tobento\Service\Imager\Calculator\Position;
use Tobento\Service\Imager\ActionException;

/**
 * Crop image by the specified parameters.
 */
class Crop extends Action implements Calculable
{
    /**
     * Create a new Crop.
     *
     * @param int $width
     * @param int $height
     * @param null|int $x
     * @param null|int $y
     */
    public function __construct(
        protected int $width,
        protected int $height,
        protected null|int $x = null,
        protected null|int $y = null,
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
        if (is_null($this->x) && is_null($this->y)) {

            $pos = (new Position($srcWidth, $srcHeight))
                ->align('center')
                ->relative(
                    (new Position($this->width, $this->height))->align('center')
                );
            
            $this->x = $pos->x();
            $this->y = $pos->y();
        }
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
     * Returns the x.
     *
     * @return int
     */
    public function x(): int
    {
        return $this->x ?: 0;
    }
    
    /**
     * Returns the y.
     *
     * @return int
     */
    public function y(): int
    {
        return $this->y ?: 0;
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
            'x' => $this->x,
            'y' => $this->y,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Cropped image to width :width, height :height, x :x and y :y.';
    }
}