<?php
namespace App\Common;

use Illuminate\Support\Facades\Input;

class Utility {

    public static function stripXSS()
    {
        $sanitized = static::cleanArray(Input::get());
        Input::merge($sanitized);
    }

    public static function cleanArray($array)
    {
        $result = array();
        foreach ($array as $key => $value) {
            $key = strip_tags($key);
            if (is_array($value)) {
                $result[$key] = static::cleanArray($value);
            } else {
                $result[$key] = trim(strip_tags($value)); // Remove trim() if you want to.
            }
        }
        return $result;
    }
}