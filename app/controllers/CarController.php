<?php
require_once __DIR__ . '/../models/CarModel.php';

class CarController {

    public function showCars(){
        $carModel = new CarModel();
        $result = $carModel->showCars();

        return $result;
    }

    public function updateCar(){

        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitEditManageCar'])){
            try {
                $id_car = $_POST['id_car'];
                $description = $_POST['description'];
                $carEmail = $_POST['carEmail'];
                $carPassword = $_POST['carPassword'];

                $carModel = new CarModel();
                $result = $carModel->updateCar($id_car, $description, $carEmail, $carPassword);

                if($result){
                    echo "<script>
                            Swal.fire({
                                title: 'Modificado!',
                                text: 'El vehículo se ha modificado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=manageCar';
                            });
                        </script>";
                        exit;
                }
            } catch (PDOException $e){
                echo "Error al modificar el vehículo: " . $e->getMessage();
            }
        }
    }

    public function addCar(){

        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitNewManageCar'])){
            try {
                $description = $_POST['description'];
                $carEmail = $_POST['carEmail'];
                $carPassword = $_POST['carPassword'];

                $carModel = new CarModel();
                $result = $carModel->addCar($description, $carEmail, $carPassword);

                if($result){
                    echo "<script>
                            Swal.fire({
                                title: 'Registrado!',
                                text: 'El vehículo se ha registrado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=manageCar';
                            });
                        </script>";
                        exit;
                }
            } catch (PDOException $e){
                echo "Error al modificar el vehículo: " . $e->getMessage();
            }
        }
    }

    public function deleteCar(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteCar'])) {
            try {
                $id_vehiculo = $_POST['id_car'];

                $carModel = new CarModel();
                $result = $carModel->deleteCar($id_vehiculo);

                if ($result){
                    echo "<script>
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: 'El vehículo se ha eliminado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=manageCar';
                            });
                        </script>";
                        exit;
                }
            } catch (PDOException $e){
                echo "Error al eliminar el vehículo: " . $e->getMessage();
            }
        }
    }
}
?>