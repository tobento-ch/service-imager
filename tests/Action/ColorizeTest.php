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
 * ColorizeTest
 */
class ColorizeTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Colorize(red: 10, green: 20, blue: 30);

        $this->assertInstanceof(ActionInterface::class, $action);
        
        $this->assertSame(
            ['red' => 10, 'green' => 20, 'blue' => 30],
            $action->parameters()
        );
        
        $this->assertSame(
            'Colorized image with red :red, green :green amd blue :blue.',
            $action->description()
        );
    }
    
    public function testSpecificMethods()
    {
        $action = new Action\Colorize(red: 10, green: 20, blue: 30);
        
        $this->assertSame(10, $action->red());
        $this->assertSame(20, $action->green());
        $this->assertSame(30, $action->blue());
    }
    
    public function testThrowsActionExceptionIfRedIsNotWithinRange()
    {
        $this->expectException(ActionException::class);
        
        $action = new Action\Colorize(red: 200, green: 20, blue: 30);
    }
    
    public function testThrowsActionExceptionIfGreenIsNotWithinRange()
    {
        $this->expectException(ActionException::class);
        
        $action = new Action\Colorize(red: 20, green: 200, blue: 30);
    }
    
    public function testThrowsActionExceptionIfBlueIsNotWithinRange()
    {
        $this->expectException(ActionException::class);
        
        $action = new Action\Colorize(red: 20, green: 20, blue: 300);
    }
}