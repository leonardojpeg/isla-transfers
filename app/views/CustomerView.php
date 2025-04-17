<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../views/Modals/OneWayModal.php';
require_once __DIR__ . '/../views/Modals/EditOneWayModal.php';
require_once __DIR__ . '/../views/Modals/ReturnModal.php';
require_once __DIR__ . '/../views/Modals/EditReturnModal.php';
require_once __DIR__ . '/../views/Modals/RoundTripModal.php';
require_once __DIR__ . '/../views/Modals/EditRoundTripModal.php';

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

if (isset($_SESSION['flash_edit_message'])) {
    echo
    "<script>alert('" . $_SESSION['flash_edit_message'] . "');</script>";
    unset($_SESSION['flash_edit_message']);
}
?>

<div class="container py-3 mt-5">
    <h1 class="pb-5 row justify-content-center">Panel de administración de clientes</h1>
    <div class="row justify-content-center">
        <div class="col-auto">

        <button type="button" class="btn text-white fw-bold" style="background-color: #007bff;"
    onmouseover="this.style.backgroundColor='#0056b3'" 
    onmouseout="this.style.backgroundColor='#007bff'" 
    data-bs-toggle="modal" data-bs-target="#oneWayModal">
    <i class="fa-solid fa-circle-plus"></i> Reservar Aeropuerto-Hotel
</button>

<button type="button" class="btn text-white fw-bold" style="background-color: #dc3545;"
    onmouseover="this.style.backgroundColor='#a71d2a'" 
    onmouseout="this.style.backgroundColor='#dc3545'" 
    data-bs-toggle="modal" data-bs-target="#returnModal">
    <i class="fa-solid fa-circle-plus"></i> Reservar Hotel-Aeropuerto
</button>

<button type="button" class="btn text-white fw-bold" style="background-color: #28a745;"
    onmouseover="this.style.backgroundColor='#1e7e34'" 
    onmouseout="this.style.backgroundColor='#28a745'" 
    data-bs-toggle="modal" data-bs-target="#roundTripModal">
    <i class="fa-solid fa-circle-plus"></i> Reservar ida-vuelta (Aeropuerto-Hotel/Hotel-Aeropuerto)
</button>

        <!--
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#oneWayModal"><i class="fa-solid fa-circle-plus"></i> Reservar Aeropuerto-Hotel</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#returnModal"><i class="fa-solid fa-circle-plus"></i> Reservar Hotel-Aeropuerto</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roundTripModal"><i class="fa-solid fa-circle-plus"></i> Reservar ida-vuelta (Aeropuerto-Hotel/Hotel-Aeropuerto)</button>
        -->
        </div>
    </div>
