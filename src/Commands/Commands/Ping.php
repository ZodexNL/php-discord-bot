<?php

namespace src\Commands\Commands;

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Interactions\Interaction;
use src\Commands\Helpers\Command;

class Ping implements Command
{
    public static function getName(): string
    {
        return "ping";
    }

    public static function getDescription(): string
    {
        return "Return pong!";
    }

    public static function getOptions(Discord $discord): array | null
    {
        return null;
    }

    public static function getType(): int
    {
        return 1;
    }

    public static function getResponse(Interaction $interaction, Discord $discord): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->setContent('Pong!'));
    }

    public static function getEmbed(Discord $discord, $response): Embed
    {
        return new Embed($discord);
    }
}
