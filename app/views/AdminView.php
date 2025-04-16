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
    <form action="index.php?page=adminPanel&action=crearReserva" method="POST" id="formReserva">
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
