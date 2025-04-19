<?php

require_once __DIR__ . '/../../../config/db.php';

?>


<!-- Modal -->
<div class="modal fade" id="newManageCar" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="customerModalLabel">Registrar vehículo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?page=manageCar" method="POST">
                    <input type="hidden" name="submitNewManageCar" value="1">
                    <input type="hidden" name="id_car" id="eid_car">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="description" class="form-label">Descripción</label>
                            <input type="text" id="description" name="description" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="carEmail" class="form-label">Email del conductor</label>
                            <input type="email" name="carEmail" id="carEmail" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="carPassword" class="form-label">Nueva contraseña</label>
                            <input type="password" name="carPassword" id="carPassword" class="form-control" required>
                        </div>

                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cerrar</button>
                        <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Añadir vehículo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>