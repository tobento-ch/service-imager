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
 * ImagerFactoryInterface.
 */
interface ImagerFactoryInterface
{
    /**
     * Create a new imager.
     *
     * @return ImagerInterface
     */
    public function createImager(): ImagerInterface;
}