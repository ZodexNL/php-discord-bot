<?php

namespace src\OpenWeather\GeoCoding\Responses;

use stdClass;

/**
 * The coordinate response
 * 
 * @property string $country    The zipcode
 * @property string $name       The city name
 * @property string $lat        The latitude from the city
 * @property string $lon        The longitude from the city
 * @property string $state      The longitude state the city
 */
class CoordinatesResponse
{

    private stdClass $obj;

    /**
     * Create and return a new CoordinatesResponse
     * @param stdClass $data
     * @return void
     */
    public function __construct(stdClass $data)
    {
        $obj = new stdClass();
        $obj->country = $data->country;
        $obj->name = $data->name;
        $obj->lat = $data->lat;
        $obj->lon = $data->lon;
        $obj->state = isset($data->state) ? $data->state : 'No state found';

        $this->obj = $obj;
    }

    /**
     * Get the country
     * @return string 
     */
    public function country(): string
    {
        return $this->obj->country;
    }

    /**
     * Get the name
     * @return string 
     */
    public function name(): string
    {
        return $this->obj->name;
    }

    /**
     * Get the lat
     * @return string 
     */
    public function lat(): string
    {
        return $this->obj->lat;
    }

    /**
     * Get the lon
     * @return string 
     */
    public function lon(): string
    {
        return $this->obj->lon;
    }

    /**
     * Get the state
     * @return string 
     */
    public function state(): string
    {
        return $this->obj->state;
    }
}
