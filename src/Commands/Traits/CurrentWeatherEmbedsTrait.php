<?php

namespace src\Commands\Traits;

use Discord\Discord;
use Discord\Parts\Embed\Embed;
use src\OpenWeather\CurrentWeather\Responses\WeatherByNameResponse;
use src\OpenWeather\GeoCoding\Responses\Errors\Helpers\ErrorInterface;

trait CurrentWeatherEmbedsTrait
{
    /**
     * Get the embed
     * @param Discord $discord 
     * @param WeatherByNameResponse $response 
     * @return Embed 
     */
    public static function searchByNameEmbed(Discord $discord, WeatherByNameResponse $response): Embed
    {
        $embedAttr = [
            'title' => $response->title(),
            'color' => hexdec('#008000'),
            'fields' => [],
            'footer' => [
                'text' => 'Roderick - made by ZodexNL using PHP-Discord'
            ],
            'thumbnail' => [
                'url' => $response->icon(),
            ]
        ];



        $embedAttr['fields'][] = [
            'name' => $response->main(),
            'value' => '',
            'inline' => false,
        ];



        $embedAttr['fields'][] = [
            'name' => 'Beschrijving',
            'value' =>  ucfirst($response->description()),
            'inline' => true,
        ];

        $embedAttr['fields'][] = [
            'name' => 'Temperatuur',
            'value' => $response->temp() . '°C',
            'inline' => true,
        ];

        $embedAttr['fields'][] = [
            'name' => 'Luchtvochtigheid',
            'value' => $response->humidity() . '%',
            'inline' => false,
        ];


        $embedAttr['fields'][] = [
            'name' => 'Wind',
            'value' => $response->wind(),
            'inline' => true,
        ];

        $embedAttr['fields'][] = [
            'name' => 'Bewolking',
            'value' => $response->clouds(),
            'inline' => true,
        ];

        return new Embed($discord, $embedAttr);
    }


    /**
     * Embed to return if there is an error
     * @param Discord $discord 
     * @param ErrorInterface $response 
     * @return Embed 
     */
    public static function errorEmbed(Discord $discord, ErrorInterface $response): Embed
    {
        $embedAttr['fields'][] = [
            'name' => '',
            'value' => '',
        ];

        $embedAttr = [
            'title' => $response->code(),
            'color' => hexdec('#FF0000'),
            'fields' => [],
            'footer' => [
                'text' => 'Roderick - made by ZodexNL using PHP-Discord'
            ],
        ];

        $embedAttr['fields'][] = [
            'name' => 'Error message',
            'value' => $response->message(),
        ];

        $embedAttr['fields'][] = [
            'name' => '',
            'value' => '',
        ];

        return new Embed($discord, $embedAttr);
    }
}
