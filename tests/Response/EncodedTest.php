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
 * EncodedTest
 */
class EncodedTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $actions = new Actions();
        $response = new Response\Encoded(
            encoded: file_get_contents(__DIR__.'/../src/image.jpg'),
            mimeType: 'image/jpeg',
            width: 200,
            height: 150,
            size: filesize(__DIR__.'/../src/image.jpg'),
            actions: $actions
        );

        $this->assertInstanceof(ResponseInterface::class, $response);
        $this->assertTrue($actions === $response->actions());
    }
    
    public function testSpecificMethods()
    {
        $encoded = file_get_contents(__DIR__.'/../src/image.jpg');
        $base64 = base64_encode($encoded);
        $dataUrl = sprintf('data:%s;base64,%s', 'image/jpeg', $base64);        
        
        $response = new Response\Encoded(
            encoded: $encoded,
            mimeType: 'image/jpeg',
            width: 200,
            height: 150,
            size: filesize(__DIR__.'/../src/image.jpg'),
            actions: new Actions()
        );
        
        $this->assertSame('image/jpeg', $response->mimeType());
        $this->assertSame(200, $response->width());
        $this->assertSame(150, $response->height());
        $this->assertSame(20042, $response->size());
        $this->assertSame($base64, $response->base64());
        $this->assertSame($dataUrl, $response->dataUrl());
    }
}