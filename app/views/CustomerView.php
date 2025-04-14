<?php 
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../views/CustomerModal.php';

if(isset($_SESSION['flash_add_message'])){
    echo
    "<script>alert('" . $_SESSION['flash_add_message'] . "');</script>";
    unset($_SESSION['flash_add_message']);
}
if(isset($_SESSION['flash_delete_message'])){
    echo
    "<script>alert('" . $_SESSION['flash_delete_message'] . "');</script>";
    unset($_SESSION['flash_delete_message']);
}
?>

<div class="container py-3 mt-5">
    <h1>Panel de administración de clientes</h1>
    <div class="row justify-content-end">
        <div class="col-auto">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customerModal"><i class="fa-solid fa-circle-plus"></i> Nueva reserva</button>
        </div>
    </div>
    <table class="table table-sm table-striped trable-hover mt-4">
        <thead class="table-dark">
            <tr>
                <th>Realizada</th>
                <th>Localizador</th>
                <th>Email cliente</th>
                <th>Fecha reserva</th>
                <th>Destino</th>
                <th>Número vuelo entrada</th>
                <th>Origen vuelo entrada</th>
                <th>Hora vuelo salida</th>
                <th>Fecha vuelo salida</th>
                <th>Cantidad pasajeros</th>
                <th>Vehículo asignado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            require __DIR__ . '/../controllers/CustomerController.php';
            $controller = new CustomerController();
            $bookings = $controller->showBookings();

            foreach($bookings as $row_booking){ ?>
            <tr>
                <td><?= $row_booking['tipo_reserva_descripcion']; ?></td>
                <td><?= $row_booking['localizador']; ?></td>
                <td><?= $row_booking['email_cliente']; ?></td>
                <td><?= $row_booking['fecha_reserva']; ?></td>
                <td><?= $row_booking['id_destino']; ?></td>
                <td><?= $row_booking['numero_vuelo_entrada']; ?></td>
                <td><?= $row_booking['origen_vuelo_entrada']; ?></td>
                <td><?= $row_booking['fecha_vuelo_salida']; ?></td>
                <td><?= $row_booking['hora_vuelo_salida']; ?></td>
                <td><?= $row_booking['num_viajeros']; ?></td>
                <td><?= $row_booking['vehiculo_descripcion']; ?></td>
                <td>
                <button type="button" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
                    <form action="index.php?page=customerPanel" method="POST" style="display:inline;">
                    <input type="hidden" name="deleteBooking" value="1">
                    <input type="hidden" name="id_reserva" value="<?= $row_booking['id_reserva']; ?>">
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Eliminar</button></td>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>