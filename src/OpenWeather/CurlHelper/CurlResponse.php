<?php

namespace src\OpenWeather\CurlHelper;

use Dotenv\Dotenv;
use src\Helpers\Helpers;
use stdClass;

/**
 * Do a get request with the given URL and return the response
 * @property string $cod
 * @return mixed
 */
class CurlResponse
{
    /**
     * 
     * @var string
     */
    private string $url;

    /**
     * Construct the class
     * @param string $url 
     * @return void 
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Initialize curl and return the respone
     * @return stdClass|null|array
     */
    public function returnData(): stdClass|null|array
    {
        $dotEnv = Dotenv::createImmutable(__DIR__ . '/../../../')->load();
        $apiKey = $_ENV['WEATHER_API_TOKEN'];

        $curl = curl_init();
        $getUrl = $this->url . '&appid=' . $apiKey;

        curl_setopt($curl, CURLOPT_URL, $getUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        Helpers::checkCurlSucces($response, $curl);

        $data = json_decode($response);
        curl_close($curl);

        return $data;
    }
}
