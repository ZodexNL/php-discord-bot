<?php

namespace src\Commands\Commands;

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;
use src\Commands\Interfaces\ResponseCommand;
use src\Commands\Traits\CurrentWeatherEmbedsTrait;
use src\OpenWeather\CurrentWeather\CurrentWeather;
use src\OpenWeather\CurrentWeather\Responses\WeatherByNameResponse;
use src\OpenWeather\GeoCoding\Responses\Errors\Helpers\ErrorInterface;

class GetCurrentWeather implements ResponseCommand
{
    use CurrentWeatherEmbedsTrait;

    public static function getName(): string
    {
        return 'getcurrentweather';
    }

    public static function getDescription(): string
    {
        return 'Get the current weather off the given location';
    }

    public static function getOptions(Discord $discord): ?array
    {
        return [
            new Option($discord, [
                'name' => 'city',
                'description' => 'The city to search for',
                'type' => 3,
                'required' => true,
            ]),
            new Option($discord, [
                'name' => 'countrycode',
                'description' => 'The countrycode to use',
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
        $city = $interaction->data->options['city']->value;
        $countryCode = $interaction->data->options['countrycode']->value;
        $weatherResponse = new CurrentWeather();

        $response = $weatherResponse->getWeatherByCityName($city, $countryCode);


        if ($response instanceof WeatherByNameResponse) {
            echo 'hij is goed', PHP_EOL;
            self::returnResponse($interaction, $discord, $response);
        } else {
            echo 'hij is niet goed', PHP_EOL;
            self::returnError($interaction, $discord, $response);
        }
    }

    public static function returnResponse(Interaction $interaction, Discord $discord, mixed $response): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->addEmbed(self::searchByNameEmbed($discord, $response)));
    }

    public static function returnError(Interaction $interaction, Discord $discord, ErrorInterface $response): void
    {
        $interaction->respondWithMessage(MessageBuilder::new()->addEmbed(self::errorEmbed($discord, $response)));
    }
}
