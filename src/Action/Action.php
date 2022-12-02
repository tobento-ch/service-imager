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

use Tobento\Service\Imager\ActionInterface;

/**
 * Action
 */
abstract class Action implements ActionInterface
{
    /**
     * @var null|string The action by which this action was processed.
     */
    protected null|string $processedBy = null;
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return '';
    }
    
    /**
     * Set the action by which this action was processed.
     *
     * @param string $action
     * @return static $this
     */
    public function setProcessedBy(string $action): static
    {
        $this->processedBy = $action;
        return $this;
    }
    
    /**
     * Returns the action by which this action was processed.
     *
     * @return null|string
     */
    public function processedBy(): null|string
    {
        return $this->processedBy;
    }
}