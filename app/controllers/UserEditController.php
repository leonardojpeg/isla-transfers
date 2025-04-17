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
                echo "<script>
                            Swal.fire({
                                title: '¡Actualizado!',
                                text: 'El perfil se ha modificado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=userEditProfile';
                            });
                        </script>";
                    exit;
            } else {
                echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al actualizar el perfil',
                            icon: 'error'
                        })
                    </script>";
                    exit;
            }
        }
    }

    public function adminEditProfile(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitAdminEdit'])){
            $adminId = $_SESSION['id_admin'];
            $username = $_POST['nombre'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $result = $userModel -> updateAdminUser($adminId, $username, $email, $password);

            if($result){
                echo "<script>
                            Swal.fire({
                                title: '¡Actualizado!',
                                text: 'El perfil se ha modificado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=userEditProfile';
                            });
                        </script>";
                    exit;
            } else {
                echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al actualizar el perfil',
                            icon: 'error'
                        })
                    </script>";
                    exit;
            }
        }
    }
}

?>