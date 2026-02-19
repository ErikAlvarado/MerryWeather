<?php
class Database {
    private $host = "YULIANN\SQLEXPRESS";
    private $db_name = "merryweather";
    public $connection;

    public function getConnection() {
        $this->connection = null;

        try {
            $dsn = "sqlsrv:Server={$this->host};Database={$this->db_name};TrustServerCertificate=true";

            $this->connection = new PDO($dsn);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $exception) {
            die("Error de conexión SQL Server: " . $exception->getMessage());
        }

        return $this->connection;
    }
}
?>
