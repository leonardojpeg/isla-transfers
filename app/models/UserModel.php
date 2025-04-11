<?php

require_once __DIR__ . '/../../config/db.php';

class UserModel
{

    public function getUserInfo($userId)
    {
        global $pdo;

        $query = "SELECT nombre, apellido1, apellido2, direccion, codigoPostal, ciudad, pais, email, password
                  FROM transfer_viajeros
                  WHERE id_viajero = :userId";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }


    public function registerUser($username, $surname, $lastname, $address, $cp, $city, $country, $email, $password)
    {
        global $pdo;

        // variable con la consulta
        $query = "INSERT INTO transfer_viajeros (nombre, apellido1, apellido2, direccion, codigoPostal, ciudad, pais, email, password)
                  VALUES (:nombre, :apellido1, :apellido2, :direccion, :codigoPostal, :ciudad, :pais, :email, :password)";

        $stmt = $pdo->prepare($query);

        // Vincular los parámetros y ejecutar la consulta
        $stmt->bindParam(':nombre', $username);
        $stmt->bindParam(':apellido1', $surname);
        $stmt->bindParam(':apellido2', $lastname);
        $stmt->bindParam(':direccion', $address);
        $stmt->bindParam(':codigoPostal', $cp);
        $stmt->bindParam(':ciudad', $city);
        $stmt->bindParam(':pais', $country);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        return $stmt->execute();
    }

    public function requestLogIn($email, $password)
    {
        global $pdo;

        $query = "SELECT * FROM transfer_viajeros WHERE email = :email AND password = :password";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function getUserByEmail($email)
    {
        global $pdo;

        $query = "SELECT * FROM transfer_viajeros WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();        

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user ? $user : false;
    }

    public function updateUser($userId, $username, $email, $password)
    {
        global $pdo;

        $query = "UPDATE transfer_viajeros SET
        nombre = :nombre,
        email = :email, 
        password = :password
        WHERE id_viajero = :userId";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':nombre', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':userId', $userId);

        return $stmt->execute();
    }
}
