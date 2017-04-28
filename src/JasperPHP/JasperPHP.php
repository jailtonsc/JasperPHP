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
     * @var \FPDF
     */
    private $pdf;
    /**
     * @var
     */
    private $jasper;
    /**
     * @var
     */
    public $jasperPath;

    /**
     * JasperPHP constructor.
     */
    public function __construct()
    {
        $this->pdf = new JFPDF('P', 'pt');
    }

    /**
     * method
     */
    private function margin()
    {
        $left = $this->jasper['@attributes']['leftMargin'];
        $top = $this->jasper['@attributes']['topMargin'];
        $this->pdf->SetMargins($left, $top);
    }

    /**
     * method
     */
    private function page(){
        $pageWidth = $this->jasper['@attributes']['pageWidth'];
        $pageHeight = $this->jasper['@attributes']['pageHeight'];

        $size = [$pageHeight, $pageWidth];

        if (isset($this->jasper['@attributes']['orientation']) && $this->jasper['@attributes']['orientation'] == 'Landscape'){
            $this->pdf->addPage('L', $size);
        } else {
            $this->pdf->addPage('P', $size);
        }

    }

    /**
     * method
     */
    public function generatePdf()
    {
        $this->jasper = XmlToArray::xmlToArray($this->jasperPath);

        $this->page();
        $this->margin();

        $band = new Band($this->pdf, $this->jasper);
        $band->run();

        $this->pdf->Output();
    }
}