<?php
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

    case 'bookingList':
        require_once __DIR__ . '/../app/views/BookingListView.php';
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

    if(isset($_POST['submitEditOneWayReservation'])){
        require_once __DIR__ . '/../app/controllers/CustomerController.php';
        $controller = new CustomerController();
        $controller->updateOneWayBooking();
    }

    if(isset($_POST['submitReturnReservation'])){
        require_once __DIR__ . '/../app/controllers/CustomerController.php';
        $controller = new CustomerController();
        $controller->addReturnBooking();
    }

    if(isset($_POST['submitEditReturnReservation'])){
        require_once __DIR__ . '/../app/controllers/CustomerController.php';
        $controller = new CustomerController();
        $controller->updateReturnBooking();
    }
    
    if(isset($_POST['submitRoundTripReservation'])){
        require_once __DIR__ . '/../app/controllers/CustomerController.php';
        $controller = new CustomerController();
        $controller->addRoundTripBooking();
    }

    if(isset($_POST['submitEditRoundTripReservation'])){
        require_once __DIR__ . '/../app/controllers/CustomerController.php';
        $controller = new CustomerController();
        $controller->updateRoundTripBooking();
    }

    if(isset($_POST['deleteBooking'])){
        require_once __DIR__ . '/../app/controllers/CustomerController.php';
        $controller = new CustomerController();
        $controller->deleteBooking();
    }

    if(isset($_POST['submitEditAdminBooking'])){
        require_once __DIR__ . '/../app/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->updateAdminBooking();
    }

    if(isset($_POST['adminDeleteBooking'])){
        require_once __DIR__ . '/../app/controllers/AdminController.php';
        $controller = new AdminController();
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

    

}

require_once __DIR__ . '/../app/views/footer.php';

ob_end_flush();
?>