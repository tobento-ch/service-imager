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

namespace Tobento\Service\Imager\Test\Calculator;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Imager\Calculator\Size;

/**
 * SizeTest
 */
class SizeTest extends TestCase
{
    public function testGetMethods()
    {
        $size = new Size(width: 200, height: 100);
        $this->assertSame(200, $size->getWidth());
        $this->assertSame(100, $size->getHeight());
        $this->assertSame(2.0, $size->getRatio());
    }
    
    public function testWidthMethodReturnsNewInstance()
    {
        $size = new Size(width: 200, height: 100);
        $sizeNew = $size->width(100);
        $this->assertFalse($size === $sizeNew);
    }
    
    public function testWidthMethodCalculations()
    {
        $size = new Size(width: 200, height: 100);
        
        $s = $size->width(width: 100);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
        
        $s = $size->width(width: 300);
        $this->assertSame(300, $s->getWidth());
        $this->assertSame(150, $s->getHeight());        
        
        $s = $size->width(width: null);
        $this->assertSame(200, $s->getWidth());
        $this->assertSame(100, $s->getHeight());
        
        // without keeping ratio:
        $s = $size->width(width: 100, ratio: 0);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(100, $s->getHeight());
        
        $s = $size->width(width: null, ratio: 0);
        $this->assertSame(200, $s->getWidth());
        $this->assertSame(100, $s->getHeight());
        
        $s = $size->width(width: 100, ratio: -5);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(100, $s->getHeight());      
    }
    
    public function testHeightMethodReturnsNewInstance()
    {
        $size = new Size(width: 200, height: 100);
        $sizeNew = $size->width(100);
        $this->assertFalse($size === $sizeNew);
    }
    
