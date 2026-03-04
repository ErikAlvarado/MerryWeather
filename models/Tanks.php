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
        // ATENCIÓN: He usado 'capcity' en el nombre del campo SQL para que coincida con tu script de MySQL
        $query = "INSERT INTO " . $this->tableName . " (description, capcity, location, installation_date, idUser) 
                  VALUES (:description, :capacity, :location, :installation_date, :idUser)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            ":description"       => $data['description'],
            ":capacity"          => $data['capacity'],
            ":location"          => $data['location'],
            ":installation_date" => $data['installation_date'],
            ":idUser"            => $data['idUser']
        ]);
    }
}
?>