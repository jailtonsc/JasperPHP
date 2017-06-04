<?php
namespace JasperPHP\Utils;

/**
 * Class Image
 * @package JasperPHP\Utils
 */
class Image
{
    /**
     * @param $file
     * @param $width
     * @param $height
     * @return mixed
     */
    /*
    public static function addBorder($file, $width, $height)
    {
        $image = imagecreatefromjpeg($file);

        $gd = imagecreatetruecolor($width, $height);

        for($i = 0; $i<$height; $i++) {
            // add left border
            imagesetpixel($image,0,$i, imagecolorallocate($gd, 0,0,0) );
            // add right border
            imagesetpixel($image,$width-1,$i, imagecolorallocate($gd, 0,0,0) );
        }
        for($j = 0; $j<$width; $j++) {
            // add bottom border
            imagesetpixel($image,$j,0, imagecolorallocate($gd, 0,0,0) );
            // add top border
            imagesetpixel($image,$j,$height-1, imagecolorallocate($gd, 0,0,0) );
        }

        return $image;
    }*/

    public static function addBorder($file, $fileTmp)
    {
        die($fileTmp);
        $im = imagecreatefromjpeg($file);
        // Draw border
        $border = imagecolorallocate($im, 180, 0, 255);
        self::drawBorder($im, $border, 1);

        imagejpeg($im, $fileTmp . "/file.jpg");
    }

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