<?php

namespace JasperPHP\Jasper\Variables\Calculation;

/**
 * Class Calculation
 * @package JasperPHP\Jasper\Variables
 */
class Calculation
{
    /**
     * @var
     */
    private $nameBand;

    /**
     * @var
     */
    private $numberPage;

    /**
     * @var
     */
    private $resetType;

    /**
     * @var
     */
    private $calculation;

    /**
     * @var
     */
    private $initialValue;

    /**
     * Calculation constructor.
     * @param $nameBand
     * @param $numberPage
     * @param $resetType
     * @param $calculation
     * @param $initialValue
     */
    public function __construct($nameBand, $numberPage, $resetType, $calculation, $initialValue = 0)
    {
        $this->nameBand = $nameBand;
        $this->numberPage = $numberPage;
        $this->resetType = $resetType;
        $this->calculation = $calculation;
        $this->initialValue = $initialValue;
    }

    public function calculate()
    {

    }
}