<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../views/Modals/OneWayModal.php';
require_once __DIR__ . '/../views/Modals/ReturnModal.php';
require_once __DIR__ . '/../views/Modals/RoundTripModal.php';

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
    <h1 class="pb-5">Panel de administración de clientes</h1>
    <div class="row justify-content-end">
        <div class="col-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#oneWayModal"><i class="fa-solid fa-circle-plus"></i> Reservar Aeropuerto-Hotel</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#returnModal"><i class="fa-solid fa-circle-plus"></i> Reservar Hotel-Aeropuerto</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roundTripModal"><i class="fa-solid fa-circle-plus"></i> Reservar ida-vuelta (Aeropuerto-Hotel/Hotel-Aeropuerto)</button>
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
                            <form action="index.php?page=customerPanel" method="POST" style="display:inline;">
                                <a href="index.php?action=editBooking&id=<?= $row_booking['id_reserva'] ?>" class="btn btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </a>
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
                foreach ($roundTripBookings as $row_booking) { ?>
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
                            <a href="#"
                                class="btn btn-warning edit-booking-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#editBookingModal"
                                data-id="<?= $row_booking['id_reserva'] ?>"
                                data-fecha="<?= $row_booking['fecha_entrada'] ?? '' ?>"
                                data-hora="<?= $row_booking['hora_entrada'] ?? '' ?>"
                                data-origen="<?= $row_booking['origen_vuelo_entrada'] ?? '' ?>"
                                data-vuelo="<?= $row_booking['numero_vuelo_entrada'] ?? '' ?>"
                                data-pasajeros="<?= $row_booking['num_viajeros'] ?>"
                                >
                                <i class="fa-solid fa-pen-to-square"></i> Editar
                            </a>

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
</div>

<!-- Modal para editar reservas antes de las 48 horas -->
<div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="index.php?page=customerPanel">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editBookingLabel">Editar reserva</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="updateBooking" value="1">
          <input type="hidden" name="id_reserva" id="edit_id_reserva">

          <div class="mb-3">
            <label for="edit_fecha" class="form-label">Fecha llegada</label>
            <input type="date" class="form-control" name="fecha_entrada" id="edit_fecha" required>
          </div>
          <div class="mb-3">
            <label for="edit_hora" class="form-label">Hora llegada</label>
            <input type="time" class="form-control" name="hora_entrada" id="edit_hora" required>
          </div>
          <div class="mb-3">
            <label for="edit_origen" class="form-label">Origen vuelo</label>
            <input type="text" class="form-control" name="origen_vuelo_entrada" id="edit_origen" required>
          </div>
          <div class="mb-3">
            <label for="edit_numero_vuelo" class="form-label">Número vuelo</label>
            <input type="text" class="form-control" name="numero_vuelo_entrada" id="edit_numero_vuelo" required>
          </div>
          <div class="mb-3">
            <label for="edit_num_viajeros" class="form-label">Nº de pasajeros</label>
            <input type="number" class="form-control" name="num_viajeros" id="edit_num_viajeros" required>
          </div>
          <div class="mb-3">
            <label for="edit_destino" class="form-label">ID Destino</label>
            <input type="number" class="form-control" name="id_destino" id="edit_destino" required>
          </div>
          <div class="mb-3">
            <label for="edit_vehiculo" class="form-label">ID Vehículo</label>
            <input type="number" class="form-control" name="id_vehiculo" id="edit_vehiculo" required>
          </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="action" value="updateBooking">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>

      </div>    
    </form>
  </div>
</div>


<!-- Acción para los modales de edición -->
<script>
document.querySelectorAll('.edit-booking-btn').forEach(button => {
    button.addEventListener('click', function () {
        document.getElementById('edit_id_reserva').value = this.dataset.id;
        document.getElementById('edit_fecha').value = this.dataset.fecha;
        document.getElementById('edit_hora').value = this.dataset.hora;
        document.getElementById('edit_origen').value = this.dataset.origen;
        document.getElementById('edit_numero_vuelo').value = this.dataset.vuelo;
        document.getElementById('edit_num_viajeros').value = this.dataset.pasajeros;
        document.getElementById('edit_destino').value = this.dataset.destino;
        document.getElementById('edit_vehiculo').value = this.dataset.vehiculo;
    });
});
</script>

