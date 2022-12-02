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
 * Mirrors image horizontally or vertically.
 */
class Flip extends Action
{
    public const HORIZONTAL = 'horizontal';
    public const VERTICAL = 'vertical';
    
    /**
     * Create a new Flip.
     *
     * @param string $flip
     */
    public function __construct(
        protected string $flip = 'horizontal',
    ) {
        if (!in_array($flip, ['horizontal', 'vertical'])) {
            throw new ActionException('Flip value must be horizontal or vertical');
        }
    }

    /**
     * Returns the flip.
     *
     * @return string
     */
    public function flip(): string
    {
        return $this->flip;
    }
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'flip' => $this->flip,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Image :flip mirrored.';
    }
}