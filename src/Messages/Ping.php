<?php

namespace src\Messages;

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Channel\Message;

// TODO: improve this file
class Ping
{
    /**
     * 
     * Send a response
     * 
     * @param Message $message 
     * @param Discord $discord 
     * @return void 
     */
    public static function send(Message $message, Discord $discord): void
    {
        $message->channel->sendMessage(
            MessageBuilder::new()
                ->setContent('Pong!')
        );
    }
}
