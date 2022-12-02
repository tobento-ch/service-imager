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

use Tobento\Service\Imager\ActionsInterface;
use Tobento\Service\Message\MessagesFactoryInterface as BaseMessagesFactoryInterface;
use Tobento\Service\Message\MessagesInterface;

/**
 * MessagesFactoryInterface
 */
interface MessagesFactoryInterface extends BaseMessagesFactoryInterface
{
    /**
     * Create messages from the specified actions.
     *
     * @param ActionsInterface $actions
     * @return MessagesInterface
     */
    public function createMessagesFromActions(ActionsInterface $actions): MessagesInterface;
}