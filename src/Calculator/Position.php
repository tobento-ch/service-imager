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
 * Position
 */
final class Position
{
    /**
     * Create a new Position.
     *
     * @param int $width
     * @param int $height
     * @param int $x
     * @param int $y
     */
    public function __construct(
        protected int $width,
        protected int $height,
        protected int $x = 0,
        protected int $y = 0
    ) {}
    
    /**
     * Returns the x.
     *
     * @return int
     */
    public function x(): int
    {
        return $this->x;
    }
    
    /**
     * Returns the y.
     *
     * @return int
     */
    public function y(): int
    {
        return $this->y;
    }

    /**
     * Returns a new instance with the calculated relative position.
     *
     * @param Position $position
     * @return static
     */
    public function relative(Position $position): static
    {
        $x = $this->x() - $position->x();
        $y = $this->y() - $position->y();

        return new static($this->width, $this->height, $x, $y);
    }
    
    /**
     * Returns a new instance with the calculated aligned position.
     *
     * @param string $position
     * @param int $offsetX
     * @param int $offsetY
     * @return static
     */
    public function align(string $position, int $offsetX = 0, int $offsetY = 0): static
    {
        switch (strtolower($position)) {

            case 'top':
            case 'top-center':
            case 'top-middle':
            case 'center-top':
            case 'middle-top':
                $x = intval($this->width / 2);
                $y = 0 + $offsetY;
                break;

            case 'top-right':
            case 'right-top':
                $x = $this->width - $offsetX;
                $y = 0 + $offsetY;
                break;

            case 'left':
            case 'left-center':
            case 'left-middle':
            case 'center-left':
            case 'middle-left':
                $x = 0 + $offsetX;
                $y = intval($this->height / 2);
                break;

            case 'right':
            case 'right-center':
            case 'right-middle':
            case 'center-right':
            case 'middle-right':
                $x = $this->width - $offsetX;
                $y = intval($this->height / 2);
                break;

            case 'bottom-left':
            case 'left-bottom':
                $x = 0 + $offsetX;
                $y = $this->height - $offsetY;
                break;

            case 'bottom':
            case 'bottom-center':
            case 'bottom-middle':
            case 'center-bottom':
            case 'middle-bottom':
                $x = intval($this->width / 2);
                $y = $this->height - $offsetY;
                break;

            case 'bottom-right':
            case 'right-bottom':
                $x = $this->width - $offsetX;
                $y = $this->height - $offsetY;
                break;

            case 'center':
            case 'middle':
            case 'center-center':
            case 'middle-middle':
                $x = intval($this->width / 2) + $offsetX;
                $y = intval($this->height / 2) + $offsetY;
                break;

            default:
            case 'top-left':
            case 'left-top':
                $x = 0 + $offsetX;
                $y = 0 + $offsetY;
                break;
        }
        
        return new static($this->width, $this->height, $x, $y);
    }
}