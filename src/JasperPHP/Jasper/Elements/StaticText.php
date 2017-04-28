<?php

namespace JasperPHP\Jasper\Elements;

use JasperPHP\Jasper\Elements\Contracts\ElementInterface;
use JasperPHP\JFPDF;
use JasperPHP\Utils\Color;

/**
 * Class StaticText
 * @package JasperPHP\Jasper\Elements
 */
class StaticText implements ElementInterface
{
    /**
     * @var JFPDF
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

    /**
     * StaticText constructor.
     * @param JFPDF $pdf
     * @param $elements
     */
    public function __construct(JFPDF $pdf, $elements)
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
        if ($element != '') {
            $x = $element['reportElement']['@attributes']['x'];
            $y = $element['reportElement']['@attributes']['y'];
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
            $bold = 'B';
        } elseif (isset($element['textElement']['font']['@attributes']['isItalic']) &&
            $element['textElement']['font']['@attributes']['isItalic'] == 'true'){
            $bold = 'I';
        } elseif (isset($element['textElement']['font']['@attributes']['isUnderline']) &&
            $element['textElement']['font']['@attributes']['isUnderline'] == 'true'){
            $bold = 'U';
        }
        return $bold;
    }

    /**
     * @param $element
     * @return JFPDF
     */
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
        }
    }

    /**
     * @param $element
     */
    private function text($element)
    {
        $text = $element['text'];
        $width = $element['reportElement']['@attributes']['width'];
        $height = $element['reportElement']['@attributes']['height'];

        $this->textColor($element);
        $this->pdf->SetFont($this->font($element), $this->bold($element), $this->size($element));
        $this->pdf->Cell($width, $height, $text);
    }

    /**
     * execute code
     */
    public function run()
    {
        //die(print_r($this->elements));
        foreach ($this->elements as $element) {
            $this->position($element);
            $this->text($element);
        }
    }
}