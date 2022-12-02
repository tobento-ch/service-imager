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

namespace Tobento\Service\Imager\InterventionImage;

use Tobento\Service\Imager\ImagerFactoryInterface;
use Tobento\Service\Imager\ImagerInterface;
use Tobento\Service\Imager\Imager;
use Intervention\Image\ImageManager;

/**
 * ImagerFactory
 */
class ImagerFactory implements ImagerFactoryInterface
{
    /**
     * Create a new ImagerFactory.
     *
     * @param array $config
     */
    public function __construct(
        protected array $config = ['driver' => 'gd']
    ) {}
    
    /**
     * Create a new imager.
     *
     * @return ImagerInterface
     */
    public function createImager(): ImagerInterface
    {
        return new Imager(
            processorFactory: new ProcessorFactory($this->config)
        );
    }
}