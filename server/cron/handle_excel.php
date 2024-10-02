<?php

require 'reader_filter.php';


class ExcelHandler {
    private $reader;
    private $filter;
    private $inputFile;
    private $chunkSize;
    private $startRow;
    private $currencyMultiplier;

    public function __construct($inputFile, $chunkSize, $startRow, $currencyMultiplier) {
        $this->inputFile = $inputFile;
        $this->chunkSize = $chunkSize;
        $this->startRow = $startRow;
        $this->currencyMultiplier = $currencyMultiplier;
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFile);
        $this->reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $this->filter = new ReaderFilter();
        $this->reader->setReadFilter($this->filter);
    }

    public function handleExcel() {
        $excelMaxRows = pow(2, 20);

        for ($i = 0; $i < $excelMaxRows; $i+=$this->chunkSize) {
            echo $i . "\n";
            $startIndex = $i;
            $endIndex = $i + $this->chunkSize;
            if ($i < $this->startRow) {
                $startIndex = $this->startRow;
            }
            $this->filter->setRows($startIndex, $endIndex);
            if ($this->handleExcelRows($startIndex, $endIndex)) {
                break;
            }
        }

    }

    private function handleExcelRows($start, $end) {
        $spreadsheet = $this->reader->load($this->inputFile);
        $sheet = $spreadsheet->getActiveSheet();

        for ($row = $start; $row < $end; $row++) {

            if ($sheet->getCell('A' . $row)->getValue()=='') {
                return true;
            }

            echo $sheet->getCell('A' . $row)->getValue() . ", " .
                $sheet->getCell('B' . $row)->getValue() . ", " .
                $sheet->getCell('D' . $row)->getValue() . ", " .
                $sheet->getCell('E' . $row)->getValue() . ", " .
                $sheet->getCell('E' . $row)->getValue() * $this->currencyMultiplier . "\n";
        }
        return false;
    }
}

?>