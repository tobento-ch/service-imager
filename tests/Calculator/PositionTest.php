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
use Tobento\Service\Imager\Calculator\Position;

/**
 * PositionTest
 */
class PositionTest extends TestCase
{
    public function testXYMethods()
    {
        $pos = new Position(width: 200, height: 100, x: 5, y: 10);
        $this->assertSame(5, $pos->x());
        $this->assertSame(10, $pos->y());
    }
    
    public function testRelativeMethodReturnsNewInstance()
    {
        $pos = new Position(width: 200, height: 100, x: 5, y: 10);
        
        $posNew = $pos->relative(new Position(width: 200, height: 100, x: 5, y: 10));
        
        $this->assertFalse($pos === $posNew);
    }
    
    public function testRelativeMethodCalculatesXYRelative()
    {
        $pos = new Position(width: 200, height: 100, x: 50, y: 100);
        
        $pos = $pos->relative(new Position(width: 200, height: 100, x: 3, y: 5));
        
        $this->assertSame(47, $pos->x());
        $this->assertSame(95, $pos->y());
    }
    
    public function testAlignMethodReturnsNewInstance()
    {
        $pos = new Position(width: 200, height: 100, x: 5, y: 10);
        
        $posNew = $pos->align(position: 'center');
        
        $this->assertFalse($pos === $posNew);
    }
    
    public function testAlignMethodCalculations()
    {
        $pos = new Position(width: 200, height: 100, x: 0, y: 0);
        
        $pos = $pos->align(position: 'top');
        $this->assertSame(100, $pos->x());
        $this->assertSame(0, $pos->y());
        
        $pos = $pos->align(position: 'top-right');
        $this->assertSame(200, $pos->x());
        $this->assertSame(0, $pos->y());
        
        $pos = $pos->align(position: 'left');
        $this->assertSame(0, $pos->x());
        $this->assertSame(50, $pos->y());
        
        $pos = $pos->align(position: 'right');
        $this->assertSame(200, $pos->x());
        $this->assertSame(50, $pos->y());
        
        $pos = $pos->align(position: 'bottom-left');
        $this->assertSame(0, $pos->x());
        $this->assertSame(100, $pos->y());
        
        $pos = $pos->align(position: 'bottom');
        $this->assertSame(100, $pos->x());
        $this->assertSame(100, $pos->y());
        
        $pos = $pos->align(position: 'bottom-right');
        $this->assertSame(200, $pos->x());
        $this->assertSame(100, $pos->y());
        
        $pos = $pos->align(position: 'center');
        $this->assertSame(100, $pos->x());
        $this->assertSame(50, $pos->y());
        
        $pos = $pos->align(position: 'top-left');
        $this->assertSame(0, $pos->x());
        $this->assertSame(0, $pos->y());
    }
    
    public function testAlignMethodCalculationsWithOffsets()
    {
        $pos = new Position(width: 200, height: 100, x: 0, y: 0);
        
        $pos = $pos->align(position: 'top', offsetX: 3, offsetY: 5);
        $this->assertSame(100, $pos->x());
        $this->assertSame(5, $pos->y());
        
        $pos = $pos->align(position: 'top-right', offsetX: 3, offsetY: 5);
        $this->assertSame(197, $pos->x());
        $this->assertSame(5, $pos->y());
        
        $pos = $pos->align(position: 'left', offsetX: 3, offsetY: 5);
        $this->assertSame(3, $pos->x());
        $this->assertSame(50, $pos->y());
        
        $pos = $pos->align(position: 'right', offsetX: 3, offsetY: 5);
        $this->assertSame(197, $pos->x());
        $this->assertSame(50, $pos->y());
        
        $pos = $pos->align(position: 'bottom-left', offsetX: 3, offsetY: 5);
        $this->assertSame(3, $pos->x());
        $this->assertSame(95, $pos->y());
        
        $pos = $pos->align(position: 'bottom', offsetX: 3, offsetY: 5);
        $this->assertSame(100, $pos->x());
        $this->assertSame(95, $pos->y());
        
        $pos = $pos->align(position: 'bottom-right', offsetX: 3, offsetY: 5);
        $this->assertSame(197, $pos->x());
        $this->assertSame(95, $pos->y());
        
        $pos = $pos->align(position: 'center', offsetX: 3, offsetY: 5);
        $this->assertSame(103, $pos->x());
        $this->assertSame(55, $pos->y());
        
        $pos = $pos->align(position: 'top-left', offsetX: 3, offsetY: 5);
        $this->assertSame(3, $pos->x());
        $this->assertSame(5, $pos->y());
    }    
}