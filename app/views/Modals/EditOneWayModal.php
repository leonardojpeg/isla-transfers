<?php
require_once __DIR__ . '/../../../config/db.php';
?>


<!-- Modal -->
<div class="modal fade" id="editOneWayModal" tabindex="-1" aria-labelledby="editOneWayModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Modificar reserva</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?page=customerPanel" method="POST">
                    <input type="hidden" name="submitEditOneWayReservation" value="1">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="uuid" class="form-label">Localizador</label>
                            <input type="text" id="uuid" name="uuid" class="form-control" readonly>
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
                            <input type="date" name="bookingDate" id="ebookingDate" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="bookingTime" class="form-label">Hora de llegada</label>
                            <input type="time" name="bookingTime" id="ebookingTime" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="flyNumer" class="form-label">Número de vuelo</label>
                            <input type="text" name="flyNumer" id="eflyNumer" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="originAirport" class="form-label">Aeropuerto de origen</label>
                            <input type="text" name="originAirport" id="eoriginAirport" class="form-control" required>
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
                            <select class="form-select" name="hotelSelect" id="ehotelSelect">
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
                            <select class="form-select" name="carSelect" id="ecarSelect">
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
                            <input type="number" name="passengerNum" id="epassengerNum" class="form-control" required min="1">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cerrar</button>
                        <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Modificar reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>