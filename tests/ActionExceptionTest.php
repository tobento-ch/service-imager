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
use Tobento\Service\Imager\ActionException;
use Tobento\Service\Imager\ImagerException;

/**
 * ActionExceptionTest
 */
class ActionExceptionTest extends TestCase
{
    public function testIsInstanceofImagerException()
    {
        $this->assertInstanceof(
            ImagerException::class,
            new ActionException('message')
        );
    }
}