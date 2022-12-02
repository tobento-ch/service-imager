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
 * UrlTest
 */
class UrlTest extends TestCase
{
    public function testThatImplementsResourceInterface()
    {
        $resource = new Resource\Url(url: 'url');

        $this->assertInstanceof(ResourceInterface::class, $resource);
    }
    
    public function testSpecificMethods()
    {
        $resource = new Resource\Url(url: 'url');
        
        $this->assertSame('url', $resource->url());
    }
}