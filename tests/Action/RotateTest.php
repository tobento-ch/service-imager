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

/**
 * RotateTest
 */
class RotateTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Rotate(degrees: 25.5, bgcolor: '#333333');

        $this->assertInstanceof(ActionInterface::class, $action);
        
        $this->assertSame(
            ['degrees' => 25.5, 'bgcolor' => '#333333'],
            $action->parameters()
        );
        
        $this->assertSame(
            'Image rotated :degrees degrees and filled empty triangles left overs with background color :bgcolor.',
            $action->description()
        );
    }
    
    public function testSpecificMethods()
    {
        $action = new Action\Rotate(degrees: 25.5, bgcolor: '#333333');
        
        $this->assertSame(25.5, $action->degrees());
        $this->assertSame('#333333', $action->bgcolor());
    }
    
    public function testLimitsDegrees()
    {
        $this->assertSame(20.5, (new Action\Rotate(degrees: 380.5))->degrees());
        $this->assertSame(-20.5, (new Action\Rotate(degrees: -380.5))->degrees());
    }
}