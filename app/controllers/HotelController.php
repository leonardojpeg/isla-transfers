<?php
require_once __DIR__ . '/../models/HotelModel.php';

class HotelController {

    public function showHotels(){
        $hotelModel = new HotelModel();
        $result = $hotelModel->showHotels();

        return $result;
    }

    public function updateHotel(){

        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitEditManageHotel'])){
            try {
                $id_hotel = $_POST['id_hotel'];
                $hotelName = $_POST['hotelName'];
                $zoneSelect = $_POST['zoneSelect'];
                $hotelCommission = $_POST['hotelCommission'];
                $hotelEmail = $_POST['hotelEmail'];
                $hotelPassword = $_POST['hotelPassword'];

                $hotelModel = new HotelModel();
                $result = $hotelModel->updateHotel($id_hotel, $hotelName, $zoneSelect, $hotelCommission, $hotelEmail, $hotelPassword);

                if($result){
                    echo "<script>
                            Swal.fire({
                                title: '¡Modificado!',
                                text: 'El hotel se ha modificado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=manageHotel';
                            });
                        </script>";
                        exit;
                }
            } catch (PDOException $e){
                echo "Error al modificar el hotel: " . $e->getMessage();
            }
        }
    }

    public function addHotel(){

        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitNewManageHotel'])){
            try {
                $hotelName = $_POST['hotelName'];
                $zoneSelect = $_POST['zoneSelect'];
                $hotelCommission = $_POST['hotelCommission'];
                $hotelEmail = $_POST['hotelEmail'];
                $hotelPassword = $_POST['hotelPassword'];

                $hotelModel = new HotelModel();
                $result = $hotelModel->addHotel($hotelName, $zoneSelect, $hotelCommission, $hotelEmail, $hotelPassword);

                if($result){
                    echo "<script>
                            Swal.fire({
                                title: '¡Registrado!',
                                text: 'El hotel se ha registrado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=manageHotel';
                            });
                        </script>";
                        exit;
                }
            } catch (PDOException $e){
                echo "Error al modificar el hotel: " . $e->getMessage();
            }
        }
    }

    public function deleteHotel(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteHotel'])) {
            try {
                $id_hotel = $_POST['id_hotel'];

                $hotelModel = new HotelModel();
                $result = $hotelModel->deleteHotel($id_hotel);

                if ($result){
                    echo "<script>
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: 'El hotel se ha eliminado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=manageHotel';
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