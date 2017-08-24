<?php

namespace JasperPHP\Jasper\Elements;

use JasperPHP\Jasper\Elements\Contracts\ElementInterface;
use JasperPHP\PDF;
use JasperPHP\Utils\Color;

/**
 * Class Line
 * @package JasperPHP\Jasper\Elements
 */
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
     * @var
     */
    private $reportElement;

    /**
     * @var
     */
    private $graphicElement;

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
     */
    private function colorLine()
    {
        if (isset($this->reportElement['@attributes']['forecolor'])) {
            $rgb = Color::HexToRGB($this->reportElement['@attributes']['forecolor']);
            $this->pdf->SetDrawColor($rgb[0], $rgb[1], $rgb[2]);
        } else {
            $this->pdf->SetDrawColor(0, 0, 0);
        }
    }

    /**
     * Adjust the border color
     *
     */
    private function lineBorder()
    {
        if (isset($this->graphicElement['pen'])) {
            $this->pdf->SetLineWidth($this->graphicElement['pen']['@attributes']['lineWidth']);
        } else {
            $this->pdf->SetLineWidth(1);
        }
    }

    /**
     * create line
     */
    private function line()
    {
        $width = $this->reportElement['@attributes']['width'];
        $x = $this->reportElement['@attributes']['x'];
        $y = $this->reportElement['@attributes']['y'];

        $this->colorLine();
        $this->lineBorder();

        $this->pdf->Line(
            ($this->pdf->marginLeft + $x) + $width,
            ($this->pdf->position + $y),
            ($this->pdf->marginLeft + $x),
            ($this->pdf->position + $y)
        );
    }

    /**
     * execute code
     */
    public function run()
    {
        foreach ($this->elements as $element) {
            if (isset($element['reportElement'])) {
                $this->reportElement = $element['reportElement'];
                $this->graphicElement = $element['graphicElement'];
            } else if (isset($element['@attributes'])) {
                $this->reportElement['@attributes'] = $element['@attributes'];
            } else if (isset($element['pen'])) {
                $this->graphicElement['pen'] = $element['pen'];
            }

            $this->line();
        }
    }
}