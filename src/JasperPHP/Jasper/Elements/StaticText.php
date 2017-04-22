<?php

namespace JasperPHP\Jasper\Elements;

use JasperPHP\Jasper\Elements\Contracts\ElementInterface;

/**
 * Class StaticText
 * @package JasperPHP\Jasper\Elements
 */
class StaticText implements ElementInterface
{
    /**
     * @var
     */
    private $pdf;
    /**
     * @var
     */
    private $elements;

    private $font = 'Arial';

    /**
     * StaticText constructor.
     * @param $pdf
     * @param $elements
     */
    public function __construct($pdf, $elements)
    {
        $this->pdf = $pdf;
        $this->elements = $elements;
    }

    public function position($element)
    {
        if ($element != '') {
            $x = $element['reportElement']['@attributes']['x'];
            $y = $element['reportElement']['@attributes']['y'];
            $this->pdf->SetXY($x, $y);
        }
    }

    private function HexToRGB($hex)
    {

        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        echo "$hex -> $r $g $b";
    }

    private function bold()
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

    private function text($element)
    {
        if (isset($element['textElement'])){

            if (isset($element['textElement']['font']['@attributes']['fontName'])){
                $this->font = $element['textElement']['font']['@attributes']['fontName'];
            }


        }
        $text = $element['text'];
        $width = $element['reportElement']['@attributes']['width'];
        $height = $element['reportElement']['@attributes']['height'];

        $this->pdf->SetFont($this->font, $this->bold(), 10);
        $this->pdf->Cell($width, $height, $text);
    }

    public function run()
    {
        foreach ($this->elements as $element) {
            $this->position($element);
            $this->text($element);
        }
        //die();
    }
}