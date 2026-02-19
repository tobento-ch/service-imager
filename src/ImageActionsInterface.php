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
 * Contract for managing and validating Imager actions.
 *
 * Implementations of this interface provide high-level functionality for
 * working with image manipulation actions, including:
 * - defining which actions are allowed
 * - validating user-provided actions and parameters
 * - filtering actions (e.g., filters vs non-filters)
 * - creating ActionInterface instances safely
 *
 * This interface is used by higher-level components such as image editors
 * to ensure only supported and valid actions reach the Imager processor.
 */
interface ImageActionsInterface extends ActionFactoryInterface
{
    /**
     * Returns a new instance with the specified allowed actions.
     *
     * @param array<array-key, string> The allowed actions such as ['crop', 'resize']
     * @return static
     */
    public function withActions(array $actions): static;
    
    /**
     * Returns a new instance with filters or non filters actions.
     *
     * @param bool $filters
     * @return static
     */
    public function filters(bool $filters = true): static;
    
    /**
     * Returns all actions.
     *
     * @return array<array-key, string>
     */
    public function all(): array;
    
    /**
     * Returns true if action exists, otherwise false.
     *
     * @return bool
     */
    public function has(string $action): bool;
    
    /**
     * Returns the allowed actions.
     *
     * @return array<array-key, class-string>
     */
    public function getAllowedActions(): array;
    
    /**
     * Returns the verified input actions.
     *
     * @param mixed $actions
     * @return array
     */
    public function verifyInputActions(mixed $actions): array;
}