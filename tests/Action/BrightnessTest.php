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
 * BrightnessTest
 */
class BrightnessTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Brightness(
            brightness: 20,
        );

        $this->assertInstanceof(ActionInterface::class, $action);
        
        $this->assertSame(
            ['brightness' => 20],
            $action->parameters()
        );
        
        $this->assertSame(
            'Adjusted image brightness to :brightness.',
            $action->description()
        );
    }
    
    public function testSpecificMethods()
    {
        $action = new Action\Brightness(
            brightness: 20,
        );
        
        $this->assertSame(20, $action->brightness());
    }
    
    public function testThrowsActionExceptionIfBrightnessIsNotWithinRange()
    {
        $this->expectException(ActionException::class);
        
        $action = new Action\Brightness(
            brightness: 200,
        );
    }    
}