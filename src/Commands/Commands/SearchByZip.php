<?php

namespace src\Commands\Commands;

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;
use Dotenv\Dotenv;
use LengthException;
use LogicException;
use src\Commands\Helpers\Command;
use src\OpenWeater\GeoCoding\GeoCoding;


class SearchByZip implements Command
{
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

        echo $response->getName();

        $interaction->respondWithMessage(MessageBuilder::new()->addEmbed(self::getEmbed($discord, $response)));
    }

    // TODO: change this to trait or something to have $response strong typed
    public static function getEmbed(Discord $discord, $response): Embed
    {
        $embedAttr = [
            'title' => $response->getCountry(),
            'color' => hexdec('#008000'),
            'fields' => [],
            'footer' => [
                'text' => 'Roderick - made by ZodexNL using PHP-Discord'
            ],
        ];

        // TODO: improve this ofcourse

        $embedAttr['fields'][] = [
            'name' => 'Stad',
            'value' => $response->getName(),
            'inline' => true,
        ];

        $embedAttr['fields'][] = [
            'name' => 'Postcode',
            'value' => $response->getZip(),
            'inline' => true,
        ];

        $embedAttr['fields'][] = [
            'name' => '',
            'value' => '',
        ];


        $embedAttr['fields'][] = [
            'name' => 'Latitude',
            'value' => $response->getLat(),
            'inline' => true,
        ];

        $embedAttr['fields'][] = [
            'name' => 'Longitude',
            'value' => $response->getLon(),
            'inline' => true,
        ];



        return new Embed($discord, $embedAttr);
    }
}
