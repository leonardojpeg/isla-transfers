<?php

require_once __DIR__ . '/../../config/db.php';

// función para generar un UUID para el localizador
function uuidGenerator($long = 7)
{
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $caracteresLongitud = strlen($caracteres);
    $uuid = '';

    for ($i = 0; $i < $long; $i++) {
        $uuid .= $caracteres[random_int(0, $caracteresLongitud - 1)];
    }

    return $uuid;
}

?>


<!-- Modal -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="customerModalLabel">Nueva reserva</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?page=customerPanel" method="POST">
                    <input type="hidden" name="submitReservation" value="1">
                    <div class="mb-3">
                        <label for="uuid" class="form-label">Localizador</label>
                        <?php $newUUID = uuidGenerator() ?>
                        <input type="text" value="<?php echo $newUUID ?>" name="uuid" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="customerEmail" class="form-label">Email</label>
                        <?php if (isset($_SESSION['email'])) {
                            $email = $_SESSION['email'];
                        } ?>
                        <input type="text" id="customerEmail" name="customerEmail" placeholder="<?php echo $email ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="bookingDate" class="form-label">Fecha reserva</label>
                        <input type="date" name="bookingDate" id="bookingDate" class="form-contriol" required>
                    </div>
                    <div class="mb-3">
                        <?php
                        global $pdo;
                        $query = "SELECT id_destino, descripcion FROM transfer_destino";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        ?>
                        <label for="destinationSelect" class="form-label">Destino</label>
                        <select class="form-select" name="destinationSelect">
                            <option selected>Selecionar...</option>
                            <?php while ($row_dest = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <option value="<?php echo $row_dest['id_destino']; ?>"><?php echo $row_dest['descripcion']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="locatorFly" class="form-label">Número de vuelo</label>
                        <input type="text" name="locatorFly" id="locatorFly" class="form-contriol" required>
                    </div>
                    <div class="mb-3">
                        <label for="originFly" class="form-label">Origen del vuelo</label>
                        <input type="text" name="originFly" id="originFly" class="form-contriol" required>
                    </div>
                    <div class="mb-3">
                        <label for="departureDate" class="form-label">Fecha salida vuelo</label>
                        <input type="date" name="departureDate" id="departureDate" class="form-contriol" required>
                    </div>
                    <div class="mb-3">
                        <label for="departureTime" class="form-label">Hora salida vuelo</label>
                        <input type="time" name="departureTime" id="departureTime" class="form-contriol" required>
                    </div>
                    <div class="mb-3">
                        <label for="passengerNum" class="form-label">Número de pasajeros</label>
                        <input type="number" name="passengerNum" id="passengerNum" class="form-contriol" required>
                    </div>
                    <div class="mb-3">
                        <?php
                        global $pdo;
                        $query = "SELECT id_vehiculo, Descripción FROM transfer_vehiculo";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        ?>
                        <label for="fleet" class="form-label">Vehículo</label>
                        <select class="form-select" name="fleetSelect">
                            <option selected>Selecionar...</option>
                            <?php while ($row_fleet = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <option value="<?php echo $row_fleet['id_vehiculo']; ?>"><?php echo $row_fleet['Descripción']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-download"></i> Registrar reserva</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>