<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;

    private $conn;

    public function __construct() {
        $this->host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];
    }

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }

    public function close() {
        $this->conn->close();
    }

    public function getUrl($id) {
        $stmt = $this->conn->prepare("SELECT target FROM url_shortener WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['target'];
        } else {
            return null;
        }
    }

    public function shortenUrl($url) {
        $unique_id = uniqid();
        $stmt = $this->conn->prepare("INSERT INTO url_shortener (id, target) VALUES (?, ?)");
        $stmt->bind_param("ss", $unique_id, $url);
        if($stmt->execute() === TRUE) {
            return $unique_id;
        } else {
            return null;
        }
    }
}

?>