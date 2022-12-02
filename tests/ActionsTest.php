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
use Tobento\Service\Imager\Actions;
use Tobento\Service\Imager\ActionsInterface;
use Tobento\Service\Imager\Action;
use Tobento\Service\Imager\ActionInterface;

/**
 * ActionsTest
 */
class ActionsTest extends TestCase
{
    public function testThatImplementsActionsInterface()
    {
        $this->assertInstanceof(
            ActionsInterface::class,
            new Actions()
        );
    }
    
    public function testCreateActions()
    {
        $actions = new Actions(
            new Action\Background(color: '#333'),
            new Action\Blur(blur: 20),
        );
        
        $this->assertTrue(true);
    }
    
    public function testAddMethod()
    {
        $actions = new Actions();
        
        $actions->add(new Action\Background(color: '#333'))
                ->add(new Action\Blur(blur: 20));
        
        $this->assertTrue(true);
    }
    
    public function testEmptyMethod()
    {
        $actions = new Actions();
        
        $this->assertTrue($actions->empty());
        
        $actions->add(new Action\Background(color: '#333'));
        
        $this->assertFalse($actions->empty());
    }
    
    public function testFilterMethod()
    {
        $actions = new Actions(
            new Action\Background(color: '#333'),
            new Action\Blur(blur: 20),
        );
        
        $actionsNew = $actions->filter(
            fn(ActionInterface $a): bool => $a::class === Action\Blur::class
        );
        
        $this->assertFalse($actions === $actionsNew);
        $this->assertSame(1, count($actionsNew->all()));
    }
    
    public function testOnlyMethod()
    {
        $actions = new Actions(
            new Action\Pixelate(pixelate: 10),
            new Action\Blur(blur: 20),
            new Action\Background(color: '#333'),
            new Action\Pixelate(pixelate: 10),
            new Action\Blur(blur: 20),
        );
        
        $actionsNew = $actions->only(Action\Pixelate::class, Action\Blur::class);
        
        $this->assertFalse($actions === $actionsNew);
        $this->assertSame(4, count($actionsNew->all()));
    }
    
    public function testExceptMethod()
    {
        $actions = new Actions(
            new Action\Pixelate(pixelate: 10),
            new Action\Blur(blur: 20),
            new Action\Background(color: '#333'),
            new Action\Pixelate(pixelate: 10),
            new Action\Blur(blur: 20),
        );
        
        $actionsNew = $actions->except(Action\Pixelate::class, Action\Blur::class);
        
        $this->assertFalse($actions === $actionsNew);
        $this->assertSame(1, count($actionsNew->all()));
    }
    
    public function testWithoutProcessedByMethod()
    {
        $actions = new Actions(
            new Action\Pixelate(pixelate: 10),
            (new Action\Blur(blur: 20))->setProcessedBy('foo'),
            new Action\Background(color: '#333'),
        );
        
        $actionsNew = $actions->withoutProcessedBy();
        
        $this->assertFalse($actions === $actionsNew);
        $this->assertSame(2, count($actionsNew->all()));
    }
    
    public function testAllMethod()
    {
        $actions = new Actions(
            new Action\Pixelate(pixelate: 10),
            new Action\Blur(blur: 20),
        );
        
        $this->assertSame(2, count($actions->all()));
    }
}