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

use ArrayIterator;
use Traversable;

/**
 * Actions
 */
class Actions implements ActionsInterface
{
    /**
     * @var array<int, ActionInterface>
     */
    protected array $actions = [];
    
    /**
     * Create a new Actions.
     *
     * @param ActionInterface ...$actions
     */
    public function __construct(
        ActionInterface ...$actions
    ) {
        $this->actions = $actions;
    }
    
    /**
     * Add an action.
     *
     * @param ActionInterface $action
     * @return static $this
     */
    public function add(ActionInterface $action): static
    {
        $this->actions[] = $action;
        return $this;
    }

    /**
     * If has any actions.
     *
     * @return bool True if has actions, otherwise false.
     */
    public function empty(): bool
    {
        return empty($this->actions);
    }
    
    /**
     * Returns a new instance with the filtered actions.
     *
     * @param callable $callback
     * @return static
     */
    public function filter(callable $callback): static
    {
        $new = clone $this;
        $new->actions = array_filter($this->actions, $callback);
        return $new;
    }
    
    /**
     * Returns a new instance with the specified action(s) only.
     *
     * @param string ...$action
     * @return static
     */
    public function only(string ...$action): static
    {
        return $this->filter(fn(ActionInterface $a): bool => in_array($a::class, $action));
    }
    
    /**
     * Returns a new instance except the specified action(s).
     *
     * @param string ...$action
     * @return static
     */
    public function except(string ...$action): static
    {
        return $this->filter(fn(ActionInterface $a): bool => !in_array($a::class, $action));
    }
    
    /**
     * Returns a new instance without actions processed by another.
     *
     * @return static
     */
    public function withoutProcessedBy(): static
    {
        return $this->filter(
            fn(ActionInterface $a): bool => empty($a->processedBy())
        );
    }
    
    /**
     * Returns all actions.
     *
     * @return array<int, ActionInterface>
     */
    public function all(): array
    {
        return $this->actions;
    }
    
    /**
     * Returns the iterator. 
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {    
        return new ArrayIterator($this->all());
    }
}