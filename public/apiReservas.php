<?php
require_once __DIR__ . '/../config/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->query("
        SELECT 
            tr.localizador, tr.fecha_reserva, tr.email_cliente, tr.numero_vuelo_entrada,
            tr.origen_vuelo_entrada, tr.hora_vuelo_salida, tr.fecha_vuelo_salida,
            tr.num_viajeros, th.nombre_hotel, ttr.descripcion AS tipo_reserva,
            tv.descripcion AS vehiculo
        FROM transfer_reservas tr
        LEFT JOIN transfer_hotel th ON tr.id_destino = th.id_hotel
        LEFT JOIN transfer_tipo_reserva ttr ON tr.id_tipo_reserva = ttr.id_tipo_reserva
        LEFT JOIN transfer_vehiculo tv ON tr.id_vehiculo = tv.id_vehiculo
    ");

    $eventos = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $descripcion = "Reserva: {$row['localizador']}\n"
            . "Tipo: {$row['tipo_reserva']}\n"
            . "Cliente: {$row['email_cliente']}\n"
            . "Hotel: {$row['nombre_hotel']}\n"
            . "Vuelo entrada: {$row['numero_vuelo_entrada']} ({$row['origen_vuelo_entrada']})\n"
            . "Salida vuelo: {$row['fecha_vuelo_salida']} {$row['hora_vuelo_salida']}\n"
            . "Pasajeros: {$row['num_viajeros']}\n"
            . "Vehículo: {$row['vehiculo']}";

        $eventos[] = [
            'title' => $row['localizador'] . ' - ' . $row['nombre_hotel'],
            'start' => $row['fecha_reserva'],
            'extendedProps' => [
                'description' => $descripcion
            ]
        ];
    }

    echo json_encode($eventos);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener reservas: ' . $e->getMessage()]);
}
