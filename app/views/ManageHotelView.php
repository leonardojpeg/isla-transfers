<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../views/Modals/EditManageHotelModal.php';
require_once __DIR__ . '/../views/Modals/NewManageHotelModal.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fa-solid fa-hotel me-2"></i>Lista de hoteles registrados
        </h2>
        <button type="button" class="btn btn-primary fw-bold shadow-sm d-flex align-items-center"
            data-bs-toggle="modal" data-bs-target="#newManageHotel">
            <i class="fa-solid fa-square-h me-2"></i> Añadir hotel
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Nombre del hotel</th>
                            <th>Zona del hotel</th>
                            <th>Comisión</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require __DIR__ . '/../controllers/HotelController.php';
                        $controller = new HotelController();
                        $hotels = $controller->showHotels();
                        foreach ($hotels as $row_hotel) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row_hotel['nombre_hotel']); ?></td>
                                <td><?= htmlspecialchars($row_hotel['descripcion_zona']); ?></td>
                                <td><?= htmlspecialchars($row_hotel['comision']); ?>%</td>
                                <td><?= htmlspecialchars($row_hotel['email_hotel']); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button"
                                            class="btn btn-sm btn-warning editManageHotel"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editManageHotel"
                                            data-id="<?= $row_hotel['id_hotel']; ?>"
                                            data-nombre_hotel="<?= $row_hotel['nombre_hotel']; ?>"
                                            data-descripcion_zona="<?= $row_hotel['descripcion_zona']; ?>"
                                            data-comision="<?= $row_hotel['comision']; ?>"
                                            data-email_hotel="<?= $row_hotel['email_hotel']; ?>"
                                            data-password="<?= $row_hotel['password']; ?>">
                                            <i class="fa-solid fa-pen-to-square me-1"></i>Editar
                                        </button>

                                        <form action="index.php?page=manageHotel" method="POST">
                                            <input type="hidden" name="deleteHotel" value="1">
                                            <input type="hidden" name="id_hotel" value="<?= $row_hotel['id_hotel'] ?? ''; ?>">
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
    // selector para modificar hoteles
    document.querySelectorAll('.editManageHotel').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('ehotelName').value = this.dataset.nombre_hotel;
            document.getElementById('ehotelCommission').value = this.dataset.comision;
            document.getElementById('ehotelEmail').value = this.dataset.email_hotel;
            document.getElementById('ehotelPassword').value = this.dataset.password;
            document.getElementById('eid_hotel').value = this.dataset.id;

            const zoneSelect = button.dataset.descripcion_zona;
            [...document.getElementById('ezoneSelect').options].forEach(opt => {
                if (opt.text === zoneSelect) opt.selected = true;
            });
        });
    });
</script>