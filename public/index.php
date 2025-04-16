
<?php

//Mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

require_once __DIR__ . '/../app/views/header.php';

// Verificamos la página que se ha solicitado, si no hay página se redirecciona al WelcomeView.php
$page = isset($_GET['page']) ? $_GET['page'] : 'welcome';

// Switch para acceder a las diferentes vistas
switch ($page) {
    case 'welcome':
        require_once __DIR__ . '/../app/views/WelcomeView.php';
        break;

    case 'customerPanel':
        require_once __DIR__ . '/../app/views/CustomerView.php';
        break;
    case 'adminPanel':
        require_once __DIR__ . '/../app/views/AdminView.php';
        break;
    
    case 'corpPanel':
        require_once __DIR__ . '/../app/views/CorpView.php';
        break;

    case 'login':
        require_once __DIR__ . '/../app/views/LoginView.php';
        break;

    case 'logout':
        require_once __DIR__ . '/../app/controllers/LogoutController.php';
        break;

    case 'userEditProfile':
        require_once __DIR__ . '/../app/views/UserEditView.php';
        break;

    case 'register':
        require_once __DIR__ . '/../app/views/RegisterView.php';
        break;
        
    default:
        echo "<h2>Página no encontrada</h2>";
        break;
}

// Procesamiento de formularios POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btn-register'])) {
        require_once __DIR__ . '/../app/controllers/RegisterController.php';
        $controller = new RegisterController();
        $controller->register();
    }

    if (isset($_POST['submitLogin'])) {
        require_once __DIR__ . '/../app/controllers/LoginController.php';
        $controller = new LoginController();
        $controller->logIn();
    }

    if (isset($_POST['submitEdit'])) {
        require_once __DIR__ . '/../app/controllers/UserEditController.php';
        $controller = new UserEditController();
        $controller->editProfile();
    }

    if(isset($_POST['submitOneWayReservation'])){
        require_once __DIR__ . '/../app/controllers/CustomerController.php';
        $controller = new CustomerController();
        $controller->addOneWayBooking();
    }

    if(isset($_POST['submitReturnReservation'])){
        require_once __DIR__ . '/../app/controllers/CustomerController.php';
        $controller = new CustomerController();
        $controller->addReturnBooking();
    }
    
    if(isset($_POST['submitRoundTripReservation'])){
        require_once __DIR__ . '/../app/controllers/CustomerController.php';
        $controller = new CustomerController();
        $controller->addRoundTripBooking();
    }

    if(isset($_POST['deleteBooking'])){
        require_once __DIR__ . '/../app/controllers/CustomerController.php';
        $controller = new CustomerController();
        $controller->deleteBooking();
    }

    if(isset($_POST['submitOneWayAdminReservation'])){
        require_once __DIR__ . '/../app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->addOneWayBooking();
    }

    if(isset($_POST['submitReturnAdminReservation'])){
        require_once __DIR__ . '/../app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->addReturnBooking();
    }

    if(isset($_POST['submitRoundTripAdminReservation'])){
        require_once __DIR__ . '/../app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->addRoundTripBooking();
    }

   // Procesar acciones por GET para updateBooking 
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'updateBooking':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    require_once __DIR__ . '/../app/controllers/CustomerController.php';
                    $controller = new CustomerController();
                    $controller->updateBooking();
                    exit;
                }
                break;
        }
    }
    
    //procesar acción POST para enviar el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'updateBooking':
                require_once __DIR__ . '/../app/controllers/CustomerController.php';
                $controller = new CustomerController();
                $controller->updateBooking();
                break;
        }
    }
    


    if (isset($_GET['page']) && $_GET['page'] === 'apiReservas') {
        require_once __DIR__ . '/../public/apiReservas.php';
        exit;
    }    

}

require_once __DIR__ . '/../app/views/footer.php';
if (isset($_SESSION['flash_update_message'])) {
    echo "<script>alert('" . $_SESSION['flash_update_message'] . "');</script>";
    unset($_SESSION['flash_update_message']);
}

ob_end_flush();
?>