<hr>
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
                    <th>Número de vuelo</th>
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
                        <td><?= $row_booking['numero_vuelo_entrada']; ?></td>
                        <td><?= $row_booking['fecha_entrada']; ?></td>
                        <td><?= $row_booking['hora_entrada']; ?></td>
                        <td><?= $row_booking['origen_vuelo_entrada']; ?></td>
                        <td><?= $row_booking['num_viajeros']; ?></td>
                        <td><?= $row_booking['vehiculo_descripcion']; ?></td>
                        <td>
                            <form action="index.php?page=customerPanel" method="POST" style="display:inline;">
                                <button type="button" class="btn btn-sm btn-warning editOneWayBooking" data-bs-toggle="modal" data-bs-target="#editOneWayModal"
                                    data-id="<?= $row_booking['id_reserva']; ?>"
                                    data-localizador="<?= $row_booking['localizador']; ?>"
                                    data-email_cliente="<?= $row_booking['email_cliente']; ?>"
                                    data-destino_nombre_hotel="<?= $row_booking['destino_nombre_hotel']; ?>"
                                    data-numero_vuelo_entrada="<?= $row_booking['numero_vuelo_entrada']; ?>"
                                    data-fecha_entrada="<?= $row_booking['fecha_entrada']; ?>"
                                    data-hora_entrada="<?= $row_booking['hora_entrada']; ?>"
                                    data-origen_vuelo_entrada="<?= $row_booking['origen_vuelo_entrada']; ?>"
                                    data-num_viajeros="<?= $row_booking['num_viajeros']; ?>"
                                    data-vehiculo_descripcion="<?= $row_booking['vehiculo_descripcion']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </button>
                            </form>
                            <form action="index.php?page=customerPanel" method="POST" style="display:inline;">
                                <input type="hidden" name="deleteBooking" value="1">
                                <input type="hidden" name="id_reserva" value="<?= $row_booking['id_reserva']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Eliminar</button>
                            </form>
                        </td>
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
                foreach ($returnBookings as $row_booking) { ?>
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
                            <form action="index.php?page=customerPanel" method="POST" style="display:inline;">
                                <button type="button" class="btn btn-sm btn-warning editReturnBooking" data-bs-toggle="modal" data-bs-target="#editReturnModal"
                                    data-id="<?= $row_booking['id_reserva']; ?>"
                                    data-localizador="<?= $row_booking['localizador']; ?>"
                                    data-email_cliente="<?= $row_booking['email_cliente']; ?>"
                                    data-destino_nombre_hotel="<?= $row_booking['destino_nombre_hotel']; ?>"
                                    data-fecha_vuelo_salida="<?= $row_booking['fecha_vuelo_salida']; ?>"
                                    data-hora_vuelo_salida="<?= $row_booking['hora_vuelo_salida']; ?>"
                                    data-hora_recogida_salida="<?= $row_booking['hora_recogida_salida']; ?>"
                                    data-num_viajeros="<?= $row_booking['num_viajeros']; ?>"
                                    data-vehiculo_descripcion="<?= $row_booking['vehiculo_descripcion']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </button>
                            </form>
                            <form action="index.php?page=customerPanel" method="POST" style="display:inline;">
                                <input type="hidden" name="deleteBooking" value="1">
                                <input type="hidden" name="id_reserva" value="<?= $row_booking['id_reserva']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Eliminar</button>
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
                    <th>Número de vuelo</th>
                    <th>Fecha de llegada</th>
                    <th>Hora de llegada</th>
                    <th>Origen del vuelo llegada</th>
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
                $roundTripBookings = $controller->showRoundTripBookings();
                foreach ($roundTripBookings as $row_booking) { ?>
                    <tr>
                        <td><?= $row_booking['tipo_reserva_descripcion']; ?></td>
                        <td><?= $row_booking['localizador']; ?></td>
                        <td><?= $row_booking['email_cliente']; ?></td>
                        <td><?= $row_booking['fecha_reserva']; ?></td>
                        <td><?= $row_booking['destino_nombre_hotel']; ?></td>
                        <td><?= $row_booking['numero_vuelo_entrada']; ?></td>
                        <td><?= $row_booking['fecha_entrada']; ?></td>
                        <td><?= $row_booking['hora_entrada']; ?></td>
                        <td><?= $row_booking['origen_vuelo_entrada']; ?></td>
                        <td><?= $row_booking['fecha_vuelo_salida']; ?></td>
                        <td><?= $row_booking['hora_vuelo_salida']; ?></td>
                        <td><?= $row_booking['hora_recogida_salida']; ?></td>
                        <td><?= $row_booking['num_viajeros']; ?></td>
                        <td><?= $row_booking['vehiculo_descripcion']; ?></td>
                        <td>
                            <form action="index.php?page=customerPanel" method="POST" style="display:inline;">
                                <button type="button" class="btn btn-sm btn-warning editRoundTripBooking" data-bs-toggle="modal" data-bs-target="#editRoundTripModal"
                                    data-id="<?= $row_booking['id_reserva']; ?>"
                                    data-localizador="<?= $row_booking['localizador']; ?>"
                                    data-destino_nombre_hotel="<?= $row_booking['destino_nombre_hotel']; ?>"
                                    data-email_cliente="<?= $row_booking['email_cliente']; ?>"
                                    data-numero_vuelo_entrada="<?= $row_booking['numero_vuelo_entrada']; ?>"
                                    data-fecha_entrada="<?= $row_booking['fecha_entrada']; ?>"
                                    data-hora_entrada="<?= $row_booking['hora_entrada']; ?>"
                                    data-origen_vuelo_entrada="<?= $row_booking['origen_vuelo_entrada']; ?>"
                                    data-fecha_vuelo_salida="<?= $row_booking['fecha_vuelo_salida']; ?>"
                                    data-hora_vuelo_salida="<?= $row_booking['hora_vuelo_salida']; ?>"
                                    data-hora_recogida_salida="<?= $row_booking['hora_recogida_salida']; ?>"
                                    data-num_viajeros="<?= $row_booking['num_viajeros']; ?>"
                                    data-vehiculo_descripcion="<?= $row_booking['vehiculo_descripcion']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </button>
                            </form>
                            <form action="index.php?page=customerPanel" method="POST" style="display:inline;">
                                <input type="hidden" name="deleteBooking" value="1">
                                <input type="hidden" name="id_reserva" value="<?= $row_booking['id_reserva']; ?>">
                                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Acción para los modales de edición -->
<script>
    // selector para modificar onewaybooking
    document.querySelectorAll('.editOneWayBooking').forEach(button => {
        button.addEventListener('click', function() {
            // Obtener los valores de los atributos de datos (data-* attributes) del botón
            document.getElementById('uuid').value = this.dataset.localizador;
            document.getElementById('customerEmail').value = this.dataset.email_cliente;
            document.getElementById('ebookingDate').value = this.dataset.fecha_entrada;
            document.getElementById('ebookingTime').value = this.dataset.hora_entrada;
            document.getElementById('eflyNumer').value = this.dataset.numero_vuelo_entrada;
            document.getElementById('eoriginAirport').value = this.dataset.origen_vuelo_entrada;

            const hotelName = button.dataset.destino_nombre_hotel;
            const carName = button.dataset.vehiculo_descripcion;

            [...document.getElementById('ehotelSelect').options].forEach(opt => {
                if (opt.text === hotelName) opt.selected = true;
            });
            [...document.getElementById('ecarSelect').options].forEach(opt => {
                if (opt.text === carName) opt.selected = true;
            });

            document.getElementById('epassengerNum').value = button.dataset.num_viajeros;
        });
    });

    // selector para modificar returnbooking
    document.querySelectorAll('.editReturnBooking').forEach(button => {
        button.addEventListener('click', function() {
            // Obtener los valores de los atributos de datos (data-* attributes) del botón
            document.getElementById('ruuid').value = this.dataset.localizador;
            document.getElementById('customerEmail').value = this.dataset.email_cliente;
            document.getElementById('rdateFly').value = this.dataset.fecha_vuelo_salida;
            document.getElementById('rtimeFly').value = this.dataset.hora_vuelo_salida;
            document.getElementById('rpickupTime').value = this.dataset.hora_recogida_salida;

            const hotelName = button.dataset.destino_nombre_hotel;
            const carName = button.dataset.vehiculo_descripcion;

            [...document.getElementById('rhotelSelect').options].forEach(opt => {
                if (opt.text === hotelName) opt.selected = true;
            });
            [...document.getElementById('rcarSelect').options].forEach(opt => {
                if (opt.text === carName) opt.selected = true;
            });

            document.getElementById('rpassengerNum').value = button.dataset.num_viajeros;
        });
    });

    // selector para modificar roundtripbooking
    document.querySelectorAll('.editRoundTripBooking').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('rtuuid').value = this.dataset.localizador;
            document.getElementById('customerEmail').value = this.dataset.email_cliente;
            document.getElementById('rtbookingDate').value = this.dataset.fecha_entrada;
            document.getElementById('rtbookingTime').value = this.dataset.hora_entrada;
            document.getElementById('rtflyNumer').value = this.dataset.numero_vuelo_entrada;
            document.getElementById('rtoriginAirport').value = this.dataset.origen_vuelo_entrada;
            document.getElementById('rtdateFly').value = this.dataset.fecha_vuelo_salida;
            document.getElementById('rttimeFly').value = this.dataset.hora_vuelo_salida;
            document.getElementById('rtpickupTime').value = this.dataset.hora_recogida_salida;

            const hotelName = this.dataset.destino_nombre_hotel;
            const carName = this.dataset.vehiculo_descripcion;

            [...document.getElementById('rthotelSelect').options].forEach(opt => {
                opt.selected = opt.text === hotelName;
            });

            [...document.getElementById('rtdhotelSelect').options].forEach(opt => {
                opt.selected = opt.text === hotelName;
            });

            document.getElementById('rtpassengerNum').value = this.dataset.num_viajeros;

            [...document.getElementById('rtcarSelect').options].forEach(opt => {
                opt.selected = opt.text === carName;
            });
        });
    });
</script>