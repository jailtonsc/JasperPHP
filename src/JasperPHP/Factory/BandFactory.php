<?php

namespace JasperPHP\Factory;

use JasperPHP\Jasper\Bands\ColumnFooter;
use JasperPHP\Jasper\Bands\ColumnHeader;
use JasperPHP\Jasper\Bands\Detail;
use JasperPHP\Jasper\Bands\PageFooter;
use JasperPHP\Jasper\Bands\PageHeader;
use JasperPHP\Jasper\Bands\Summary;
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
            case 'columnHeader':
                $object = new ColumnHeader($pdf, $band);
                break;
            case 'detail':
                $object = new Detail($pdf, $band);
                break;
            case 'columnFooter':
                $object = new ColumnFooter($pdf, $band);
                break;
            case 'pageFooter':
                $object = new PageFooter($pdf, $band);
                break;
            case 'summary':
                $object = new Summary($pdf, $band);
                break;
        }
        return $object;
    }
}