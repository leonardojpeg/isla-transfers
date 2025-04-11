<?php

require_once __DIR__ . '/../models/BookingModel.php';

class AdminController{

    public function addBooking(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $uuid = $_POST['uuid'];
                $bookingDate = $_POST['bookingDate'];
                $destination = $_POST['destinationSelect'];
                $locatorFly = $_POST['locatorFly'];
                $originFly = $_POST['originFly'];
                $departureDate = $_POST['departureDate'];
                $departureTime = $_POST['departureTime'];
                $passengerNum = $_POST['passengerNum'];
                $vehiculo = $_POST['fleetSelect'];

                $reserveType = 3;
                $email = $_SESSION['email'];

                $bookingModel = new BookingModel();
                $result = $bookingModel->addCustomerBooking($uuid, $bookingDate, $destination, $locatorFly, $originFly, $departureDate, $departureTime, $passengerNum, $vehiculo, $email, $reserveType);
                
                if($result){
                    $_SESSION['flash_add_message'] = "Reserva registrada correctamente";
                    header("Location: index.php?page=customerPanel");
                    exit;
                }
            } catch (PDOException $e) {
                echo "Error al registrar la reserva: " . $e->getMessage();
            }
        }
    }

    public function showBookings(){
        
        $bookingModel = new BookingModel();
        $result = $bookingModel->adminBookings();
        return $result;
    }

    public function deleteBooking(){

        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteBooking'])){
            try {
                $id_reserva = $_POST['id_reserva'];

                $bookingModel = new BookingModel();
                $resutl = $bookingModel->deleteBooking($id_reserva);

                if($resutl){
                    $_SESSION['flash_delete_message'] = "Reserva eliminada correctamente";
                    header("Location: index.php?page=customerPanel");
                    exit;
                }
            } catch (Exception $e){
                echo "Error al eliminar la reserva: " . $e->getMessage();
            }
        }
    }
}


?>