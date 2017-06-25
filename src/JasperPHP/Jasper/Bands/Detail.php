<?php

namespace JasperPHP\Jasper\Bands;

use JasperPHP\PDF;

/**
 * Class Detail
 * @package JasperPHP\Jasper\Bands
 */
class Detail extends BandAbstract
{
    /**
     * Name Band
     */
    const NAME_BAND = 'Detail';

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
        $this->setNameBand(self::NAME_BAND);
        $this->adjustPosition();
        $this->runElement();
        $this->reportHeightBand();
    }
}