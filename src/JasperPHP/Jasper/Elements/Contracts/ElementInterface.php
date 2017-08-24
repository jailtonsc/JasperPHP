<?php

namespace JasperPHP\Jasper\Elements\Contracts;

use JasperPHP\PDF;

/**
 * Interface ElementInterface
 * @package JasperPHP\Jasper\Elements\Contracts
 */
interface ElementInterface
{
    /**
     * ElementInterface constructor.
     * @param PDF $pdf
     * @param $elements
     */
    public function __construct(PDF $pdf, $elements);

    /**
     * @return mixed
     */
    public function run();
}