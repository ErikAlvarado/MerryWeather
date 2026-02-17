<?php
class Database {
    private $host = "localhost\SQLEXPRESS"; 
    private $db_name = "merryweather";
    private $username = "DESKTOP-SJ8F4J0\SQLEXPRESS";
    private $password = "";
    public $connection;

    public function getConnection() {
        $this->connection = null;
        try {
            // Sintaxis para SQL Server: "sqlsrv:Server=...;Database=..."
            $this->connection = new PDO("sqlsrv:Server=" . $this->host . ";Database=" . $this->db_name, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión SQL Server: " . $exception->getMessage();
        }
        return $this->connection;
    }
}
?>