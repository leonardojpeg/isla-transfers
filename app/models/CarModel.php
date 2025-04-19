<?php

require_once __DIR__ . '/../../config/db.php';

class CarModel {

    public function showCars(){
        global $pdo;

        $query = "
        SELECT
            id_vehiculo,
            descripcion,
            email_conductor,
            password
        FROM transfer_vehiculo
        ";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCar($id_car, $description, $carEmail, $carPassword){
        global $pdo;

        $query = "
        UPDATE transfer_vehiculo
        SET descripcion = :descripcion,
            email_conductor = :email_conductor,
            password = :password
        WHERE id_vehiculo = :id_vehiculo
        ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':descripcion', $description);
        $stmt->bindParam(':email_conductor', $carEmail);
        $stmt->bindParam(':password', $carPassword);
        $stmt->bindParam(':id_vehiculo', $id_car);

        
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function addCar($carDescription, $carEmail, $carPassword){
        global $pdo;

        $query = "
        INSERT INTO transfer_vehiculo (descripcion, email_conductor, password)
        VALUES
        (:descripcion, :email_conductor, :password)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':descripcion', $carDescription);
        $stmt->bindParam(':email_conductor', $carEmail);
        $stmt->bindParam(':password', $carPassword);

        return $stmt->execute();
    }

    public function deleteCar($id_vehiculo){
        global $pdo;

        $query = "
        DELETE FROM transfer_vehiculo
        WHERE id_vehiculo = :id_vehiculo
        ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_vehiculo', $id_vehiculo);

        return $stmt->execute();
    }
}

?>