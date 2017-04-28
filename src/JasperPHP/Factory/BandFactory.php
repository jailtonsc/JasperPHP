<?php

namespace JasperPHP\Factory;

use JasperPHP\Jasper\Elements\StaticText;
use JasperPHP\JFPDF;


/**
 * Class BandFactoryMethod
 * @package JasperPHP\BandFactory
 */
class BandFactory
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
     * @var array
     */
    private $band = [
        'title'
    ];

    /**
     * BandFactoryMethod constructor.
     * @param JFPDF $pdf
     * @param $jasper
     */
    public function __construct(JFPDF $pdf, $jasper)
    {
        $this->pdf = $pdf;
        $this->jasper = $jasper;
    }

    /**
     * @param $band
     */
    private function generateHeight($band)
    {
        $height = $band['@attributes']['height'];
        $this->pdf->SetX($height);
    }

    /**
     * method
     */
    public function makeBand()
    {
        foreach ($this->jasper as $key => $band) {
            if (in_array($key, $this->band)){
                $b = $band['band'];
                $this->generateHeight($b);
                foreach ($b as $k => $element) {
                    switch ($k) {
                        case 'staticText':
                            //die(print_r($b));
                           (new StaticText($this->pdf, $element))->run();
                            break;
                    }
                }
            }
        }
    }
}