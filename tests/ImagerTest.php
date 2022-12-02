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

namespace Tobento\Service\Imager\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Imager\Imager;
use Tobento\Service\Imager\ImagerInterface;
use Tobento\Service\Imager\ProcessorInterface;
use Tobento\Service\Imager\ActionFactory;
use Tobento\Service\Imager\ResourceInterface;
use Tobento\Service\Imager\Action;
use Tobento\Service\Imager\Resource;
use Tobento\Service\Imager\Response;
use Tobento\Service\Imager\InterventionImage\ImagerFactory;
use Tobento\Service\Imager\InterventionImage\ProcessorFactory;
use Tobento\Service\Filesystem\Dir;

/**
 * ImagerTest
 */
class ImagerTest extends TestCase
{
    public function testConstructorAndThatImplementsImagerInterface()
    {
        $imager = new Imager(
            processorFactory: new ProcessorFactory(),
            actionFactory: new ActionFactory()
        );
        
        $this->assertInstanceof(
            ImagerInterface::class,
            $imager
        );
    }
    
    public function testResourceMethods()
    {
        $imager = (new ImagerFactory())->createImager();
        
        $this->assertSame(null, $imager->getResource());
        
        $resource = new Resource\File(__DIR__.'/src/image.jpg');
        
        $imager->resource(resource: $resource);
        
        $this->assertSame($resource, $imager->getResource());
    }
    
    public function testGetProcessorMethod()
    {
        $imager = (new ImagerFactory())->createImager();
        
        $this->assertSame(null, $imager->getProcessor());
        
        $resource = new Resource\File(__DIR__.'/src/image.jpg');
        
        $imager->resource(resource: $resource);
        
        $this->assertInstanceof(
            ProcessorInterface::class,
            $imager->getProcessor()
        );
    }
    
    public function testFileMethod()
    {
        $imager = (new ImagerFactory())->createImager();
        
        $imager->file(file: __DIR__.'/src/image.jpg');
        
        $this->assertInstanceof(
            ResourceInterface::class,
            $imager->getResource()
        );
    }
    
    public function testActionMethod()
    {
        $imager = (new ImagerFactory())->createImager();
        
        $imager->file(file: __DIR__.'/src/image.jpg');
        
        $this->assertInstanceof(
            ImagerInterface::class,
            $imager->action(new Action\Resize(width: 100))
        );
    }
    
    public function testDynamicActionCalls()
    {
        $actions = [
            'background' => ['color' => '#333'],
            'blur' => ['blur' => 20],
            'brightness' => ['brightness' => 20],
            'colorize' => ['red' => 10, 'green' => 10, 'blue' => 10],
            'contrast' => ['contrast' => 20],
            'crop' => ['width' => 50, 'height' => 50],
            'encode' => ['mimeType' => 'image/webp'],
            'fit' => ['width' => 50, 'height' => 50],
            'flip' => [],
            'gamma' => ['gamma' => 5.5],
            'greyscale' => [],
            'orientate' => [],
            'pixelate' => ['pixelate' => 10],
            'resize' => ['width' => 50],
            'rotate' => ['degrees' => 50],
            'save' => ['filename' => __DIR__.'/src/tmp/image.jpg'],
            'sepia' => [],
            'sharpen' => ['sharpen' => 10],
        ];
        
        $imager = (new ImagerFactory())->createImager();
        
        foreach($actions as $name => $params) {
            $imager->file(file: __DIR__.'/src/image.jpg');
            $imager->$name(...$params);
        }
        
        (new Dir())->delete(__DIR__.'/src/tmp/');
        
        $this->assertTrue(true);
    }    
}