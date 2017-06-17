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
        $name = '';
        $type = self::type($file);

        if (!self::isType($type)){
            throw new \Exception("Jasper contains images in an invalid format.");
        }

        switch ($type) {
            case 'jpeg':
            case '.jpg':
                $name = self::imageJPEG($file, $fileTmp, $rgb, $sizeBorder);
                break;
            case '.png':
                $name = self::imagePNG($file, $fileTmp, $rgb, $sizeBorder);
                break;
            case '.gif':
                $name = self::imageGIF($file, $fileTmp, $rgb, $sizeBorder);
                break;
        }

        return $fileTmp . $name;
    }

    /**
     * @param $file
     * @param $fileTmp
     * @param array $rgb
     * @param $sizeBorder
     * @return string
     */
    private static function imageJPEG($file, $fileTmp, $rgb = array(), $sizeBorder)
    {
        $im = imagecreatefromjpeg($file);
        // Draw border
        $border = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
        self::drawBorder($im, $border, $sizeBorder);

        $name = md5(uniqid()) . '-' . time() . '.jpg';

        imagejpeg($im, $fileTmp . $name);
        return $name;
    }

    /**
     * @param $file
     * @param $fileTmp
     * @param array $rgb
     * @param $sizeBorder
     * @return string
     */
    private static function imagePNG($file, $fileTmp, $rgb = array(), $sizeBorder)
    {
        $im = imagecreatefrompng($file);
        // Draw border
        $border = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
        self::drawBorder($im, $border, $sizeBorder);

        $name = md5(uniqid()) . '-' . time() . '.jpg';

        imagepng($im, $fileTmp . $name);
        return $name;
    }

    /**
     * @param $file
     * @param $fileTmp
     * @param array $rgb
     * @param $sizeBorder
     * @return string
     */
    private static function imageGIF($file, $fileTmp, $rgb = array(), $sizeBorder)
    {
        $im = imagecreatefromgif($file);
        // Draw border
        $border = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
        self::drawBorder($im, $border, $sizeBorder);

        $name = md5(uniqid()) . '-' . time() . '.jpg';

        imagegif($im, $fileTmp . $name);
        return $name;
    }

    /**
     * @param $image
     * @return bool|string
     */
    private static function type($image)
    {
        return substr($image, (strlen($image) -4), 4);
    }

    /**
     * @param $ype
     * @return bool
     */
    private static function isType($ype)
    {
        return in_array($ype, array(
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