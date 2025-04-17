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
            th.nombre_hotel
        FROM transfer_reservas tr
        JOIN transfer_hotel th ON tr.id_destino = th.id_hotel
    ");

    $reservas = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $baseTitle = "{$row['localizador']} - {$row['nombre_hotel']} - {$row['email_cliente']}";
        $commonInfo = "Localizador: {$row['localizador']}\nCliente: {$row['email_cliente']}\nHotel: {$row['nombre_hotel']}\nPasajeros: {$row['num_viajeros']}";
    
        switch ((int)$row['id_tipo_reserva']) {
            case 1: // OneWay (IDA)
                if (!empty($row['fecha_entrada'])) {
                    $title = $baseTitle . ' (IDA)';
                    $tooltip = $commonInfo .
                               "\nFecha llegada: {$row['fecha_entrada']}" .
                               "\nHora llegada: {$row['hora_entrada']}" .
                               "\nVuelo: {$row['numero_vuelo_entrada']}" .
                               "\nOrigen: {$row['origen_vuelo_entrada']}";

                            $reservas[] = [
                                'id' => $row['id_reserva'],
                                'title' => $title,
                                'start' => $row['fecha_entrada'],
                                'color' => '#007bff',
                                'extendedProps' => [
                                    'tooltip' => $tooltip,
                                    'id_reserva' => $row['id_reserva'],
                                    'id_tipo_reserva' => $row['id_tipo_reserva'],
                                    'localizador' => $row['localizador'],
                                    'email_cliente' => $row['email_cliente'],
                                    'fecha_entrada' => $row['fecha_entrada'],
                                    'hora_entrada' => $row['hora_entrada'],
                                    'numero_vuelo_entrada' => $row['numero_vuelo_entrada'],
                                    'origen_vuelo_entrada' => $row['origen_vuelo_entrada'],
                                    'fecha_vuelo_salida' => $row['fecha_vuelo_salida'],
                                    'hora_vuelo_salida' => $row['hora_vuelo_salida'],
                                    'hora_recogida_salida' => $row['hora_recogida_salida'],
                                    'nombre_hotel' => $row['nombre_hotel'],
                                    'num_viajeros' => $row['num_viajeros'],
                                    'id_vehiculo' => $row['id_vehiculo']
                                    ]
                            ];
                }
                break;
    
            case 2: // Return (VUELTA)
                if (!empty($row['fecha_vuelo_salida'])) {
                    $title = $baseTitle . ' (VUELTA)';
                    $tooltip = $commonInfo .
                               "\nFecha salida: {$row['fecha_vuelo_salida']}" .
                               "\nHora salida: {$row['hora_vuelo_salida']}" .
                               "\nHora recogida: {$row['hora_recogida_salida']}";
                    $reservas[] = [
                        'id' => $row['id_reserva'],
                        'title' => $title,
                        'start' => $row['fecha_vuelo_salida'],
                        'color' => '#dc3545', // Rojo
                        'extendedProps' => [
                            'tooltip' => $tooltip,
                            'id_reserva' => $row['id_reserva'],
                            'id_tipo_reserva' => $row['id_tipo_reserva'],
                            'localizador' => $row['localizador'],
                            'email_cliente' => $row['email_cliente'],
                            'fecha_entrada' => $row['fecha_entrada'],
                            'hora_entrada' => $row['hora_entrada'],
                            'numero_vuelo_entrada' => $row['numero_vuelo_entrada'],
                            'origen_vuelo_entrada' => $row['origen_vuelo_entrada'],
                            'fecha_vuelo_salida' => $row['fecha_vuelo_salida'],
                            'hora_vuelo_salida' => $row['hora_vuelo_salida'],
                            'hora_recogida_salida' => $row['hora_recogida_salida'],
                            'nombre_hotel' => $row['nombre_hotel'],
                            'num_viajeros' => $row['num_viajeros'],
                            'id_vehiculo' => $row['id_vehiculo']
                            ]
                    ];
                }
                break;
    
            case 3: // RoundTrip
                if (!empty($row['fecha_entrada'])) {
                    $title = $baseTitle . ' (IDA)';
                    $tooltip = $commonInfo .
                               "\nFecha llegada: {$row['fecha_entrada']}" .
                               "\nHora llegada: {$row['hora_entrada']}" .
                               "\nVuelo: {$row['numero_vuelo_entrada']}" .
                               "\nOrigen: {$row['origen_vuelo_entrada']}";
                    $reservas[] = [
                        'id' => $row['id_reserva'],
                        'title' => $title,
                        'start' => $row['fecha_entrada'],
                        'color' => '#28a745', // Verde
                        'extendedProps' => [
                            'tooltip' => $tooltip,
                            'id_reserva' => $row['id_reserva'],
                            'id_tipo_reserva' => $row['id_tipo_reserva'],
                            'localizador' => $row['localizador'],
                            'email_cliente' => $row['email_cliente'],
                            'fecha_entrada' => $row['fecha_entrada'],
                            'hora_entrada' => $row['hora_entrada'],
                            'numero_vuelo_entrada' => $row['numero_vuelo_entrada'],
                            'origen_vuelo_entrada' => $row['origen_vuelo_entrada'],
                            'fecha_vuelo_salida' => $row['fecha_vuelo_salida'],
                            'hora_vuelo_salida' => $row['hora_vuelo_salida'],
                            'hora_recogida_salida' => $row['hora_recogida_salida'],
                            'nombre_hotel' => $row['nombre_hotel'],
                            'num_viajeros' => $row['num_viajeros'],
                            'id_vehiculo' => $row['id_vehiculo']
                            ]
                    ];
                }
                if (!empty($row['fecha_vuelo_salida'])) {
                    $title = $baseTitle . ' (VUELTA)';
                    $tooltip = $commonInfo .
                               "\nFecha salida: {$row['fecha_vuelo_salida']}" .
                               "\nHora salida: {$row['hora_vuelo_salida']}" .
                               "\nHora recogida: {$row['hora_recogida_salida']}";
                    $reservas[] = [
                        'id' => $row['id_reserva'],
                        'title' => $title,
                        'start' => $row['fecha_vuelo_salida'],
                        'color' => '#28a745', // Verde
                        'extendedProps' => [
                            'tooltip' => $tooltip,
                            'id_reserva' => $row['id_reserva'],
                            'id_tipo_reserva' => $row['id_tipo_reserva'],
                            'localizador' => $row['localizador'],
                            'email_cliente' => $row['email_cliente'],
                            'fecha_entrada' => $row['fecha_entrada'],
                            'hora_entrada' => $row['hora_entrada'],
                            'numero_vuelo_entrada' => $row['numero_vuelo_entrada'],
                            'origen_vuelo_entrada' => $row['origen_vuelo_entrada'],
                            'fecha_vuelo_salida' => $row['fecha_vuelo_salida'],
                            'hora_vuelo_salida' => $row['hora_vuelo_salida'],
                            'hora_recogida_salida' => $row['hora_recogida_salida'],
                            'nombre_hotel' => $row['nombre_hotel'],
                            'num_viajeros' => $row['num_viajeros'],
                            'id_vehiculo' => $row['id_vehiculo']
                            ]
                    ];
                }
                break;
        }
    }
    

    echo json_encode($reservas);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener reservas: ' . $e->getMessage()]);
}
