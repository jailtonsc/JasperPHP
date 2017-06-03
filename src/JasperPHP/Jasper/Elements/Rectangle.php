<?php

namespace JasperPHP\Jasper\Elements;

use JasperPHP\Jasper\Elements\Contracts\ElementInterface;
use JasperPHP\PDF;
use JasperPHP\Utils\Color;

class Rectangle implements ElementInterface
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

    /**
     * Rectangle constructor.
     * @param PDF $pdf
     * @param $elements
     */
    public function __construct(PDF $pdf, $elements)
    {
        $this->pdf = $pdf;
        $this->elements = $elements;
        $this->config = $this->pdf->config();
    }

    /**
     * Informs the line color
     *
     * @param $element
     */
    private function colorLine($element)
    {
        $this->pdf->SetDrawColor(0, 0, 0);

        if (isset($element['reportElement']['@attributes']['forecolor'])) {
            $rgb = Color::HexToRGB($element['reportElement']['@attributes']['forecolor']);
            $this->pdf->SetDrawColor($rgb[0], $rgb[1], $rgb[2]);
        } else if (isset($element['@attributes']['forecolor'])) {
            $rgb = Color::HexToRGB($element['@attributes']['forecolor']);
            $this->pdf->SetDrawColor($rgb[0], $rgb[1], $rgb[2]);
        }
    }

    /**
     * Adjust the border color
     *
     * @param $element
     */
    private function border($element)
    {
        if (isset($element['graphicElement'])){
            $this->pdf->SetLineWidth($element['graphicElement']['pen']['@attributes']['lineWidth']);
        } else if (isset($element['pen'])){
            $this->pdf->SetLineWidth($element['pen']['@attributes']['lineWidth']);
        }
    }

    /**
     * Generates the rectangle with its respective
     *
     * @param $element
     */
    private function rec($element)
    {
        $width = 0;
        $height = 0;
        $x = 0;
        $y = 0;

        if (isset($element['reportElement'])) {
            $width = $element['reportElement']['@attributes']['width'];
            $height = $element['reportElement']['@attributes']['height'];
            $x = $element['reportElement']['@attributes']['x'];
            $y = $element['reportElement']['@attributes']['y'];
        } else if (isset($element['@attributes'])) {
            $width = $element['@attributes']['width'];
            $height = $element['@attributes']['height'];
            $x = $element['@attributes']['x'];
            $y = $element['@attributes']['y'];
        }

        $this->border($element);
        $this->colorLine($element);
        $this->pdf->Rect(($this->pdf->marginLeft + $x), ($this->pdf->position + $y), $width, $height);
    }

    /**
     * @return mixed
     */
    public function run()
    {
        foreach ($this->elements as $element) {
            if (is_array($element)) {
                $this->rec($element);
            } else {
                $this->rec($this->elements);
                break;
            }
            $this->rec($element);
        }
    }
}