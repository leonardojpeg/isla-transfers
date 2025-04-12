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

        //  solo un admin logueado pueda acceder a ?page=adminPanel
        case 'adminPanel':
            session_start();
            if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
                header('Location: index.php?page=login');
                exit;
            }
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

    if (isset($_GET['action']) && $_GET['action'] === 'crearReserva') {
        require_once __DIR__ . '/../app/controllers/ReserveController.php';
        $controller = new ReserveController();
        $controller->create();
    }

    
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
}

require_once __DIR__ . '/../app/views/footer.php';

ob_end_flush();
?>