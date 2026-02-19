<?php
require_once "../config/Database.php";
require_once "../models/Tanks.php";

class TanksController {

    private $db;
    private $tankModel;

    public function __construct(){
        $database = new Database();
        $this->db = $database->getConnection();
        $this->tankModel = new Tanks($this->db);
    }

    public function listUserTanks($userId){
        $stmt = $this->tankModel->getTanksByUser($userId);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
