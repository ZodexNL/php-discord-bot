<?php

namespace src\OpenWeather\GeoCoding\Responses\Errors\Helpers;

use stdClass;

/**
 * Returns the error response
 *
 * @return stdClass
 *
 * @property string $code        The error
 * @property string $message The error message
 */
interface ErrorInterface
{
    /**
     * Get the code of the error
     * @return string 
     */
    public function code(): string;

    /**
     * Get the message of the error
     * @return string 
     */
    public function message(): string;
}
