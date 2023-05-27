<?php

namespace src\OpenWeather\CurrentWeather;

use Dotenv\Exception\InvalidPathException;
use Dotenv\Exception\InvalidEncodingException;
use Dotenv\Exception\InvalidFileException;
use src\OpenWeather\CurlHelper\CurlResponse;
use src\OpenWeather\CurrentWeather\Responses\Errors\WeatherError;
use src\OpenWeather\CurrentWeather\Responses\WeatherByNameResponse;

class CurrentWeather
{
    /**
     * Get the weather by city name
     * @param string $city 
     * @param string $countryCode 
     * @return WeatherByNameResponse|WeatherError 
     */
    public function getWeatherByCityName(string $city, string $countryCode): WeatherByNameResponse|WeatherError
    {
        $url = 'http://api.openweathermap.org/data/2.5/weather?q=' . $city . ',' . $countryCode . '&units=metric&lang=nl';

        $curl = new CurlResponse($url);
        $data = $curl->returnData();

        return $data->cod != '200' || is_null($data) ? new WeatherError($data) : new WeatherByNameResponse($data);
    }
}
