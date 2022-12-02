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

/**
 * Encode image by the specified parameters.
 */
class Encode extends Action
{
    /**
     * Create a new Encode.
     *
     * @param string $mimeType
     * @param null|int $quality
     */
    public function __construct(
        protected string $mimeType,
        protected null|int $quality = null,
    ) {
        // handle mime type:
        $formats = new ImageFormats();
        
        $format = $formats->getFormat($this->mimeType);

        if (is_null($format)) {
            throw new ActionException(sprintf('Unsupported mimeType: "%s".', $this->mimeType));
        }
        
        $mimeType = $formats->getMimeType(format: $format);
        
        if (is_null($mimeType)) {
            throw new ActionException(sprintf('Unsupported mimeType: "%s".', $this->mimeType));
        }        
        
        $this->mimeType = $mimeType;
        
        // handle quality:
        if (is_null($this->quality)) {
            $this->quality = $this->getDefaultQuality($mimeType);
        }
    }
    
    /**
     * Returns the mimeType.
     *
     * @return string
     */
    public function mimeType(): string
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
     * Returns the action parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return [
            'mimeType' => $this->mimeType,
            'quality' => $this->quality,
        ];
    }
    
    /**
     * Process the action.
     *
     * @param ImagerInterface $imager
     * @return ImagerInterface|ResponseInterface Must return Response\Encoded::class
     * @throws ActionException
     */
    //public function process(ImagerInterface $imager): ImagerInterface|ResponseInterface;    
    
    /**
     * Returns a description of the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Encoded image to the mime type :mimeType with quality ":quality".';
    }
    
    /**
     * Returns the default quality for the specified file mime type.
     *
     * @param string $mimeType
     * @return null|int
     */
    protected function getDefaultQuality(string $mimeType): null|int
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