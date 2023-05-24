<?php

namespace src\OpenWeater\GeoCoding;

use src\Helpers\Helpers;
use src\OpenWeater\GeoCoding\Responses\CoordinatesResponse;
use src\OpenWeater\GeoCoding\Responses\Errors\GeoCodingError;
use src\OpenWeater\GeoCoding\Responses\ZipCodeResponse;

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
     * @param int $limit maximum value: 5
     * @return array 
     */
    public function searchByName(string $query, int $limit): array
    {
        $limit = $limit <= 5 ? $limit : 5;

        $curl = curl_init();
        $url = 'http://api.openweathermap.org/geo/1.0/direct?q=' . $query . '&limit=' . $limit . '&appid=' . $this->apiKey;

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        $succes = Helpers::checkCurlSucces($response, $curl);
        if (!$succes) {
            return 'Something went wrong';
        }

        $data = json_decode($response);
        curl_close($curl);



        $returnArr = [];
        foreach ($data as $val) {
            array_push($returnArr, new CoordinatesResponse($val));
        }

        return $returnArr;
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

        $succes = Helpers::checkCurlSucces($response, $curl);
        if (!$succes) {
            return 'Something went wrong';
        }

        $data = json_decode($response);
        curl_close($curl);


        return isset($data->cod) ? new GeoCodingError($data) : new ZipCodeResponse($data);
    }
}
