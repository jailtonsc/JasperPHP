<?php

namespace JasperPHP\Jasper\Bands;

use JasperPHP\PDF;

class PageHeader extends BandObstract
{
    /**
     * Title constructor.
     * @param PDF $pdf
     * @param $band
     */
    public function __construct(PDF $pdf, $band)
    {
        $this->pdf = $pdf;
        $this->band = $band;
    }

    /**
     * Adjusts the position of element
     */
    public function adjustPosition()
    {
        $this->pdf->marginTop += $this->pdf->heightBandPrevious;
    }

    /**
     * execute method element
     */
    public function run()
    {
        $this->adjustPosition();
        $this->runElement();
    }
}