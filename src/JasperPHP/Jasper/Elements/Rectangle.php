<?php
/**
 * Created by PhpStorm.
 * User: Joanilson Assis
 * Date: 22/05/2017
 * Time: 23:38
 */

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

    public function __construct(PDF $pdf, $elements)
    {
        $this->pdf = $pdf;
        $this->elements = $elements;
        $this->config = $this->pdf->config();
    }

    public function position($element)
    {
        if (isset($element['reportElement'])) {
            $x = ($this->pdf->marginLeft + $element['reportElement']['@attributes']['x']);
            $y = ($this->pdf->position + $element['reportElement']['@attributes']['y']);
            $this->pdf->SetXY($x, $y);
        }
    }

    private function border($element)
    {
        if (isset($element['graphicElement']['pen']['@attributes']['lineWidth'])){
            /*$rgb = Color::HexToRGB($element['graphicElement']['pen']['@attributes']['lineColor']);

            $this->pdf->SetDrawColor($rgb[0], $rgb[1], $rgb[2]);*/
            $this->pdf->SetLineWidth($element['graphicElement']['pen']['@attributes']['lineWidth']);
            return 'D';
        }
        return 'F';
    }

    /**
     * @param $element
     */
    private function rec($element)
    {
        $width = 0;
        $height = 0;

        if (isset($element['reportElement'])){

            $width = $element['reportElement']['@attributes']['width'];
            $height = $element['reportElement']['@attributes']['height'];
        }


        //$this->pdf->Rect($element['reportElement']['@attributes']['x'], $element['reportElement']['@attributes']['y'], $width, $height, $this->border($element));
       // echo "<script>alert(". $element['reportElement']['@attributes']['x'].")</script>";
        $this->pdf->Rect($this->pdf->marginLeft + $element['reportElement']['@attributes']['x'], $this->pdf->position + $element['reportElement']['@attributes']['y'], 100, 23, $this->border($element));
    }

    /**
     * @return mixed
     */
    public function run()
    {
        foreach ($this->elements as $element) {
            if (is_array($element)) {
                $this->position($element);
                $this->rec($element);
            } else {
                $this->position($this->elements);
                $this->rec($this->elements);
                break;
            }
        }
    }
}