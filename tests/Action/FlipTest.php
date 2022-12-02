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
 * FlipTest
 */
class FlipTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Flip(flip: Action\Flip::HORIZONTAL);

        $this->assertInstanceof(ActionInterface::class, $action);
        
        $this->assertSame(
            ['flip' => 'horizontal'],
            $action->parameters()
        );
        
        $this->assertSame(
            'Image :flip mirrored.',
            $action->description()
        );
    }
    
    public function testSpecificMethods()
    {
        $action = new Action\Flip(flip: Action\Flip::VERTICAL);
        
        $this->assertSame('vertical', $action->flip());
    }
    
    public function testThrowsActionExceptionIfInvalidFlip()
    {
        $this->expectException(ActionException::class);
        
        $action = new Action\Flip(flip: 'vert');
    }
}