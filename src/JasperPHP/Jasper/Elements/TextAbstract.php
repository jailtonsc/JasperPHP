<?php

namespace JasperPHP\Jasper\Elements;

use JasperPHP\PDF;
use JasperPHP\Utils\Color;

abstract class TextAbstract
{
    /**
     * @var PDF
     */
    protected $pdf;

    /**
     * @var
     */
    protected $elements;

    /**
     * @var mixed
     */
    protected $config;

    /**
     * Position of the element
     *
     * @param $element
     */
    protected function position($element)
    {
        if (isset($element['reportElement'])) {
            $x = ($this->pdf->marginLeft + $element['reportElement']['@attributes']['x']);
            $y = ($this->pdf->position + $element['reportElement']['@attributes']['y']);
            $this->pdf->SetXY($x, $y);
        }
    }

    /**
     * Informs the type of border of the element
     *
     * @param $element
     * @return string
     */
    protected function bold($element)
    {
        $bold = '';
        if (isset($element['textElement']['font']['@attributes']['isBold']) &&
            $element['textElement']['font']['@attributes']['isBold'] == 'true'){
            $bold .= 'B';
        }
        if (isset($element['textElement']['font']['@attributes']['isItalic']) &&
            $element['textElement']['font']['@attributes']['isItalic'] == 'true'){
            $bold .= 'I';
        }

        if (isset($element['textElement']['font']['@attributes']['isUnderline']) &&
            $element['textElement']['font']['@attributes']['isUnderline'] == 'true'){
            $bold .= 'U';
        }
        return $bold;
    }

    /**
     * Informs the source type of the element, if it does not find the source
     * in the jasper picks up the default
     *
     * @param $element
     * @return mixed
     */
    protected function font($element)
    {
        if (isset($element['textElement']['font']['@attributes']['fontName'])){
            return $element['textElement']['font']['@attributes']['fontName'];
        }
        return $this->config['font'];
    }

    /**
     * @param $element
     * @return string
     */
    protected function size($element)
    {
        if (isset($element['textElement']['font']['@attributes']['fontName'])){
            return $element['textElement']['font']['@attributes']['size'];
        }
        return $this->config['sizeFont'];
    }

    /**
     * @param $element
     */
    protected function textColor($element)
    {
        if (isset($element['reportElement']['@attributes']['forecolor'])) {
            $rgb = Color::HexToRGB($element['reportElement']['@attributes']['forecolor']);
            $this->pdf->SetTextColor($rgb[0], $rgb[1], $rgb[2]);
        } else {
            $this->pdf->SetTextColor(0, 0, 0);
        }
    }

    /**
     * @param $element
     * @return bool
     */
    protected function backgroundColor($element)
    {
        if (isset($element['reportElement']['@attributes']['mode']) &&
            $element['reportElement']['@attributes']['mode'] == 'Opaque'){
            $rgb = Color::HexToRGB($element['reportElement']['@attributes']['backcolor']);
            $this->pdf->SetFillColor($rgb[0], $rgb[1], $rgb[2]);
            return true;
        }
        return false;
    }

    /**
     * @param $element
     * @return string
     */
    protected function align($element)
    {
        if (isset($element['textElement']['@attributes']['textAlignment'])){
            $align = $element['textElement']['@attributes']['textAlignment'];
            if ($align == 'Center'){
                return 'L';
            } elseif ($align == 'Right'){
                return 'R';
            }
        }

        return $this->config['alignText'];
    }

    /**
     * @param $element
     * @return int
     */
    protected function border($element)
    {
        if (isset($element['box']['pen']['@attributes']['lineWidth'])){
            $rgb = Color::HexToRGB($element['box']['pen']['@attributes']['lineColor']);

            $this->pdf->SetDrawColor($rgb[0], $rgb[1], $rgb[2]);
            $this->pdf->SetLineWidth($element['box']['pen']['@attributes']['lineWidth']);
            return 1;
        }
        return 0;
    }

    abstract protected function text($element);
}