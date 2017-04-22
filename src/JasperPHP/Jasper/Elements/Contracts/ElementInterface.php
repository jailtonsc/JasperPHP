<?php

namespace JasperPHP\Jasper\Elements\Contracts;

/**
 * Interface ElementInterface
 * @package JasperPHP\Jasper\Elements\Contracts
 */
interface ElementInterface
{
    public function position($element);

    /**
     * @return mixed
     */
    public function run();
}