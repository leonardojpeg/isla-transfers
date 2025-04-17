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
            $getUser = $userModel->getUserByEmail($email);

            if($getUser){
                echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Dirección de correo electrónico ya existe en el sistema',
                            icon: 'error'
                        })
                    </script>";
                    exit;
            } else {
                $result = $userModel->registerUser($username, $surname, $lastname, $address, $cp, $city, $country, $email, $password);
                if($result){
                    echo "<script>
                            Swal.fire({
                                title: '¡Registrado!',
                                text: 'El usuario se ha registrado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=login';
                            });
                        </script>";
                        exit;
                } else {
                    echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al registrar el nuevo usuario',
                            icon: 'error'
                        }).then(() => {
                            window.location.href = 'index.php?page=welcome';
                        });
                    </script>";
                    exit;
                }
            }
        }
    }
}

?>