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
 * SepiaTest
 */
class SepiaTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Sepia();

        $this->assertInstanceof(ActionInterface::class, $action);
        $this->assertInstanceof(Action\Processable::class, $action);
        
        $this->assertSame(
            [],
            $action->parameters()
        );
        
        $this->assertSame(
            'Sepia filter applied to image.',
            $action->description()
        );
    }
    
    public function testProcessMethodReturnsImager()
    {
        $imager = (new ImagerFactory())->createImager();
        $imager->file(file: __DIR__.'/../src/image.jpg');
        
        $action = new Action\Sepia();
        
        $response = $action->process(imager: $imager, srcWidth: 200, srcHeight: 100);
        
        $this->assertInstanceof(ImagerInterface::class, $response);
    }    
    
    public function testProcessMethodCallsActionToCreateSepia()
    {
        $imager = (new ImagerFactory())->createImager();
        $imager->file(file: __DIR__.'/../src/image.jpg');
        
        $action = new Action\Sepia();
        $action->process(imager: $imager, srcWidth: 200, srcHeight: 100);
        
        $response = $imager->action(new Action\Save(__DIR__.'/../src/tmp/image.jpg'));
        
        $actions = [];
        
        foreach($response->actions()->except(Action\Save::class) as $index => $action) {
            $actions[$index.':'.$action::class] = $action->parameters();
        }
        
        $this->assertSame(
            [
                '0:Tobento\Service\Imager\Action\Greyscale' => [],
                '1:Tobento\Service\Imager\Action\Brightness' => ['brightness' => -10],
                '2:Tobento\Service\Imager\Action\Contrast' => ['contrast' => 10],
                '3:Tobento\Service\Imager\Action\Colorize' => ['red' => 38, 'green' => 27, 'blue' => 12],
                '4:Tobento\Service\Imager\Action\Brightness' => ['brightness' => -10],
                '5:Tobento\Service\Imager\Action\Contrast' => ['contrast' => 10],
            ],
            $actions
        );
        
        (new Dir())->delete(__DIR__.'/src/tmp/');
    }
}