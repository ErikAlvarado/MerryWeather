<?php
class Database {
    private $host = "localhost"; 
    private $db_name = "merryweather";
    private $username = "root";
    private $password = "";
    public $connection;

    public function getConnection() {
        $this->connection = null;

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $exception) {
            die("Error de conexión MySQL: " . $exception->getMessage());
        }

        return $this->connection;
    }
}
?>