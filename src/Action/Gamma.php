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
 * Adjusts the gamma of the image.
 */
class Gamma extends Action
{
    /**
     * Create a new Gamma.
     *
     * @param float $gamma
     */
    public function __construct(
        protected float $gamma,
    ) {
        if ($gamma < 0.01 || $gamma > 9.99) {
            throw new ActionException('Gamma should be between 0.01 and 9.99');
        }
    }

    /**
     * Returns the gamma.
     *
     * @return float
     */
    public function gamma(): float
    {
        return $this->gamma;
    }
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'gamma' => $this->gamma,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Adjusted image gamma to :gamma.';
    }
}