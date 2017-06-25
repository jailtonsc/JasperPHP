<?php
namespace JasperPHP\Factory;

use JasperPHP\Jasper\Variables\Field;
use JasperPHP\Jasper\Variables\Parameter;
use JasperPHP\Jasper\Variables\Variable;
use JasperPHP\PDF;

/**
 * Class VariableFactory
 * @package JasperPHP\Factory
 */
class VariableFactory
{
    /**
     * @param PDF $pdf
     * @param $type
     * @param $variable
     * @return Field|Parameter|Variable|null
     */
    public function makeElement(PDF $pdf, $type, $variable)
    {
        $element = null;
        switch ($type) {
            case '$F':
                $element =  new Field($pdf, $variable);
                break;
            case '$P':
                $element =  new Parameter($pdf, $variable);
                break;
            case '$V':
                $element =  new Variable($pdf, $variable);
                break;
        }
        return $element;
    }
}