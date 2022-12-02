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

namespace Tobento\Service\Imager\Test\InterventionImage;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Imager\InterventionImage\ProcessorFactory;
use Tobento\Service\Imager\ProcessorFactoryInterface;
use Tobento\Service\Imager\ProcessorInterface;
use Tobento\Service\Imager\Resource;
use Tobento\Service\Imager\ProcessorCreateException;
use GuzzleHttp\Psr7;

/**
 * ProcessorFactoryTest
 */
class ProcessorFactoryTest extends TestCase
{
    public function testThatImplementsProcessorFactoryInterface()
    {
        $processorFactory = new ProcessorFactory(config: ['driver' => 'gd']);
        
        $this->assertInstanceof(
            ProcessorFactoryInterface::class,
            $processorFactory
        );
    }
    
    public function testCreateProcessorMethod()
    {
        $processorFactory = new ProcessorFactory();
        
        $this->assertInstanceof(
            ProcessorInterface::class,
            $processorFactory->createProcessor(new Resource\File(__DIR__.'/../src/image.jpg'))
        );
    }
    
    public function testCreateProcessorMethodSupportedResources()
    {
        $binary = file_get_contents(__DIR__.'/../src/image.jpg');
        $base64 = base64_encode($binary);
        $dataUrl = sprintf('data:%s;base64,%s', 'image/jpeg', $base64);
            
        $resources = [
            new Resource\Base64(data: $base64),
            new Resource\Binary(data: $binary),
            new Resource\DataUrl(data: $dataUrl),
            new Resource\File(file: __DIR__.'/../src/image.jpg'),
            new Resource\Stream(stream: Psr7\Utils::streamFor($binary)),
        ];
        
        $processorFactory = new ProcessorFactory();
        
        foreach($resources as $resource) {
            $this->assertInstanceof(
                ProcessorInterface::class,
                $processorFactory->createProcessor($resource)
            );
        }
        
        // specific data url test
        try {
            $this->assertInstanceof(
                ProcessorInterface::class,
                $processorFactory->createProcessor(new Resource\Url(url: 'url'))
            );
        } catch (ProcessorCreateException $e) {
            $this->assertSame(
                'Unable to create processor',
                $e->getMessage()
            );
        }
    }    
}