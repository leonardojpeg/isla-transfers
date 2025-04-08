<?php

require_once __DIR__ . '/../models/UserModel.php';

class UserEditController {
    
    public function editProfile(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitEdit'])){
            $userId = $_SESSION['id_viajero'];
            $username = $_POST['nombre'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $result = $userModel -> updateUser($userId, $username, $email, $password);

            if($result){
                header("Location: index.php?page=home");
                exit;
            } else {
                echo "Error al actualizar el perfil";
            }
        }
    }
}

?>