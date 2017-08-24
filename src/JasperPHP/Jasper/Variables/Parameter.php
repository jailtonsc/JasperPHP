<?php

namespace JasperPHP\Jasper\Variables;

use JasperPHP\Exception\JasperPHPException;
use JasperPHP\Jasper\Variables\Contracts\VariablesInterface;
use JasperPHP\PDF;

/**
 * Class Parameter
 * @package JasperPHP\Jasper\Variables
 */
class Parameter implements VariablesInterface
{
    /**
     * @var PDF
     */
    private $pdf;

    /**
     * @var
     */
    private $variable;

    /**
     * Parameter constructor.
     * @param PDF $pdf
     * @param $variable
     */
    public function __construct(PDF $pdf, $variable)
    {
        $this->pdf = $pdf;
        $this->variable = $variable;
    }

    /**
     * @return mixed
     * @throws JasperPHPException
     */
    public function text()
    {
        if (!isset($this->pdf->parameters[$this->variable])){
            throw new JasperPHPException("'" . $this->variable . "' parameter was not reported on JasperPHP.");
        }
        return $this->pdf->parameters[$this->variable];
    }
}