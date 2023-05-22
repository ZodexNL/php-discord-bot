<?php

namespace src\Commands\Helpers;

use Discord\Discord;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;

interface Command
{
    public static function getName(): string;
    public static function getDescription(): string;
    public static function getOptions(Discord $discord): array | null;
    public static function getType(): int;
    public static function getResponse(Interaction $interaction, Discord $discord): void;
    public static function getEmbed(Discord $discord, $response): Embed;
}
