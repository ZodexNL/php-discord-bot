<?php

namespace src\Commands\Helpers;

use Discord\Discord;
use Discord\Parts\Interactions\Interaction;
use src\OpenWeater\GeoCoding\Responses\Errors\Helpers\ErrorInterface;

interface Command
{
    /**
     * Get the name of the command
     * @return string 
     */
    public static function getName(): string;

    /**
     * Get the description of the command
     * @return string 
     */
    public static function getDescription(): string;

    /**
     * Get the options of the command
     * @param Discord $discord 
     * @return array|null 
     */
    public static function getOptions(Discord $discord): array | null;

    /**
     * Get the type
     * @return int 
     */
    public static function getType(): int;

    /**
     * Return the response in discord
     * @param Interaction $interaction 
     * @param Discord $discord 
     * @return void 
     */
    public static function getResponse(Interaction $interaction, Discord $discord): void;
}