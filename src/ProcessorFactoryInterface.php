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
 * ProcessorFactoryInterface.
 */
interface ProcessorFactoryInterface
{
    /**
     * Create a new processor.
     *
     * @param ResourceInterface $resource
     * @return ProcessorInterface
     * @throws ProcessorCreateException
     */
    public function createProcessor(ResourceInterface $resource): ProcessorInterface;
}