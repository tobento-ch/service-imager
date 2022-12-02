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

namespace Tobento\Service\Imager\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Imager\ActionProcessException;
use Tobento\Service\Imager\ActionException;
use Tobento\Service\Imager\Action;

/**
 * ActionProcessExceptionTest
 */
class ActionProcessExceptionTest extends TestCase
{
    public function testIsInstanceofActionException()
    {
        $action = new Action\Greyscale();
        $exception = new ActionProcessException(action: $action, message: 'message');
        
        $this->assertInstanceof(
            ActionException::class,
            $exception
        );
        
        $this->assertTrue($action === $exception->action());
    }
}