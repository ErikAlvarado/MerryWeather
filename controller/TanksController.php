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

    public function listUserTanks($idUser){
        $stmt = $this->tankModel->getTanksByUser($idUser);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTank($idUser) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_tank'])) {
        $data = [
            'description' => $_POST['description'],
            'capacity' => $_POST['capacity'],
            'location' => $_POST['location'],
            'installation_date' => $_POST['installation_date'],
            'idUser' => $idUser
        ];
        if ($this->tankModel->create($data)) {
            header("Location: dashboard.php");
        }
    }
}
}
?>
