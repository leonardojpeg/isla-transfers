<?php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/AdminModel.php';

class LoginController {

    public function logIn(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitLogin'])){
            $user_type = $_POST['user_type'];
            $email = $_POST['inputEmail'];
            $password = $_POST['inputPassword'];

            $customerModel = new UserModel();
            $adminModel = new AdminModel();

            switch ($user_type){

                case "1":
                    $result = $customerModel->requestLogIn($email, $password);

                    if($result == 1){
                    session_start();
                    $user = $customerModel -> getUserByEmail($email);
                    
                    if($user && $user['password'] === $password){
                        $_SESSION['email'] = $email;
                        $_SESSION['id_viajero'] = $user['id_viajero'];
    
                        header("Location: index.php?page=customerPanel");
                        exit;
                    }
                    } else {
                        header("Location: index.php?page=login&error=1");
                    exit;
                    }
                   break;

                case "2":
                    echo "Transfer Administrador";
                    break;

                case "3":
                    $result = $adminModel->requestLogIn($email, $password);

                    if($result == 1){
                        session_start();
                        $user = $adminModel->getAdminByEmail($email);

                        if($user && $user['password'] === $password){
                            $_SESSION['email'] = $email;
                            $_SESSION['id_vehiculo'] = $user['id_vehiculo'];

                            header("Location: index.php?page=adminPanel");
                            exit;
                        }
                    } else {
                        header("Location: index.php?page=login&error=1");
                        exit;
                    }
                    break;
            }           
        }
    }
}

?>