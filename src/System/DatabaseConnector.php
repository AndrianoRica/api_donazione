<?php
class DatabaseConnector {
    private $host = "";
    private $username = "";
    private $password = "";
    private $dbname = "";

    public function getConnection() {
        try {
            $conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }
}

?>