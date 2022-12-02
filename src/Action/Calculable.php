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

use Tobento\Service\Imager\ImagerInterface;
use Tobento\Service\Imager\ActionException;

/**
 * Calculable.
 */
interface Calculable
{
    /**
     * Calculates the action with the specified parameters.
     *
     * @param ImagerInterface $imager
     * @param int $srcWidth
     * @param int $srcHeight
     * @return void
     * @throws ActionException
     */
    public function calculate(ImagerInterface $imager, int $srcWidth, int $srcHeight): void;
}