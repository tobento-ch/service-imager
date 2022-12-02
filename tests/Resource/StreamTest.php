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
use GuzzleHttp\Psr7;

/**
 * StreamTest
 */
class StreamTest extends TestCase
{
    public function testThatImplementsResourceInterface()
    {
        $stream = Psr7\Utils::streamFor('foo');
        
        $resource = new Resource\Stream(stream: $stream);

        $this->assertInstanceof(ResourceInterface::class, $resource);
    }
    
    public function testSpecificMethods()
    {
        $stream = Psr7\Utils::streamFor('foo');

        $resource = new Resource\Stream(stream: $stream);
        
        $this->assertTrue($stream === $resource->stream());
    }
}