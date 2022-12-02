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
 * BackgroundTest
 */
class BackgroundTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Background(
            color: '#333',
        );

        $this->assertInstanceof(ActionInterface::class, $action);
        
        $this->assertSame(
            ['color' => '#333'],
            $action->parameters()
        );
        
        $this->assertSame(
            'Background color :color applied to image if transparent.',
            $action->description()
        );
    }
    
    public function testSpecificMethods()
    {
        $action = new Action\Background(
            color: '#333',
        );
        
        $this->assertSame('#333', $action->color());
    }
}