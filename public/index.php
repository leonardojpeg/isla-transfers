<?php
ob_start();
require_once __DIR__ . '/../app/views/header.php';

// verificamos la página que se está solicitando
if (isset($_GET['page'])){
    $page = $_GET['page'];

    if($page == 'welcome'){
        require_once __DIR__ . '/../app/views/WelcomeView.php';
    }

    // si se llama a "home" accedemos a index.php
    if($page == 'home'){
        require_once __DIR__ . '/../public/index.php';
    }

    // si se llama a "login" accedemos a LoginView.php
    if($page == 'login'){
        require_once __DIR__ . '/../app/views/LoginView.php';
    }

    // si se llama a "logout" desde el navbar accedemos al LogoutController.php, eliminará la sesión activa
    if($page == 'logout'){
        require_once __DIR__ . '/../app/controllers/LogoutController.php';
    }

    //si se llama a "userEditProfile" desde el navbar accederemos al UserEditController.php, podremos editar los datos del usuario
    if ($page == 'userEditProfile'){
        require_once __DIR__ . '/../app/views/UserEditView.php';
    }

    // si se llama a "register" accedemos a RegisterView.php
    if($page == 'register'){
        require_once __DIR__ . '/../app/views/RegisterView.php';
    }
}

// verificamos la petición "POST", instanciamos un objeto controlador y ejecutamos la función del controlador
if (($_SERVER['REQUEST_METHOD']) == 'POST' && isset($_POST['btn-register'])){
    require_once __DIR__ . '/../app/controllers/RegisterController.php';
    $controller = new RegisterController();
    $controller -> register();
}

// verificamos la petición "POST", instanciamos un objeto controlador y ejecutamos la función del controlador
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitLogin'])){
    require_once __DIR__ . '/../app/controllers/LoginController.php';
    $controller = new LoginController();
    $controller -> logIn();
}

// verificamos la petición "POST", instanciamos un objeto controllador y ejecutamos la función del controlador
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitEdit'])){
    require_once __DIR__ . '/../app/controllers/UserEditController.php';
    $controller = new UserEditController();
    $controller -> editProfile();
}

?>

<?php

require_once __DIR__ . '/../app/views/footer.php';

ob_end_flush();
?>