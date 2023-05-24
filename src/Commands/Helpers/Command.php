<?php

namespace src\Commands\Helpers;

use Discord\Discord;
use Discord\Parts\Interactions\Interaction;
use src\OpenWeater\GeoCoding\Responses\Errors\Helpers\ErrorInterface;

interface Command
{
    public static function getName(): string;
    public static function getDescription(): string;
    public static function getOptions(Discord $discord): array | null;
    public static function getType(): int;
    public static function getResponse(Interaction $interaction, Discord $discord): void;
    public static function returnResponse(Interaction $interaction, Discord $discord, mixed $response): void;
    public static function returnError(Interaction $interaction, Discord $discord, ErrorInterface $response): void;
}
