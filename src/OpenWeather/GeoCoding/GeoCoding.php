<?php

namespace src\OpenWeather\GeoCoding;

use src\Helpers\Helpers;
use src\OpenWeather\GeoCoding\Responses\CoordinatesResponse;
use src\OpenWeather\GeoCoding\Responses\Errors\GeoCodingError;
use src\OpenWeather\GeoCoding\Responses\NameResponse;
use src\OpenWeather\GeoCoding\Responses\ZipCodeResponse;

class GeoCoding
{
    private $apiKey;

    /**
     * Set the apikey for the class
     * @param string $appKey
     * @return void
     */
    public function __construct(string $appKey)
    {
        $this->apiKey = $appKey;
    }

    /**
     * Get a list of city's based on the search param
     * @param string $query 
     * @return NameResponse|GeoCodingError 
     */
    public function searchByName(string $query): NameResponse|GeoCodingError
    {
        $curl = curl_init();
        $url = 'http://api.openweathermap.org/geo/1.0/direct?q=' . $query . '&limit=1&appid=' . $this->apiKey;

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        Helpers::checkCurlSucces($response, $curl);

        $data = json_decode($response);
        curl_close($curl);

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
        $curl = curl_init();
        $url = 'http://api.openweathermap.org/geo/1.0/zip?zip=' . $zipCode . ',' . $countryCode . '&appid=' . $this->apiKey;

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        Helpers::checkCurlSucces($response, $curl);

        $data = json_decode($response);
        curl_close($curl);


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
        $url = 'http://api.openweathermap.org/geo/1.0/reverse?lat=' . $lat . '&lon=' . $lon . '&limit=1&appid=' . $this->apiKey;

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        Helpers::checkCurlSucces($response, $curl);

        $data = json_decode($response);
        curl_close($curl);

        return isset($data->cod) || !isset($data['0']) ? new GeoCodingError($data) : new CoordinatesResponse($data['0']);
    }
}
