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
 * Blurs the image.
 */
class Blur extends Action
{
    /**
     * Create a new Blur.
     *
     * @param int $blur
     */
    public function __construct(
        protected int $blur,
    ) {
        if ($blur < 0 || $blur > 100) {
            throw new ActionException('Blur value should be between 0 and 100');
        }
    }

    /**
     * Returns the blur.
     *
     * @return int
     */
    public function blur(): int
    {
        return $this->blur;
    }
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'blur' => $this->blur,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Blured image by :blur.';
    }
}