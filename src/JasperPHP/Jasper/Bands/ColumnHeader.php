<?php

namespace JasperPHP\Jasper\Bands;

use JasperPHP\PDF;

/**
 * Class ColumnHeader
 * @package JasperPHP\Jasper\Bands
 */
class ColumnHeader extends BandAbstract
{
    /**
     * Name Band
     */
    const NAME_BAND = 'ColumnHeader';

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