<?php

require_once __DIR__ . '/../models/ReserveModel.php';

class ReserveController
{
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipoTrayecto = $_POST['tipoTrayecto'];
            $email = $_POST['email_cliente'];
            $hotel = $_POST['hotel'];
            $viajeros = $_POST['viajeros'];

            // Generar un localizador aleatorio único
            $localizador = uniqid('res_');

            $model = new ReserveModel();

            $datosReserva = [
                'localizador' => $localizador,
                'email_cliente' => $email,
                'id_destino' => $model->getHotelIdByName($hotel),
                'num_viajeros' => $viajeros,
                'id_tipo_reserva' => $model->getTipoReservaId($tipoTrayecto),
                'fecha_reserva' => date('Y-m-d H:i:s'),
                'fecha_modificacion' => date('Y-m-d H:i:s'),
                'id_vehiculo' => 1, // temporal mientras no haya lógica de asignación
            ];

            // Datos opcionales según tipo
            if ($tipoTrayecto === 'ida' || $tipoTrayecto === 'ida_vuelta') {
                $datosReserva['fecha_entrada'] = $_POST['dia_llegada'];
                $datosReserva['hora_entrada'] = $_POST['hora_llegada'];
                $datosReserva['numero_vuelo_entrada'] = $_POST['num_vuelo_ida'];
                $datosReserva['origen_vuelo_entrada'] = $_POST['aeropuerto_origen'];
            }

            if ($tipoTrayecto === 'vuelta' || $tipoTrayecto === 'ida_vuelta') {
                $datosReserva['fecha_vuelo_salida'] = $_POST['dia_vuelo'];
                $datosReserva['hora_vuelo_salida'] = $_POST['hora_vuelo'];
            }

            $exito = $model->crearReserva($datosReserva);

            if ($exito) {
                header("Location: index.php?page=adminPanel&success=1");
                exit;
            } else {
                header("Location: index.php?page=adminPanel&error=1");
                exit;
            }
        }
    }
}
