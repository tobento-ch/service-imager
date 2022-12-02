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

use IteratorAggregate;

/**
 * ActionsInterface.
 */
interface ActionsInterface extends IteratorAggregate
{
    /**
     * Add an action.
     *
     * @param ActionInterface $action
     * @return static $this
     */
    public function add(ActionInterface $action): static;

    /**
     * If has any actions.
     *
     * @return bool True if has actions, otherwise false.
     */
    public function empty(): bool;
    
    /**
     * Returns a new instance with the filtered actions.
     *
     * @param callable $callback
     * @return static
     */
    public function filter(callable $callback): static;
    
    /**
     * Returns a new instance with the specified action(s) only.
     *
     * @param string ...$action
     * @return static
     */
    public function only(string ...$action): static;
    
    /**
     * Returns a new instance except the specified action(s).
     *
     * @param string ...$action
     * @return static
     */
    public function except(string ...$action): static;

    /**
     * Returns a new instance without actions processed by another.
     *
     * @return static
     */
    public function withoutProcessedBy(): static;
    
    /**
     * Returns all actions.
     *
     * @return array<int, ActionInterface>
     */
    public function all(): array;
}