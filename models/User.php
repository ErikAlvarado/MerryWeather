<?php
class User {
    private $connection;
    private $table_name = "users";

    public $id;
    public $name;
    public $email;
    public $passwordHash;
    public $idRole;
    public $idGender;

    public function __construct($DataBase)
    {
        $this->connection = $DataBase;
    }
    public function emailExists()
    {
        $query = "SELECT 1 FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        return $stmt->fetch() !== false;
    }
    public function create()
    {
        $this->email = strtolower(trim($this->email));
        if ($this->emailExists()) {
            return false;
        }
        $query = "INSERT INTO " . $this->table_name . " 
                  (name, email, passwordHash, idRole, idGender) 
                  VALUES (:name, :email, :passwordHash, :idRole, :idGender)";
        $stmt = $this->connection->prepare($query);
        $hashedPassword = password_hash($this->passwordHash, PASSWORD_BCRYPT);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":passwordHash", $hashedPassword);
        $stmt->bindParam(":idRole", $this->idRole);
        $stmt->bindParam(":idGender", $this->idGender);
        return $stmt->execute();
    }
}
?>