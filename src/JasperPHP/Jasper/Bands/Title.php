<?php

namespace JasperPHP\Jasper\Bands;

use JasperPHP\PDF;

/**
 * Class Title
 * @package JasperPHP\Jasper\Bands
 */
class Title extends BandObstract
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
    protected function adjustPosition()
    {
        $this->pdf->position = $this->pdf->marginTop;
    }

    /**
     * execute method element
     */
    public function run()
    {
        $this->adjustPosition();
        $this->runElement();
        $this->reportHeightBand();
    }
}