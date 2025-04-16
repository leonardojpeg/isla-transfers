<?php

require_once __DIR__ . '/../models/BookingModel.php';

class AdminController{

    public function addOneWayBooking(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $uuid = $_POST['uuid'];
                $bookingDate = $_POST['bookingDate'];
                $bookingTime = $_POST['bookingTime'];
                $flyNumer = $_POST['flyNumer'];
                $originAirport = $_POST['originAirport'];
                $hotelSelect = $_POST['hotelSelect'];
                $carSelect = $_POST['carSelect'];
                $passengerNum = $_POST['passengerNum'];
                $customerEmail = $_POST['customerEmailSelect'];
    
                $reserveType = 3; //reserva de tipo Administrador

                $bookingModel = new BookingModel();
                $result = $bookingModel->addOneWayBooking($uuid, $bookingDate, $bookingTime, $flyNumer, $originAirport, $hotelSelect, $carSelect, $passengerNum, $customerEmail, $reserveType);

                if ($result) {
                    $_SESSION['flash_add_message'] = "Reserva registrada correctamente";
                    header("Location: index.php?page=adminPanel");
                    exit;
                }
            } catch (PDOException $e) {
                echo "Error al registrar la reserva: " . $e->getMessage();
            }
        }
    }

    public function addReturnBooking(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            try {
                $uuid = $_POST['uuid'];
                $dateFly = $_POST['dateFly'];
                $timeFly = $_POST['timeFly'];
                $flyNumer = $_POST['flyNumer'];
                $pickupTime = $_POST['pickupTime'];
                $hotelSelect = $_POST['hotelSelect'];
                $carSelect = $_POST['carSelect'];
                $passengerNum = $_POST['passengerNum'];
                $customerEmail = $_POST['customerEmailSelect'];

                $reserveType = 3; //reserva de tipo Administrador

                $bookingModel = new BookingModel();
                $result = $bookingModel->addReturnBooking($uuid, $dateFly, $timeFly, $flyNumer, $pickupTime, $hotelSelect, $carSelect, $passengerNum, $customerEmail, $reserveType);
                
                if($result){
                    $_SESSION['flash_add_message'] = "Reserva registrada correctamente";
                    header("Location: index.php?page=adminPanel");
                    exit;
                }
            } catch (PDOException $e) {
                echo "Error al registrar la reserva: " . $e->getMessage();
            }
        }
    }

    public function addRoundTripBooking(){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            try {
                $uuid = $_POST['uuid'];
                $bookingDate = $_POST['bookingDate'];
                $bookingTime = $_POST['bookingTime'];
                $dateFly = $_POST['dateFly'];
                $timeFly = $_POST['timeFly'];
                $pickupTime = $_POST['pickupTime'];
                $flyNumer = $_POST['flyNumer'];
                $originAirport = $_POST['originAirport'];
                $hotelSelect = $_POST['hotelSelect'];
                $carSelect = $_POST['carSelect'];
                $passengerNum = $_POST['passengerNum'];
                $customerEmail = $_POST['customerEmailSelect'];

                $reserveType = 3; //reserva de tipo Administrador

                $bookingModel = new BookingModel();
                $result = $bookingModel->addRoundTripBooking($uuid, $bookingDate, $bookingTime, $dateFly, $timeFly, $pickupTime, $flyNumer, $originAirport, $hotelSelect, $carSelect, $passengerNum, $customerEmail, $reserveType);
                
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

        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adminDeleteBooking'])){
            try {
                $id_reserva = $_POST['id_reserva'];

                $bookingModel = new BookingModel();
                $resutl = $bookingModel->deleteBooking($id_reserva);

                if($resutl){
                    $_SESSION['flash_delete_message'] = "Reserva eliminada correctamente";
                    header("Location: index.php?page=bookingList");
                    exit;
                }
            } catch (Exception $e){
                echo "Error al eliminar la reserva: " . $e->getMessage();
            }
        }
    }
}

?>