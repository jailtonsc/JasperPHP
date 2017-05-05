<?php

namespace JasperPHP\Jasper\Elements;

use JasperPHP\Jasper\Elements\Contracts\ElementInterface;
use JasperPHP\PDF;
use JasperPHP\Utils\Color;

/**
 * Class StaticText
 * @package JasperPHP\Jasper\Elements
 */
class StaticText implements ElementInterface
{
    /**
     * @var PDF
     */
    private $pdf;

    /**
     * @var
     */
    private $elements;

    /**
     * @var mixed
     */
    private $config;

    public function __construct(PDF $pdf, $elements)
    {
        $this->pdf = $pdf;
        $this->elements = $elements;
        $this->config = $this->pdf->config();
    }

    /**
     * @param $element
     */
    public function position($element)
    {
        if (isset($element['reportElement'])) {
            $x = ($this->pdf->marginLeft + $element['reportElement']['@attributes']['x']);
            $y = ($this->pdf->marginTop + $element['reportElement']['@attributes']['y']);
            $this->pdf->SetXY($x, $y);
        }
    }

    /**
     * @param $element
     * @return string
     */
    private function bold($element)
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

    private function font($element)
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
    private function size($element)
    {
        if (isset($element['textElement']['font']['@attributes']['fontName'])){
            return $element['textElement']['font']['@attributes']['size'];
        }
        return $this->config['sizeFont'];
    }

    private function textColor($element)
    {
        if (isset($element['reportElement']['@attributes']['forecolor'])) {
            $rgb = Color::HexToRGB($element['reportElement']['@attributes']['forecolor']);
            $this->pdf->SetTextColor($rgb[0], $rgb[1], $rgb[2]);
        } else {
            $this->pdf->SetTextColor(0, 0, 0);
        }
    }

    private function backgroundColor($element)
    {
        if (isset($element['reportElement']['@attributes']['mode']) &&
            $element['reportElement']['@attributes']['mode'] == 'Opaque'){
            $rgb = Color::HexToRGB($element['reportElement']['@attributes']['backcolor']);
            $this->pdf->SetFillColor($rgb[0], $rgb[1], $rgb[2]);
            return true;
        }
        return false;
    }

    private function align($element)
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

    private function border($element)
    {
        if (isset($element['box']['pen']['@attributes']['lineWidth'])){
            $rgb = Color::HexToRGB($element['box']['pen']['@attributes']['lineColor']);

            $this->pdf->SetDrawColor($rgb[0], $rgb[1], $rgb[2]);
            $this->pdf->SetLineWidth($element['box']['pen']['@attributes']['lineWidth']);
            return 1;
        }
        return 0;
    }

    /**
     * @param $element
     */
    private function text($element)
    {
        $width = 0;
        $height = 0;
        $text = '';

        if (isset($element['text'])){
            $text = $element['text'];
        }

        if (isset($element['reportElement'])){
            $width = $element['reportElement']['@attributes']['width'];
            $height = $element['reportElement']['@attributes']['height'];
        }

        $this->textColor($element);
        $this->pdf->SetFont($this->font($element), $this->bold($element), $this->size($element));
        $this->pdf->Cell($width, $height, $text, $this->border($element), 0, $this->align($element), $this->backgroundColor($element));
    }

    /**
     * execute code
     */
    public function run()
    {
        //print_r($this->elements);
        foreach ($this->elements as $element) {
            $this->position($element);
            $this->text($element);
        }
    }
}