<?php
class Tanks {
    private $conn;
    private $tableName = "water_tank";

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
        $query = "SELECT * FROM " . $this->tableName . " WHERE idUser = :idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":idUser", $userId);
        $stmt->execute();
        return $stmt;
    }

    public function create($data){
        $query = "INSERT INTO " . $this->tableName . " (description, capcity, location, installation_date, idUser) 
                  VALUES (:description, :capacity, :location, :installation_date, :idUser)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ":description" => $data['description'],
            ":capacity"  => $data['capacity'],
            ":location"  => $data['location'],
            ":installation_date" => $data['installation_date'],
            ":idUser" => $data['idUser']
        ]);
    }
    
}
?>
