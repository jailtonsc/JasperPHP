<?php

namespace JasperPHP;

use JasperPHP\Jasper\Band;
use JasperPHP\Utils\XmlToArray;

/**
 * Class JasperPHP
 * @package JasperPHP
 */
class JasperPHP
{
    /**
     * Fpdf instance
     *
     * @var \FPDF
     */
    private $pdf;

    /**
     * array jasper
     * @var
     */
    private $jasper;

    /**
     * Path of the jasper
     *
     * @var
     */
    public $jasperPath;

    /**
     * Collection of data that will be displayed in the pdf
     *
     * @var array
     */
    public $data = array();

    /**
     * Collection of parameters that will be displayed in the pdf
     *
     * @var array
     */
    public $parameters = array();

    /**
     * JasperPHP constructor.
     */
    public function __construct()
    {
        $this->pdf = new PDF('P', 'pt');
    }

    /**
     * config the margin
     */
    private function margin()
    {
        $left = $this->jasper['@attributes']['leftMargin'];
        $top = $this->jasper['@attributes']['topMargin'];
        $this->pdf->SetMargins($left, $top, $top);

        $this->pdf->marginLeft = $left;
        $this->pdf->marginTop = $top;
    }

    /**
     * Config the margin
     */
    private function page(){
        $pageWidth = $this->jasper['@attributes']['pageWidth'];
        $pageHeight = $this->jasper['@attributes']['pageHeight'];

        $size = array($pageHeight, $pageWidth);

        if (isset($this->jasper['@attributes']['orientation']) && $this->jasper['@attributes']['orientation'] == 'Landscape'){
            $this->pdf->addPage('L', $size);
        } else {
            $this->pdf->addPage('P', $size);
        }

    }

    /**
     * Mounts the page header
     */
    private function pageHeader()
    {
        if (isset($this->jasper['pageHeader'])){
            $this->pdf->heightBandPrevious += $this->jasper['title']['band']['@attributes']['height'];
            $this->pdf->pageHeader = $this->jasper['pageHeader'];
        }
    }

    /**
     * Adds all types of variables
     */
    private function addVariables()
    {
        $this->pdf->data = $this->data;
        $this->pdf->parameters = $this->parameters;
        $this->variable();
    }

    /**
     * Informs all variables
     */
    private function variable()
    {
        if (isset($this->jasper['variable'])){
            $this->pdf->variables = $this->jasper['variable'];
        }
    }

    /**
     * Generate pdf
     */
    public function generatePdf()
    {
        $this->jasper = XmlToArray::xmlToArray($this->jasperPath);
        $this->addVariables();

        $this->pageHeader();

        $this->page();
        $this->margin();

        $band = new Band($this->pdf, $this->jasper);
        $band->run();
        $this->pdf->Output();
    }
}