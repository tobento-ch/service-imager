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

namespace Tobento\Service\Imager;

/**
 * ActionInterface.
 */
interface ActionInterface
{
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array;
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string;
    
    /**
     * Set the action by which this action was processed.
     *
     * @param string $action
     * @return static $this
     */
    public function setProcessedBy(string $action): static;
    
    /**
     * Returns the action by which this action was processed.
     *
     * @return null|string
     */
    public function processedBy(): null|string;
}