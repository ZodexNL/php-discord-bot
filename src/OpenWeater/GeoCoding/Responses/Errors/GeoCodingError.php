<?php

namespace src\OpenWeater\GeoCoding\Responses\Errors;

use src\OpenWeater\GeoCoding\Responses\Errors\Helpers\ErrorInterface;
use stdClass;

/**
 * The error response
 * @property string $code    The error code
 * @property string $message The error message
 * 
 */
class GeoCodingError implements ErrorInterface
{
    public stdClass $error;
    /**
     * Construct the error 
     */
    public function __construct(stdClass $data)
    {
        $this->error = $data;
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
