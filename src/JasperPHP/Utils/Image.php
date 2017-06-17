<?php
namespace JasperPHP\Utils;

/**
 * Class Image
 * @package JasperPHP\Utils
 */
class Image
{
    /**
     * generate border to image
     *
     * @param $file
     * @param $fileTmp
     * @param array $rgb
     * @param $sizeBorder
     * @return string
     * @throws \Exception
     */
    public static function addBorder($file, $fileTmp, $rgb = array(), $sizeBorder)
    {
        if (self::isType($file)){
            throw new \Exception("Jasper contains images in an invalid format.");
        }
        $im = imagecreatefromjpeg($file);
        // Draw border
        $border = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
        self::drawBorder($im, $border, $sizeBorder);

        $name = md5(uniqid()) . '-' . time() . '.jpg';

        imagejpeg($im, $fileTmp . $name);
        return $fileTmp . $name;
    }

    /**
     * @param $image
     * @return bool
     */
    private static function isType($image)
    {
        return in_array(substr($image, strlen($image), -4), array(
            '.png',
            '.jpg',
            'jpeg',
            '.gif'
        ));
    }

    /**
     * @param $im
     * @param $color
     * @param int $thickness
     */
    private static function drawBorder($im, $color, $thickness = 1)
    {
        $x1 = 0;
        $y1 = 0;
        $x2 = ImageSX($im) - 1;
        $y2 = ImageSY($im) - 1;

        for($i = 0; $i < $thickness; $i++)
        {
            ImageRectangle($im, $x1++, $y1++, $x2--, $y2--, $color);
        }
    }
}