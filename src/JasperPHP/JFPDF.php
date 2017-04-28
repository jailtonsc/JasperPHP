<?php

namespace JasperPHP;

/**
 * Class JFPDF
 * @package JasperPHP
 */
class JFPDF extends \FPDF
{
    /**
     * get config params
     *
     * @return mixed
     */
    public function config()
    {
        return include_once dirname(__FILE__) . '/../config/config.php';
    }
}