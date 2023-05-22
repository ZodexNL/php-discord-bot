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

class PingUser implements Command
{

    /**
     * Get the name
     * @return string 
     */
    public static function getName(): string
    {
        return "pinguser";
    }

    /**
     * Get the description
     * @return string 
     */
    public static function getDescription(): string
    {
        return "Ping a user!";
    }

    /**
     * Get the options
     * @param Discord $discord 
     * @return array|null 
     */
    public static function getOptions(Discord $discord): array | null
    {
        $arr = [
            new Option($discord, [
                'name' => 'user',
                'description' => 'The user to ping',
                'type' => 6,
                'required' => true,
            ])
        ];

        return $arr;
    }

    /**
     * Get the type
     * @return int 
     */
    public static function getType(): int
    {
        return 1;
    }

    /**
     * Get the response
     * @param Interaction $interaction 
     * @return void 
     * @throws LengthException 
     * @throws LogicException 
     */
    public static function getResponse(Interaction $interaction, Discord $discord): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->setContent($interaction->data->resolved->users->first()));
    }

    /**
     * Return the embed
     * @param Discord $discord 
     * @param mixed $response 
     * @return src\Commands\Commands\Embed 
     */
    public static function getEmbed(Discord $discord, $response): Embed
    {
        return new Embed($discord);
    }
}
