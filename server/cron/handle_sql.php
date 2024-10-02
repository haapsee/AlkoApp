<?php

class SQLHandler {
    private $conn;
    private $stmt;

    public function __construct($servername, $username, $password, $database) {
        $sql = <<<EOD
        INSERT INTO items (number, name, bottlesize, price, pricegbp, retrieved, orderamount)
        VALUES (?, ?, ?, ?, ?, NOW(), 0)
        ON DUPLICATE KEY UPDATE
            name = VALUES(name),
            bottlesize = VALUES(bottlesize),
            price = VALUES(price),
            pricegbp = VALUES(pricegbp),
            retrieved = NOW();
        EOD;

        $this->conn = new Mysqli($servername, $username, $password, $database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $this->stmt = $this->conn->prepare($sql);
        if (!$this->stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
    }

    public function addEntry($number, $name, $bottlesize, $price, $pricegbp) {
        $this->stmt->bind_param("issdd", $number, $name, $bottlesize, $price, $pricegbp);
        if (!$this->stmt->execute()) {
            die("Statement failure: " . $this->stmt->error . "\n");
        }
    }

    public function close() {
        $this->stmt->close();
        $this->conn->close();
    }
}