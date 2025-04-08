    <!-- Formulario para el login con estilos de BootStrap -->
    <div class="container mt-5" style="width: 350px; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.2); position: relative; margin: 100px auto; transform: none; top: auto; left: auto;">
        <form action="index.php?=login" method="POST">
            <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    Email o contraseña incorrectos.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <img src="/images/login.jpg" class="login-image" alt="LoginImage" style="width: 100px; height: auto;">
                <h5>Iniciar sesión</h5>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Dirección correo electrónico</label>
                <input type="email" class="form-control" name="inputEmail" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Nunca compartiremos su correo electrónico con nadie más.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="inputPassword">
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="submitLogin">Enviar</button>
        </form>
    </div>