<?php

require_once __DIR__ . '/../../../config/db.php';

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
<div class="modal fade" id="oneWayModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="customerModalLabel">Nueva reserva</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?page=customerPanel" method="POST">
                    <input type="hidden" name="submitOneWayReservation" value="1">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="uuid" class="form-label">Localizador</label>
                            <?php $newUUID = uuidGenerator() ?>
                            <input type="text" value="<?php echo $newUUID ?>" name="uuid" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="customerEmail" class="form-label">Email</label>
                            <?php if (isset($_SESSION['email'])) {
                                $email = $_SESSION['email'];
                            } ?>
                            <input type="text" id="customerEmail" name="customerEmail" placeholder="<?php echo $email ?>" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bookingDate" class="form-label">Día de llegada</label>
                            <input type="date" name="bookingDate" id="bookingDate" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="bookingTime" class="form-label">Hora de llegada</label>
                            <input type="time" name="bookingTime" id="bookingTime" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="flyNumer" class="form-label">Número de vuelo</label>
                            <input type="text" name="flyNumer" id="flyNumer" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="originAirport" class="form-label">Aeropuerto de origen</label>
                            <input type="text" name="originAirport" id="originAirport" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <?php
                            global $pdo;
                            $query = "SELECT id_hotel, nombre_hotel FROM transfer_hotel";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute();
                            ?>
                            <label for="hotelSelect" class="form-label">Hotel de destino</label>
                            <select class="form-select" name="hotelSelect" id="hotelSelect">
                                <option selected>Selecionar...</option>
                                <?php while ($row_fleet = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <option value="<?php echo $row_fleet['id_hotel']; ?>"><?php echo $row_fleet['nombre_hotel']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $query = "SELECT id_vehiculo, descripcion FROM transfer_vehiculo";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute();
                            ?>
                            <label for="carSelect" class="form-label">Vehículo</label>
                            <select class="form-select" name="carSelect" id="carSelect">
                                <option selected>Selecionar...</option>
                                <?php while ($row_fleet = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <option value="<?php echo $row_fleet['id_vehiculo']; ?>"><?php echo $row_fleet['descripcion']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="passengerNum" class="form-label">Número de pasajeros</label>
                            <input type="number" name="passengerNum" id="passengerNum" class="form-control" required min="1">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-download"></i> Registrar reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>