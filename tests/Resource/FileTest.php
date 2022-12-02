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
use Tobento\Service\Filesystem\File as BaseFile;

/**
 * FileTest
 */
class FileTest extends TestCase
{
    public function testThatImplementsResourceInterface()
    {
        $resource = new Resource\File(file: 'filename.jpg');

        $this->assertInstanceof(ResourceInterface::class, $resource);
    }
    
    public function testSpecificMethods()
    {
        $resource = new Resource\File(file: 'filename.jpg');
        
        $this->assertInstanceof(BaseFile::class, $resource->file());
        $this->assertSame('filename.jpg', $resource->file()->getFile());
        
        $file = new BaseFile('filename.jpg');
        $resource = new Resource\File(file: $file);
        $this->assertTrue($file === $resource->file());
    }
}