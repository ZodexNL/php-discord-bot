<?php

namespace src\Commands\Commands;

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;
use Dotenv\Dotenv;
use LengthException;
use LogicException;
use OverflowException;
use src\Commands\Helpers\ResponseCommand;
use src\Commands\Traits\GeoCodingEmbedsTrait;
use src\OpenWeater\GeoCoding\GeoCoding;
use src\OpenWeater\GeoCoding\Responses\Errors\Helpers\ErrorInterface;
use src\OpenWeater\GeoCoding\Responses\ZipCodeResponse;

class SearchByZip implements ResponseCommand
{
    use GeoCodingEmbedsTrait;

    /**
     * Get the name of the command
     * @return string 
     */
    public static function getName(): string
    {
        return "searchbyzip";
    }

    /**
     * Return the description
     * @return string 
     */
    public static function getDescription(): string
    {
        return "Search a city by zip and country code";
    }

    /**
     * Return the options or null
     * @param Discord $discord 
     * @return Option|null 
     */
    public static function getOptions(Discord $discord): array | null
    {
        return  [
            new Option($discord, [
                'name' => 'zipcode',
                'description' => 'The zipcode to search',
                'type' => 3,
                'required' => true,
            ]),
            new Option($discord, [
                'name' => 'countrycode',
                'description' => 'The country code belonging to the zipcode',
                'type' => 3,
                'required' => true,
            ])
        ];
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
     * @param Discord $discord 
     * @return void 
     * @throws LengthException 
     * @throws LogicException 
     */
    public static function getResponse(Interaction $interaction, Discord $discord): void
    {
        // Not sure about loading the env here TODO: find solution
        $dotEnv = Dotenv::createImmutable(__DIR__ . '/../../../')->load();

        $zip = $interaction->data->options['zipcode']->value;
        $countryCode = $interaction->data->options['countrycode']->value;

        $weatherResponse = new GeoCoding($_ENV['WEATHER_API_TOKEN']);
        $response = $weatherResponse->searchByZipCode($zip, $countryCode);
        if ($response instanceof ZipCodeResponse) {
            self::returnResponse($interaction, $discord, $response);
        } else {
            self::returnError($interaction, $discord, $response);
        }
    }

    /**
     * Return this if there is an error
     * @param Interaction $interaction 
     * @param Discord $discord 
     * @param ErrorInterface $response 
     * @return void 
     * @throws OverflowException 
     * @throws LogicException 
     */
    public static function returnError(Interaction $interaction, Discord $discord, ErrorInterface $response): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->addEmbed(self::errorEmbed($discord, $response)));
    }

    /**
     * Return the correct response
     * @param Interaction $interaction 
     * @param Discord $discord 
     * @param ZipCodeResponse $response 
     * @return void 
     * @throws OverflowException 
     * @throws LogicException 
     */
    public static function returnResponse(Interaction $interaction, Discord $discord, $response): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->addEmbed(self::searchByZipEmbed($discord, $response)));
    }
}
