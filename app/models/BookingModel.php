<?php

require_once __DIR__ . '/../../config/db.php';

class BookingModel{

    public function customerBookings($email){
        global $pdo;

        $query = "
        SELECT tr.id_reserva, tr.localizador, tr.id_tipo_reserva, ttr.descripcion AS tipo_reserva_descripcion, tr.email_cliente, tr.fecha_reserva, tr.id_destino, tr.numero_vuelo_entrada, tr.origen_vuelo_entrada, tr.hora_vuelo_salida, tr.fecha_vuelo_salida, tr.num_viajeros, tr.id_vehiculo, tv.descripcion AS vehiculo_descripcion
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

    public function getOneWayBookings($email) {
        global $pdo;
    
        $query = "
            SELECT 
                tr.id_reserva,
                tr.localizador,
                tr.id_tipo_reserva,
                ttr.descripcion AS tipo_reserva_descripcion,
                tr.email_cliente,
                tr.fecha_reserva,
                tr.fecha_entrada,
                tr.hora_entrada,
                tr.numero_vuelo_entrada,
                tr.origen_vuelo_entrada,
                tr.num_viajeros,
                tr.id_vehiculo,
                tv.descripcion AS vehiculo_descripcion,
                tr.id_destino,
                th.nombre_hotel AS destino_nombre_hotel
            FROM transfer_reservas tr
            LEFT JOIN transfer_tipo_reserva ttr ON tr.id_tipo_reserva = ttr.id_tipo_reserva
            LEFT JOIN transfer_vehiculo tv ON tr.id_vehiculo = tv.id_vehiculo
            LEFT JOIN transfer_hotel th ON tr.id_destino = th.id_hotel
            WHERE tr.email_cliente = :userEmail AND tr.fecha_vuelo_salida IS NULL
        ";
    
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userEmail', $email);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReturnBookings($email) {
        global $pdo;
    
        $query = "
            SELECT 
                tr.id_reserva,
                tr.localizador,
                tr.id_tipo_reserva,
                ttr.descripcion AS tipo_reserva_descripcion,
                tr.email_cliente,
                tr.fecha_reserva,
                tr.fecha_vuelo_salida,
                tr.hora_vuelo_salida,
                tr.hora_recogida_salida,
                tr.numero_vuelo_entrada,
                tr.origen_vuelo_entrada,
                tr.num_viajeros,
                tr.id_vehiculo,
                tv.descripcion AS vehiculo_descripcion,
                tr.id_destino,
                th.nombre_hotel AS destino_nombre_hotel
            FROM transfer_reservas tr
            LEFT JOIN transfer_tipo_reserva ttr ON tr.id_tipo_reserva = ttr.id_tipo_reserva
            LEFT JOIN transfer_vehiculo tv ON tr.id_vehiculo = tv.id_vehiculo
            LEFT JOIN transfer_hotel th ON tr.id_destino = th.id_hotel
            WHERE tr.email_cliente = :userEmail AND tr.fecha_entrada IS NULL
        ";
    
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userEmail', $email);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getRoundTripBookings($email) {
        global $pdo;
    
        $query = "
            SELECT 
                tr.id_reserva,
                tr.localizador,
                tr.id_tipo_reserva,
                ttr.descripcion AS tipo_reserva_descripcion,
                tr.email_cliente,
                tr.fecha_reserva,
                tr.fecha_entrada,
                tr.hora_entrada,
                tr.fecha_vuelo_salida,
                tr.hora_vuelo_salida,
                tr.hora_recogida_salida,
                tr.numero_vuelo_entrada,
                tr.origen_vuelo_entrada,
                tr.num_viajeros,
                tr.id_vehiculo,
                tv.descripcion AS vehiculo_descripcion,
                tr.id_destino,
                th.nombre_hotel AS destino_nombre_hotel
            FROM transfer_reservas tr
            LEFT JOIN transfer_tipo_reserva ttr ON tr.id_tipo_reserva = ttr.id_tipo_reserva
            LEFT JOIN transfer_vehiculo tv ON tr.id_vehiculo = tv.id_vehiculo
            LEFT JOIN transfer_hotel th ON tr.id_destino = th.id_hotel
            WHERE tr.email_cliente = :userEmail 
              AND tr.fecha_entrada IS NOT NULL 
              AND tr.fecha_vuelo_salida IS NOT NULL
        ";
    
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userEmail', $email);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addOneWayBooking($uuid, $bookingDate, $bookingTime, $flyNumer, $originAirport, $hotelSelect, $carSelect, $passengerNum, $email, $reserveType){
        global $pdo;

        $query = "
                INSERT INTO transfer_reservas (id_tipo_reserva, localizador, email_cliente, fecha_entrada, hora_entrada, numero_vuelo_entrada, origen_vuelo_entrada, id_destino, num_viajeros, id_vehiculo)
                VALUES
                (:tipo_reserva, :localizador, :email_cliente, :fecha_entrada, :hora_entrada, :numero_vuelo_entrada, :origen_vuelo_entrada, :id_destino, :num_viajeros, :id_vehiculo)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':tipo_reserva', $reserveType);
        $stmt->bindParam(':localizador', $uuid);
        $stmt->bindParam(':email_cliente', $email);
        $stmt->bindParam(':fecha_entrada', $bookingDate);
        $stmt->bindParam(':hora_entrada', $bookingTime);
        $stmt->bindParam(':numero_vuelo_entrada', $flyNumer);
        $stmt->bindParam(':origen_vuelo_entrada', $originAirport);
        $stmt->bindParam(':id_destino', $hotelSelect);
        $stmt->bindParam(':num_viajeros', $passengerNum);
        $stmt->bindParam(':id_vehiculo', $carSelect);
        return $stmt->execute();
    }

