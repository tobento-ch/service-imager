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
use Tobento\Service\Imager\ResponseInterface;
use Tobento\Service\Imager\Calculator\Size;
use Tobento\Service\Imager\Calculator\Position;
use Tobento\Service\Imager\ActionException;

/**
 * Fit image by the specified parameters.
 */
class Fit extends Action implements Processable
{
    public const TOP_LEFT = 'top-left';
    public const TOP = 'top';
    public const TOP_RIGHT = 'top-right';
    public const LEFT = 'left';
    public const CENTER = 'center';
    public const RIGHT = 'right';
    public const BOTTOM_LEFT = 'bottom-left';
    public const BOTTOM = 'bottom';
    public const BOTTOM_RIGHT = 'bottom-right';
    
    /**
     * Create a new Fit.
     *
     * @param int $width
     * @param int $height
     * @param string $position
     * @param null|float $upsize
     */
    public function __construct(
        protected int $width,
        protected int $height,
        protected string $position = 'center',
        protected null|float $upsize = null
    ) {}
    
    /**
     * Process the action.
     *
     * @param ImagerInterface $imager
     * @param int $srcWidth
     * @param int $srcHeight     
     * @return ImagerInterface|ResponseInterface
     * @throws ActionException
     */
    public function process(
        ImagerInterface $imager,
        int $srcWidth,
        int $srcHeight
    ): ImagerInterface|ResponseInterface {
        
        // calculate crop data based on fit data:
        $size = (new Size(width: $srcWidth, height: $srcHeight))->fit(new Size($this->width, $this->height));
        
        $pos = (new Position($srcWidth, $srcHeight))->align($this->position)
            ->align($this->position)
            ->relative(
                (new Position($size->getWidth(), $size->getHeight()))->align($this->position)
            );
        
        // do the cropping:
        $imager->action(new Crop(
            width: $size->getWidth(),
            height: $size->getHeight(),
            x: $pos->x(),
            y: $pos->y()
        ));
        
        // calculate upsize as update width and height for the messsage:
        $resized = $size->resize(
            width: $this->width,
            height: $this->height,
            keepRatio: true,
            upsize: $this->upsize
        );
        
        $this->width = $resized->getWidth();
        $this->height = $resized->getHeight();        
        
        // do the resizing:
        return $imager->action(new Resize(width: $this->width, height: $this->height));        
    }

    /**
     * Returns the width.
     *
     * @return int
     */
    public function width(): int
    {
        return $this->width;
    }
    
    /**
     * Returns the height.
     *
     * @return int
     */
    public function height(): int
    {
        return $this->height;
    }
    
    /**
     * Returns the position.
     *
     * @return string
     */
    public function position(): string
    {
        return $this->position;
    }
    
    /**
     * Returns the upsize.
     *
     * @return null|float
     */
    public function upsize(): null|float
    {
        return $this->upsize;
    }
    
    /**
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'width' => $this->width,
            'height' => $this->height,
            'position' => $this->position,
            'upsize' => $this->upsize,
        ];
    }
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Image fitted to width :width, height :height positioned :position.';
    }
}