<?php

namespace JasperPHP\Jasper;

use JasperPHP\Factory\BandFactory;
use JasperPHP\PDF;

/**
 * Class Band
 * @package JasperPHP\Jasper
 */
class Band
{
    /**
     * @var PDF
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
    public function __construct(PDF $pdf, $jasper)
    {
        $this->pdf = $pdf;
        $this->jasper = $jasper;
    }

    /**
     * execute method band
     */
    public function run()
    {
        $band = new BandFactory();
        foreach ($this->jasper as $bandName => $bandObject) {
            $object = $band->makeBand($this->pdf, $bandName, $bandObject);

            if (!empty($object)){
                $object->run();
            }
        }
    }
}