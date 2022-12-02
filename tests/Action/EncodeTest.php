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
use Tobento\Service\Imager\ActionException;

/**
 * EncodeTest
 */
class EncodeTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Encode(mimeType: 'image/webp', quality: 90);

        $this->assertInstanceof(ActionInterface::class, $action);
        
        $this->assertSame(
            ['mimeType' => 'image/webp', 'quality' => 90],
            $action->parameters()
        );
        
        $this->assertSame(
            'Encoded image to the mime type :mimeType with quality ":quality".',
            $action->description()
        );
    }
    
    public function testSpecificMethods()
    {
        $action = new Action\Encode(mimeType: 'image/webp', quality: 90);
        
        $this->assertSame('image/webp', $action->mimeType());
        $this->assertSame(90, $action->quality());
    }

    public function testMapsToRightMimeType()
    {
        $mimeTypes = [
            'image/jpeg' => ['image/jpeg', 'jpg', 'jpeg'],
            'image/pjpeg' => ['image/pjpeg', 'pjpeg'],
            'image/png' => ['image/png', 'png'],
            'image/gif' => ['image/gif', 'gif'],
            'image/webp' => ['image/webp', 'webp'],
            'image/tiff' => ['image/tiff', 'tiff', 'tif'],
            'image/svg+xml' => ['image/svg+xml', 'svg'],
            'image/psd' => ['image/psd', 'psd'],
            'image/bmp' =>  ['image/bmp', 'bmp'],
            'image/x-icon' => ['image/x-icon', 'ico'],
            'image/avif' => ['image/avif', 'avif'],
        ];
        
        foreach($mimeTypes as $mimeType => $mimes) {
            foreach($mimes as $mime) {
                $action = new Action\Encode(mimeType: $mime);
                $this->assertSame($mimeType, $action->mimeType());
            }
        }
    }

    public function testThrowsActionExceptionIfInvalidMimeTypeSpecified()
    {
        $this->expectException(ActionException::class);
        
        $action = new Action\Encode(mimeType: 'image/web');
    }
    
    public function testWithoutSpecifiedQualitySetsDefault()
    {
        $mimeTypes = [
            'image/jpeg' => 90,
            'image/pjpeg' => 90,
            'image/png' => null,
            'image/gif' => null,
            'image/webp' => 90,
            'image/tiff' => null,
            'image/svg+xml' => null,
            'image/psd' => null,
            'image/bmp' =>  null,
            'image/x-icon' => null,
            'image/avif' => null,
        ];
        
        foreach($mimeTypes as $mimeType => $quality) {
            $action = new Action\Encode(mimeType: $mimeType);
            $this->assertSame($quality, $action->quality());
        }
    }
}