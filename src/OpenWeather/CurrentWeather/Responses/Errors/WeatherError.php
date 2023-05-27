<?php

namespace src\OpenWeather\CurrentWeather\Responses\Errors;

use src\OpenWeather\GeoCoding\Responses\Errors\Helpers\ErrorInterface;
use stdClass;

/**
 * The error response
 * @property string $code    The error code
 * @property string $message The error message
 * 
 */
class WeatherError implements ErrorInterface
{
    public stdClass $error;
    /**
     * Construct the error 
     */
    public function __construct(mixed $data)
    {
        if (!empty($data)) {
            $this->error = $data;
            return;
        }
        $this->setEmptyError();
    }

    private function setEmptyError()
    {
        $newObj = new stdClass();
        $newObj->cod = 'Geen resultaten';
        $newObj->message = 'Er zijn geen resultaten gevonden voor deze zoekopdracht';

        $this->error = $newObj;
    }

    /**
     * Get the code of the error
     * @return string 
     */
    public function code(): string
    {
        return $this->error->cod;
    }

    /**
     * Get the message of the error
     * @return string 
     */
    public function message(): string
    {
        return $this->error->message;
    }
}
