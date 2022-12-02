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
use Tobento\Service\Imager\ResponseInterface;
use Tobento\Service\Imager\ActionException;

/**
 * Processable.
 */
interface Processable
{
    /**
     * Process the action.
     *
     * @param ImagerInterface $imager
     * @param int $srcWidth
     * @param int $srcHeight     
     * @return ImagerInterface|ResponseInterface
     * @throws ActionException
     */
    public function process(
        ImagerInterface $imager,
        int $srcWidth,
        int $srcHeight
    ): ImagerInterface|ResponseInterface;
}