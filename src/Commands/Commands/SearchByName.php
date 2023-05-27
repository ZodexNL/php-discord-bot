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
use src\OpenWeather\GeoCoding\Responses\Errors\Helpers\ErrorInterface;
use src\OpenWeather\GeoCoding\Responses\NameResponse;

class SearchByName implements ResponseCommand
{
    use GeoCodingEmbedsTrait;

    public static function getName(): string
    {
        return 'searchbyname';
    }

    public static function getDescription(): string
    {
        return 'Get information by a city name';
    }

    public static function getOptions(Discord $discord): ?array
    {
        return [
            new Option($discord, [
                'name' => 'city',
                'description' => 'The city to get information about',
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

        $city = $interaction->data->options['city']->value;

        $weatherResponse = new GeoCoding();
        $response = $weatherResponse->searchByName($city);
        if ($response instanceof NameResponse) {
            self::returnResponse($interaction, $discord, $response);
        } else {
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
