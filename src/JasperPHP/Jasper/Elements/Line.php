<?php

namespace JasperPHP\Jasper\Elements;

use JasperPHP\Jasper\Elements\Contracts\ElementInterface;
use JasperPHP\PDF;

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

    public function run()
    {
        $this->pdf->SetLineWidth(0.8);
        $this->pdf->SetDrawColor(10,10,10);

        //x="164" y="89" width="100" height="1"
        $this->pdf->Line(164+100, 89, 164, 89);
    }
}