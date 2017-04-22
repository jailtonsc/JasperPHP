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

    private function text($element)
    {
        if (isset($element['textElement'])){
            $this->font = $element['textElement']['font']['@attributes']['fontName'];

            $isBold = $element['textElement']['font']['@attributes']['isBold'];
            if ($isBold){

            }
        }

        $text = $element['text'];
        $width = $element['reportElement']['@attributes']['width'];
        $height = $element['reportElement']['@attributes']['height'];

        $this->pdf->SetFont($this->font, 'B', 10);
        $this->pdf->Cell($width, $height, $text);
    }

    public function run()
    {
        foreach ($this->elements as $element) {
            $this->position($element);
            $this->text($element);
        }
    }
}