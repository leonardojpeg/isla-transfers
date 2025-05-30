<?php

require_once __DIR__ . '/../../../config/db.php';

?>


<!-- Modal -->
<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="customerModalLabel">Nueva reserva</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?page=customerPanel" method="POST">
                    <input type="hidden" name="submitReturnReservation" value="1">
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
                            <label for="dateFly" class="form-label">Día del vuelo</label>
                            <input type="date" name="dateFly" id="dateFly" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="timeFly" class="form-label">Hora del vuelo</label>
                            <input type="time" name="timeFly" id="timeFly" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="pickupTime" class="form-label">Hora de recogida</label>
                            <input type="time" name="pickupTime" id="pickupTime" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <?php
                            global $pdo;
                            $query = "SELECT id_hotel, nombre_hotel FROM transfer_hotel";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute();
                            ?>
                            <label for="hotelSelect" class="form-label">Hotel de recogida</label>
                            <select class="form-select" name="hotelSelect" id="hotelSelect">
                                <option selected>Selecionar...</option>
                                <?php while ($row_fleet = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <option value="<?php echo $row_fleet['id_hotel']; ?>"><?php echo $row_fleet['nombre_hotel']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="passengerNum" class="form-label">Número de pasajeros</label>
                            <input type="number" name="passengerNum" id="passengerNum" class="form-control" required min="1">
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
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cerrar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-download"></i> Registrar reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>