    public function addReturnBooking($uuid, $dateFly, $timeFly, $pickupTime, $hotelSelect, $carSelect, $passengerNum, $email, $reserveType){
        global $pdo;

        $query = "
                INSERT INTO transfer_reservas (id_tipo_reserva, localizador, email_cliente, fecha_vuelo_salida, hora_vuelo_salida, hora_recogida_salida, id_destino, num_viajeros, id_vehiculo)
                VALUES
                (:tipo_reserva, :localizador, :email_cliente, :fecha_vuelo_salida, :hora_vuelo_salida, :hora_recogida_salida, :id_destino, :num_viajeros, :id_vehiculo)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':tipo_reserva', $reserveType);
        $stmt->bindParam(':localizador', $uuid);
        $stmt->bindParam(':email_cliente', $email);
        $stmt->bindParam(':fecha_vuelo_salida', $dateFly);
        $stmt->bindParam(':hora_vuelo_salida', $timeFly);
        $stmt->bindParam(':hora_recogida_salida', $pickupTime);
        $stmt->bindParam(':id_destino', $hotelSelect);
        $stmt->bindParam(':num_viajeros', $passengerNum);
        $stmt->bindParam(':id_vehiculo', $carSelect);
        return $stmt->execute();
    }

    public function addRoundTripBooking($uuid, $bookingDate, $bookingTime, $dateFly, $timeFly, $pickupTime, $flyNumer, $originAirport, $hotelSelect, $carSelect, $passengerNum, $email, $reserveType){
        global $pdo;

        $query = "
                INSERT INTO transfer_reservas (id_tipo_reserva, localizador, email_cliente, fecha_entrada, hora_entrada, fecha_vuelo_salida, hora_vuelo_salida, hora_recogida_salida, numero_vuelo_entrada, origen_vuelo_entrada, id_destino, num_viajeros, id_vehiculo)
                VALUES
                (:tipo_reserva, :localizador, :email_cliente, :fecha_entrada, :hora_entrada, :fecha_vuelo_salida, :hora_vuelo_salida, :hora_recogida_salida, :numero_vuelo_entrada, :origen_vuelo_entrada, :id_destino, :num_viajeros, :id_vehiculo)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':tipo_reserva', $reserveType);
        $stmt->bindParam(':localizador', $uuid);
        $stmt->bindParam(':email_cliente', $email);
        $stmt->bindParam(':fecha_entrada', $bookingDate);
        $stmt->bindParam(':hora_entrada', $bookingTime);
        $stmt->bindParam(':fecha_vuelo_salida', $dateFly);
        $stmt->bindParam(':hora_vuelo_salida', $timeFly);
        $stmt->bindParam(':hora_recogida_salida', $pickupTime);
        $stmt->bindParam(':numero_vuelo_entrada', $flyNumer);
        $stmt->bindParam(':origen_vuelo_entrada', $originAirport);
        $stmt->bindParam(':id_destino', $hotelSelect);
        $stmt->bindParam(':num_viajeros', $passengerNum);
        $stmt->bindParam(':id_vehiculo', $carSelect);
        return $stmt->execute();
    }

    public function deleteBooking($id_reserva){
        global $pdo;

        $query = "DELETE FROM transfer_reservas WHERE id_reserva = :id_reserva";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_reserva', $id_reserva);

        return $stmt->execute();
    }

    public function adminBookings(){
        global $pdo;

        $query = "
        SELECT 
            tr.id_reserva,
            tr.localizador,
            tr.id_tipo_reserva,
            ttr.descripcion AS tipo_reserva_descripcion,
            tr.email_cliente,
            tr.fecha_reserva,
            tr.fecha_modificacion,
            tr.fecha_entrada,
            tr.hora_entrada,
            tr.fecha_vuelo_salida,
            tr.hora_vuelo_salida,
            tr.hora_recogida_salida,
            tr.numero_vuelo_entrada,
            tr.origen_vuelo_entrada,
            tr.num_viajeros,
            tr.id_vehiculo,
            tv.descripcion AS vehiculo_descripcion,
            tr.id_destino,
            th.nombre_hotel AS destino_nombre_hotel
        FROM transfer_reservas tr
        LEFT JOIN transfer_tipo_reserva ttr ON tr.id_tipo_reserva = ttr.id_tipo_reserva
        LEFT JOIN transfer_vehiculo tv ON tr.id_vehiculo = tv.id_vehiculo
        LEFT JOIN transfer_hotel th ON tr.id_destino = th.id_hotel
        ";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAdminBooking($id_reserva) {
        global $pdo;
    
        $query = "
            SELECT 
                tr.id_reserva,
                tr.localizador,
                tr.id_tipo_reserva,
                ttr.descripcion AS tipo_reserva_descripcion,
                tr.email_cliente,
                tr.fecha_reserva,
                tr.fecha_entrada,
                tr.hora_entrada,
                tr.fecha_vuelo_salida,
                tr.hora_vuelo_salida,
                tr.hora_recogida_salida,
                tr.numero_vuelo_entrada,
                tr.origen_vuelo_entrada,
                tr.num_viajeros,
                tr.id_vehiculo,
                tv.descripcion AS vehiculo_descripcion,
                tr.id_destino,
                th.nombre_hotel AS destino_nombre_hotel
            FROM transfer_reservas tr
            LEFT JOIN transfer_tipo_reserva ttr ON tr.id_tipo_reserva = ttr.id_tipo_reserva
            LEFT JOIN transfer_vehiculo tv ON tr.id_vehiculo = tv.id_vehiculo
            LEFT JOIN transfer_hotel th ON tr.id_destino = th.id_hotel
            WHERE tr.id_reserva = :id_reserva 
              AND tr.fecha_entrada IS NOT NULL 
              AND tr.fecha_vuelo_salida IS NOT NULL
        ";
    
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_reserva', $id_reserva);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUpOneWayBooking($id_reserva){
        global $pdo;

        $query = "
        SELECT id_reserva,
            tr.id_destino,
            th.nombre_hotel AS destino_nombre_hotel
            tr.fecha_entrada,
            tr.hora_entrada,
            tr.numero_vuelo_entrada,
            tr.origen_vuelo_entrada,
            tr.num_viajeros,
            tr.id_vehiculo
            tv.descripcion AS vehiculo_descripcion
        FROM transfer_reservas tr
        LEFT JOIN transfer_vehiculo tv ON tr.id_vehiculo = tv.id_vehiculo
        LEFT JOIN transfer_hotel th ON tr.id_destino = th.id_hotel
        WHERE id_reserva = :id_reserva
        ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_reserva', $id_reserva);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBookingById($id_reserva){
        global $pdo;

        $query = "SELECT fecha_entrada, hora_entrada, fecha_vuelo_salida, hora_vuelo_salida FROM transfer_reservas WHERE id_reserva = :id_reserva";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_reserva', $id_reserva);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOneWayBooking($uuid, $bookingDate, $bookingTime, $flyNumer, $originAirport, $hotelSelect, $carSelect, $passengerNum, $email){
        global $pdo;
        
        $query = "
        UPDATE transfer_reservas
        SET fecha_entrada = :fecha_entrada,
            hora_entrada = :hora_entrada,
            numero_vuelo_entrada = :numero_vuelo_entrada,
            origen_vuelo_entrada = :origen_vuelo_entrada,
            id_destino = :id_destino,
            id_vehiculo = :id_vehiculo,
            num_viajeros = :num_viajeros,
            fecha_modificacion = NOW()
        WHERE localizador = :localizador AND email_cliente = :email_cliente
        ";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':fecha_entrada', $bookingDate);
        $stmt->bindParam(':hora_entrada', $bookingTime);
        $stmt->bindParam(':numero_vuelo_entrada', $flyNumer);
        $stmt->bindParam(':origen_vuelo_entrada', $originAirport);
        $stmt->bindParam(':id_destino', $hotelSelect);
        $stmt->bindParam(':id_vehiculo', $carSelect);
        $stmt->bindParam(':num_viajeros', $passengerNum);
        $stmt->bindParam(':localizador', $uuid);
        $stmt->bindParam(':email_cliente', $email);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function updateReturnBooking($uuid, $dateFly, $timeFly, $pickupTime, $hotelSelect, $carSelect, $passengerNum, $email){
        global $pdo;
        
        $query = "
        UPDATE transfer_reservas
        SET fecha_vuelo_salida = :fecha_vuelo_salida,
            hora_vuelo_salida = :hora_vuelo_salida,
            hora_recogida_salida = :hora_recogida_salida,
            id_destino = :id_destino,
            id_vehiculo = :id_vehiculo,
            num_viajeros = :num_viajeros,
            fecha_modificacion = NOW()
        WHERE localizador = :localizador AND email_cliente = :email_cliente
        ";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':fecha_vuelo_salida', $dateFly);
        $stmt->bindParam(':hora_vuelo_salida', $timeFly);
        $stmt->bindParam(':hora_recogida_salida', $pickupTime);
        $stmt->bindParam(':id_destino', $hotelSelect);
        $stmt->bindParam(':id_vehiculo', $carSelect);
        $stmt->bindParam(':num_viajeros', $passengerNum);
        $stmt->bindParam(':localizador', $uuid);
        $stmt->bindParam(':email_cliente', $email);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function updateRoundTripBooking($uuid, $bookingDate, $bookingTime, $flyNumer, $originAirport, $dateFly, $timeFly, $pickupTime, $hotelSelect, $carSelect, $passengerNum, $email){
        global $pdo;
        
        $query = "
        UPDATE transfer_reservas
        SET fecha_entrada = :fecha_entrada,
            hora_entrada = :hora_entrada,
            numero_vuelo_entrada = :numero_vuelo_entrada,
            origen_vuelo_entrada = :origen_vuelo_entrada,
            fecha_vuelo_salida = :fecha_vuelo_salida,
            hora_vuelo_salida = :hora_vuelo_salida,
            hora_recogida_salida = :hora_recogida_salida,
            id_destino = :id_destino,
            id_vehiculo = :id_vehiculo,
            num_viajeros = :num_viajeros,
            fecha_modificacion = NOW()
        WHERE localizador = :localizador AND email_cliente = :email_cliente
        ";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':fecha_entrada', $bookingDate);
        $stmt->bindParam(':hora_entrada', $bookingTime);
        $stmt->bindParam(':numero_vuelo_entrada', $flyNumer);
        $stmt->bindParam(':origen_vuelo_entrada', $originAirport);
        $stmt->bindParam(':fecha_vuelo_salida', $dateFly);
        $stmt->bindParam(':hora_vuelo_salida', $timeFly);
        $stmt->bindParam(':hora_recogida_salida', $pickupTime);
        $stmt->bindParam(':id_destino', $hotelSelect);
        $stmt->bindParam(':id_vehiculo', $carSelect);
        $stmt->bindParam(':num_viajeros', $passengerNum);
        $stmt->bindParam(':localizador', $uuid);
        $stmt->bindParam(':email_cliente', $email);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}

?>