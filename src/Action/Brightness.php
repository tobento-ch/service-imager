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
 * Adjusts the brightness of the image.
 */
class Brightness extends Action
{
    /**
     * Create a new Brightness.
     *
     * @param int $brightness
     */
    public function __construct(
        protected int $brightness,
    ) {
        if ($brightness < -100 || $brightness > 100) {
            throw new ActionException('Brightness should be between -100 and 100');
        }
    }

    /**
     * Returns the brightness.
     *
     * @return int
     */
    public function brightness(): int
    {
        return $this->brightness;
    }
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'brightness' => $this->brightness,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Adjusted image brightness to :brightness.';
    }
}