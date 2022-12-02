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

namespace Tobento\Service\Imager\Resource;

use Tobento\Service\Imager\ResourceInterface;
use Tobento\Service\Filesystem\File as BaseFile;

/**
 * File
 */
class File implements ResourceInterface
{
    /**
     * @var BaseFile
     */
    protected BaseFile $file;
    
    /**
     * Create a new File.
     *
     * @param string|BaseFile $file
     */
    public function __construct(
        string|BaseFile $file
    ) {
        $this->file = is_string($file) ? new BaseFile($file) : $file;
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
}