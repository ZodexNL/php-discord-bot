<?php

namespace src\OpenWeather\CurrentWeather\Responses;

use stdClass;

/**
 * The WeatherByNameResponse response
 * @property string $icon           The icon
 * @property string $title          The title
 * @property string $main           The main
 * @property string $description    The description
 * @property string $temp           The current temp
 * @property string $humidity       The humidity
 * @property string $wind           The wind
 * @property string $clouds         The clouds
 */
class WeatherByNameResponse
{
    private stdClass $obj;

    public function __construct(stdClass $data)
    {
        $newObj = new stdClass();

        $newObj->icon = $data->weather['0']->icon;

        $newObj->city = $data->name;
        $newObj->country = $data->sys->country;

        $newObj->main = $data->weather['0']->main;
        $newObj->description = $data->weather['0']->description;
        $newObj->temp = $data->main->temp;
        $newObj->humidity = $data->main->humidity;

        $newObj->windSpeed = $data->wind->speed;
        $newObj->windDir = $data->wind->deg;

        $newObj->clouds = $data->clouds->all;

        $this->obj = $newObj;
    }

    /**
     * Return the icon
     * @return string 
     */
    public function icon(): string
    {
        return 'http://openweathermap.org/img/wn/' . $this->obj->icon . '@2x.png';
    }

    /**
     * Return the title
     * @return string 
     */
    public function title(): string
    {
        return 'Huidig weer voor ' . $this->obj->city . ', ' . $this->obj->country;
    }

    /**
     * Return the main
     * @return string 
     */
    public function main(): string
    {
        return $this->obj->main;
    }

    /**
     * Return the description
     * @return string 
     */
    public function description(): string
    {
        return $this->obj->description;
    }

    /**
     * Return the temp
     * @return string 
     */
    public function temp(): string
    {
        return $this->obj->temp;
    }

    /**
     * Return the humidity
     * @return string 
     */
    public function humidity(): string
    {
        return $this->obj->humidity;
    }

    /**
     * Return the wind
     * @return string 
     */
    public function wind(): string
    {
        $degVal = $this->obj->windDir;
        $windDir = '';

        if ($degVal >= 0 && $degVal <= 30) {
            $windDir = 'Noorden';
        } else if ($degVal >= 31 && $degVal <= 60) {
            $windDir = 'Noordoost';
        } else if ($degVal >= 61 && $degVal <= 90) {
            $windDir = 'Oosten';
        } else if ($degVal >= 91 && $degVal <= 120) {
            $windDir = 'Oosten';
        } else if ($degVal >= 121 && $degVal <= 150) {
            $windDir = 'Zuidoost';
        } else if ($degVal >= 151 && $degVal <= 180) {
            $windDir = 'Zuiden';
        } else if ($degVal >= 181 && $degVal <= 210) {
            $windDir = 'Zuiden';
        } else if ($degVal >= 211 && $degVal <= 240) {
            $windDir = 'Zuidwest';
        } else if ($degVal >= 271 && $degVal <= 300) {
            $windDir = 'Westen';
        } else if ($degVal >= 301 && $degVal <= 330) {
            $windDir = 'Westen';
        } else if ($degVal >= 331 && $degVal <= 350) {
            $windDir = 'Noordwest';
        } else if ($degVal >= 351 && $degVal <= 380) {
            $windDir = 'Noorden';
        }


        return $this->obj->windSpeed . ' km/h ' . $windDir;
    }

    /**
     * Return the clouds
     * @return string 
     */
    public function clouds(): string
    {
        return $this->obj->clouds;
    }
}
