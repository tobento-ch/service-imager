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
 * GammaTest
 */
class GammaTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Gamma(gamma: 2.5);

        $this->assertInstanceof(ActionInterface::class, $action);
        
        $this->assertSame(
            ['gamma' => 2.5],
            $action->parameters()
        );
        
        $this->assertSame(
            'Adjusted image gamma to :gamma.',
            $action->description()
        );
    }
    
    public function testSpecificMethods()
    {
        $action = new Action\Gamma(gamma: 2.5);
        
        $this->assertSame(2.5, $action->gamma());
    }
    
    public function testThrowsActionExceptionIfInvalidFlip()
    {
        $this->expectException(ActionException::class);
        
        $action = new Action\Gamma(gamma: 12.5);
    }
}