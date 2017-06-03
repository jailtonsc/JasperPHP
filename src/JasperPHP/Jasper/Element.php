<?php

namespace JasperPHP\Jasper;

use JasperPHP\Factory\ElementFactory;
use JasperPHP\PDF;

/**
 * Class Element
 * @package JasperPHP\Jasper
 */
class Element
{
    /**
     * @var PDF
     */
    private $pdf;
    /**
     * @var
     */
    private $band;

    /**
     * Element constructor.
     * @param $pdf
     * @param $band
     */
    public function __construct(PDF $pdf, $band)
    {
        $this->pdf = $pdf;
        $this->band = $band;
    }

    /**
     * execute method band
     */
    public function run()
    {
        $element = new ElementFactory();
        foreach ($this->band['band'] as $elementName => $elementObject) {
            $object = $element->makeElement($this->pdf, $elementName, $elementObject);

            if (!empty($object)){
                $object->run();
            }
        }
    }
}