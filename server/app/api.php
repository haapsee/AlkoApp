<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

class Api {
    private $conn;
    private $stmt;

    public function __construct() {
        $this->conn = new Mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('DB_NAME'));
        if ($this->conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }

    private function getRows() {
        $from = $_GET['from'];
        $amount = $_GET['amount'];
        $this->stmt = $this->conn->prepare("SELECT * FROM items Limit ? OFFSET ?;");
        $this->stmt->bind_param('ii', $amount, $from);
        $this->stmt->execute();
        $result = $this->stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($data);
    }

    private function addItem($num) {
        $sql = "UPDATE items SET orderamount = ? WHERE number = ?;";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bind_param('ii', $_REQUEST["quantity"], $num);
        $this->stmt->execute();
    }

    private function clearItem($num) {
        $sql = "UPDATE items SET orderamount = 0 WHERE number = ?;";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bind_param('i', $num);
        $this->stmt->execute();
    }

    public function handle() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->getRows();
        } else if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['func'] == "Add") {
            $this->addItem($_REQUEST['number']);
        } else if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['func'] == "Clear") {
            $this->clearItem($_REQUEST['number']);
        }

        $this->stmt->close();
        $this->conn->close();
    }
}

$api = new Api();
$api->handle();

?>