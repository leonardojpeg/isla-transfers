<?php

require_once __DIR__ . '/../models/BookingModel.php';

class CustomerController{

    public function addOneWayBooking() {
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
    
                $reserveType = 1; //reserva de tipo Cliente
                $email = $_SESSION['email']; //obtenemos email de SESSION
    
                // Unificamos fecha y hora de la reserva
                $bookingDateTime = DateTime::createFromFormat('Y-m-d H:i', $bookingDate . ' ' . $bookingTime);
                $now = new DateTime();
    
                // Verificamos que la reserva sea con al menos 48 horas de antelación
                $diff = $now->diff($bookingDateTime);
                $hoursDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);
    
                if ($bookingDateTime < $now || $hoursDiff < 48) {
                    $_SESSION['flash_add_message'] = "Las reservas deben realizarse con al menos 48 horas de antelación.";
                    header("Location: index.php?page=customerPanel");
                    exit;
                }
    
                $bookingModel = new BookingModel();
                $result = $bookingModel->addOneWayBooking($uuid, $bookingDate, $bookingTime, $flyNumer, $originAirport, $hotelSelect, $carSelect, $passengerNum, $email, $reserveType);
                
                if ($result) {
                    $_SESSION['flash_add_message'] = "Reserva registrada correctamente";
                    header("Location: index.php?page=customerPanel");
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

                $reserveType = 1; //reserva de tipo Cliente
                $email = $_SESSION['email']; //obtenemos email de SESSION

                // Unificamos fecha y hora de la reserva
                $pickupDateTime = DateTime::createFromFormat('Y-m-d H:i', $dateFly . ' ' . $pickupTime);
                $now = new DateTime();

                // Verificamos que la reserva sea con al menos 48 horas de antelación
                $diff = $now->diff($pickupDateTime);
                $hoursDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);
                
                if ($pickupDateTime < $now || $hoursDiff < 48) {
                    $_SESSION['flash_add_message'] = "Las reservas deben realizarse con al menos 48 horas de antelación.";
                    header("Location: index.php?page=customerPanel");
                    exit;
                }

                $bookingModel = new BookingModel();
                $result = $bookingModel->addReturnBooking($uuid, $dateFly, $timeFly, $flyNumer, $pickupTime, $hotelSelect, $carSelect, $passengerNum, $email, $reserveType);
                
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

                $reserveType = 1; //reserva de tipo Cliente
                $email = $_SESSION['email']; //obtenemos email de SESSION

                // Validación 48h (basada en llegada aeropuerto)
                $bookingDateTime = DateTime::createFromFormat('Y-m-d H:i', $bookingDate . ' ' . $bookingTime);
                $now = new DateTime();

                $diff = $now->diff($bookingDateTime);
                $hoursDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);

                if ($bookingDateTime < $now || $hoursDiff < 48) {
                    $_SESSION['flash_add_message'] = "Las reservas deben realizarse con al menos 48 horas de antelación.";
                    header("Location: index.php?page=customerPanel");
                    exit;
                }

                $bookingModel = new BookingModel();
                $result = $bookingModel->addRoundTripBooking($uuid, $bookingDate, $bookingTime, $dateFly, $timeFly, $pickupTime, $flyNumer, $originAirport, $hotelSelect, $carSelect, $passengerNum, $email, $reserveType);
                
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

    public function showOneWayBookings(){
        $userEmail = $_SESSION['email'];

        $bookingModel = new BookingModel();

        $result = $bookingModel->getOneWayBookings($userEmail);

        return $result;
    }

    public function showReturnBookings(){
        $userEmail = $_SESSION['email'];

        $bookingModel = new BookingModel();

        $result = $bookingModel->getReturnBookings($userEmail);

        return $result;
    }

    public function showRoundTripBookings(){
        $userEmail = $_SESSION['email'];

        $bookingModel = new BookingModel();

        $result = $bookingModel->getRoundTripBookings($userEmail);

        return $result;
    }

    public function deleteBooking(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteBooking'])){
            try {
                $id_reserva = $_POST['id_reserva'];

                $bookingModel = new BookingModel();
                $booking = $bookingModel->getBookingById($id_reserva);

                if ($booking){
                    $now = new DateTime();
                    $validDateTimes = [];

                    if (!empty($booking['fecha_reserva']) && !empty($booking['hora_reserva'])) {
                        $oneWayDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $booking['fecha_reserva'] . ' ' . $booking['hora_reserva']);
                        if($oneWayDateTime !== false){
                            $validDateTimes[] = $oneWayDateTime;
                        }
                    }
    
                    if (!empty($booking['fecha_vuelo_salida']) && !empty($booking['hora_vuelo_salida'])) {
                        $returnDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $booking['fecha_vuelo_salida'] . ' ' . $booking['hora_vuelo_salida']);
                        if($returnDateTime !== false){
                            $validDateTimes[] = $returnDateTime;
                        }
                    }
    
                    if (empty($validDateTimes)) {
                        $_SESSION['flash_delete_message'] = "No se pudo validar la fecha de la reserva.";
                        header("Location: index.php?page=customerPanel");
                        exit;
                    }

                    foreach ($validDateTimes as $dateTime) {
                        $diff = $now->diff($dateTime);
                        $hoursDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);
    
                        if ($dateTime < $now || $hoursDiff < 48) {
                            $_SESSION['flash_delete_message'] = "No se puede eliminar la reserva porque falta menos de 48 horas.";
                            header("Location: index.php?page=customerPanel");
                            exit;
                        }
                    }

                    $result = $bookingModel->deleteBooking($id_reserva);
                    if($result){
                        $_SESSION['flash_delete_message'] = "Reserva eliminada correctamente";
                        header('Location: index.php?page=customerPanel');
                        exit;
                    }
                } else {
                    $_SESSION['flash_delete_message'] = "Reserva no encontrada";
                    header('Location: index.php?page=customerPanel');
                    exit;
                }
            } catch (Exception $e){
                echo "Error al eliminar la reserva: " . $e->getMessage();
            }
        }
    }


}
