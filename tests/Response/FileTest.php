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

namespace Tobento\Service\Imager\Test\Response;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Imager\Response;
use Tobento\Service\Imager\ResponseInterface;
use Tobento\Service\Imager\Actions;
use Tobento\Service\Filesystem\File as BaseFile;

/**
 * FileTest
 */
class FileTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $actions = new Actions();
        $response = new Response\File(file: 'filename.jpg', actions: $actions);

        $this->assertInstanceof(ResponseInterface::class, $response);
        $this->assertTrue($actions === $response->actions());
    }
    
    public function testSpecificMethods()
    {
        $response = new Response\File(file: __DIR__.'/../src/image.jpg', actions: new Actions());
        
        $this->assertInstanceof(BaseFile::class, $response->file());
        $this->assertSame(__DIR__.'/../src/image.jpg', $response->file()->getFile());
        $this->assertSame(200, $response->width());
        $this->assertSame(150, $response->height());
        
        $file = new BaseFile('filename.jpg');
        $response = new Response\File(file: $file, actions: new Actions());
        $this->assertTrue($file === $response->file());
        $this->assertSame(0, $response->width());
        $this->assertSame(0, $response->height());
    }
}