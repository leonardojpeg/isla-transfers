<?php

require_once __DIR__ . '/../../../config/db.php';

?>


<!-- Modal -->
<div class="modal fade" id="editManageHotel" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="customerModalLabel">Modificar hotel</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?page=manageHotel" method="POST">
                    <input type="hidden" name="submitEditManageHotel" value="1">
                    <input type="hidden" name="id_hotel" id="eid_hotel">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hotelName" class="form-label">Nombre hotel</label>
                            <input type="text" id="ehotelName" name="hotelName" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <?php
                            global $pdo;
                            $query = "SELECT id_zona, descripcion FROM transfer_zona";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute();
                            ?>
                            <label for="zoneSelect" class="form-label">Zona hotel</label>
                            <select class="form-select" name="zoneSelect" id="ezoneSelect">
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
                            <input type="number" name="hotelCommission" id="ehotelCommission" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label for="hotelEmail" class="form-label">Email hotel</label>
                            <input type="email" name="hotelEmail" id="ehotelEmail" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hotelPassword" class="form-label">Nueva contraseña</label>
                            <input type="password" name="hotelPassword" id="ehotelPassword" class="form-control" required>
                        </div>

                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cerrar</button>
                        <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Modificar hotel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>