<?php

namespace JasperPHP\Utils;


class Color
{
    public static function HexToRGB($hex)
    {
        return sscanf($hex, "#%02x%02x%02x");
    }
}