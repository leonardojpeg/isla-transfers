<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../views/Modals/OneWayAdminModal.php';
require_once __DIR__ . '/../views/Modals/ReturnAdminModal.php';
require_once __DIR__ . '/../views/Modals/RoundTripAdminModal.php';

if (isset($_SESSION['flash_add_message'])) {
    echo
    "<script>alert('" . $_SESSION['flash_add_message'] . "');</script>";
    unset($_SESSION['flash_add_message']);
}
if (isset($_SESSION['flash_delete_message'])) {
    echo
    "<script>alert('" . $_SESSION['flash_delete_message'] . "');</script>";
    unset($_SESSION['flash_delete_message']);
}
?>

<div class="container py-3 mt-5">
    <h1 class="pb-5">Panel de administración de administradores</h1>
    <div class="row justify-content-end">
        <div class="col-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#oneWayAdminModal"><i class="fa-solid fa-circle-plus"></i> Reservar Aeropuerto-Hotel</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#returnAdminModal"><i class="fa-solid fa-circle-plus"></i> Reservar Hotel-Aeropuerto</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roundTripAdminModal"><i class="fa-solid fa-circle-plus"></i> Reservar ida-vuelta (Aeropuerto-Hotel/Hotel-Aeropuerto)</button>
        </div>
    </div>

    <!-- Tabla reservas ida -->
    <div class="container py-5">
        <h5>Reservas realizadas Aeropuerto-Hotel</h5>
        <table class="table table-sm table-striped trable-hover mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Realizada por</th>
                    <th>Localizador</th>
                    <th>Email cliente</th>
                    <th>Fecha reserva</th>
                    <th>Destino</th>
                    <th>Fecha de llegada</th>
                    <th>Hora de llegada</th>
                    <th>Origen del vuelo llegada</th>
                    <th>Pasajeros</th>
                    <th>Vehículo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require __DIR__ . '/../controllers/CustomerController.php';
                $controller = new CustomerController();
                $oneWayBookings = $controller->showOneWayBookings();
                foreach ($oneWayBookings as $row_booking) { ?>
                    <tr>
                        <td><?= $row_booking['tipo_reserva_descripcion']; ?></td>
                        <td><?= $row_booking['localizador']; ?></td>
                        <td><?= $row_booking['email_cliente']; ?></td>
                        <td><?= $row_booking['fecha_reserva']; ?></td>
                        <td><?= $row_booking['destino_nombre_hotel']; ?></td>
                        <td><?= $row_booking['fecha_entrada']; ?></td>
                        <td><?= $row_booking['hora_entrada']; ?></td>
                        <td><?= $row_booking['origen_vuelo_entrada']; ?></td>
                        <td><?= $row_booking['num_viajeros']; ?></td>
                        <td><?= $row_booking['vehiculo_descripcion']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
                            <form action="index.php?page=customerPanel" method="POST" style="display:inline;">
                                <input type="hidden" name="deleteBooking" value="1">
                                <input type="hidden" name="id_reserva" value="<?= $row_booking['id_reserva']; ?>">
                                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Eliminar</button>
                        </td>
                        </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Tabla reserva vuelta -->
    <div class="container py-5">
    <h5>Reservas realizadas Hotel-Aeropuerto</h5>
    <table class="table table-sm table-striped trable-hover mt-4">
        <thead class="table-dark">
            <tr>
                <th>Realizada por</th>
                <th>Localizador</th>
                <th>Email cliente</th>
                <th>Fecha reserva</th>
                <th>Destino</th>
                <th>Fecha de salida</th>
                <th>Hora de salida</th>
                <th>Hora de recogida</th>
                <th>Pasajeros</th>
                <th>Vehículo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $returnBookings = $controller->showReturnBookings();
            foreach($returnBookings as $row_booking){ ?>
            <tr>
                <td><?= $row_booking['tipo_reserva_descripcion']; ?></td>
                <td><?= $row_booking['localizador']; ?></td>
                <td><?= $row_booking['email_cliente']; ?></td>
                <td><?= $row_booking['fecha_reserva']; ?></td>
                <td><?= $row_booking['destino_nombre_hotel']; ?></td>
                <td><?= $row_booking['fecha_vuelo_salida']; ?></td>
                <td><?= $row_booking['hora_vuelo_salida']; ?></td>
                <td><?= $row_booking['hora_recogida_salida']; ?></td>
                <td><?= $row_booking['num_viajeros']; ?></td>
                <td><?= $row_booking['vehiculo_descripcion']; ?></td>
                <td>
                <button type="button" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
                    <form action="index.php?page=customerPanel" method="POST" style="display:inline;">
                    <input type="hidden" name="deleteBooking" value="1">
                    <input type="hidden" name="id_reserva" value="<?= $row_booking['id_reserva']; ?>">
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Eliminar</button></td>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>

    <!-- Tabla reservas ida-vuelta -->
    <div class="container py-5">
        <h5>Reservas realizadas Aeropuerto-Hotel (ida-vuelta)</h5>
    <table class="table table-sm table-striped trable-hover mt-4">
        <thead class="table-dark">
            <tr>
                <th>Realizada por</th>
                <th>Localizador</th>
                <th>Email cliente</th>
                <th>Fecha reserva</th>
                <th>Destino</th>
                <th>Fecha de llegada</th>
                <th>Hora de llegada</th>
                <th>Origen del vuelo llegada</th>
                <th>Fecha de salida</th>
                <th>Hora de salida</th>
                <th>Pasajeros</th>
                <th>Vehículo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $roundTripBookings = $controller->showRoundTripBookings();
            foreach($roundTripBookings as $row_booking){ ?>
            <tr>
                <td><?= $row_booking['tipo_reserva_descripcion']; ?></td>
                <td><?= $row_booking['localizador']; ?></td>
                <td><?= $row_booking['email_cliente']; ?></td>
                <td><?= $row_booking['fecha_reserva']; ?></td>
                <td><?= $row_booking['destino_nombre_hotel']; ?></td>
                <td><?= $row_booking['fecha_entrada']; ?></td>
                <td><?= $row_booking['hora_entrada']; ?></td>
                <td><?= $row_booking['origen_vuelo_entrada']; ?></td>
                <td><?= $row_booking['fecha_vuelo_salida']; ?></td>
                <td><?= $row_booking['hora_vuelo_salida']; ?></td>
                <td><?= $row_booking['num_viajeros']; ?></td>
                <td><?= $row_booking['vehiculo_descripcion']; ?></td>
                <td>
                    <button type="button" class="btn btn-warning">
                        <i class="fa-solid fa-pen-to-square"></i> Editar
                    </button>

                    <form method="POST" action="index.php?action=eliminarReserva" style="display:inline;">
                        <input type="hidden" name="id_reserva" value="<?= $row_booking['id_reserva']; ?>">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash"></i> Eliminar
                        </button>
                    </form>
                </td>

            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
</div>
