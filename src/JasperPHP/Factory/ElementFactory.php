<?php

namespace JasperPHP\Factory;


use JasperPHP\Jasper\Elements\StaticText;
use JasperPHP\PDF;

class ElementFactory
{
    public function makeBand(PDF $pdf, $elementName, $elementObject)
    {
        $element = null;
        switch ($elementName) {
            case 'staticText':
                $element =  new StaticText($pdf, $elementObject);
                break;
        }
        return $element;
    }
}