    public function testHeightMethodCalculations()
    {
        $size = new Size(width: 200, height: 100);
        
        $s = $size->height(height: 50);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
        
        $s = $size->height(height: 200);
        $this->assertSame(400, $s->getWidth());
        $this->assertSame(200, $s->getHeight());        
        
        $s = $size->height(height: null);
        $this->assertSame(200, $s->getWidth());
        $this->assertSame(100, $s->getHeight());
        
        // without keeping ratio:
        $s = $size->height(height: 50, ratio: 0);
        $this->assertSame(200, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
        
        $s = $size->height(height: null, ratio: 0);
        $this->assertSame(200, $s->getWidth());
        $this->assertSame(100, $s->getHeight());
        
        $s = $size->height(height: 50, ratio: -5);
        $this->assertSame(200, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
    }
    
    public function testResizeMethodReturnsNewInstance()
    {
        $size = new Size(width: 200, height: 100);
        $sizeNew = $size->resize(width: 100);
        $this->assertFalse($size === $sizeNew);
    }
    
    public function testResizeMethodWidthCalculations()
    {
        $size = new Size(width: 200, height: 100);
        
        $s = $size->resize(width: 100);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
        
        $s = $size->resize(width: 300);
        $this->assertSame(300, $s->getWidth());
        $this->assertSame(150, $s->getHeight());
        
        // without keeping ratio
        $s = $size->resize(width: 100, keepRatio: false);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(100, $s->getHeight());
        
        $s = $size->resize(width: 300, keepRatio: false);
        $this->assertSame(300, $s->getWidth());
        $this->assertSame(100, $s->getHeight());
        
        // with upsize
        $s = $size->resize(width: 100, upsize: 1.5);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
        
        $s = $size->resize(width: 500, upsize: 1.5);
        $this->assertSame(300, $s->getWidth());
        $this->assertSame(150, $s->getHeight());
        
        $s = $size->resize(width: 500, upsize: 0.5);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
        
        // without keeping ratio and with upsize
        $s = $size->resize(width: 100, keepRatio: false, upsize: 1.5);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(100, $s->getHeight());
        
        $s = $size->resize(width: 500, keepRatio: false, upsize: 1.5);
        $this->assertSame(300, $s->getWidth());
        $this->assertSame(100, $s->getHeight());
        
        $s = $size->resize(width: 500, keepRatio: false, upsize: 0.5);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(100, $s->getHeight());        
    }
    
    public function testResizeMethodHeightCalculations()
    {
        $size = new Size(width: 200, height: 100);
        
        $s = $size->resize(height: 50);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
        
        $s = $size->resize(height: 150);
        $this->assertSame(300, $s->getWidth());
        $this->assertSame(150, $s->getHeight());
        
        // without keeping ratio
        $s = $size->resize(height: 50, keepRatio: false);
        $this->assertSame(200, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
        
        $s = $size->resize(height: 150, keepRatio: false);
        $this->assertSame(200, $s->getWidth());
        $this->assertSame(150, $s->getHeight());
        
        // with upsize
        $s = $size->resize(height: 50, upsize: 1.5);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
        
        $s = $size->resize(height: 300, upsize: 1.5);
        $this->assertSame(300, $s->getWidth());
        $this->assertSame(150, $s->getHeight());
        
        $s = $size->resize(height: 300, upsize: 0.5);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
        
        // without keeping ratio and with upsize
        $s = $size->resize(height: 50, keepRatio: false, upsize: 1.5);
        $this->assertSame(200, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
        
        $s = $size->resize(height: 300, keepRatio: false, upsize: 1.5);
        $this->assertSame(200, $s->getWidth());
        $this->assertSame(150, $s->getHeight());
        
        $s = $size->resize(height: 300, keepRatio: false, upsize: 0.5);
        $this->assertSame(200, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
    }
    
    public function testResizeMethodWidthAndHeightCalculations()
    {
        $size = new Size(width: 200, height: 100);
        
        $s = $size->resize(width: 100, height: 80);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
        
        $s = $size->resize(width: 300, height: 80);
        $this->assertSame(160, $s->getWidth());
        $this->assertSame(80, $s->getHeight());
        
        // without keeping ratio
        $s = $size->resize(width: 100, height: 80, keepRatio: false);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(80, $s->getHeight());
        
        $s = $size->resize(width: 300, height: 80, keepRatio: false);
        $this->assertSame(300, $s->getWidth());
        $this->assertSame(80, $s->getHeight());
        
        // with upsize
        $s = $size->resize(width: 100, height: 80, upsize: 1.5);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
        
        $s = $size->resize(width: 500, height: 80, upsize: 1.5);
        $this->assertSame(160, $s->getWidth());
        $this->assertSame(80, $s->getHeight());
        
        $s = $size->resize(width: 500, height: 80, upsize: 0.5);
        $this->assertSame(160, $s->getWidth());
        $this->assertSame(80, $s->getHeight());
        
        // without keeping ratio and with upsize
        $s = $size->resize(width: 100, height: 80, keepRatio: false, upsize: 1.5);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(80, $s->getHeight());
        
        $s = $size->resize(width: 500, height: 80, keepRatio: false, upsize: 1.5);
        $this->assertSame(300, $s->getWidth());
        $this->assertSame(150, $s->getHeight());
        
        $s = $size->resize(width: 500, height: 80, keepRatio: false, upsize: 0.5);
        $this->assertSame(100, $s->getWidth());
        $this->assertSame(50, $s->getHeight());
    }
    
    public function testFitMethodReturnsNewInstance()
    {
        $size = new Size(width: 200, height: 100);
        $sizeNew = $size->fit(new Size(width: 200, height: 100));
        $this->assertFalse($size === $sizeNew);
    }
    
    public function testFitMethodCalculations()
    {
        $size = new Size(width: 200, height: 100);
        
        $s = $size->fit(new Size(width: 300, height: 200));
        $this->assertSame(150, $s->getWidth());
        $this->assertSame(100, $s->getHeight());
        
        $s = $size->fit(new Size(width: 200, height: 300));
        $this->assertSame(67, $s->getWidth());
        $this->assertSame(100, $s->getHeight());    
    }
    
    public function testFitsIntoMethodCalculations()
    {
        $size = new Size(width: 200, height: 100);
        
        $this->assertTrue($size->fitsInto(new Size(width: 200, height: 300)));
        $this->assertTrue($size->fitsInto(new Size(width: 200, height: 100)));
        $this->assertTrue($size->fitsInto(new Size(width: 500, height: 300)));
        $this->assertFalse($size->fitsInto(new Size(width: 199, height: 300)));
        $this->assertFalse($size->fitsInto(new Size(width: 200, height: 99)));
        $this->assertFalse($size->fitsInto(new Size(width: 100, height: 50)));
    }    
}