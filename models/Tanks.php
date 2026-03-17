<?php
class Tanks {
    private $conn;
    private $tableName = "water_tank";

    public $idTanks; 
    public $idUser;
    public $description;
    public $capacity; // Mantenemos el nombre de la propiedad como capacity para el objeto
    public $location;
    public $installation_date;

    public function __construct($db){
        $this->conn = $db;
    }

    public function getTanksByUser($userId){
        // MySQL usa la misma sintaxis básica, pero agregamos un ORDER BY para mejor visualización
        $query = "SELECT * FROM " . $this->tableName . " WHERE idUser = :idUser ORDER BY idTank DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":idUser", $userId);
        $stmt->execute();
        return $stmt;
    }

    public function create($data){
        $query = "INSERT INTO " . $this->tableName . " (description, capcity, location, idUser) 
                  VALUES (:description, :capacity, :location, :idUser)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            ":description"       => $data['description'],
            ":capacity"          => $data['capacity'],
            ":location"          => $data['location'],
            ":idUser"            => $data['idUser']
        ]);
    }

    public function delete($idTank, $idUser){
        $query = "DELETE FROM ". $this->tableName . " WHERE idTank = :idTank AND idUser = :idUser";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":idTank", $idTank);
        $stmt->bindParam(":idUser", $idUser);

        return $stmt->execute();
    }

    public function update($idTank, $idUser, $description, $capacity, $location){
        $query = "UPDATE " . $this->tableName . " 
                SET description = :description, capcity = :capcity, location = :location
                WHERE idTank = :idTank AND idUser =:idUser";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ":idTank" => $idTank,
            ":idUser" => $idUser,
            ":description" => $description,
            ":capcity" => $capacity,
            ":location" => $location
        ]);
    }
}
?>