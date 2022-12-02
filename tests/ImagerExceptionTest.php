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
use Tobento\Service\Imager\ImagerException;
use Exception;

/**
 * ImagerExceptionTest
 */
class ImagerExceptionTest extends TestCase
{
    public function testIsInstanceofException()
    {
        $this->assertInstanceof(
            Exception::class,
            new ImagerException('message')
        );
    }
}