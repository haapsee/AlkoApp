<?php
class ReaderFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter {
    private $start = 0;
    private $end = 0;

    public function setRows($start, $end) {
        $this->start = $start;
        $this->end = $end;
    }

    public function readCell(string $columnAddress, int $row, string $worksheetName = ''): bool {
        if ($columnAddress > 'E') {
            return false;
        }
        if ($row >= $this->start && $row < $this->end) {
            return true;
        }
        return false;
    }
}
?>