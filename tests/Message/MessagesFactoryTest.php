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

namespace Tobento\Service\Imager\Test\Message;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Imager\Message\MessagesFactory;
use Tobento\Service\Imager\Message\MessagesFactoryInterface;
use Tobento\Service\Imager\Actions;
use Tobento\Service\Imager\Action;
use Tobento\Service\Message\MessagesFactory as BaseMessagesFactory;
use Tobento\Service\Message\MessagesFactoryInterface as BaseMessagesFactoryInterface;
use Tobento\Service\Message\MessagesInterface;

/**
 * MessagesFactoryTest
 */
class MessagesFactoryTest extends TestCase
{
    public function testThatImplementsInterfaces()
    {
        $messagesFactory = new MessagesFactory();
        
        $this->assertInstanceof(
            BaseMessagesFactoryInterface::class,
            $messagesFactory
        );
        
        $this->assertInstanceof(
            MessagesFactoryInterface::class,
            $messagesFactory
        );
    }
    
    public function testCreateMessagesFromActions()
    {
        $actions = new Actions(
            new Action\Blur(blur: 20),
            new Action\Brightness(brightness: 20),
        );
                
        $messages = (new MessagesFactory())->createMessagesFromActions(actions: $actions);
        
        $this->assertInstanceof(MessagesInterface::class, $messages);
        $this->assertSame(2, count($messages->all()));
    }
    
    public function testCreateMessagesFromActionsIgnoresEmptyDescriptions()
    {
        $action = new class extends Action\Action {};
        
        $actions = new Actions(
            new Action\Blur(blur: 20),
            $action,
        );
                
        $messages = (new MessagesFactory())->createMessagesFromActions(actions: $actions);
        
        $this->assertSame(1, count($messages->all()));
    }
    
    public function testCreateMessagesFromActionsMessage()
    {
        $actions = new Actions(
            new Action\Blur(blur: 20),
        );
                
        $messages = (new MessagesFactory())->createMessagesFromActions(actions: $actions);
        
        $message = $messages->first();
        
        $this->assertSame('info', $message->level());
        $this->assertSame('Blured image by 20.', $message->message());
        
        $this->assertSame(
            ['action' => 'Tobento\Service\Imager\Action\Blur', 'processedByAction' => null],
            $messages->first()->context()
        );
        
        $this->assertSame(
            [':blur' => 20],
            $messages->first()->parameters()
        );
        
        $this->assertSame(null, $message->key());
        
        $this->assertFalse($message->logged());
    }
}