<?php

namespace src\OpenWeater\GeoCoding\Responses;

use stdClass;

/**
 * The zipcode response
 * @property string $zip        The zipcode
 * @property string $name       The city name
 * @property string $lat        The latitude from the city
 * @property string $lon        The longitude from the city
 * @property string $country    The country from the city
 */
class ZipCodeResponse
{
    private stdClass $obj;

    /**
     * Construct
     * @param stdClass $data 
     * @return void 
     */
    public function __construct(stdClass $data)
    {
        $objC = new stdClass();

        $objC->zip = $data->zip;
        $objC->name = $data->name;
        $objC->lat = $data->lat;
        $objC->lon = $data->lon;
        $objC->country = $data->country;
        $this->obj = $objC;
    }

    /**
     * Get the zipcode
     * @return string 
     */
    public function getZip(): string
    {
        return $this->obj->zip;
    }

    /**
     * Get the name
     * @return string 
     */
    public function getName(): string
    {
        return $this->obj->name;
    }

    /**
     * Get the Latitude
     * @return string 
     */
    public function getLat(): string
    {
        return $this->obj->lat;
    }

    /**
     * Get the Longitude
     * @return string 
     */
    public function getLon(): string
    {
        return $this->obj->lon;
    }

    /**
     * Get the country
     * @return string 
     */
    public function getCountry(): string
    {
        return $this->obj->country;
    }
}
