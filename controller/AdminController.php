<?php
require_once __DIR__ . "/../config/DataBase.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/Tanks.php";

class AdminController {
    private $db;

    public function __construct(){
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function listAllUsers() {
        $query = "SELECT * FROM users ORDER BY idUser DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE idUser = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    public function listAllTanks() {
        $query = "SELECT t.*, u.name as owner FROM water_tank t 
                  INNER JOIN users u ON t.idUser = u.idUser 
                  ORDER BY t.idTank DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteTankAdmin($id) {
        $query = "DELETE FROM water_tank WHERE idTank = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    public function getTankById($id) {
        $query = "SELECT t.*, u.name as owner FROM water_tank t 
                INNER JOIN users u ON t.idUser = u.idUser 
                WHERE t.idTank = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTankAnyUser($data) {
        $query = "UPDATE water_tank 
                SET description = :desc, capcity = :cap, location = :loc 
                WHERE idTank = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':desc' => $data['description'],
            ':cap'  => $data['capacity'],
            ':loc'  => $data['location'],
            ':id'   => $data['idTank']
        ]);
    }
}