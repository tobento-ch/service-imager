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
 * ProcessorInterface.
 */
interface ProcessorInterface
{
    /**
     * Process the action.
     *
     * @param ActionInterface $action
     * @param ImagerInterface $imager
     * @return ImagerInterface|ResponseInterface
     * @throws ActionProcessException
     */
    public function processAction(
        ActionInterface $action,
        ImagerInterface $imager
    ): ImagerInterface|ResponseInterface;
}