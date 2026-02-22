<?php
class Login {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function authenticate($email, $password) {
        $sql = "SELECT TOP 1 idUser, email, passwordHash FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['passwordHash'])) {
            return $user;
        }

        return false;
    }
}