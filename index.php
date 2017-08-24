<?php
include 'vendor/autoload.php';

$jasper = new \JasperPHP\JasperPHP();

$jasper->jasperPath = 'jasper/teste.jrxml';

$jasper->parameters = array(
    'P_TESTE' => 'teste de parâmetro'
);

$jasper->generatePdf();