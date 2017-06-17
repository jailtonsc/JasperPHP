<?php

namespace JasperPHP\Jasper\Elements;

use JasperPHP\Exception\JasperPHPException;
use JasperPHP\Jasper\Elements\Contracts\ElementInterface;
use JasperPHP\PDF;
use JasperPHP\Utils\Color;
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
     * @var
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
     * @var
     */
    private $removeImage;

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
     * add color border
     *
     * @return array
     */
    private function addColorBorder()
    {
        if (isset($this->reportElement['@attributes']['forecolor'])) {
            $rgb = Color::HexToRGB($this->reportElement['@attributes']['forecolor']);
        } else {
            $rgb = $this->config['imageBorderRGB'];
        }
        return $rgb;
    }

    /**
     * add border to image
     *
     * @param $file
     * @return string
     */
    private function addBorder($file)
    {
        if (isset($this->graphicElement['pen'])){
            $this->removeImage = true;
            $imageSizeBorder = $this->graphicElement['pen']['@attributes']['lineWidth'];
            return ImageUtil::addBorder($file, $this->config['dirTmpImage'], $this->addColorBorder(), $imageSizeBorder);
        }
        $this->removeImage = false;
        return $file;
    }

    /**
     * create image
     */
    private function image()
    {
        try {
            $file = str_replace("\"", "", $this->imageExpression);

            $width = $this->reportElement['@attributes']['width'];
            $height = $this->reportElement['@attributes']['height'];
            $x = $this->reportElement['@attributes']['x'];
            $y = $this->reportElement['@attributes']['y'];

            $file = $this->addBorder($file);

            $this->pdf->Image($file, ($this->pdf->marginLeft + $x), ($this->pdf->position + $y), $width, $height);

            if ($this->removeImage){
                unlink($file);
            }
        } catch (\Exception $e) {
            throw new JasperPHPException("Image not found for the specified path.");
        }
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

                if (isset($element['graphicElement'])) {
                    $this->graphicElement = $element['graphicElement'];
                }
            } else {
                $this->reportElement['@attributes'] = $this->elements['reportElement']['@attributes'];
                $this->imageExpression = $this->elements['imageExpression'];

                if (isset($this->elements['graphicElement'])) {
                    $this->graphicElement = $this->elements['graphicElement'];
                }
            }

            $this->image();
        }
    }
}