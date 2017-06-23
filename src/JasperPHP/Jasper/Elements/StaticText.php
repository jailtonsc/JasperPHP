<?php

namespace JasperPHP\Jasper\Elements;

use JasperPHP\Jasper\Elements\Contracts\ElementInterface;
use JasperPHP\PDF;

/**
 * Class StaticText
 * @package JasperPHP\Jasper\Elements
 */
class StaticText extends TextAbstract implements ElementInterface
{
    /**
     * StaticText constructor.
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
     * @param $element
     */
    protected function text($element)
    {
        $width = 0;
        $height = 0;
        $text = '';

        if (isset($element['text'])){
            $text = $element['text'];
        }

        if (isset($element['reportElement'])){
            $width = $element['reportElement']['@attributes']['width'];
            $height = $element['reportElement']['@attributes']['height'];
        }

        $this->textColor($element);
        $this->pdf->SetFont($this->font($element), $this->bold($element), $this->size($element));
        $this->pdf->Cell(
            $width,
            $height,
            utf8_decode($text),
            $this->border($element),
            0,
            $this->align($element),
            $this->backgroundColor($element)
        );
    }

    /**
     * execute code
     */
    public function run()
    {
        foreach ($this->elements as $element) {
            if (is_array($element)){
                $this->position($element);
                $this->text($element);
            } else {
                $this->position($this->elements);
                $this->text($this->elements);
                break;
            }
        }
    }
}