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
use Tobento\Service\Imager\InterventionImage\Processor;
use Tobento\Service\Imager\InterventionImage\ProcessorFactory;
use Tobento\Service\Imager\InterventionImage\ImagerFactory;
use Tobento\Service\Imager\ProcessorInterface;
use Tobento\Service\Imager\ImagerInterface;
use Tobento\Service\Imager\Action;
use Tobento\Service\Imager\ActionProcessException;
use Intervention\Image\ImageManager;
use Intervention\Image\Image;
use Tobento\Service\Filesystem\Dir;

/**
 * ProcessorTest
 */
class ProcessorTest extends TestCase
{
    protected function createProcessor(): Processor
    {
        return new Processor(
            image: (new ImageManager(['driver' => 'gd']))->make(__DIR__.'/../src/image.jpg')
        );
    }
    
    public function testConstructorAndThatImplementsProcessorInterface()
    {
        $this->assertInstanceof(
            ProcessorInterface::class,
            $this->createProcessor()
        );
    }
    
    public function testImageMethod()
    {
        $processor = $this->createProcessor();
        
        $this->assertInstanceof(
            Image::class,
            $processor->image()
        );
    }
    
    public function testProcessActionMethod()
    {
        $processor = $this->createProcessor();
        $imager = (new ImagerFactory())->createImager();
        
        $processedAction = $processor->processAction(
            action: new Action\Greyscale(),
            imager: $imager
        );
        
        $this->assertInstanceof(
            ImagerInterface::class,
            $processedAction
        );
    }
    
    public function testProcessActionMethodThrowsActionProcessExceptionIfActionIsNotSupported()
    {
        $this->expectException(ActionProcessException::class);
        
        $action = new class extends Action\Action {};
        
        $processor = $this->createProcessor();
        $imager = (new ImagerFactory())->createImager();
        
        $processedAction = $processor->processAction(
            action: $action,
            imager: $imager
        );    
    }
    
    public function testProcessActionMethodSupportedActions()
    {
        $actions = [
            new Action\Background(color: '#333'),
            new Action\Blur(blur: 20),
            new Action\Brightness(brightness: 20),
            new Action\Colorize(red: 10, green: 10, blue: 10),
            new Action\Contrast(contrast: 10),
            new Action\Crop(width: 80, height: 50),
            new Action\Encode(mimeType: 'image/webp'),
            new Action\Fit(width: 80, height: 50),
            new Action\Flip(flip: Action\Flip::HORIZONTAL),
            new Action\Gamma(gamma: 2.5),
            new Action\Greyscale(),
            new Action\Orientate(),
            new Action\Pixelate(pixelate: 10),
            new Action\Resize(width: 80),
            new Action\Rotate(degrees: 25.5, bgcolor: '#333333'),
            new Action\Save(filename: __DIR__.'/src/tmp/image.jpg'),
            new Action\Sepia(),
            new Action\Sharpen(sharpen: 10),
        ];
        
        $processor = $this->createProcessor();
        $imager = (new ImagerFactory())->createImager();
        $imager->file(file: __DIR__.'/../src/image.jpg');
        
        foreach($actions as $action) {
            $processor->processAction(action: $action, imager: $imager);
        }
        
        (new Dir())->delete(__DIR__.'/src/tmp/');
        
        $this->assertTrue(true);        
    }    
    
    public function testProcessActionMethodSetsProcessedByAction()
    {
        $imager = (new ImagerFactory())->createImager();
        $imager->file(file: __DIR__.'/../src/image.jpg');
        
        $imager->action(new Action\Fit(width: 50, height: 30));
        
        $response = $imager->action(new Action\Encode(mimeType: 'image/webp'));
        
        foreach($response->actions() as $index => $action) {
            $actions[$index.':'.$action::class] = $action->processedBy();
        }
        
        $this->assertSame(
            [
                '0:Tobento\Service\Imager\Action\Fit' => null,
                '1:Tobento\Service\Imager\Action\Crop' => 'Tobento\Service\Imager\Action\Fit',
                '2:Tobento\Service\Imager\Action\Resize' => 'Tobento\Service\Imager\Action\Fit',
                '3:Tobento\Service\Imager\Action\Encode' => null,
            ],
            $actions
        );        
    }
}