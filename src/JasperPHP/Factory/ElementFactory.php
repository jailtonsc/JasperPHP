<?php

namespace JasperPHP\Factory;

use JasperPHP\Jasper\Elements\Image;
use JasperPHP\Jasper\Elements\Line;
use JasperPHP\Jasper\Elements\StaticText;
use JasperPHP\Jasper\Elements\Rectangle;
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
            case 'rectangle':
                $element =  new Rectangle($pdf, $elementObject);
                break;
            case 'line':
                $element =  new Line($pdf, $elementObject);
                break;
            case 'image':
                $element =  new Image($pdf, $elementObject);
                break;
        }
        return $element;
    }
}