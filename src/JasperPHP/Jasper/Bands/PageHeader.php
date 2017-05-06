<?php

namespace JasperPHP\Jasper\Bands;

use JasperPHP\PDF;

/**
 * Class PageHeader
 * @package JasperPHP\Jasper\Bands
 */
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
    protected function adjustPosition()
    {
        $page = $this->pdf->PageNo();

        if ($page == 1 && isset($this->pdf->title['band']['@attributes']['height'])){
            $this->pdf->position += ($this->pdf->heightBandPrevious  + $this->pdf->title['band']['@attributes']['height']);
        } else {
            $this->pdf->position = $this->pdf->marginTop;
        }
    }

    /**
     * Report height band
     */
    protected function reportHeightBand()
    {
        if (!empty($this->pdf->pageHeader)){
            $this->pdf->heightBandPrevious = $this->pdf->pageHeader['band']['@attributes']['height'];
        } else {
            $this->pdf->heightBandPrevious = null;
        }
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