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
 * ResizeTest
 */
class ResizeTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Resize(width: 80, height: 50, keepRatio: true, upsize: 1.2);

        $this->assertInstanceof(ActionInterface::class, $action);
        $this->assertInstanceof(Action\Calculable::class, $action);
        
        $this->assertSame(
            [
                'width' => 80,
                'height' => 50,
                'keepRatio' => true,
                'upsize' => 1.2,
                'srcWidth' => null,
                'srcHeight' => null,
            ],
            $action->parameters()
        );
        
        $this->assertSame(
            'Resized image from :srcWidthx:srcHeightpx to :widthx:heightpx.',
            $action->description()
        );
    }
    
    public function testSpecificMethods()
    {
        $action = new Action\Resize(width: 80, height: 50, keepRatio: false, upsize: 1.2);
        
        $this->assertSame(80, $action->width());
        $this->assertSame(50, $action->height());
        $this->assertSame(false, $action->keepRatio());
        $this->assertSame(1.2, $action->upsize());
    }
    
    public function testCalculateMethodWidth()
    {
        $imager = (new ImagerFactory())->createImager();

        $action = new Action\Resize(width: 100);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(50, $action->height());
        
        $action = new Action\Resize(width: 300);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(300, $action->width());
        $this->assertSame(150, $action->height());
        
        // without keeping ratio
        $action = new Action\Resize(width: 100, keepRatio: false);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(100, $action->height());
        
        $action = new Action\Resize(width: 300, keepRatio: false);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(300, $action->width());
        $this->assertSame(100, $action->height());
        
        // with upsize
        $action = new Action\Resize(width: 100, upsize: 1.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(50, $action->height());
        
        $action = new Action\Resize(width: 500, upsize: 1.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(300, $action->width());
        $this->assertSame(150, $action->height());
        
        $action = new Action\Resize(width: 500, upsize: 0.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(50, $action->height());
        
        // without keeping ratio and with upsize
        $action = new Action\Resize(width: 100, keepRatio: false, upsize: 1.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(100, $action->height());
        
        $action = new Action\Resize(width: 500, keepRatio: false, upsize: 1.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(300, $action->width());
        $this->assertSame(100, $action->height());
        
        $action = new Action\Resize(width: 500, keepRatio: false, upsize: 0.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(100, $action->height()); 
    }
    
    public function testCalculateMethodHeight()
    {
        $imager = (new ImagerFactory())->createImager();
        
        $action = new Action\Resize(height: 50);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(50, $action->height());
        
        $action = new Action\Resize(height: 150);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(300, $action->width());
        $this->assertSame(150, $action->height());
        
        // without keeping ratio
        $action = new Action\Resize(height: 50, keepRatio: false);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(200, $action->width());
        $this->assertSame(50, $action->height());
        
        $action = new Action\Resize(height: 150, keepRatio: false);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(200, $action->width());
        $this->assertSame(150, $action->height());
        
        // with upsize
        $action = new Action\Resize(height: 50, upsize: 1.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(50, $action->height());
        
        $action = new Action\Resize(height: 300, upsize: 1.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(300, $action->width());
        $this->assertSame(150, $action->height());
        
        $action = new Action\Resize(height: 300, upsize: 0.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(50, $action->height());
        
        // without keeping ratio and with upsize
        $action = new Action\Resize(height: 50, keepRatio: false, upsize: 1.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(200, $action->width());
        $this->assertSame(50, $action->height());
        
        $action = new Action\Resize(height: 300, keepRatio: false, upsize: 1.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(200, $action->width());
        $this->assertSame(150, $action->height());
        
        $action = new Action\Resize(height: 300, keepRatio: false, upsize: 0.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(200, $action->width());
        $this->assertSame(50, $action->height());
    }
    
    public function testCalculateMethodWidthAndHeight()
    {
        $imager = (new ImagerFactory())->createImager();
        
        $action = new Action\Resize(width: 100, height: 80);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(50, $action->height());
        
        $action = new Action\Resize(width: 300, height: 80);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(160, $action->width());
        $this->assertSame(80, $action->height());
        
        // without keeping ratio
        $action = new Action\Resize(width: 100, height: 80, keepRatio: false);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(80, $action->height());
        
        $action = new Action\Resize(width: 300, height: 80, keepRatio: false);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(300, $action->width());
        $this->assertSame(80, $action->height());
        
        // with upsize
        $action = new Action\Resize(width: 100, height: 80, upsize: 1.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(50, $action->height());
        
        $action = new Action\Resize(width: 500, height: 80, upsize: 1.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(160, $action->width());
        $this->assertSame(80, $action->height());
        
        $action = new Action\Resize(width: 500, height: 80, upsize: 0.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(160, $action->width());
        $this->assertSame(80, $action->height());
        
        // without keeping ratio and with upsize
        $action = new Action\Resize(width: 100, height: 80, keepRatio: false, upsize: 1.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(80, $action->height());
        
        $action = new Action\Resize(width: 500, height: 80, keepRatio: false, upsize: 1.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(300, $action->width());
        $this->assertSame(150, $action->height());
        
        $action = new Action\Resize(width: 500, height: 80, keepRatio: false, upsize: 0.5);
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        $this->assertSame(100, $action->width());
        $this->assertSame(50, $action->height());
    }
}