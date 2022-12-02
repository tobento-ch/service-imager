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

namespace Tobento\Service\Imager\InterventionImage;

use Tobento\Service\Imager\ProcessorInterface;
use Tobento\Service\Imager\ImagerInterface;
use Tobento\Service\Imager\ResponseInterface;
use Tobento\Service\Imager\ActionInterface;
use Tobento\Service\Imager\ActionProcessException;
use Tobento\Service\Imager\ActionException;
use Tobento\Service\Imager\Resource;
use Tobento\Service\Imager\Response;
use Tobento\Service\Imager\Action;
use Tobento\Service\Imager\Actions;
use Intervention\Image\Image;
use Exception;

/**
 * Processor
 */
class Processor implements ProcessorInterface
{
    /**
     * @var array<int, ActionInterface>
     */
    protected array $actions = [];
    
    /**
     * @var null|string
     */
    protected null|string $processableAction = null;
    
    /**
     * Create a new InterventionImageProcessor.
     *
     * @param Image $image
     */
    public function __construct(
        protected Image $image
    ) {}
    
    /**
     * Process the action.
     *
     * @param ActionInterface $action
     * @param ImagerInterface $imager
     * @return ImagerInterface|ResponseInterface
     * @throws ActionProcessException
     */
    public function processAction(
        ActionInterface $action,
        ImagerInterface $imager
    ): ImagerInterface|ResponseInterface {

        if ($action instanceof Action\Processable) {
            $this->processableAction = $action::class;
        }
        
        if ($this->processableAction && !$action instanceof Action\Processable) {
            $action->setProcessedBy($this->processableAction);
        }        
        
        $this->actions[] = $action;
        
        try {
            $response = $this->callAction($this->image, $action, $imager);
        } catch (ActionException|ActionProcessException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ActionProcessException($action, 'Action failed', 0, $e);
        }
        
        if ($response instanceof Image) {
            $this->image = $response;
        }
        
        if ($action instanceof Action\Processable) {
            $this->processableAction = null;
        }
        
        if ($response instanceof ResponseInterface) {
            return $response;
        }
        
        return $imager;
    }
    
    /**
     * Returns the image.
     *
     * @return Image
     */
    public function image(): Image
    {
        return $this->image;
    }
    
    /**
     * Calls the action.
     *
     * @param Image $image
     * @param ActionInterface $action
     * @param ImagerInterface $imager
     * @return mixed
     * @throws ActionProcessException
     */
    protected function callAction(Image $image, ActionInterface $action, ImagerInterface $imager): mixed
    {
        if ($action instanceof Action\Calculable) {
            $action->calculate($imager, $image->getWidth(), $image->getHeight());
        }
        
        if ($action instanceof Action\Processable) {
            return $action->process($imager, $image->getWidth(), $image->getHeight());
        }
            
        switch ($action::class) {
            case Action\Background::class:
                
                $new = $image->getDriver()->newImage(
                    $image->getWidth(),
                    $image->getHeight(),
                    $action->color()
                );

                $new->mime = $image->mime;

                return $new->insert($image, 'top-left', 0, 0);
            case Action\Blur::class:
                return $image->blur($action->blur());
            case Action\Brightness::class:
                return $image->brightness($action->brightness());
            case Action\Colorize::class:
                return $image->colorize($action->red(), $action->green(), $action->blue());                
            case Action\Contrast::class:
                return $image->contrast($action->contrast());
            case Action\Crop::class:
                return $image->crop($action->width(), $action->height(), $action->x(), $action->y());
            case Action\Encode::class:
                
                if (is_int($action->quality())) {
                    $image = $image->encode($action->mimeType(), $action->quality());
                } else {
                    $image = $image->encode($action->mimeType());
                }

                $filesize = $image->filesize();
                
                return new Response\Encoded(
                    encoded: (string)$image,
                    mimeType: $action->mimeType(),
                    width: $image->width(),
                    height: $image->height(),
                    size: is_int($filesize) ? $filesize : null, 
                    actions: new Actions(...$this->actions)
                );
            case Action\Flip::class:
                $mode = $action->flip() === Action\Flip::HORIZONTAL ? 'h' : 'v';
                return $image->flip($mode);
            case Action\Gamma::class:
                return $image->gamma($action->gamma());
            case Action\Greyscale::class:
                return $image->greyscale();
            case Action\Orientate::class:
                return $image->orientate();
            case Action\Pixelate::class:
                return $image->pixelate($action->pixelate());
            case Action\Resize::class:
                return $image->resize($action->width(), $action->height());
            case Action\Rotate::class:
                
                // change rotation as intervention rotates counter-clockwise
                // but action is clockwise.
                $degress = ($action->degrees() * -1);
                
                return $image->rotate($degress, $action->bgcolor());
            case Action\Save::class:
                $image->save($action->filename(), $action->quality());
                
                // destroy resource
                $image->destroy();
                
                return new Response\File(
                    file: $action->filename(),
                    actions: new Actions(...$this->actions)
                );
            case Action\Sharpen::class:
                return $image->sharpen($action->sharpen());
        }
        
        throw new ActionProcessException($action);
    }
}