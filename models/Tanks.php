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

    public function saveLog($idTank, $level) {
    $query = "INSERT INTO water_level_log (current_level, water_quality_score, idTank) 
              VALUES (:level, :quality, :idTank)";
    $stmt = $this->conn->prepare($query);
    
    return $stmt->execute([
        ":level"   => $level,
        ":quality" => 100,
        ":idTank"  => $idTank
    ]);
}


public function getLevelHistory($idUser, $limit = 20) {
    // Unimos (JOIN) la tabla de logs con la de tanques para filtrar por el dueño (idUser)
    $query = "SELECT l.current_level, l.reading_date, t.description 
              FROM water_level_log l
              INNER JOIN water_tank t ON l.idTank = t.idTank
              WHERE t.idUser = :idUser 
              ORDER BY l.reading_date DESC 
              LIMIT :limit";

    $stmt = $this->conn->prepare($query);
    
    $stmt->bindValue(":idUser", $idUser, PDO::PARAM_INT);
    $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
    
    $stmt->execute();
    return $stmt;
}

public function getLevelHistorySeparated($idUser, $limit = 30) {
    // Traemos las lecturas incluyendo el ID del tanque para poder agruparlas en el controlador o vista
    $query = "SELECT l.current_level, l.reading_date, t.idTank, t.description 
              FROM water_level_log l
              INNER JOIN water_tank t ON l.idTank = t.idTank
              WHERE t.idUser = :idUser 
              ORDER BY l.reading_date DESC 
              LIMIT :limit";

    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(":idUser", $idUser, PDO::PARAM_INT);
    $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
?>