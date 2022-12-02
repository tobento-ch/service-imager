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

namespace Tobento\Service\Imager;

use Tobento\Service\Filesystem\FileFormatsInterface;
use Tobento\Service\Filesystem\FileFormats;

/**
 * ImageFormats
 */
class ImageFormats implements FileFormatsInterface
{
    use FileFormats;
    
    /**
     * Create a new ImageFormats.
     *
     * @param bool $defaultFormats
     */
    public function __construct(bool $defaultFormats = true)
    {
        if ($defaultFormats) {
            $this->addDefaultFormats();
        }
    }
    
    /**
     * Adds the defaults formats.
     *
     * @return void
     */
    protected function addDefaultFormats(): void
    {
        $this->addFormat('jpg', 'image/jpeg');
        $this->addFormat('jpeg', 'image/jpeg');
        $this->addFormat('jpe', 'image/jpeg');
        $this->addFormat('pjpeg', 'image/pjpeg');
        $this->addFormat('png', 'image/png');
        $this->addFormat('png', 'image/x-png');
        $this->addFormat('gif', 'image/gif');
        $this->addFormat('webp', 'image/webp');
        $this->addFormat('webp', 'image/x-webp');
        $this->addFormat('tif', 'image/tiff');
        $this->addFormat('tiff', 'image/tiff');
        $this->addFormat('svg', 'image/svg+xml');
        $this->addFormat('psd', 'image/psd');
        $this->addFormat('psd', 'image/vnd.adobe.photoshop');
        $this->addFormat('bmp', 'image/bmp');
        $this->addFormat('bmp', 'image/x-bitmap');
        $this->addFormat('bmp', 'image/x-bmp');
        $this->addFormat('bmp', 'image/x-ms-bmp');
        $this->addFormat('bmp', 'image/x-win-bitmap');
        $this->addFormat('bmp', 'image/x-windows-bmp');
        $this->addFormat('bmp', 'image/x-xbitmap');
        $this->addFormat('ico', 'image/x-icon');
        $this->addFormat('ico', 'image/vnd.microsoft.icon');
        $this->addFormat('avif', 'image/avif');
    }
}