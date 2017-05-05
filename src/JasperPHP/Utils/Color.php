<?php

namespace JasperPHP\Utils;

/**
 * Class Color
 * @package JasperPHP\Utils
 */
class Color
{
    /**
     * Convert hexadecimal to RGB
     *
     * @param $hex
     * @return mixed
     */
    public static function HexToRGB($hex)
    {
        return sscanf($hex, "#%02x%02x%02x");
    }
}