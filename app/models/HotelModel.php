<?php

require_once __DIR__ . '/../../config/db.php';

class HotelModel {

    public function showHotels(){
        global $pdo;

        $query = "
        SELECT
            th.id_hotel,
            th.nombre_hotel,
            th.id_zona,
            tz.descripcion AS descripcion_zona,
            th.comision,
            th.email_hotel,
            th.password
        FROM transfer_hotel th
        JOIN transfer_zona tz ON th.id_zona = tz.id_zona
        ";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateHotel($id_hotel, $hotelName, $zoneSelect, $hotelCommission, $hotelEmail, $hotelPassword){
        global $pdo;

        $query = "
        UPDATE transfer_hotel
        SET nombre_hotel = :nombre_hotel,
            id_zona = :id_zona,
            comision = :comision,
            email_hotel = :email_hotel,
            password = :password
        WHERE id_hotel = :id_hotel
        ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_hotel', $id_hotel);
        $stmt->bindParam(':nombre_hotel', $hotelName);
        $stmt->bindParam(':id_zona', $zoneSelect);
        $stmt->bindParam(':comision', $hotelCommission);
        $stmt->bindParam(':email_hotel', $hotelEmail);
        $stmt->bindParam(':password', $hotelPassword);
        
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function addHotel($hotelName, $zoneSelect, $hotelCommission, $hotelEmail, $hotelPassword){
        global $pdo;

        $query = "
        INSERT INTO transfer_hotel (nombre_hotel, id_zona, comision, email_hotel, password)
        VALUES
        (:nombre_hotel, :id_zona, :comision, :email_hotel, :password)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nombre_hotel', $hotelName);
        $stmt->bindParam(':id_zona', $zoneSelect);
        $stmt->bindParam(':comision', $hotelCommission);
        $stmt->bindParam(':email_hotel', $hotelEmail);
        $stmt->bindParam(':password', $hotelPassword);

        return $stmt->execute();
    }

    public function deleteHotel($id_hotel){
        global $pdo;

        $query = "
        DELETE FROM transfer_hotel
        WHERE id_hotel = :id_hotel
        ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam('id_hotel', $id_hotel);

        return $stmt->execute();
    }
}

?>