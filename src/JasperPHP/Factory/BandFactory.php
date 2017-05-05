<?php

namespace JasperPHP\Factory;

use JasperPHP\Jasper\Bands\PageHeader;
use JasperPHP\Jasper\Bands\Title;
use JasperPHP\PDF;


/**
 * Class BandFactoryMethod
 * @package JasperPHP\BandFactory
 */
class BandFactory
{

    /**
     * return class band
     *
     * @param PDF $pdf
     * @param $bandName
     * @param $band
     * @return object
     */
    public function makeBand(PDF $pdf, $bandName, $band)
    {
        $object = null;

        switch ($bandName) {
            case 'title':
                $object = new Title($pdf, $band);
                break;
            case 'pageHeader':
                $object = new PageHeader($pdf, $band);
                break;
        }
        return $object;
    }
}