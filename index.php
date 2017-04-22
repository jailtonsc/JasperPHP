<?php
include 'vendor/autoload.php';

$jasper = new \JasperPHP\JasperPHP();

$jasper->jasperPath = 'jasper/teste.jrxml';

$jasper->generatePdf();