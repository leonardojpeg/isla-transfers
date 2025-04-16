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

    // public function getUpOneWayBooking(){
    //     if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateBooking'])){
    //         try {
    //             $id_reserva = $_POST['id_reserva'];

    //             $bookingModel = new BookingModel();
    //             $result = $bookingModel->getUpOneWayBooking($id_reserva);
    //         }
    //     }
    // }

    public function editBooking(){
        if (isset($_GET['id'])){
            $id_reserva = $_GET['id'];

            $bookingModel = new BookingModel();

            $booking = $bookingModel->getUpOneWayBooking($id_reserva);

            require_once __DIR__ . '/../controllers/updateBookingForm.php';
        } else {
            header('Location: index.php?page=customerPanel');
        }
    }

   /* public function updateBooking(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateBooking'])){
            try {
                $id_reserva = $_POST['id_reserva'];
                $fecha = $_POST['fecha_entrada'];
                $hora = $_POST['hora_entrada'];
                $vuelo = $_POST['numero_vuelo_entrada'];
                $origen = $_POST['origen_vuelo_entrada'];
                $destino = $_POST['id_destino'];
                $pasajeros = $_POST['num_viajeros'];
                $vehiculo = $_POST['id_vehiculo'];

                $bookingModel = new BookingModel();

                $result = $bookingModel->getUpOneWayBooking($id_reserva, $fecha, $hora, $vuelo, $origen, $destino, $pasajeros, $vehiculo);

                if($result){
                    $_SESSION['flash_update_message'] = "Reserva actualizada correctamente";
                    header('Location: index.php?page=customerPanel');
                    exit;
                }
            } catch (PDOException $e){
                echo "Error al actualizar la reserva: " . $e->getMessage();
            }
        }
    }*/


   public function updateBooking(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateBooking'])) {
            print_r($_POST);
            try {
                $id_reserva = $_POST['id_reserva'];
                $fecha = $_POST['fecha_entrada'];
                $hora = $_POST['hora_entrada'];
                $vuelo = $_POST['numero_vuelo_entrada'];
                $origen = $_POST['origen_vuelo_entrada'];
                $destino = $_POST['id_destino'];
                $pasajeros = $_POST['num_viajeros'];
                $vehiculo = $_POST['id_vehiculo'];
                //var_dump($fecha); // debería ser '2025-04-26'
                //var_dump($hora);  // debería ser '12:01' o '12:01:00' según cómo lo esté enviando el input
                                // Validación de 48 horas

                // --- Validación: que la reserva solo pueda actualizarse si faltan más de 48h ---
                $fechaHoraVuelo = DateTime::createFromFormat('Y-m-d H:i:s', $fecha . ' ' . $hora)
                ?: DateTime::createFromFormat('Y-m-d H:i', $fecha . ' ' . $hora);
                $now = new DateTime();
                // calcula la diferencia entre ahora y la fecha del vuelo
                $diff = $now->diff($fechaHoraVuelo);
                $hoursDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);
    
                if ($fechaHoraVuelo < $now || $hoursDiff < 48) {
                    echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'No se puede editar la reserva con menos de 48 horas de antelación',
                            icon: 'error'
                        }).then(() => {
                            window.location.href = 'index.php?page=customerPanel';
                        });
                    </script>";
                    exit;

                }
    
                // Guardar cambios
                $bookingModel = new BookingModel();
                 // Se llama al modelo para ejecutar el UPDATE
                $result = $bookingModel->updateOneWayBooking($id_reserva, $fecha, $hora, $vuelo, $origen, $destino, $pasajeros, $vehiculo);
                 // Si fue exitoso, mostrar mensaje y redirigir al panel del cliente
                if ($result) {
                    echo "<script>
                            Swal.fire({
                                title: '¡Actualizada!',
                                text: 'La reserva se ha guardado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=customerPanel';
                            });
                        </script>";
                    exit;

                }
    
            } catch (PDOException $e) {
                echo "Error al actualizar la reserva: " . $e->getMessage();
            }
        }
    }

    
    
}
