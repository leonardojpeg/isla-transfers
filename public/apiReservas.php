<?php
require_once __DIR__ . '/../config/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->query("
        SELECT 
            tr.id_reserva,
            tr.localizador, 
            tr.id_tipo_reserva,
            tr.fecha_entrada,
            tr.hora_entrada,
            tr.fecha_vuelo_salida,
            tr.hora_vuelo_salida,
            tr.hora_recogida_salida,
            tr.numero_vuelo_entrada,
            tr.origen_vuelo_entrada,
            tr.num_viajeros,
            tr.email_cliente,
            tr.id_vehiculo,
            tv.descripcion AS vehiculo_descripcion,
            th.nombre_hotel
        FROM transfer_reservas tr
        JOIN transfer_hotel th ON tr.id_destino = th.id_hotel
        LEFT JOIN transfer_vehiculo tv ON tr.id_vehiculo = tv.id_vehiculo
    ");

    $reservas = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $baseTitle = "{$row['localizador']} - {$row['nombre_hotel']} - {$row['email_cliente']}";
        $commonInfo = "Localizador: {$row['localizador']}\nCliente: {$row['email_cliente']}\nHotel: {$row['nombre_hotel']}\nPasajeros: {$row['num_viajeros']}";
    
        $tieneIda = !empty($row['fecha_entrada']);
        $tieneVuelta = !empty($row['fecha_vuelo_salida']);
    
        // IDA
        if ($tieneIda) {
            $title = $baseTitle . ($tieneVuelta ? ' (IDA)' : ' (IDA)');
            $tooltip = $commonInfo .
                "\nFecha llegada: {$row['fecha_entrada']}" .
                "\nHora llegada: {$row['hora_entrada']}" .
                "\nVuelo entrada: {$row['numero_vuelo_entrada']}" .
                "\nOrigen vuelo: {$row['origen_vuelo_entrada']}" .
                "\nVehículo: {$row['vehiculo_descripcion']}";
    
            $reservas[] = [
                'id' => $row['id_reserva'] . '-ida',
                'title' => $title,
                'start' => $row['fecha_entrada'] . 'T' . ($row['hora_entrada'] ?? '00:00:00'),
                'color' => $tieneVuelta ? '#28a745' : '#007bff', // Verde
                'tipo_viaje' => $tieneVuelta ? 'ida-vuelta' : 'ida',
                'extendedProps' => [
                    'tooltip' => $tooltip,
                    'id_reserva' => $row['id_reserva'],
                    'localizador' => $row['localizador'],
                    'email_cliente' => $row['email_cliente'],
                    'fecha_entrada' => $row['fecha_entrada'],
                    'hora_entrada' => $row['hora_entrada'],
                    'numero_vuelo_entrada' => $row['numero_vuelo_entrada'],
                    'origen_vuelo_entrada' => $row['origen_vuelo_entrada'],
                    'nombre_hotel' => $row['nombre_hotel'],
                    'num_viajeros' => $row['num_viajeros'],
                    'id_vehiculo' => $row['id_vehiculo']
                ]
            ];
        }
    
        // VUELTA
        if ($tieneVuelta) {
            $title = $baseTitle . ($tieneIda ? ' (VUELTA)' : ' (VUELTA)');
            $tooltip = $commonInfo .
                "\nFecha salida: {$row['fecha_vuelo_salida']}" .
                "\nHora salida: {$row['hora_vuelo_salida']}" .
                "\nHora recogida: {$row['hora_recogida_salida']}" .
                "\nVehículo: {$row['vehiculo_descripcion']}";
    
            $reservas[] = [
                'id' => $row['id_reserva'] . '-vuelta',
                'title' => $title,
                'start' => $row['fecha_vuelo_salida'] . 'T' . ($row['hora_vuelo_salida'] ?? '00:00:00'),
                'color' => $tieneIda ? '#28a745' : '#dc3545', // Verde ida-vuelta, rojo solo vuelta
                'tipo_viaje' => $tieneIda ? 'ida-vuelta' : 'vuelta',
                'extendedProps' => [
                    'tooltip' => $tooltip,
                    'id_reserva' => $row['id_reserva'],
                    'localizador' => $row['localizador'],
                    'email_cliente' => $row['email_cliente'],
                    'fecha_vuelo_salida' => $row['fecha_vuelo_salida'],
                    'hora_vuelo_salida' => $row['hora_vuelo_salida'],
                    'hora_recogida_salida' => $row['hora_recogida_salida'],
                    'nombre_hotel' => $row['nombre_hotel'],
                    'num_viajeros' => $row['num_viajeros'],
                    'id_vehiculo' => $row['id_vehiculo']
                ]
            ];
        }
    }

    echo json_encode($reservas);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener reservas: ' . $e->getMessage()]);
}
