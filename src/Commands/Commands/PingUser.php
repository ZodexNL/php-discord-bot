<?php

namespace src\Commands\Commands;

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;
use src\Commands\Interfaces\Command;

class PingUser implements Command
{

    public static function getName(): string
    {
        return "pinguser";
    }

    public static function getDescription(): string
    {
        return "Ping a user!";
    }

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

    public static function getType(): int
    {
        return 1;
    }

    public static function getResponse(Interaction $interaction, Discord $discord): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->setContent($interaction->data->resolved->users->first()));
    }


    public static function getEmbed(Discord $discord, $response): Embed
    {
        return new Embed($discord);
    }
}
