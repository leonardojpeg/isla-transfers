<?php

require_once __DIR__ . '/../models/UserModel.php';

// Mostrar el formulario de edición del perfil del usuario
$userModel = new UserModel();
$userInfo = $userModel -> getUserInfo($_SESSION['id_viajero']);
?>

<div class="container col-4 p-4" style="padding: 30px; background: #fff; border-radius: 10px; box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.1); position: relative; margin: 100px auto;">
    <form action="index.php?page=editProfile" method="POST">
        <h3 class="text-center mb-4">Editar perfil</h3>

        <!-- Fila 1 (Nombre) -->
        <div class="row mb-3">
            <div class="col-12">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?= $userInfo['nombre']; ?>" required>
            </div>
        </div>

        <!-- Fila 2 (Correo Electrónico) -->
        <div class="row mb-3">
            <div class="col-12">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="email" value="<?= $userInfo['email']; ?>" required>
            </div>
        </div>

        <!-- Fila 3 (Contraseña) -->
        <div class="row mb-3">
            <div class="col-12">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" placeholder="Ingrese nueva contraseña">
            </div>
        </div>

        <!-- Botón de Guardar -->
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100 py-2" name="submitEdit" value="Guardar">Guardar Cambios</button>
            </div>
        </div>
    </form>
</div>