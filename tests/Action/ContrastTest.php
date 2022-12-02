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
 * ContrastTest
 */
class ContrastTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Contrast(contrast: 10);

        $this->assertInstanceof(ActionInterface::class, $action);
        
        $this->assertSame(
            ['contrast' => 10],
            $action->parameters()
        );
        
        $this->assertSame(
            'Adjusted image contrast to :contrast.',
            $action->description()
        );
    }
    
    public function testSpecificMethods()
    {
        $action = new Action\Contrast(contrast: 10);
        
        $this->assertSame(10, $action->contrast());
    }
    
    public function testThrowsActionExceptionIfRedIsNotWithinRange()
    {
        $this->expectException(ActionException::class);
        
        $action = new Action\Contrast(contrast: 200);
    }
}