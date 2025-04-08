<?php

require_once __DIR__ . '/../models/UserModel.php';

class LoginController {

    public function logIn(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitLogin'])){
            $email = $_POST['inputEmail'];
            $password = $_POST['inputPassword'];

            $userModel = new UserModel();
            $result = $userModel->requestLogIn($email, $password);

            if($result == 1){
                session_start();
                $user = $userModel -> getUserByEmail($email);
                
                if($user && $user['password'] === $password){
                    $_SESSION['nombre'] = $user['nombre'];
                    $_SESSION['apellido1'] = $user['apellido1'];
                    $_SESSION['id_viajero'] = $user['id_viajero'];

                    header("Location: index.php?page=home");
                    exit;
                }
            } else {
                header("Location: index.php?page=login&error=1");
                exit;
            }
        }
    }
}

?>