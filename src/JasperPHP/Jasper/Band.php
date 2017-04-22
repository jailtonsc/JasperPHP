<?php

namespace JasperPHP\Jasper;

use JasperPHP\Factory\BandFactory;

/**
 * Class Band
 * @package JasperPHP\Jasper
 */
class Band
{
    /**
     * @var
     */
    private $pdf;
    /**
     * @var
     */
    private $jasper;

    /**
     * Band constructor.
     * @param $pdf
     * @param $jasper
     */
    public function __construct($pdf, $jasper)
    {
        $this->pdf = $pdf;
        $this->jasper = $jasper;
    }

    /**
     * method
     */
    public function run()
    {
        $band = new BandFactory($this->pdf, $this->jasper);
        $band->makeBand();
    }
}