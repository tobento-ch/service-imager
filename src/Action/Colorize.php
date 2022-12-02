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

use Tobento\Service\Imager\ActionException;

/**
 * Colorize the image.
 */
class Colorize extends Action
{
    /**
     * Create a new Colorize.
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     */
    public function __construct(
        protected int $red,
        protected int $green,
        protected int $blue,
    ) {
        if ($red < -100 || $red > 100) {
            throw new ActionException('red should be between -100 and 100');
        }
        
        if ($green < -100 || $green > 100) {
            throw new ActionException('green should be between -100 and 100');
        }
        
        if ($blue < -100 || $blue > 100) {
            throw new ActionException('blue should be between -100 and 100');
        }        
    }

    /**
     * Returns the red.
     *
     * @return int
     */
    public function red(): int
    {
        return $this->red;
    }
    
    /**
     * Returns the green.
     *
     * @return int
     */
    public function green(): int
    {
        return $this->green;
    }
    
    /**
     * Returns the blue.
     *
     * @return int
     */
    public function blue(): int
    {
        return $this->blue;
    }
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'red' => $this->red,
            'green' => $this->green,
            'blue' => $this->blue,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Colorized image with red :red, green :green amd blue :blue.';
    }
}