<?php
require 'vendor/autoload.php';
require 'handle_excel.php';
require 'query_alko.php';

function main() {
    $inputFile = 'alko.xslx';
    $currencyMultiplier = 0.8;
    getAlkoExcel($inputFile);

    try {
        $chunkSize = pow(2, 10);
        $excelHandler = new ExcelHandler($inputFile, pow(2, 10), 5, $currencyMultiplier);
        $excelHandler->handleExcel();
    } catch (Exception $e) {
        echo 'Error loading file: ', $e->getMessage();
    }
    exec("rm " . $inputFile);
}

main();
?>