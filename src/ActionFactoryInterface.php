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
 * ActionFactoryInterface.
 */
interface ActionFactoryInterface
{
    /**
     * Create a new action.
     *
     * @param string $name
     * @param array $parameters
     * @return ActionInterface
     * @throws ActionCreateException
     */
    public function createAction(string $name, array $parameters): ActionInterface;
}