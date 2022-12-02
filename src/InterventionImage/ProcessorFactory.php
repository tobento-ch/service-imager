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

use Tobento\Service\Imager\ProcessorFactoryInterface;
use Tobento\Service\Imager\ProcessorInterface;
use Tobento\Service\Imager\ResourceInterface;
use Tobento\Service\Imager\Resource;
use Tobento\Service\Imager\ProcessorCreateException;
use Intervention\Image\ImageManager;
use Exception;

/**
 * ProcessorFactory
 */
class ProcessorFactory implements ProcessorFactoryInterface
{
    /**
     * Create a new ProcessorFactory.
     *
     * @param array $config
     */
    public function __construct(
        protected array $config = ['driver' => 'gd']
    ) {}    
    
    /**
     * Create a new processor.
     *
     * @param ResourceInterface $resource
     * @return ProcessorInterface
     * @throws ProcessorCreateException
     */
    public function createProcessor(ResourceInterface $resource): ProcessorInterface
    {
        $src = null;
        
        switch ($resource::class) {
            case Resource\File::class:
                $src = $resource->file()->getFile();
                break;
            case Resource\Url::class:
                $src = $resource->url();
                break;
            case Resource\Binary::class:
                $src = $resource->data();
                break;
            case Resource\Base64::class:
                $src = $resource->data();
                break;
            case Resource\Stream::class:
                $src = $resource->stream();
                break;
            case Resource\DataUrl::class:
                $src = $resource->data();
                break;
        }
        
        if (is_null($src)) {
            throw new ProcessorCreateException('Unsupported resource: '.$resource::class);
        }
                
        try {
            $manager = new ImageManager($this->config);
            return new Processor($manager->make($src));
        } catch (Exception $e) {
            throw new ProcessorCreateException('Unable to create processor', 0, $e);
        }
    }    
}