<?php

namespace JasperPHP\Jasper\Variables;

use JasperPHP\Exception\JasperPHPException;
use JasperPHP\Jasper\Variables\Contracts\VariablesInterface;
use JasperPHP\PDF;

class Variable implements VariablesInterface
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
        die(print_r($this->pdf->variables));
        /*
        if (!isset($this->pdf->variables[$this->variable])){
            throw new JasperPHPException("'" . $this->variable . "' variable was not reported on JasperPHP.");
        }
        return $this->pdf->variables[$this->variable];*/
    }
}