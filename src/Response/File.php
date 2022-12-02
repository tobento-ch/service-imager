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

namespace Tobento\Service\Imager\Response;

use Tobento\Service\Imager\ResponseInterface;
use Tobento\Service\Imager\ActionsInterface;
use Tobento\Service\Filesystem\File as BaseFile;

/**
 * File
 */
class File implements ResponseInterface
{
    /**
     * @var BaseFile
     */
    protected BaseFile $file;
    
    /**
     * Create a new File.
     *
     * @param string|BaseFile $file
     * @param ActionsInterface $actions
     */
    public function __construct(
        string|BaseFile $file,
        protected ActionsInterface $actions
    ) {
        $this->file = is_string($file) ? new BaseFile($file) : $file;
    }
    
    /**
     * Returns the actions processed.
     *
     * @return ActionsInterface
     */
    public function actions(): ActionsInterface
    {
        return $this->actions;
    }
    
    /**
     * Returns the file.
     *
     * @return BaseFile
     */
    public function file(): BaseFile
    {
        return $this->file;
    }
    
    /**
     * Returns the width of the image.
     *
     * @return int
     */
    public function width(): int
    {
        $width = $this->file->getImageSize(0);
        return is_int($width) ? $width : 0;
    }
    
    /**
     * Returns the height of the image.
     *
     * @return int
     */
    public function height(): int
    {
        $height = $this->file->getImageSize(1);
        return is_int($height) ? $height : 0;
    }
}