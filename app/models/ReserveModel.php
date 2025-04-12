<?php

require_once __DIR__ . '/../../config/db.php';

class ReserveModel
{
    public function crearReserva($data)
    {
        global $pdo;

        try {
        $sql = "INSERT INTO transfer_reservas (
                    localizador, id_hotel, id_tipo_reserva, email_cliente,
                    fecha_reserva, fecha_modificacion, id_destino,
                    fecha_entrada, hora_entrada, numero_vuelo_entrada,
                    origen_vuelo_entrada, hora_vuelo_salida, fecha_vuelo_salida,
                    num_viajeros, id_vehiculo
                ) VALUES (
                    :localizador, :id_hotel, :id_tipo_reserva, :email_cliente,
                    :fecha_reserva, :fecha_modificacion, :id_destino,
                    :fecha_entrada, :hora_entrada, :numero_vuelo_entrada,
                    :origen_vuelo_entrada, :hora_vuelo_salida, :fecha_vuelo_salida,
                    :num_viajeros, :id_vehiculo
                )";

        $stmt = $pdo->prepare($sql);

        // Vincular parámetros con valores, usando null si no están definidos
        $stmt->bindValue(':localizador', $data['localizador']);
        $stmt->bindValue(':id_hotel', $data['id_destino']); // provisional: mismo valor como hotel y destino
        $stmt->bindValue(':id_tipo_reserva', $data['id_tipo_reserva']);
        $stmt->bindValue(':email_cliente', $data['email_cliente']);
        $stmt->bindValue(':fecha_reserva', $data['fecha_reserva']);
        $stmt->bindValue(':fecha_modificacion', $data['fecha_modificacion']);
        $stmt->bindValue(':id_destino', $data['id_destino']);
        $stmt->bindValue(':fecha_entrada', $data['fecha_entrada'] ?? null);
        $stmt->bindValue(':hora_entrada', $data['hora_entrada'] ?? null);
        $stmt->bindValue(':numero_vuelo_entrada', $data['numero_vuelo_entrada'] ?? null);
        $stmt->bindValue(':origen_vuelo_entrada', $data['origen_vuelo_entrada'] ?? null);
        $stmt->bindValue(':hora_vuelo_salida', $data['hora_vuelo_salida'] ?? null);
        $stmt->bindValue(':fecha_vuelo_salida', $data['fecha_vuelo_salida'] ?? null);
        $stmt->bindValue(':num_viajeros', $data['num_viajeros']);
        $stmt->bindValue(':id_vehiculo', $data['id_vehiculo']);

        return $stmt->execute();
    } catch (PDOException $e) {
        die("❌ Error en la reserva: " . $e->getMessage());
    }
    }
    
    public function getHotelIdByName($nombre)
    {
        global $pdo;

        $query = "SELECT id_hotel FROM tranfer_hotel WHERE id_hotel = :nombre OR usuario = :nombre LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id_hotel'] : null;
    }

    public function getTipoReservaId($descripcion)
    {
        global $pdo;

        $mapa = [
            'ida' => 1,
            'vuelta' => 2,
            'ida_vuelta' => 3
        ];

        return $mapa[$descripcion] ?? 1;
    }

    public function obtenerReservas()
{
    global $pdo;

    $query = "SELECT * FROM transfer_reservas ORDER BY fecha_reserva DESC";
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
