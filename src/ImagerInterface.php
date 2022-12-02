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

use Tobento\Service\Filesystem\File;

/**
 * ImagerInterface.
 */
interface ImagerInterface
{
    /**
     * Set the resource.
     *
     * @param ResourceInterface $resource
     * @return static
     */
    public function resource(ResourceInterface $resource): static;
    
    /**
     * Returns the resource.
     *
     * @return null|ResourceInterface
     */
    public function getResource(): null|ResourceInterface;
    
    /**
     * Returns the processor.
     *
     * @return null|ProcessorInterface
     */
    public function getProcessor(): null|ProcessorInterface;
    
    /**
     * Set the file.
     *
     * @param string|File $file
     * @return static $this
     */
    public function file(string|File $file): static;
    
    /**
     * Add an action to be processed.
     *
     * @param ActionInterface $action
     * @return ImagerInterface|ResponseInterface
     * @throws ActionException
     */
    public function action(ActionInterface $action): ImagerInterface|ResponseInterface;
}