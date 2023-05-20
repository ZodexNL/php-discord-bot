<?php

namespace src\Commands\Commands;

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;
use LengthException;
use LogicException;
use src\Commands\Helpers\Command;


class Ping implements Command
{
    /**
     * Get the name of the command
     * @return string 
     */
    public static function getName(): string
    {
        return "ping";
    }

    /**
     * Return the description
     * @return string 
     */
    public static function getDescription(): string
    {
        return "Return pong!";
    }

    /**
     * Return the options or null
     * @param Discord $discord 
     * @return Option|null 
     */
    public static function getOptions(Discord $discord): Option | null
    {
        // $option = new Option($discord, [
        //     'name' => 'user',
        //     'description' => 'The user',
        //     'type' => 6,
        //     'required' => true
        // ]);
        return null;
    }

    /**
     * Get the type of the command
     * @return int
     */
    public static function getType(): int
    {
        return 1;
    }

    /**
     * Return the response when this command is used
     * 
     * @param Interaction $interaction 
     * @return void 
     * @throws LengthException 
     * @throws LogicException 
     */
    public static function getResponse(Interaction $interaction): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->setContent('Pong!'));
    }
}
