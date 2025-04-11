<?php

require_once __DIR__ . '/../../config/db.php';

class AdminModel {

    public function getAdminInfo($userId){
        global $pdo;

        $query = "SELECT id_admin, usuario, password, email_admin
                  FROM transfer_admin
                  WHERE id_admin = :userId";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId);

        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function requestLogIn($email, $password){
        global $pdo;

        $query = "SELECT * FROM transfer_admin WHERE email_admin = :email AND password = :password";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function getAdminByEmail($email){
        global $pdo;

        $query = "SELECT * FROM transfer_admin WHERE email_admin = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}


?>