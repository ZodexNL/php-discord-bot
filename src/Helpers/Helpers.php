<?php

namespace src\Helpers;

class Helpers
{
    public static function checkCurlSucces($response, $curl): void
    {
        if ($response === false) {
            $error = curl_error($curl);
            echo 'curl Error: ' . $error, PHP_EOL;
        }
    }
}
