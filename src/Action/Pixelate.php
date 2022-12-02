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
 * Pixelates the image.
 */
class Pixelate extends Action
{
    /**
     * Create a new Pixelate.
     *
     * @param int $pixelate
     */
    public function __construct(
        protected int $pixelate,
    ) {
        if ($pixelate < 0 || $pixelate > 1000) {
            throw new ActionException('Pixelate value should be between 0 and 1000');
        }
    }

    /**
     * Returns the pixelate.
     *
     * @return int
     */
    public function pixelate(): int
    {
        return $this->pixelate;
    }
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'pixelate' => $this->pixelate,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Pixelated image by :pixelate.';
    }
}