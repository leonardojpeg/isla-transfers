<?php
require_once __DIR__ . '/../views/Modals/EditAdminModal.php';

if (isset($_SESSION['flash_delete_message'])) {
    echo "<div class='alert alert-danger alert-dismissible fade show mt-3 mx-3' role='alert'>
            {$_SESSION['flash_delete_message']}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
    unset($_SESSION['flash_delete_message']);
}

if (isset($_SESSION['flash_edit_message'])) {
    echo "<div class='alert alert-success alert-dismissible fade show mt-3 mx-3' role='alert'>
            {$_SESSION['flash_edit_message']}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
    unset($_SESSION['flash_edit_message']);
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php?page=customerPanel');
    exit;
}
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fa-solid fa-list-check me-2"></i>Listado de reservas registradas
        </h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Localizador</th>
                            <th>Cliente</th>
                            <th>Fecha reserva</th>
                            <th>Última modificación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require __DIR__ . '/../controllers/AdminController.php';
                        $controller = new AdminController();
                        $bookings = $controller->showBookings();
                        foreach ($bookings as $row_booking) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row_booking['localizador']); ?></td>
                                <td><?= htmlspecialchars($row_booking['email_cliente']); ?></td>
                                <td><?= htmlspecialchars($row_booking['fecha_reserva']); ?></td>
                                <td><?= htmlspecialchars($row_booking['fecha_modificacion']); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-warning editAdminBooking"
                                            data-bs-toggle="modal" data-bs-target="#editAdminModal"
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
                                            <i class="fa-solid fa-pen-to-square me-1"></i>Editar
                                        </button>

                                        <form action="index.php?page=bookingList" method="POST">
                                            <input type="hidden" name="adminDeleteBooking" value="1">
                                            <input type="hidden" name="id_reserva" value="<?= $row_booking['id_reserva'] ?? ''; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash me-1"></i>Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Script para manejar edición de reservas
document.querySelectorAll('.editAdminBooking').forEach(button => {
    button.addEventListener('click', function () {
        const tipo = parseInt(this.dataset.id_tipo_reserva);

        document.getElementById('bloqueIda').style.display = tipo === 1 || tipo === 3 ? 'block' : 'none';
        document.getElementById('bloqueVuelta').style.display = tipo === 2 || tipo === 3 ? 'block' : 'none';

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

        [...document.getElementById('adhotelSelect').options].forEach(opt => {
            opt.selected = opt.text === this.dataset.destino_nombre_hotel;
        });

        [...document.getElementById('addhotelSelect').options].forEach(opt => {
            opt.selected = opt.text === this.dataset.destino_nombre_hotel;
        });

        document.getElementById('adpassengerNum').value = this.dataset.num_viajeros;

        [...document.getElementById('adcarSelect').options].forEach(opt => {
            opt.selected = opt.text === this.dataset.vehiculo_descripcion;
        });
    });
});
</script>
