<?php

namespace src\Commands\Commands;

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Dotenv\Exception\InvalidEncodingException;
use Dotenv\Exception\InvalidFileException;
use src\Commands\Helpers\ResponseCommand;
use src\Commands\Traits\GeoCodingEmbedsTrait;
use src\OpenWeater\GeoCoding\GeoCoding;
use src\OpenWeater\GeoCoding\Responses\CoordinatesResponse;
use src\OpenWeater\GeoCoding\Responses\Errors\Helpers\ErrorInterface;

class SearchCityByCoords implements ResponseCommand
{
    use GeoCodingEmbedsTrait;

    /**
     * Get the name of the command
     * @return string 
     */
    public static function getName(): string
    {
        return 'searchcitybycoords';
    }

    /**
     * Get the description
     * @return string 
     */
    public static function getDescription(): string
    {
        return 'Search a city by Coordinates';
    }

    /**
     * Return the options or null
     * @param Discord $discord 
     * @return null|array 
     */
    public static function getOptions(Discord $discord): ?array
    {
        return [
            new Option($discord, [
                'name' => 'latitude',
                'description' => 'The latitude to use',
                'type' => 3,
                'required' => true,
            ]),
            new Option($discord, [
                'name' => 'longitude',
                'description' => 'The longitude to use',
                'type' => 3,
                'required' => true,
            ])
        ];
    }

    public static function getType(): int
    {
        return 1;
    }

    /**
     * Get the response
     * @param Interaction $interaction 
     * @param Discord $discord 
     * @return void 
     * @throws InvalidPathException 
     * @throws InvalidEncodingException 
     * @throws InvalidFileException 
     */
    public static function getResponse(Interaction $interaction, Discord $discord): void
    {
        $dotEnv = Dotenv::createImmutable(__DIR__ . '/../../../')->load();

        $lat = $interaction->data->options['latitude']->value;
        $lon = $interaction->data->options['longitude']->value;

        $weatherResponse = new GeoCoding($_ENV['WEATHER_API_TOKEN']);
        $response = $weatherResponse->searchByCoords($lat, $lon);
        if ($response instanceof CoordinatesResponse) {
            self::returnResponse($interaction, $discord, $response);
        } else {
            self::returnError($interaction, $discord, $response);
        }
    }

    /**
     * Return the response
     * @param Interaction $interaction 
     * @param Discord $discord 
     * @param mixed $response 
     * @return void 
     */
    public static function returnResponse(Interaction $interaction, Discord $discord, mixed $response): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->addEmbed(self::searchByCoordsEmbed($discord, $response)));
    }

    /**
     * Return the error
     * @param Interaction $interaction 
     * @param Discord $discord 
     * @param ErrorInterface $response 
     * @return void 
     */
    public static function returnError(Interaction $interaction, Discord $discord, ErrorInterface $response): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->addEmbed(self::errorEmbed($discord, $response)));
    }
}
