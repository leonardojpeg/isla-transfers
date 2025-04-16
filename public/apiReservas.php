<?php
require_once __DIR__ . '/../config/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->query("
        SELECT 
            tr.localizador, 
            tr.fecha_reserva, 
            th.nombre_hotel,
            tr.email_cliente
        FROM transfer_reservas tr
        JOIN transfer_hotel th ON tr.id_destino = th.id_hotel
    ");

    $reservas = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $reservas[] = [
            'title' => $row['localizador'] . "\n" . 'Destino: ' . $row['nombre_hotel'] . "\n" . 'Cliente: ' . $row['email_cliente'],
            'start' => $row['fecha_reserva']
        ];
    }

    echo json_encode($reservas);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener reservas: ' . $e->getMessage()]);
}
