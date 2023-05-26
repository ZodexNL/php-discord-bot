<?php

namespace src\Commands\Commands;

use DateTime;
use DateTimeZone;
use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Interactions\Interaction;
use src\Commands\Interfaces\Command;

class Kerst implements Command
{

    public static function getName(): string
    {
        return 'kerst';
    }

    public static function getDescription(): string
    {
        return 'Get the time till the next Christmas';
    }

    public static function getOptions(Discord $discord): ?array
    {
        return null;
    }

    public static function getType(): int
    {
        return 1;
    }

    public static function getResponse(Interaction $interaction, Discord $discord): void
    {
        $currentYear = date('Y');
        $nextChristmas = new DateTime($currentYear . '-12-25');

        $val = floor((strtotime($nextChristmas->format('Y-m-d H:i:s')) - time()) / 60 / 60 / 24);

        switch ($val) {
            case 0:
                $interaction->respondWithMessage(MessageBuilder::new()->setContent('Het is vandaag kerst!'));
                break;
            case 1:
                $interaction->respondWithMessage(MessageBuilder::new()->setContent('Het is kerstavond'));
                break;
            case -1:
                $interaction->respondWithMessage(MessageBuilder::new()->setContent('Kerst dag twee!'));
                break;
            case -2:
                $interaction->respondWithMessage(MessageBuilder::new()->setContent('Restjes eten en uitbuiken!'));
                break;
            default:
                $interaction->respondWithMessage(MessageBuilder::new()->setContent('Het is kerst over ' . $val . ' dagen!'));
                break;
        }
    }

    public static function getEmbed(Discord $discord, $response): Embed
    {
        return new Embed($discord);
    }
}
