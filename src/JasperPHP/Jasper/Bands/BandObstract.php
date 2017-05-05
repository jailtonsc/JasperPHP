<?php

namespace JasperPHP\Jasper\Bands;

use JasperPHP\Factory\ElementFactory;
use JasperPHP\Jasper\Element;
use JasperPHP\PDF;

/**
 * Class BandObstract
 * @package JasperPHP\Jasper\Bands
 */
abstract class BandObstract
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
        $this->reportHeightBand();
    }

    /**
     * Report height band
     */
    protected function reportHeightBand()
    {
        $this->pdf->heightBandPrevious = $this->band['band']['@attributes']['height'];
    }

    /**
     * execute method element
     */
    abstract public function run();

}