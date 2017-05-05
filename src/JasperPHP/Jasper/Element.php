<?php

namespace JasperPHP\Jasper;


use JasperPHP\Factory\ElementFactory;
use JasperPHP\PDF;

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
     * Band constructor.
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
        foreach ($this->band['band'] as $elementName => $elementObject) {
            $element = new ElementFactory();
            $object = $element->makeBand($this->pdf, $elementName, $elementObject);

            if (!empty($object)){
                $object->run();
            }
        }
    }
}