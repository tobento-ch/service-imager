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
use Tobento\Service\Imager\InterventionImage\ImagerFactory;

/**
 * CropTest
 */
class CropTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Crop(width: 80, height: 50, x: 5, y: 10);

        $this->assertInstanceof(ActionInterface::class, $action);
        $this->assertInstanceof(Action\Calculable::class, $action);
        
        $this->assertSame(
            ['width' => 80, 'height' => 50, 'x' => 5, 'y' => 10],
            $action->parameters()
        );
        
        $this->assertSame(
            'Cropped image to width :width, height :height, x :x and y :y.',
            $action->description()
        );
    }
    
    public function testSpecificMethods()
    {
        $action = new Action\Crop(width: 80, height: 50, x: 5, y: 10);
        
        $this->assertSame(80, $action->width());
        $this->assertSame(50, $action->height());
        $this->assertSame(5, $action->x());
        $this->assertSame(10, $action->y());
    }
    
    public function testWithoutXY()
    {
        $action = new Action\Crop(width: 80, height: 50);
        
        $this->assertSame(0, $action->x());
        $this->assertSame(0, $action->y());
    }
    
    public function testCalculateMethodCentersXYIfBothAreNotSet()
    {
        $action = new Action\Crop(width: 100, height: 50);
        
        $action->calculate(
            imager: (new ImagerFactory())->createImager(),
            srcWidth: 200,
            srcHeight: 100
        );
        
        $this->assertSame(50, $action->x());
        $this->assertSame(25, $action->y());
    }    
}