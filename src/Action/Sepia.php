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
 * Adds a sepia filter to the image.
 */
class Sepia extends Action implements Processable
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
    ): ImagerInterface|ResponseInterface {
        return $imager
            ->action(new Greyscale())
            ->action(new Brightness(-10))
            ->action(new Contrast(10))
            ->action(new Colorize(red: 38, green: 27, blue: 12))
            ->action(new Brightness(-10))
            ->action(new Contrast(10));
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Sepia filter applied to image.';
    }
}