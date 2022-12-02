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

namespace Tobento\Service\Imager\Action;

use Tobento\Service\Imager\ImagerInterface;
use Tobento\Service\Imager\ImageFormats;
use Tobento\Service\Imager\ActionException;
use Tobento\Service\Filesystem\File;
use Tobento\Service\Filesystem\Dir;

/**
 * Save image by the specified parameters.
 */
class Save extends Action implements Calculable
{
    public const OVERWRITE = 'overwrite'; // allows overwriting image.
    public const OVERWRITE_UNIQUE = 'unique'; // creates unique image if exists.
    public const OVERWRITE_THROW = 'throw'; // throws ActionException if image exists.
    
    /**
     * Create a new Save.
     *
     * @param string $filename
     * @param null|string $mimeType The prioritized mimeType for the file to save.
     * @param null|int $quality
     * @param string $overwrite
     * @param int $modeDir
     */
    public function __construct(
        protected string $filename,
        protected null|string $mimeType = null,
        protected null|int $quality = null,
        protected string $overwrite = 'overwrite',
        protected int $modeDir = 0755,
    ) {
        // verify if file format is supported:
        $file = new File($filename);
        $extension = $file->getExtension();
        $fileMimeType = (new ImageFormats())->getMimeType(format: $extension);

        if (is_null($fileMimeType)) {
            throw new ActionException(sprintf('Unsupported filename format: "%s".', $extension));
        }
        
        // modify filename if specified mime type differs from filename:
        if (!is_null($mimeType)) {
            
            $extension = (new ImageFormats())->getFormat($mimeType);

            if (is_null($extension)) {
                throw new ActionException(sprintf('Unsupported mimeType: "%s".', $mimeType));
            }

            $this->filename = $file->getDirname().$file->getFilename().'.'.$extension;
            $fileMimeType = $mimeType;
        }
        
        // assign default quality if not specified:
        if (is_null($quality)) {
            $this->quality = $this->getDefaultQuality($fileMimeType);
        }
        
        // verify overwrite:
        if (!in_array($overwrite, ['overwrite', 'unique', 'throw'])) {
            throw new ActionException('Overwrite mode must be one of [overwrite, unique, throw]');
        }
    }
    
    /**
     * Returns the filename.
     *
     * @return string
     */
    public function filename(): string
    {
        return $this->filename;
    }
    
    /**
     * Returns the mimeType.
     *
     * @return null|string
     */
    public function mimeType(): null|string
    {
        return $this->mimeType;
    }
    
    /**
     * Returns the quality.
     *
     * @return null|int
     */
    public function quality(): null|int
    {
        return $this->quality;
    }
    
    /**
     * Returns the overwrite.
     *
     * @return string
     */
    public function overwrite(): string
    {
        return $this->overwrite;
    }
    
    /**
     * Returns the modeDir.
     *
     * @return int
     */
    public function modeDir(): int
    {
        return $this->modeDir;
    }
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'filename' => $this->filename,
            'mimeType' => $this->mimeType,
            'quality' => $this->quality,
            'overwrite' => $this->overwrite,
            'modeDir' => $this->modeDir,
        ];
    }

    /**
     * Process the action.
     *
     * @param ImagerInterface $imager
     * @return ImagerInterface|ResponseInterface Must return Response\File::class
     * @throws ActionException
     */
    //public function process(ImagerInterface $imager): ImagerInterface|ResponseInterface;
    
    /**
     * Calculates the action with the specified parameters.
     *
     * @param ImagerInterface $imager
     * @param int $srcWidth
     * @param int $srcHeight
     * @return void
     * @throws ActionException
     */
    public function calculate(ImagerInterface $imager, int $srcWidth, int $srcHeight): void
    {
        // check if directory exist and is writable.
        $file = new File($this->filename);
        $directory = $file->getDirname();
        $dir = new Dir();
        
        if (!$dir->has($directory)) {
            // if directory does not exist, we create it:
            if ($dir->create(directory: $directory, mode: $this->modeDir, recursive: true) === false) {
                throw new ActionException(sprintf('Directory "%s" could not get created.', $directory));
            }
        }
        
        if (! $dir->isWritable(directory: $directory)) {
            throw new ActionException(sprintf('Image directory "%s" is not writable.', $directory));
        }
        
        // handle overwrite:
        if ($this->overwrite !== static::OVERWRITE) {
            
            // file does not exist, so we just return:
            if (!$file->isFile()) {
                return;
            }

            if ($this->overwrite === static::OVERWRITE_UNIQUE) {
                $this->filename = $file->withUniqueFilename()->getFile();
                return;
            }            
            
            throw new ActionException(sprintf('Overwritting file: "%s" is disabled.', $this->filename));
        }
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Saved image :filename with quality ":quality".';
    }
    
    /**
     * Returns the default quality for the specified file mime type.
     *
     * @param null|string $mimeType
     * @return null|int
     */
    protected function getDefaultQuality(null|string $mimeType): null|int
    {
        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/pjpeg':
                return 90;
            case 'image/webp':
                return 90;                
            default:
                return null;
        }
    }
}