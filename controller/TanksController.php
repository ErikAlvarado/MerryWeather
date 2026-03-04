<?php
// Usamos __DIR__ para asegurar que encuentre los archivos sin importar desde dónde se llame el controlador
require_once __DIR__ . "/../config/DataBase.php";
require_once __DIR__ . "/../models/Tanks.php";

class TanksController {

    private $db;
    private $tankModel;

    public function __construct(){
        $database = new Database();
        $this->db = $database->getConnection();
        // Asegúrate de que el archivo en models se llame "Tanks.php" y la clase "Tanks"
        $this->tankModel = new Tanks($this->db);
    }

    public function listUserTanks($idUser){
        $stmt = $this->tankModel->getTanksByUser($idUser);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTank($idUser) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_tank'])) {
            $data = [
                'description'       => $_POST['description'],
                'capacity'          => $_POST['capacity'],
                'location'          => $_POST['location'],
                'installation_date' => $_POST['installation_date'],
                'idUser'            => $idUser
            ];
            
            if ($this->tankModel->create($data)) {
                header("Location: dashboard.php");
                exit(); // Siempre añade exit() después de un header Location
            }
        }
    }
}
?>