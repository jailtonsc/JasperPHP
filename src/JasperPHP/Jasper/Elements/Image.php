<?php

namespace JasperPHP\Jasper\Elements;

use JasperPHP\Jasper\Elements\Contracts\ElementInterface;
use JasperPHP\PDF;
use JasperPHP\Utils\Image as ImageUtil;

/**
 * Class Image
 * @package JasperPHP\Jasper\Elements
 */
class Image implements ElementInterface
{
    /**
     * @var PDF
     */
    private $pdf;

    /**
     * @var
     */
    private $elements;

    /**
     * @var mixed
     */
    private $config;

    /**
     * @var
     */
    private $reportElement;

    /**
     * @var
     */
    private $graphicElement;

    /**
     * @var
     */
    private $imageExpression;

    /**
     * Rectangle constructor.
     * @param PDF $pdf
     * @param $elements
     */
    public function __construct(PDF $pdf, $elements)
    {
        $this->pdf = $pdf;
        $this->elements = $elements;
        $this->config = $this->pdf->config();
    }

    /**
     * create image
     */
    private function image()
    {
        $file = str_replace("\"", "", $this->imageExpression);

        $width = $this->reportElement['@attributes']['width'];
        $height = $this->reportElement['@attributes']['height'];
        $x = $this->reportElement['@attributes']['x'];
        $y = $this->reportElement['@attributes']['y'];

       // die($this->config['font'].'dd');
       // die(print_r(ImageUtil::addBorder($file, $this->config['dirTmpImage'])));


        $this->pdf->Image($file, ($this->pdf->marginLeft + $x), ($this->pdf->position + $y), $width, $height);
    }

    /**
     * execute code
     */
    public function run()
    {
        foreach ($this->elements as $element) {
            if (isset($element['reportElement'])) {
                $this->reportElement = $element['reportElement'];
                $this->imageExpression = $element['imageExpression'];
            } else {
                $this->reportElement['@attributes'] = $this->elements['reportElement']['@attributes'];
                $this->imageExpression = $this->elements['imageExpression'];
            }

            $this->image();
        }
    }
}