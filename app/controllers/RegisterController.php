<?php

require_once __DIR__ . '/../models/UserModel.php';

class RegisterController {

    public function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn-register'])){
            $username = $_POST['nombre'];
            $surname = $_POST['apellido1'];
            $lastname = $_POST['apellido2'];
            $address = $_POST['direccion'];
            $cp = $_POST['codigoPostal'];
            $city = $_POST['ciudad'];
            $country = $_POST['pais'];
            $email = $_POST['email'];
            $password = $_POST['password']; 

            $userModel = new UserModel();
            $result = $userModel->registerUser($username, $surname, $lastname, $address, $cp, $city, $country, $email, $password);

            if($result){
                header("Location: index.php?page=login");
            } else {
                echo "Error al registrar el usuario.";
            }
        }
    }
}

?>