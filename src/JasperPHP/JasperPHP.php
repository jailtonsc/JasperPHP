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

    private function pageHeader()
    {
        if (isset($this->jasper['pageHeader'])){
            $this->pdf->pageHeader = $this->jasper['pageHeader'];
            $this->pdf->title = $this->jasper['title'];
        }
    }

    /**
     * Generate pdf
     */
    public function generatePdf()
    {
        $this->jasper = XmlToArray::xmlToArray($this->jasperPath);

        $this->pageHeader();

        $this->page();
        $this->margin();

        $band = new Band($this->pdf, $this->jasper);
        $band->run();
        $this->pdf->Output();
    }
}