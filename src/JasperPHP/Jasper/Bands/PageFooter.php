<?php

namespace JasperPHP\Jasper\Bands;

use JasperPHP\PDF;

/**
 * Class PageFooter
 * @package JasperPHP\Jasper\Bands
 */
class PageFooter extends BandAbstract
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
     * execute method element
     */
    public function run()
    {
        $this->adjustPosition();
        $this->runElement();
        $this->reportHeightBand();
    }
}