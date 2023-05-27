<?php

namespace src\OpenWeather\GeoCoding;

use src\OpenWeather\CurlHelper\CurlResponse;
use src\OpenWeather\GeoCoding\Responses\CoordinatesResponse;
use src\OpenWeather\GeoCoding\Responses\Errors\GeoCodingError;
use src\OpenWeather\GeoCoding\Responses\NameResponse;
use src\OpenWeather\GeoCoding\Responses\ZipCodeResponse;

class GeoCoding
{
    /**
     * Get a list of city's based on the search param
     * @param string $query 
     * @return NameResponse|GeoCodingError 
     */
    public function searchByName(string $query): NameResponse|GeoCodingError
    {
        $url = 'http://api.openweathermap.org/geo/1.0/direct?q=' . $query . '&limit=1';


        $curl = new CurlResponse($url);
        $data = $curl->returnData();

        return isset($data->cod) || !isset($data['0']) ? new GeoCodingError($data) : new NameResponse($data['0']);
    }

    /**
     * Get a city the zipcode and country code
     * @param string $zipCode 
     * @param string $countryCode type (ISO 3166) country code
     * @return ZipCodeResponse|GeoCodingError
     */
    public function searchByZipCode(string $zipCode, string $countryCode): ZipCodeResponse|GeoCodingError
    {
        $url = 'http://api.openweathermap.org/geo/1.0/zip?zip=' . $zipCode . ',' . $countryCode;

        $curl = new CurlResponse($url);
        $data = $curl->returnData();

        return isset($data->cod) ? new GeoCodingError($data) : new ZipCodeResponse($data);
    }

    /**
     * Search a city by coordinates
     * @param string $lat 
     * @param string $lon 
     * @return CoordinatesResponse|GeoCodingError 
     */
    public function searchByCoords(string $lat, string $lon): CoordinatesResponse|GeoCodingError
    {
        $curl = curl_init();
        $url = 'http://api.openweathermap.org/geo/1.0/reverse?lat=' . $lat . '&lon=' . $lon . '&limit=1';

        $curl = new CurlResponse($url);
        $data = $curl->returnData();

        return isset($data->cod) || !isset($data['0']) ? new GeoCodingError($data) : new CoordinatesResponse($data['0']);
    }
}
