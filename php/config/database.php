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

    public function getProjects() {
        $stmt = $this->conn->prepare("SELECT * FROM projects");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return null;
        }
    }

    public function getProjectByID($id) {
        $stmt = $this->conn->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function authenticate($input_username, $input_password) {
        $stmt = $this->conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $input_username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return password_verify($input_password, $row['password']);
        } else {
            return false;
        }
    }

    public function removeProject($id) {
        $stmt = $this->conn->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function addProject($name, $description, $project_url, $image_url) {
        $stmt = $this->conn->prepare("INSERT INTO projects (name, description, project_url, image_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $description, $project_url, $image_url);
        return $stmt->execute();
    }

    public function addMessage($name, $email, $message) {
        $stmt = $this->conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        return $stmt->execute();
    }

    public function getMessages() {
        $stmt = $this->conn->prepare("SELECT * FROM messages");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return null;
        }
    }

    public function removeMessage($id) {
        $stmt = $this->conn->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

?>