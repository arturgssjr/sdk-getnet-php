<?php


namespace Getnet\Api\Helpers;


class ArrayUtil
{

    public static function convertArrayToHeader($array)
    {
        return array_map(
            function ($k, $v) {
                return "$k:$v";
            }, array_keys($array), array_values($array)
        );
    }
}