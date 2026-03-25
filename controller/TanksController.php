<?php
require_once __DIR__ . "/../config/DataBase.php";
require_once __DIR__ . "/../models/Tanks.php";

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
                'description'       => $_POST['description'],
                'capacity'          => $_POST['capacity'],
                'location'          => $_POST['location'],
                'idUser'            => $idUser
            ];
            
            if ($this->tankModel->create($data)) {
                header("Location: tanks.php");
                exit();
            }
        }
    }
    public function deleteTank($idUser){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])){
            $idTank = $_POST['idTank'];

            if ($this->tankModel->delete($idTank, $idUser)) {
                header("Location: tanks.php?msg=deleted");
                exit();
            } else {
                echo "Error al intentar eliminar el tinaco.";
            }
        }
    }

    public function updateTank($idUser){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_tank'])){
            $idTank = $_POST['idTank'];
            $description = $_POST['description'];
            $capacity = $_POST['capacity'];
            $lotacion = $_POST['location'];

            if ($this->tankModel->update($idTank, $idUser, $description, $capacity, $lotacion)) {
                header("Location: tanks.php?msg=Actualizado");
                exit();
            } else {
                header("Location: update_tank.php?msg=Algo fallo, vuelve a intentar");
            }
        }
        return false;
    }

    public function registerLevelLog($idTank, $level) {
        if ($idTank && $level !== null) {
            return $this->tankModel->saveLog($idTank, $level);
        }
        return false;
    }
}
?>