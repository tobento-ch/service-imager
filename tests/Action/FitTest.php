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

namespace Tobento\Service\Imager\Test\Action;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Imager\Action;
use Tobento\Service\Imager\ActionInterface;
use Tobento\Service\Imager\ImagerInterface;
use Tobento\Service\Imager\InterventionImage\ImagerFactory;
use Tobento\Service\Filesystem\Dir;

/**
 * FitTest
 */
class FitTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Fit(width: 80, height: 50, position: 'left', upsize: 1.2);

        $this->assertInstanceof(ActionInterface::class, $action);
        $this->assertInstanceof(Action\Processable::class, $action);
        
        $this->assertSame(
            ['width' => 80, 'height' => 50, 'position' => 'left', 'upsize' => 1.2],
            $action->parameters()
        );
        
        $this->assertSame(
            'Image fitted to width :width, height :height positioned :position.',
            $action->description()
        );
    }
    
    public function testSpecificMethods()
    {
        $action = new Action\Fit(width: 80, height: 50, position: 'left', upsize: 1.2);
        $this->assertSame(80, $action->width());
        $this->assertSame(50, $action->height());
        $this->assertSame('left', $action->position());
        $this->assertSame(1.2, $action->upsize());
        
        $action = new Action\Fit(width: 80, height: 50);
        $this->assertSame(80, $action->width());
        $this->assertSame(50, $action->height());
        $this->assertSame('center', $action->position());
        $this->assertSame(null, $action->upsize());        
    }
    
    public function testProcessMethodReturnsImager()
    {
        $imager = (new ImagerFactory())->createImager();
        $imager->file(file: __DIR__.'/../src/image.jpg');
        
        $action = new Action\Fit(width: 80, height: 50);
        
        $response = $action->process(imager: $imager, srcWidth: 200, srcHeight: 100);
        
        $this->assertInstanceof(ImagerInterface::class, $response);
    }
    
    public function testProcessMethodCallsCropAndResizeAction()
    {
        $imager = (new ImagerFactory())->createImager();
        $imager->file(file: __DIR__.'/../src/image.jpg');
        
        $action = new Action\Fit(width: 80, height: 50);
        $action->process(imager: $imager, srcWidth: 200, srcHeight: 100);
        
        $response = $imager->action(new Action\Save(__DIR__.'/../src/tmp/image.jpg'));
        
        $this->assertSame(80, $response->width());
        $this->assertSame(50, $response->height());
        
        $actions = [];
        
        foreach($response->actions() as $action) {
            $actions[] = $action::class;
        }
        
        $this->assertSame(
            [
                'Tobento\Service\Imager\Action\Crop',
                'Tobento\Service\Imager\Action\Resize',
                'Tobento\Service\Imager\Action\Save',
            ],
            $actions
        );
        
        (new Dir())->delete(__DIR__.'/src/tmp/');
    }
}