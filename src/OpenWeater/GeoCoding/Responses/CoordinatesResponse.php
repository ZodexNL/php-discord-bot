<?php

namespace src\OpenWeater\GeoCoding\Responses;

use stdClass;

/**
 *
 * @package src\OpenWeater\GeoCoding\Responses
 */
class CoordinatesResponse
{

    // TODO: check if array would be better response

    /**
     * Create and return a new CoordinatesResponse
     * @param object $val
     * @return stdClass
     */
    public function __construct(object $val)
    {
        $obj = new stdClass();
        $obj->lat = $val->lat;
        $obj->lon = $val->lon;
        $obj->country = $val->country;
        $obj->state = $val->state;

        return $obj;
    }
}
