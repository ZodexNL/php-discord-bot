<?php

namespace src\Messages;

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Channel\Message;

// TODO: improve this file
class Weer
{
    /**
     * 
     * Send a response
     * 
     * @param Message $message 
     * @param Discord $discord 
     * @return void 
     */
    public static function send(Message $message, Discord $discord): void
    {
        $method = 'GET';
        // $url = 'http://api.openweathermap.org/geo/1.0/direct?q=london&limit=1&appid=0c3b1e92805713bf4e34e1134f85d7a8';
        $url = 'http://api.openweathermap.org/data/2.5/weather?lat=51.5073219&lon=-0.1276474&appid=0c3b1e92805713bf4e34e1134f85d7a8';
        $data = false;


        $curl = curl_init();

        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        $result = curl_exec($curl);

        $result2 = json_decode($result);

        if (!$result) {
            echo "Connection Failure", PHP_EOL;
        }


        curl_close($curl);

        echo $result2->weather[0]->main, PHP_EOL;

        // foreach ($result2 as $loc) {
        // echo $loc->lat, PHP_EOL;
        // echo $loc->lon, PHP_EOL;
        // }
        // echo $result2, PHP_EOL;

        $message->channel->sendMessage(
            MessageBuilder::new()
                ->setContent('Pong!')
        );
    }
}
