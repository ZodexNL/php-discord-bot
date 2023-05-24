<?php

namespace src\Commands\Traits;

use Discord\Discord;
use Discord\Parts\Embed\Embed;
use src\OpenWeater\GeoCoding\Responses\Errors\Helpers\ErrorInterface;
use src\OpenWeater\GeoCoding\Responses\ZipCodeResponse;

trait SearchByZipTrait
{
    /**
     * Return the embed
     * @param Discord $discord 
     * @param ZipCodeResponse $response 
     * @return Embed 
     */
    public static function getEmbed(Discord $discord, ZipCodeResponse $response): Embed
    {
        $embedAttr = [
            'title' => $response->country(),
            'color' => hexdec('#008000'),
            'fields' => [],
            'footer' => [
                'text' => 'Roderick - made by ZodexNL using PHP-Discord'
            ],
        ];

        $embedAttr['fields'][] = [
            'name' => 'Stad',
            'value' => $response->name(),
            'inline' => true,
        ];

        $embedAttr['fields'][] = [
            'name' => 'Postcode',
            'value' => $response->zip(),
            'inline' => true,
        ];

        $embedAttr['fields'][] = [
            'name' => '',
            'value' => '',
        ];


        $embedAttr['fields'][] = [
            'name' => 'Latitude',
            'value' => $response->lat(),
            'inline' => true,
        ];

        $embedAttr['fields'][] = [
            'name' => 'Longitude',
            'value' => $response->lon(),
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
