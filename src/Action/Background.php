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

/**
 * Applies the specified background color for transparent images.
 */
class Background extends Action
{
    /**
     * Create a new Background.
     *
     * @param string $color
     */
    public function __construct(
        protected string $color
    ) {}

    /**
     * Returns the color.
     *
     * @return string
     */
    public function color(): string
    {
        return $this->color;
    }
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'color' => $this->color,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Background color :color applied to image if transparent.';
    }
}