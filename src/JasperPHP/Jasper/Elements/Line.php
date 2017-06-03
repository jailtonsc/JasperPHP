<?php

namespace JasperPHP\Jasper\Elements;

use JasperPHP\Jasper\Elements\Contracts\ElementInterface;
use JasperPHP\PDF;
use JasperPHP\Utils\Color;

class Line implements ElementInterface
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
     * Rectangle constructor.
     * @param PDF $pdf
     * @param $elements
     */
    public function __construct(PDF $pdf, $elements)
    {
        $this->pdf = $pdf;
        $this->elements = $elements;
    }

    /**
     * Informs the line color
     *
     * @param $element
     */
    private function colorLine($element)
    {
        if (isset($element['reportElement']['@attributes']['forecolor'])) {
            $rgb = Color::HexToRGB($element['reportElement']['@attributes']['forecolor']);
            $this->pdf->SetDrawColor($rgb[0], $rgb[1], $rgb[2]);
        } else if (isset($element['@attributes']['forecolor'])) {
            $rgb = Color::HexToRGB($element['@attributes']['forecolor']);
            $this->pdf->SetDrawColor($rgb[0], $rgb[1], $rgb[2]);
        } else {
            $this->pdf->SetDrawColor(0, 0, 0);
        }
    }

    /**
     * Adjust the border color
     *
     * @param $element
     */
    private function lineBorder($element)
    {
        if (isset($element['graphicElement'])){
            $this->pdf->SetLineWidth($element['graphicElement']['pen']['@attributes']['lineWidth']);
        } else if (isset($element['pen'])){
            $this->pdf->SetLineWidth($element['pen']['@attributes']['lineWidth']);
        } else {
            $this->pdf->SetLineWidth(1);
        }
    }

    private function line($element)
    {
        $width = 0;
        $x = 0;
        $y = 0;

        if (isset($element['reportElement'])) {
            $width = $element['reportElement']['@attributes']['width'];
            $x = $element['reportElement']['@attributes']['x'];
            $y = $element['reportElement']['@attributes']['y'];
        } else if (isset($element['@attributes'])) {
            $width = $element['@attributes']['width'];
            $x = $element['@attributes']['x'];
            $y = $element['@attributes']['y'];
        }

        $this->lineBorder($element);
        $this->colorLine($element);

        $this->pdf->Line(
            ($this->pdf->marginLeft + $x) + $width,
            ($this->pdf->position + $y),
            ($this->pdf->marginLeft + $x),
            ($this->pdf->position + $y)
        );
    }

    public function run()
    {
        foreach ($this->elements as $element) {
            if (is_array($element)){
                $this->line($element);
            } else {
                $this->line($this->elements);
                break;
            }
        }
    }
}