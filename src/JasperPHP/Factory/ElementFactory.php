<?php

namespace JasperPHP\Factory;

use JasperPHP\Jasper\Elements\StaticText;
use JasperPHP\PDF;

/**
 * Class ElementFactory
 * @package JasperPHP\Factory
 */
class ElementFactory
{
    /**
     * return class Element
     *
     * @param PDF $pdf
     * @param $elementName
     * @param $elementObject
     * @return StaticText|null
     */
    public function makeElement(PDF $pdf, $elementName, $elementObject)
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