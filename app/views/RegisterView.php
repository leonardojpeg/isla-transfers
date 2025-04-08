<div class="container col-8 p-4" style="padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.2); position: relative; margin: 100px auto; transform: none; top: auto; left: auto;">
    <form action="index.php?page=register" method="POST">
        <!-- Fila 1 (Nombre y Apellidos) -->
        <div class="row mb-3">
            <h3 class="p-4">Formulario de registro nuevo usuario</h3>
            <div class="col-md-4">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" placeholder="Ingrese su nombre" required>
            </div>
            <div class="col-md-4">
                <label for="apellido1" class="form-label">Apellido 1</label>
                <input type="text" class="form-control" name="apellido1" placeholder="Ingrese su primer apellido" required>
            </div>
            <div class="col-md-4">
                <label for="apellido2" class="form-label">Apellido 2</label>
                <input type="text" class="form-control" name="apellido2" placeholder="Ingrese su segundo apellido" required>
            </div>
        </div>

        <!-- Fila 2 (Dirección y Código Postal) -->
        <div class="row mb-3">
            <div class="col-md-8">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccion" placeholder="Ingrese su dirección" required>
            </div>
            <div class="col-md-4">
                <label for="codigoPostal" class="form-label">Código Postal</label>
                <input type="text" class="form-control" name="codigoPostal" placeholder="Ingrese su código postal" required>
            </div>
        </div>

        <!-- Fila 3 (Ciudad y País) -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="ciudad" class="form-label">Ciudad</label>
                <input type="text" class="form-control" name="ciudad" placeholder="Ingrese su ciudad" required>
            </div>
            <div class="col-md-6">
                <label for="pais" class="form-label">País</label>
                <input type="text" class="form-control" name="pais" placeholder="Ingrese su país" required>
            </div>
        </div>

        <!-- Fila 4 (Correo y Contraseña) -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="email" placeholder="Ingrese su correo electrónico" required>
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" placeholder="Ingrese su contraseña" required>
            </div>
        </div>

        <!-- Fila 5 (Botón Registrar en el centro) -->
        <div class="row mb-3">
            <div class="col-md-4 offset-md-4">
                <button type="submit" class="btn btn-primary w-100" name="btn-register" value="Registrar">Registrar</button>
            </div>
        </div>
    </form>
</div>
