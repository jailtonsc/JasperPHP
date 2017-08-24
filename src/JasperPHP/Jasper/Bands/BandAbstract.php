<?php

namespace JasperPHP\Jasper\Bands;

use JasperPHP\Jasper\Element;
use JasperPHP\PDF;

/**
 * Class BandObstract
 * @package JasperPHP\Jasper\Bands
 */
abstract class BandAbstract
{
    /**
     * @var PDF $pdf
     */
    protected $pdf;

    /**
     * @var
     */
    protected $band;

    /**
     * execute element
     */
    protected function runElement()
    {
        $element = new Element($this->pdf, $this->band);
        $element->run();
    }

    /**
     * Adjusts the position of element
     */
    protected function adjustPosition()
    {
        $page = $this->pdf->PageNo();

        //Sum with the size of the title band
        if ($page == 1 && isset($this->pdf->title['band']['@attributes']['height'])){
            $this->pdf->position += ($this->pdf->heightBandPrevious + $this->pdf->title['band']['@attributes']['height']);
        } else {
            $this->pdf->position += ($this->pdf->heightBandPrevious + $this->pdf->pageHeader['band']['@attributes']['height']);
        }

    }

    /**
     * Report height band
     */
    protected function reportHeightBand()
    {
        $this->pdf->heightBandPrevious = $this->band['band']['@attributes']['height'];
    }

    /**
     * Informs the name of the band for any calculations
     *
     * @param $nameBand
     */
    protected function setNameBand($nameBand)
    {
        $this->pdf->nameBand = $nameBand;
    }

    /**
     * execute method element
     */
    abstract public function run();

}