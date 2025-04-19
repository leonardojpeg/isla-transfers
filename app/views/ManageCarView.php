<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../views/Modals/EditManageCarModal.php';
require_once __DIR__ . '/../views/Modals/NewManageCarModal.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
        <i class="fa-solid fa-car"></i> Lista de vehículos registrados
        </h2>
        <button type="button" class="btn btn-primary fw-bold shadow-sm d-flex align-items-center"
            data-bs-toggle="modal" data-bs-target="#newManageCar">
            <i class="fa-solid fa-car-side"></i>  Añadir vehículo
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Descripción del vehículo</th>
                            <th>Email del conductor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require __DIR__ . '/../controllers/CarController.php';
                        $controller = new CarController();
                        $cars = $controller->showCars();
                        foreach ($cars as $row_car) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row_car['descripcion']); ?></td>
                                <td><?= htmlspecialchars($row_car['email_conductor']); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button"
                                            class="btn btn-sm btn-warning editManageCar"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editManageCar"
                                            data-id="<?= $row_car['id_vehiculo']; ?>"
                                            data-descripcion="<?= $row_car['descripcion']; ?>"
                                            data-email_conductor="<?= $row_car['email_conductor']; ?>"
                                            data-password="<?= $row_car['password']; ?>">
                                            <i class="fa-solid fa-pen-to-square me-1"></i>Editar
                                        </button>

                                        <form action="index.php?page=manageCar" method="POST">
                                            <input type="hidden" name="deleteCar" value="1">
                                            <input type="hidden" name="id_car" value="<?= $row_car['id_vehiculo'] ?? ''; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash me-1"></i>Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Acción para el modal de edición -->
<script>
    // selector para modificar vehículos
    document.querySelectorAll('.editManageCar').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('eDescription').value = this.dataset.descripcion;
            document.getElementById('ecarEmail').value = this.dataset.email_conductor;
            document.getElementById('ecarPassword').value = this.dataset.password;
            document.getElementById('eid_car').value = this.dataset.id;
        });
    });
</script>