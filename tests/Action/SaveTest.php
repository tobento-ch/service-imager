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
use Tobento\Service\Imager\InterventionImage\ImagerFactory;
use Tobento\Service\Imager\ActionException;
use Tobento\Service\Filesystem\Dir;

/**
 * SaveTest
 */
class SaveTest extends TestCase
{
    public function testInterfaceMethods()
    {
        $action = new Action\Save(
            filename: __DIR__.'/../src/tmp/image.jpg',
            mimeType: 'image/webp',
            quality: 90,
            overwrite: Action\Save::OVERWRITE,
            modeDir: 0755
        );

        $this->assertInstanceof(ActionInterface::class, $action);
        $this->assertInstanceof(Action\Calculable::class, $action);
        
        $this->assertSame(
            [
                'filename' => __DIR__.'/../src/tmp/image.webp',
                'mimeType' => 'image/webp',
                'quality' => 90,
                'overwrite' => 'overwrite',
                'modeDir' => 0755,
            ],
            $action->parameters()
        );
        
        $this->assertSame(
            'Saved image :filename with quality ":quality".',
            $action->description()
        );
    }
    
    public function testSpecificMethods()
    {
        $action = new Action\Save(
            filename: __DIR__.'/../src/tmp/image.jpg',
            mimeType: 'image/webp',
            quality: 90,
            overwrite: Action\Save::OVERWRITE,
            modeDir: 0755
        );
        
        $this->assertSame(__DIR__.'/../src/tmp/image.webp', $action->filename());
        $this->assertSame('image/webp', $action->mimeType());
        $this->assertSame('overwrite', $action->overwrite());
        $this->assertSame(0755, $action->modeDir());
    }
    
    public function testFilenameSupportedFormats()
    {
        $filenames = [
            'path/image.jpg',
            'path/image.jpeg',
            'path/image.pjpeg',
            'path/image.png',
            'path/image.gif',
            'path/image.webp',
            'path/image.tiff',
            'path/image.tif',
            'path/image.svg',
            'path/image.psd',
            'path/image.bmp',
            'path/image.ico',
            'path/image.avif',
        ];
        
        foreach($filenames as $filename) {
            $action = new Action\Save(filename: $filename);
            $this->assertSame($filename, $action->filename());
        }
    }
    
    public function testThrowsActionExceptionIfFilenameFormatIsNotSupported()
    {
        $this->expectException(ActionException::class);
        
        $action = new Action\Save(filename: 'path/image.jp');
    }
    
    public function testThrowsActionExceptionIfFilenameFormatIsMissing()
    {
        $this->expectException(ActionException::class);
        
        $action = new Action\Save(filename: 'path/image');
    }
    
    public function testModifiesFilenameIfDifferentMimeTypeSpceified()
    {
        $action = new Action\Save(filename: 'path/image.jpg', mimeType: 'image/webp');
        $this->assertSame('path/image.webp', $action->filename());
        
        $action = new Action\Save(filename: 'path/image.jpg');
        $this->assertSame('path/image.jpg', $action->filename());
    }
    
    public function testThrowsActionExceptionIfUnsupportedMimeTypeSpecified()
    {
        $this->expectException(ActionException::class);
        
        $action = new Action\Save(filename: 'path/image.jpg', mimeType: 'image/foo');
    }
    
    public function testWithoutSpecifiedQualityDefaultIsset()
    {
        $filenames = [
            'path/image.jpg' => 90,
            'path/image.jpeg' => 90,
            'path/image.pjpeg' => 90,
            'path/image.png' => null,
            'path/image.gif' => null,
            'path/image.webp' => 90,
            'path/image.tiff' => null,
            'path/image.tif' => null,
            'path/image.svg' => null,
            'path/image.psd' => null,
            'path/image.bmp' => null,
            'path/image.ico' => null,
            'path/image.avif' => null,
        ];
        
        foreach($filenames as $filename => $quality) {
            $action = new Action\Save(filename: $filename);
            $this->assertSame($quality, $action->quality());
        }
    }
    
    public function testWithoutSpecifiedQualityDefaultIssetMimeType()
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
            $action = new Action\Save(filename: 'path/image.jpg', mimeType: $mimeType);
            $this->assertSame($quality, $action->quality());
        }
    }
    
    public function testThrowsActionExceptionIfUnsupportedOverwriteMode()
    {
        $this->expectException(ActionException::class);
        
        $action = new Action\Save(filename: 'path/image.jpg', overwrite: 'invalid');
    }    
    
    public function testCalculateMethodCreatesDirIfNotExists()
    {
        $imager = (new ImagerFactory())->createImager();
                
        $action = new Action\Save(filename: __DIR__.'/../src/tmp/foo/image.jpg');
        
        $this->assertFalse((new Dir())->has(__DIR__.'/../src/tmp/foo/'));
        
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        
        $this->assertTrue((new Dir())->has(__DIR__.'/../src/tmp/foo/'));
        
        (new Dir())->delete(__DIR__.'/../src/tmp/');
    }
    
    public function testCalculateMethodIfOverwriteUniqueCreateUniqueFilename()
    {
        $imager = (new ImagerFactory())->createImager();
                
        $action = new Action\Save(
            filename: __DIR__.'/../src/image.jpg',
            overwrite: Action\Save::OVERWRITE_UNIQUE
        );
        
        $filename = $action->filename();
        
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        
        $this->assertTrue($filename !== $action->filename());
    }
    
    public function testCalculateMethodThrowsActionExceptionIfOverwriteThrowModeAndFileExists()
    {
        $this->expectException(ActionException::class);
        
        $imager = (new ImagerFactory())->createImager();
                
        $action = new Action\Save(
            filename: __DIR__.'/../src/image.jpg',
            overwrite: Action\Save::OVERWRITE_THROW
        );
        
        $action->calculate(imager: $imager, srcWidth: 200, srcHeight: 100);
        
        (new Dir())->delete(__DIR__.'/../src/tmp/');
    }    
}