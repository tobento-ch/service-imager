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
 * Adjusts the contrast of the image.
 */
class Contrast extends Action
{
    /**
     * Create a new Contrast.
     *
     * @param int $contrast
     */
    public function __construct(
        protected int $contrast,
    ) {
        if ($contrast < -100 || $contrast > 100) {
            throw new ActionException('Contrast should be between -100 and 100');
        }
    }

    /**
     * Returns the contrast.
     *
     * @return int
     */
    public function contrast(): int
    {
        return $this->contrast;
    }
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'contrast' => $this->contrast,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Adjusted image contrast to :contrast.';
    }
}