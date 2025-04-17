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
                    echo "<script>
                            Swal.fire({
                                title: '¡Registrada!',
                                text: 'La reserva se ha registrado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=adminPanel';
                            });
                        </script>";
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
                $pickupTime = $_POST['pickupTime'];
                $hotelSelect = $_POST['hotelSelect'];
                $carSelect = $_POST['carSelect'];
                $passengerNum = $_POST['passengerNum'];
                $customerEmail = $_POST['customerEmailSelect'];

                $reserveType = 2; // tipo Return (Hotel → Aeropuerto)

                $bookingModel = new BookingModel();
                $result = $bookingModel->addReturnBooking($uuid, $dateFly, $timeFly, $pickupTime, $hotelSelect, $carSelect, $passengerNum, $customerEmail, $reserveType);
                
                if($result){
                    echo "<script>
                            Swal.fire({
                                title: '¡Registrada!',
                                text: 'La reserva se ha registrado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=adminPanel';
                            });
                        </script>";
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
                    echo "<script>
                            Swal.fire({
                                title: '¡Registrada!',
                                text: 'La reserva se ha registrado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=adminPanel';
                            });
                        </script>";
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

    public function getAdminBooking(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitEditAdminBooking'])) {
            try {
                $uuid = $_POST['uuid'];
                $bookingDate = $_POST['bookingDate'];
                $bookingTime = $_POST['bookingTime'];
                $flyNumer = $_POST['flyNumer'];
                $originAirport = $_POST['originAirport'];
                $dateFly = $_POST['dateFly'];
                $timeFly = $_POST['timeFly'];
                $pickupTime = $_POST['pickupTime'];
                $hotelSelect = $_POST['hotelSelect'];
                $carSelect = $_POST['carSelect'];
                $passengerNum = $_POST['passengerNum'];
                $email = $_POST['email_cliente'];

                $bookingModel = new BookingModel();
                $result = $bookingModel->updateRoundTripBooking(
                    $uuid,
                    $bookingDate,
                    $bookingTime,
                    $flyNumer,
                    $originAirport,
                    $dateFly,
                    $timeFly,
                    $pickupTime,
                    $hotelSelect,
                    $carSelect,
                    $passengerNum,
                    $email
                );

                if ($result) {
                    echo "<script>
                            Swal.fire({
                                title: '¡Modificada!',
                                text: 'La reserva se ha modificado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=adminPanel';
                            });
                        </script>";
                        exit;
                } else {
                    echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'No se puede ha podido modificar la reserva',
                            icon: 'error'
                        }).then(() => {
                            window.location.href = 'index.php?page=adminPanel';
                        });
                    </script>";
                    exit;
                }
                header("Location: index.php?page=adminPanel");
                exit;
            } catch (PDOException $e) {
                $_SESSION['flash_edit_message'] = "Error al modificar la reserva: " . $e->getMessage();
                header("Location: index.php?page=adminPanel");
                exit;
            }
        }
    }

    public function updateAdminBooking(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitEditAdminBooking'])) {
            try {
                $uuid = $_POST['uuid'];
                $bookingDate = !empty($_POST['bookingDate']) ? $_POST['bookingDate'] : null;
                $bookingTime = !empty($_POST['bookingTime']) ? $_POST['bookingTime'] : null;
                $flyNumer = !empty($_POST['flyNumer']) ? $_POST['flyNumer'] : null;
                $originAirport = !empty($_POST['originAirport']) ? $_POST['originAirport'] : null;
                $dateFly = !empty($_POST['dateFly']) ? $_POST['dateFly'] : null;
                $timeFly = !empty($_POST['timeFly']) ? $_POST['timeFly'] : null;
                $pickupTime = !empty($_POST['pickupTime']) ? $_POST['pickupTime'] : null;
                $hotelSelect = !empty($_POST['hotelSelect']) ? $_POST['hotelSelect'] : null;
                $carSelect = !empty($_POST['carSelect']) ? $_POST['carSelect'] : null;
                $passengerNum = !empty($_POST['passengerNum']) ? $_POST['passengerNum'] : null;
                $email = $_POST['customerEmail'];

                $bookingModel = new BookingModel();
                $result = $bookingModel->updateRoundTripBooking(
                    $uuid,
                    $bookingDate,
                    $bookingTime,
                    $flyNumer,
                    $originAirport,
                    $dateFly,
                    $timeFly,
                    $pickupTime,
                    $hotelSelect,
                    $carSelect,
                    $passengerNum,
                    $email
                );

                if ($result) {
                    echo "<script>
                            Swal.fire({
                                title: '¡Modificada!',
                                text: 'La reserva se ha modificado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=bookingList';
                            });
                        </script>";
                        exit;
                } else {
                    echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'No se puede ha podido modificar la reserva',
                            icon: 'error'
                        }).then(() => {
                            window.location.href = 'index.php?page=bookingList';
                        });
                    </script>";
                    exit;
                }
                header("Location: index.php?page=adminPanel");
                exit;
            } catch (PDOException $e) {
                $_SESSION['flash_edit_message'] = "Error al modificar la reserva: " . $e->getMessage();
                header("Location: index.php?page=adminPanel");
                exit;
            }
        }
    }

    // elimina en bookingList
    public function deleteBooking(){

        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adminDeleteBooking'])){
            try {
                $id_reserva = $_POST['id_reserva'];

                $bookingModel = new BookingModel();
                $result = $bookingModel->deleteBooking($id_reserva);

                if($resutl){
                    echo "<script>
                            Swal.fire({
                                title: '¡Eliminada!',
                                text: 'La reserva se ha eliminado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=bookingList';
                            });
                        </script>";
                        exit;
                }
            } catch (Exception $e){
                echo "Error al eliminar la reserva: " . $e->getMessage();
            }
        }
    }
}


?>