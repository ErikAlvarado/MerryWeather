<?php
class Tanks {
    private $conn;
    private $tableName = "water_tanks";

    public $idTanks; 
    public $idUser;
    public $description;
    public $capacity;
    public $location;
    public $installation_date;

    public function __construct($db){
    $this->conn = $db;
    }

    public function getTanksByUser($userId){
        $query = "SELECT * FROM " . $this->tableName . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
        return $stmt;
    }
    
}