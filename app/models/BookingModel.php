<?php

require_once __DIR__ . '/../../config/db.php';

class BookingModel{

    public function customerBookings($email){
        global $pdo;

        $query = "
        SELECT tr.id_reserva, tr.localizador, tr.id_tipo_reserva, ttr.descripcion AS tipo_reserva_descripcion, tr.email_cliente, tr.fecha_reserva, tr.id_destino, tr.numero_vuelo_entrada, tr.origen_vuelo_entrada, tr.hora_vuelo_salida, tr.fecha_vuelo_salida, tr.num_viajeros, tr.id_vehiculo, tv.Descripción AS vehiculo_descripcion
        FROM transfer_reservas tr
        LEFT JOIN transfer_tipo_reserva ttr ON tr.id_tipo_reserva = ttr.id_tipo_reserva
        LEFT JOIN transfer_vehiculo tv ON tr.id_vehiculo = tv.id_vehiculo
        WHERE email_cliente = :userEmail
        ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userEmail', $email);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCustomerBooking($uuid, $bookingDate, $destination, $locatorFly, $originFly, $departureDate, $departureTime, $passengerNum, $vehiculo, $email, $reserveType){
        global $pdo;

        $query = "
                INSERT INTO transfer_reservas (id_tipo_reserva, localizador, email_cliente, fecha_reserva, id_destino, numero_vuelo_entrada, origen_vuelo_entrada, hora_vuelo_salida, fecha_vuelo_salida, num_viajeros, id_vehiculo)
                VALUES
                (:tipo_reserva, :localizador, :email_cliente, :fecha_reserva, :id_destino, :numero_vuelo_entrada, :origen_vuelo_entrada, :hora_vuelo_salida, :fecha_vuelo_salida, :num_viajeros, :id_vehiculo)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':tipo_reserva', $reserveType);
        $stmt->bindParam(':localizador', $uuid);
        $stmt->bindParam(':email_cliente', $email);
        $stmt->bindParam(':fecha_reserva', $bookingDate);
        $stmt->bindParam(':id_destino', $destination);
        $stmt->bindParam(':numero_vuelo_entrada', $locatorFly);
        $stmt->bindParam(':origen_vuelo_entrada', $originFly);
        $stmt->bindParam(':fecha_vuelo_salida', $departureDate);
        $stmt->bindParam(':hora_vuelo_salida', $departureTime);
        $stmt->bindParam(':num_viajeros', $passengerNum);
        $stmt->bindParam(':id_vehiculo', $vehiculo);

        return $stmt->execute();
    }

    public function adminBookings(){
        global $pdo;

        $query = "
        SELECT tr.id_reserva, tr.localizador, tr.id_tipo_reserva, ttr.descripcion AS tipo_reserva_descripcion, tr.email_cliente, tr.fecha_reserva, tr.id_destino, tr.numero_vuelo_entrada, tr.origen_vuelo_entrada, tr.hora_vuelo_salida, tr.fecha_vuelo_salida, tr.num_viajeros, tr.id_vehiculo, tv.descripcion AS vehiculo_descripcion
        FROM transfer_reservas tr
        LEFT JOIN transfer_tipo_reserva ttr ON tr.id_tipo_reserva = ttr.id_tipo_reserva
        LEFT JOIN transfer_vehiculo tv ON tr.id_vehiculo = tv.id_vehiculo
        ";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteBooking($id_reserva){
        global $pdo;

        $query = "DELETE FROM transfer_reservas WHERE id_reserva = :id_reserva";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_reserva', $id_reserva);

        return $stmt->execute();
    }
}

?>