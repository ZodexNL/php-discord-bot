<?php

namespace src\Commands\Commands;

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Embed\Embed;
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
     * @return array|null 
     */
    public static function getOptions(Discord $discord): array | null
    {
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
    public static function getResponse(Interaction $interaction, Discord $discord): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->setContent('Pong!'));
    }

    /**
     * Return the embed
     * @param Discord $discord 
     * @param mixed $response 
     * @return Embed 
     */
    public static function getEmbed(Discord $discord, $response): Embed
    {
        return new Embed($discord);
    }
}
