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
 * Imager
 */
class Imager implements ImagerInterface
{
    /**
     * @var ActionFactoryInterface
     */
    protected ActionFactoryInterface $actionFactory;

    /**
     * @var null|ProcessorInterface
     */
    protected null|ProcessorInterface $processor = null;
    
    /**
     * @var null|ResourceInterface
     */
    protected null|ResourceInterface $resource = null;    
    
    /**
     * Create a new Imager.
     *
     * @param ProcessorFactoryInterface $processorFactory
     * @param null|ActionFactoryInterface $actionFactory
     */
    public function __construct(
        protected ProcessorFactoryInterface $processorFactory,
        null|ActionFactoryInterface $actionFactory = null
    ) {
        $this->actionFactory = $actionFactory ?: new ActionFactory();
    }
    
    /**
     * Set the resource.
     *
     * @param ResourceInterface $resource
     * @return static
     */
    public function resource(ResourceInterface $resource): static
    {
        $this->resource = $resource;
        $this->processor = $this->processorFactory->createProcessor($resource);
        return $this;
    }
    
    /**
     * Returns the resource.
     *
     * @return null|ResourceInterface
     */
    public function getResource(): null|ResourceInterface
    {
        return $this->resource;
    }
    
    /**
     * Returns the processor.
     *
     * @return null|ProcessorInterface
     */
    public function getProcessor(): null|ProcessorInterface
    {
        return $this->processor;
    }
    
    /**
     * Set the file.
     *
     * @param string|File $file
     * @return static $this
     */
    public function file(string|File $file): static
    {
        $this->resource(new Resource\File($file));
        return $this;
    }
    
    /**
     * Add an action to be processed.
     *
     * @param ActionInterface $action
     * @return ImagerInterface|ResponseInterface
     * @throws ActionException
     */
    public function action(ActionInterface $action): ImagerInterface|ResponseInterface
    {
        if (is_null($this->processor)) {
            throw new ActionException('Cannot process action without a processor');
        }
        
        return $this->processor->processAction(
            action: $action,
            imager: $this
        );
    }
    
    /**
     * Calls the actions.
     *
     * @param string $name
     * @param array $arguments
     * @return ImagerInterface|ResponseInterface
     * @throws ActionException
     */
    public function __call(string $name, array $arguments): ImagerInterface|ResponseInterface
    {
        if (is_null($this->processor)) {
            throw new ActionException('Cannot process action without a processor');
        }
                
        return $this->processor->processAction(
            action: $this->actionFactory->createAction($name, $arguments),
            imager: $this
        );
    }
}