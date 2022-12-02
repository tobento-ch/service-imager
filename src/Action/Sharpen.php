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
 * Sharpens the image.
 */
class Sharpen extends Action
{
    /**
     * Create a new Sharpen.
     *
     * @param int $sharpen
     */
    public function __construct(
        protected int $sharpen,
    ) {
        if ($sharpen < 0 || $sharpen > 100) {
            throw new ActionException('Sharpen value should be between 0 and 100');
        }
    }

    /**
     * Returns the sharpen.
     *
     * @return int
     */
    public function sharpen(): int
    {
        return $this->sharpen;
    }
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'sharpen' => $this->sharpen,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Sharpened image by :sharpen.';
    }
}