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
 * Rotates image by the specified number of degrees clockwise.
 */
class Rotate extends Action
{
    /**
     * Create a new Rotate.
     *
     * @param float $degrees
     * @param string $bgcolor Background color to fill empty triangles left overs.
     */
    public function __construct(
        protected float $degrees,
        protected string $bgcolor = '#ffffff'
    ) {
        $this->degrees = fmod($degrees, 360);
        
        if (preg_match('/^#(?:(?:[0-9a-f]{3}){1,2}|(?:[0-9a-f]{4}){1})$/i', $bgcolor) !== 1) {
            throw new ActionException('bgcolor should be a valid HEX color without alpha');
        }
    }

    /**
     * Returns the degrees.
     *
     * @return float
     */
    public function degrees(): float
    {
        return $this->degrees;
    }
    
    /**
     * Returns the bgcolor.
     *
     * @return string
     */
    public function bgcolor(): string
    {
        return $this->bgcolor;
    }
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'degrees' => $this->degrees,
            'bgcolor' => $this->bgcolor,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Image rotated :degrees degrees and filled empty triangles left overs with background color :bgcolor.';
    }
}