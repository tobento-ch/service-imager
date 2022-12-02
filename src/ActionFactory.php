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

use Tobento\Service\Imager\Action;
use Throwable;

/**
 * ActionFactory
 */
class ActionFactory implements ActionFactoryInterface
{
    /**
     * Create a new action.
     *
     * @param string $name
     * @param array $parameters
     * @return ActionInterface
     * @throws ActionCreateException
     */
    public function createAction(string $name, array $parameters): ActionInterface
    {
        try {            
            $class = $this->getActions()[$name] ?? null;
            
            if (is_null($class)) {
                throw new ActionCreateException('Action ['.$name.'] not found');
            }
            
            $action = new $class(...$parameters);
            
            if (!$action instanceof ActionInterface) {
                throw new ActionCreateException(
                    'Action must be an instanceof '.ActionInterface::class
                );
            }
            
            return $action;
        } catch (Throwable $e) {
            throw new ActionCreateException('Could not create action ['.$name.']', 0, $e);
        }
    }
    
    /**
     * Returns the available actions.
     *
     * @return array<string, class-string>
     */
    protected function getActions(): array
    {
        return [
            'background' => Action\Background::class,
            'blur' => Action\Blur::class,
            'brightness' => Action\Brightness::class,
            'colorize' => Action\Colorize::class,
            'contrast' => Action\Contrast::class,
            'crop' => Action\Crop::class,
            'encode' => Action\Encode::class,
            'fit' => Action\Fit::class,
            'flip' => Action\Flip::class,
            'gamma' => Action\Gamma::class,
            'greyscale' => Action\Greyscale::class,
            'orientate' => Action\Orientate::class,
            'pixelate' => Action\Pixelate::class,
            'resize' => Action\Resize::class,
            'rotate' => Action\Rotate::class,
            'save' => Action\Save::class,
            'sepia' => Action\Sepia::class,
            'sharpen' => Action\Sharpen::class,
        ];
    }
}