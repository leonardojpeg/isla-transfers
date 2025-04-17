<?php
require_once __DIR__ . '/../views/Modals/EditAdminModal.php';

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

<!-- Tabla reservas ida -->
<div class="container py-5">
    <h5>Listado de reservas registradas</h5>
    <table class="table table-sm table-striped trable-hover mt-4">
        <thead class="table-dark">
            <tr>
                <th>Localizador</th>
                <th>Cliente</th>
                <th>Fecha reserva</th>
                <th>Fecha modificación</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require __DIR__ . '/../controllers/AdminController.php';
            $controller = new AdminController();
            $bookings = $controller->showBookings();
            foreach ($bookings as $row_booking) { ?>
                <tr>
                    <td><?= $row_booking['localizador']; ?></td>
                    <td><?= $row_booking['email_cliente']; ?></td>
                    <td><?= $row_booking['fecha_reserva']; ?></td>
                    <td><?= $row_booking['fecha_modificacion']; ?></td>
                    <td>
                        <form action="index.php?page=bookingList" method="POST" style="display:inline;">
                            <button type="button" class="btn btn-sm btn-warning editAdminBooking" data-bs-toggle="modal" data-bs-target="#editAdminModal"
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
                                data-vehiculo_descripcion="<?= $row_booking['vehiculo_descripcion']; ?>"
                                data-id_tipo_reserva="<?= $row_booking['id_tipo_reserva']; ?>">
                                <i class="fa-solid fa-pen-to-square"></i> Editar
                            </button>
                        </form>

                        <form action="index.php?page=bookingList" method="POST" style="display:inline;">
                            <input type="hidden" name="adminDeleteBooking" value="1">
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
<script>
    // selector para modificar reservas como administrador
    document.querySelectorAll('.editAdminBooking').forEach(button => {
        button.addEventListener('click', function () {
            const tipo = parseInt(this.dataset.id_tipo_reserva);

            // Mostrar secciones según el tipo de reserva
            const idaBlock = document.getElementById('bloqueIda');
            const vueltaBlock = document.getElementById('bloqueVuelta');

            if (tipo === 1) { // OneWay
                idaBlock.style.display = 'block';
                vueltaBlock.style.display = 'none';
            } else if (tipo === 2) { // Return
                idaBlock.style.display = 'none';
                vueltaBlock.style.display = 'block';
            } else if (tipo === 3) { // RoundTrip
                idaBlock.style.display = 'block';
                vueltaBlock.style.display = 'block';
            }

            // Rellenar campos del modal
            document.getElementById('sourceField').value = 'bookingList';
            document.getElementById('editIdReserva').value = this.dataset.id;
            document.getElementById('uuid').value = this.dataset.localizador;
            document.getElementById('adcustomerEmail').value = this.dataset.email_cliente;
            document.getElementById('adbookingDate').value = this.dataset.fecha_entrada;
            document.getElementById('adbookingTime').value = this.dataset.hora_entrada;
            document.getElementById('adflyNumer').value = this.dataset.numero_vuelo_entrada;
            document.getElementById('adoriginAirport').value = this.dataset.origen_vuelo_entrada;
            document.getElementById('addateFly').value = this.dataset.fecha_vuelo_salida;
            document.getElementById('adtimeFly').value = this.dataset.hora_vuelo_salida;
            document.getElementById('adpickupTime').value = this.dataset.hora_recogida_salida;

            const hotelName = this.dataset.destino_nombre_hotel;
            const carName = this.dataset.vehiculo_descripcion;

            [...document.getElementById('adhotelSelect').options].forEach(opt => {
                opt.selected = opt.text === hotelName;
            });

            [...document.getElementById('addhotelSelect').options].forEach(opt => {
                opt.selected = opt.text === hotelName;
            });

            document.getElementById('adpassengerNum').value = this.dataset.num_viajeros;

            [...document.getElementById('adcarSelect').options].forEach(opt => {
                opt.selected = opt.text === carName;
            });
        });
    });
</script>
