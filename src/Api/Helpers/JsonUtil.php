<?php


namespace Getnet\Api\Helpers;


class JsonUtil
{
    public static function unserialize($json)
    {
        return self::isJson($json) ? json_decode($json, true) : $json;
    }

    public static function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}