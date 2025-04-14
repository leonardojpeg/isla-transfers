<div class="container mt-5" style="max-width: 800px; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.2);">
    <h1 class="mb-4">Panel de administración</h1>

    <!-- Mensajes de éxito y error -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ¡Reserva creada con éxito!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Hubo un problema al procesar la reserva. Inténtalo de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <h4 class="mb-3">Crear nueva reserva</h4>

    <!-- Formulario de nueva reserva -->
    <form action="index.php?action=crearReserva" method="POST" id="formReserva">
        <div class="mb-3">
            <label for="tipoTrayecto" class="form-label">Tipo de trayecto:</label>
            <select name="tipoTrayecto" id="tipoTrayecto" class="form-select" required>
                <option value="">Selecciona una opción</option>
                <option value="ida">Aeropuerto → Hotel</option>
                <option value="vuelta">Hotel → Aeropuerto</option>
                <option value="ida_vuelta">Ida y Vuelta</option>
            </select>
        </div>

        <!-- Campos para trayecto de ida -->
        <div id="idaFields" style="display: none;">
            <h5>Datos de llegada (ida)</h5>
            <div class="mb-3">
                <label>Día de llegada:
                    <input type="date" name="dia_llegada" class="form-control">
                </label>
            </div>
            <div class="mb-3">
                <label>Hora de llegada:
                    <input type="time" name="hora_llegada" class="form-control">
                </label>
            </div>
            <div class="mb-3">
                <label>Número de vuelo:
                    <input type="text" name="num_vuelo_ida" class="form-control">
                </label>
            </div>
            <div class="mb-3">
                <label>Aeropuerto de origen:
                    <input type="text" name="aeropuerto_origen" class="form-control">
                </label>
            </div>
        </div>

        <!-- Campos para trayecto de vuelta -->
        <div id="vueltaFields" style="display: none;">
            <h5>Datos de regreso (vuelta)</h5>
            <div class="mb-3">
                <label>Día del vuelo:
                    <input type="date" name="dia_vuelo" class="form-control">
                </label>
            </div>
            <div class="mb-3">
                <label>Hora del vuelo:
                    <input type="time" name="hora_vuelo" class="form-control">
                </label>
            </div>
            <div class="mb-3">
                <label>Número de vuelo:
                    <input type="text" name="num_vuelo_vuelta" class="form-control">
                </label>
            </div>
            <div class="mb-3">
                <label>Hora de recogida:
                    <input type="time" name="hora_recogida" class="form-control">
                </label>
            </div>
        </div>

        <!-- Datos generales -->
        <div class="mb-3">
            <h5>Datos generales</h5>
            <label>Hotel destino o recogida:
                <input type="text" name="hotel" class="form-control" required>
            </label>
        </div>
        <div class="mb-3">
            <label>Número de viajeros:
                <input type="number" name="viajeros" class="form-control" required min="1">
            </label>
        </div>
        <div class="mb-3">
            <label>Email del cliente:
                <input type="email" name="email_cliente" class="form-control" required>
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Crear reserva</button>
    </form>

    <!-- Listado de reservas existentes -->
    <?php
    require_once __DIR__ . '/../controllers/ReserveController.php';
    $reservaController = new ReserveController();
    $reservas = $reservaController->mostrarReservas();
    ?>

    <hr class="my-5">
    <h4>Reservas existentes</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Localizador</th>
                <th>Email Cliente</th>
                <th>Fecha Reserva</th>
                <th>Tipo</th>
                <th>Nº Viajeros</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $res): ?>
                <tr>
                    <td><?= htmlspecialchars($res['localizador']) ?></td>
                    <td><?= htmlspecialchars($res['email_cliente']) ?></td>
                    <td><?= htmlspecialchars($res['fecha_reserva']) ?></td>
                    <td>
                        <?php
                        $tipos = [1 => 'Ida', 2 => 'Vuelta', 3 => 'Ida y vuelta'];
                        echo htmlspecialchars($tipos[$res['id_tipo_reserva']] ?? 'Desconocido');
                        ?>
                    </td>
                    <td><?= htmlspecialchars($res['num_viajeros']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    const tipoTrayecto = document.getElementById('tipoTrayecto');
    const idaFields = document.getElementById('idaFields');
    const vueltaFields = document.getElementById('vueltaFields');

    tipoTrayecto.addEventListener('change', function () {
        const value = this.value;
        idaFields.style.display = (value === 'ida' || value === 'ida_vuelta') ? 'block' : 'none';
        vueltaFields.style.display = (value === 'vuelta' || value === 'ida_vuelta') ? 'block' : 'none';
    });
</script>
<?php 
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../views/CustomerModal.php';

if(isset($_SESSION['flash_add_message'])){
    echo
    "<script>alert('" . $_SESSION['flash_add_message'] . "');</script>";
    unset($_SESSION['flash_add_message']);
}
if(isset($_SESSION['flash_delete_message'])){
    echo
    "<script>alert('" . $_SESSION['flash_delete_message'] . "');</script>";
    unset($_SESSION['flash_delete_message']);
}
?>

<div class="container py-3 mt-5">
    <h1>Panel de administración de administradores</h1>
    <div class="row justify-content-end">
        <div class="col-auto">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customerModal"><i class="fa-solid fa-circle-plus"></i> Nueva reserva</button>
        </div>
    </div>
    <table class="table table-sm table-striped trable-hover mt-4">
        <thead class="table-dark">
            <tr>
                <th>Realizada</th>
                <th>Localizador</th>
                <th>Email cliente</th>
                <th>Fecha reserva</th>
                <th>Destino</th>
                <th>Número vuelo entrada</th>
                <th>Origen vuelo entrada</th>
                <th>Hora vuelo salida</th>
                <th>Fecha vuelo salida</th>
                <th>Cantidad pasajeros</th>
                <th>Vehículo asignado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            require __DIR__ . '/../controllers/AdminController.php';
            $controller = new AdminController();
            $bookings = $controller->showBookings();

            foreach($bookings as $row_booking){ ?>
            <tr>
                <td><?= $row_booking['tipo_reserva_descripcion']; ?></td>
                <td><?= $row_booking['localizador']; ?></td>
                <td><?= $row_booking['email_cliente']; ?></td>
                <td><?= $row_booking['fecha_reserva']; ?></td>
                <td><?= $row_booking['id_destino']; ?></td>
                <td><?= $row_booking['numero_vuelo_entrada']; ?></td>
                <td><?= $row_booking['origen_vuelo_entrada']; ?></td>
                <td><?= $row_booking['fecha_vuelo_salida']; ?></td>
                <td><?= $row_booking['hora_vuelo_salida']; ?></td>
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
