<?php

require_once __DIR__ . '/../../../config/db.php';

?>


<!-- Modal -->
<div class="modal fade" id="newManageHotel" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="customerModalLabel">Registrar hotel</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?page=manageHotel" method="POST">
                    <input type="hidden" name="submitNewManageHotel" value="1">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hotelName" class="form-label">Nombre hotel</label>
                            <input type="text" id="hotelName" name="hotelName" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <?php
                            global $pdo;
                            $query = "SELECT id_zona, descripcion FROM transfer_zona";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute();
                            ?>
                            <label for="zoneSelect" class="form-label">Zona hotel</label>
                            <select class="form-select" name="zoneSelect" id="zoneSelect">
                                <option selected>Selecionar...</option>
                                <?php while ($row_zone = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <option value="<?php echo $row_zone['id_zona']; ?>"><?php echo $row_zone['descripcion']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hotelCommission" class="form-label">Comisión</label>
                            <input type="number" name="hotelCommission" id="hotelCommission" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label for="hotelEmail" class="form-label">Email hotel</label>
                            <input type="email" name="hotelEmail" id="hotelEmail" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hotelPassword" class="form-label">Password hotel</label>
                            <input type="password" name="hotelPassword" id="hotelPassword" class="form-control" step="0.01" required>
                        </div>

                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cerrar</button>
                        <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-download"></i> Añadir hotel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>