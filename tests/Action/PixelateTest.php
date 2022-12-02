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
use Tobento\Service\Imager\ActionException;

/**
 * PixelateTest
 */
class PixelateTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Pixelate(pixelate: 10);

        $this->assertInstanceof(ActionInterface::class, $action);
        
        $this->assertSame(
            ['pixelate' => 10],
            $action->parameters()
        );
        
        $this->assertSame(
            'Pixelated image by :pixelate.',
            $action->description()
        );
    }
    
    public function testSpecificMethods()
    {
        $action = new Action\Pixelate(pixelate: 10);
        
        $this->assertSame(10, $action->pixelate());
    }
    
    public function testThrowsActionExceptionIfInvalidFlip()
    {
        $this->expectException(ActionException::class);
        
        $action = new Action\Pixelate(pixelate: 10000);
    }
}