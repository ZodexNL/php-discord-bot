<?php

namespace src\Commands\Commands;

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;
use Dotenv\Dotenv;
use src\Commands\Interfaces\ResponseCommand;
use src\Commands\Traits\GeoCodingEmbedsTrait;
use src\OpenWeather\GeoCoding\GeoCoding;
use src\OpenWeather\GeoCoding\Responses\CoordinatesResponse;
use src\OpenWeather\GeoCoding\Responses\Errors\Helpers\ErrorInterface;

class SearchCityByCoords implements ResponseCommand
{
    use GeoCodingEmbedsTrait;

    public static function getName(): string
    {
        return 'searchcitybycoords';
    }

    public static function getDescription(): string
    {
        return 'Search a city by Coordinates';
    }

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

    public static function getResponse(Interaction $interaction, Discord $discord): void
    {
        $dotEnv = Dotenv::createImmutable(__DIR__ . '/../../../')->load();

        $lat = $interaction->data->options['latitude']->value;
        $lon = $interaction->data->options['longitude']->value;

        $weatherResponse = new GeoCoding();
        $response = $weatherResponse->searchByCoords($lat, $lon);
        if ($response instanceof CoordinatesResponse) {
            self::returnResponse($interaction, $discord, $response);
        } else {
            self::returnError($interaction, $discord, $response);
        }
    }

    public static function returnResponse(Interaction $interaction, Discord $discord, mixed $response): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->addEmbed(self::searchByCoordsEmbed($discord, $response)));
    }

    public static function returnError(Interaction $interaction, Discord $discord, ErrorInterface $response): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->addEmbed(self::errorEmbed($discord, $response)));
    }
}
