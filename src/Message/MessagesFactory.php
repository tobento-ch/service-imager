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

namespace Tobento\Service\Imager\Message;

use Tobento\Service\Imager\Message\MessagesFactoryInterface;
use Tobento\Service\Imager\ActionsInterface;
use Tobento\Service\Message\MessagesFactory as BaseMessagesFactory;
use Tobento\Service\Message\MessagesInterface;

/**
 * MessagesFactory
 */
class MessagesFactory extends BaseMessagesFactory implements MessagesFactoryInterface
{
    /**
     * Create messages from the specified actions.
     *
     * @param ActionsInterface $actions
     * @return MessagesInterface
     */
    public function createMessagesFromActions(ActionsInterface $actions): MessagesInterface
    {
        $messages = $this->createMessages();
        
        foreach($actions as $action) {
            
            if ($action->description() === '') {
                continue;
            }
            
            $messages->add(
                level: 'info',
                message: $action->description(),
                context: [
                    'action' => $action::class,
                    'processedByAction' => $action->processedBy(),
                ],
                parameters: $this->toMessageParameters($action->parameters()),
            );
        }

        return $messages;
    }
    
    /**
     * To message parameters.
     *
     * @param array $parameters
     * @return array
     */
    protected function toMessageParameters(array $parameters): array
    {
        foreach($parameters as $key => $value) {
            if (is_string($key) && !str_starts_with($key, ':')) {
                unset($parameters[$key]);
                $parameters[':'.$key] = $value;
                continue;
            }
        }

        return $parameters;
    }
}