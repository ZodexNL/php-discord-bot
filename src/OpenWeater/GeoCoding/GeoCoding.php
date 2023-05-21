<?php

namespace src\OpenWeater\GeoCoding;

use src\Helpers\Helpers;
use src\OpenWeater\GeoCoding\Responses\CoordinatesResponse;

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
     * @return void 
     */
    public function searchByName(string $query, int $limit)
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

        // continue


    }
}
