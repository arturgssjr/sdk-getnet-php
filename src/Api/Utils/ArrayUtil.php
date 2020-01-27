<?php


namespace Getnet\Api\Utils;


class ArrayUtil
{

    public static function convertArrayToHeader(array $array)
    {
        return array_map(
            function ($k, $v) {
                return "$k:$v";
            }, array_keys($array), array_values($array)
        );
    }
}