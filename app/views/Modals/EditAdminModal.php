<?php
require_once __DIR__ . '/../../../config/db.php';
?>

<!-- Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="customerModalLabel">Modificar reserva</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBookingForm" action="index.php?page=adminPanel" method="POST">
                    <input type="hidden" name="submitEditAdminBooking" value="1">
                    <input type="hidden" id="reservaTipo" value="">
                    <input type="hidden" id="editIdReserva" name="id_reserva">

                    <!-- BLOQUE: Datos entrada (IDA) -->
                    <div id="bloqueIda">
                        <h6 class="mb-3">Datos de entrada</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Localizador</label>
                                <input type="text" id="uuid" name="uuid" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email cliente</label>
                                <input type="text" name="customerEmail" id="adcustomerEmail" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Día de llegada</label>
                                <input type="date" name="bookingDate" id="adbookingDate" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hora de llegada</label>
                                <input type="time" name="bookingTime" id="adbookingTime" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Número de vuelo</label>
                                <input type="text" name="flyNumer" id="adflyNumer" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Aeropuerto de origen</label>
                                <input type="text" name="originAirport" id="adoriginAirport" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <?php
                                global $pdo;
                                $stmt = $pdo->query("SELECT id_hotel, nombre_hotel FROM transfer_hotel");
                                ?>
                                <label class="form-label">Hotel de destino</label>
                                <select class="form-select" name="hotelSelect" id="adhotelSelect">
                                    <option selected>Selecionar...</option>
                                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?= $row['id_hotel'] ?>"><?= $row['nombre_hotel'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- BLOQUE: Datos salida (VUELTA) -->
                    <div id="bloqueVuelta">
                        <h6 class="mt-2 mb-3">Datos de salida</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Día del vuelo</label>
                                <input type="date" name="dateFly" id="addateFly" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hora del vuelo</label>
                                <input type="time" name="timeFly" id="adtimeFly" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Hora de recogida</label>
                                <input type="time" name="pickupTime" id="adpickupTime" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <?php
                                $stmt = $pdo->query("SELECT id_hotel, nombre_hotel FROM transfer_hotel");
                                ?>
                                <label class="form-label">Hotel de recogida</label>
                                <select class="form-select" name="hotelSelect" id="addhotelSelect">
                                    <option selected>Selecionar...</option>
                                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?= $row['id_hotel'] ?>"><?= $row['nombre_hotel'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- BLOQUE: Común -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Número de pasajeros</label>
                            <input type="number" name="passengerNum" id="adpassengerNum" class="form-control" required min="1">
                        </div>
                        <div class="col-md-6">
                            <?php
                            $stmt = $pdo->query("SELECT id_vehiculo, descripcion FROM transfer_vehiculo");
                            ?>
                            <label class="form-label">Vehículo</label>
                            <select class="form-select" name="carSelect" id="adcarSelect">
                                <option selected>Selecionar...</option>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <option value="<?= $row['id_vehiculo'] ?>"><?= $row['descripcion'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-danger" onclick="eliminarReserva()">
                            <i class="fa-solid fa-trash"></i> Eliminar reserva
                        </button>
                        <div>
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                                <i class="fa-solid fa-xmark"></i> Cerrar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Modificar reserva
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Formulario de eliminación oculto -->
                <form id="deleteForm" action="index.php?page=adminPanel" method="POST" style="display: none;">
                    <input type="hidden" name="adminDeleteBooking" value="1">
                    <input type="hidden" name="id_reserva" id="idReservaToDeleteHidden">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
    function mostrarCamposEdit(tipo) {
        document.getElementById('bloqueIda').style.display = (tipo === '1' || tipo === '3') ? 'block' : 'none';
        document.getElementById('bloqueVuelta').style.display = (tipo === '2' || tipo === '3') ? 'block' : 'none';
        document.getElementById('reservaTipo').value = tipo;
    }

    function eliminarReserva() {
        if (confirm("¿Estás seguro de que deseas eliminar esta reserva?")) {
            const idReserva = document.getElementById('editIdReserva').value;
            document.getElementById('idReservaToDeleteHidden').value = idReserva;
            document.getElementById('deleteForm').submit();
            /*
            setTimeout(() => {
            location.reload();
            }, 50);*/
        }
    }
</script>