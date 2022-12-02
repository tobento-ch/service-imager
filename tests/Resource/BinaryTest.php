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

namespace Tobento\Service\Imager\Test\Resource;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Imager\Resource;
use Tobento\Service\Imager\ResourceInterface;

/**
 * BinaryTest
 */
class BinaryTest extends TestCase
{
    public function testThatImplementsResourceInterface()
    {
        $resource = new Resource\Binary(data: 'foo');

        $this->assertInstanceof(ResourceInterface::class, $resource);
    }
    
    public function testSpecificMethods()
    {
        $resource = new Resource\Binary(data: 'foo');
        
        $this->assertSame('foo', $resource->data());
    }
}