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
 * OrientateTest
 */
class OrientateTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Orientate();

        $this->assertInstanceof(ActionInterface::class, $action);
        
        $this->assertSame(
            [],
            $action->parameters()
        );
        
        $this->assertSame(
            'Auto orientated image.',
            $action->description()
        );
    }
}