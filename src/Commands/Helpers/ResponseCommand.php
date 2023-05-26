<?php

namespace src\Commands\Helpers;

use Discord\Discord;
use Discord\Parts\Interactions\Interaction;
use src\OpenWeater\GeoCoding\Responses\Errors\Helpers\ErrorInterface;

interface ResponseCommand
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
     * Get the type of the command
     * @return int 
     */
    public static function getType(): int;

    /**
     * Get the corresponding response of the command
     * @param Interaction $interaction 
     * @param Discord $discord 
     * @return void 
     */
    public static function getResponse(Interaction $interaction, Discord $discord): void;

    /**
     * Return the command response in discord
     * @param Interaction $interaction 
     * @param Discord $discord 
     * @param mixed $response 
     * @return void 
     */
    public static function returnResponse(Interaction $interaction, Discord $discord, mixed $response): void;

    /**
     * Return the command error in discord
     * @param Interaction $interaction 
     * @param Discord $discord 
     * @param ErrorInterface $response 
     * @return void 
     */
    public static function returnError(Interaction $interaction, Discord $discord, ErrorInterface $response): void;
}
