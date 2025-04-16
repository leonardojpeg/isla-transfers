<form action="index.php?action=updateBooking" method="POST">
    <input type="hidden" name="id_reserva" value="<?php echo $booking['id_reserva']; ?>">

    <label for="fecha_entrada">Fecha de entrada:</label>
    <input type="date" name="fecha_entrada" value="<?php echo $booking['fecha_entrada']; ?>" required>

    <label for="hora_entrada">Hora de entrada:</label>
    <input type="time" name="hora_entrada" value="<?php echo $booking['hora_entrada']; ?>" required>

    <label for="numero_vuelo_entrada">Número de vuelo:</label>
    <input type="text" name="numero_vuelo_entrada" value="<?php echo $booking['numero_vuelo_entrada']; ?>" required>

    <label for="origen_vuelo_entrada">Origen del vuelo:</label>
    <input type="text" name="origen_vuelo_entrada" value="<?php echo $booking['origen_vuelo_entrada']; ?>" required>

    <label for="id_destino">Destino:</label>
    <select name="id_destino">
        <!-- Opciones de destinos (se pueden cargar dinámicamente desde la base de datos) -->
    </select>

    <label for="num_viajeros">Número de viajeros:</label>
    <input type="number" name="num_viajeros" value="<?php echo $booking['num_viajeros']; ?>" required>

    <label for="id_vehiculo">Vehículo:</label>
    <select name="id_vehiculo">
        <!-- Opciones de vehículos (se pueden cargar dinámicamente desde la base de datos) -->
    </select>

    <button type="submit" name="updateBooking">Actualizar Reserva</button>
</form>
