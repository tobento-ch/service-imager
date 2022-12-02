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

namespace Tobento\Service\Imager\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Imager\ActionFactory;
use Tobento\Service\Imager\ActionFactoryInterface;
use Tobento\Service\Imager\ActionInterface;
use Tobento\Service\Imager\ActionCreateException;

/**
 * ActionFactoryTest
 */
class ActionFactoryTest extends TestCase
{
    public function testThatImplementsActionFactoryInterface()
    {
        $this->assertInstanceof(
            ActionFactoryInterface::class,
            new ActionFactory()
        );
    }
    
    public function testCreateActionMethod()
    {
        $actions = [
            'background' => ['color' => '#333'],
            'blur' => ['blur' => 20],
            'brightness' => ['brightness' => 20],
            'colorize' => ['red' => 10, 'green' => 10, 'blue' => 10],
            'contrast' => ['contrast' => 20],
            'crop' => ['width' => 50, 'height' => 50],
            'encode' => ['mimeType' => 'image/webp'],
            'fit' => ['width' => 50, 'height' => 50],
            'flip' => [],
            'gamma' => ['gamma' => 5.5],
            'greyscale' => [],
            'orientate' => [],
            'pixelate' => ['pixelate' => 10],
            'resize' => ['width' => 50],
            'rotate' => ['degrees' => 50],
            'save' => ['filename' => __DIR__.'/src/tmp/image.jpg'],
            'sepia' => [],
            'sharpen' => ['sharpen' => 10],
        ];
        
        $actionFactory = new ActionFactory();
        
        foreach($actions as $name => $params) {
            $this->assertInstanceof(
                ActionInterface::class,
                $actionFactory->createAction($name, $params)
            );
        }
    }
    
    public function testCreateActionMethodThrowsActionCreateExceptionIfActionNotFound()
    {
        $this->expectException(ActionCreateException::class);

        (new ActionFactory())->createAction('foo', []);
    }
    
    public function testCreateActionMethodThrowsActionCreateExceptionIfInvalidParams()
    {
        $this->expectException(ActionCreateException::class);

        (new ActionFactory())->createAction('background', ['foo' => '']);
    }
}