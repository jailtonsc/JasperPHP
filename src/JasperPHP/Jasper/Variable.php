<?php

namespace JasperPHP\Jasper;

use JasperPHP\Factory\VariableFactory;
use JasperPHP\PDF;

/**
 * Class Variable
 * @package JasperPHP\Jasper
 */
class Variable
{
    /**
     * @param $variable
     * @return bool|string
     */
    private function type($variable)
    {
        return substr($variable, 0, 2);
    }

    /**
     * @param $variable
     * @return bool|string
     */
    private function variable($variable)
    {
        return substr($variable, 3, (strlen($variable) -4));
    }

    /**
     * @param PDF $pdf
     * @param $variable
     * @return null|void
     */
    public function run(PDF $pdf, $variable)
    {
        $element = new VariableFactory();

        $object = $element->makeElement($pdf, $this->type($variable), $this->variable($variable));

        if (!empty($object)){
            return $object->text();
        }
        return $variable;
    }
}