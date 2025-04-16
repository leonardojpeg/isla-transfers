<?php
if (isset($_SESSION['flash_delete_message'])) {
    echo
    "<script>alert('" . $_SESSION['flash_delete_message'] . "');</script>";
    unset($_SESSION['flash_delete_message']);
}

if (isset($_SESSION['flash_edit_message'])) {
    echo
    "<script>alert('" . $_SESSION['flash_edit_message'] . "');</script>";
    unset($_SESSION['flash_edit_message']);
}
?>

<!-- Tabla reservas ida -->
<div class="container py-5">
    <h5>Listado de reservas registradas</h5>
    <table class="table table-sm table-striped trable-hover mt-4">
        <thead class="table-dark">
            <tr>
                <th>Localizador</th>
                <th>Cliente</th>
                <th>Fecha reserva</th>
                <th>Fecha modificación</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require __DIR__ . '/../controllers/AdminController.php';
            $controller = new AdminController();
            $bookings = $controller->showBookings();
            foreach ($bookings as $row_booking) { ?>
                <tr>
                    <td><?= $row_booking['localizador']; ?></td>
                    <td><?= $row_booking['email_cliente']; ?></td>
                    <td><?= $row_booking['fecha_reserva']; ?></td>
                    <td><?= $row_booking['fecha_modificacion']; ?></td>
                    <td>
                        <form action="index.php?page=customerPanel" method="POST" style="display:inline;">
                            <button type="button" class="btn btn-sm btn-warning editOneWayBooking" data-bs-toggle="modal" data-bs-target="#editOneWayModal"
                                <i class="fa-solid fa-pen-to-square"></i> Editar
                            </button>
                        </form>
                        <form action="index.php?page=bookingList" method="POST" style="display:inline;">
                            <input type="hidden" name="adminDeleteBooking" value="1">
                            <input type="hidden" name="id_reserva" value="<?= $row_booking['id_reserva']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Eliminar</button>
                        </form>
                    </td>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>