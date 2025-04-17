<?php

require_once __DIR__ . '/../models/BookingModel.php';

class CustomerController
{

    public function addOneWayBooking()
    {
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
                    echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Las reservas deben realizarse con al menos 48 horas de antelación',
                            icon: 'error'
                        }).then(() => {
                            window.location.href = 'index.php?page=customerPanel';
                        });
                    </script>";
                    exit;
                }

                $bookingModel = new BookingModel();
                $result = $bookingModel->addOneWayBooking($uuid, $bookingDate, $bookingTime, $flyNumer, $originAirport, $hotelSelect, $carSelect, $passengerNum, $email, $reserveType);

                if ($result) {
                    echo "<script>
                            Swal.fire({
                                title: '¡Registrada!',
                                text: 'La reserva se ha registrado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=customerPanel';
                            });
                        </script>";
                        exit;
                }
            } catch (PDOException $e) {
                echo "Error al registrar la reserva: " . $e->getMessage();
            }
        }
    }

    public function addReturnBooking()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $uuid = $_POST['uuid'];
                $dateFly = $_POST['dateFly'];
                $timeFly = $_POST['timeFly'];
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
                    echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Las reservas deben realizarse con al menos 48 horas de antelación',
                            icon: 'error'
                        }).then(() => {
                            window.location.href = 'index.php?page=customerPanel';
                        });
                    </script>";
                    exit;
                }

                $bookingModel = new BookingModel();
                $result = $bookingModel->addReturnBooking($uuid, $dateFly, $timeFly, $pickupTime, $hotelSelect, $carSelect, $passengerNum, $email, $reserveType);

                if ($result) {
                    echo "<script>
                            Swal.fire({
                                title: '¡Registrada!',
                                text: 'La reserva se ha registrado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=customerPanel';
                            });
                        </script>";
                        exit;
                }
            } catch (PDOException $e) {
                echo "Error al registrar la reserva: " . $e->getMessage();
            }
        }
    }

    public function addRoundTripBooking()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                    echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Las reservas deben realizarse con al menos 48 horas de antelación',
                            icon: 'error'
                        }).then(() => {
                            window.location.href = 'index.php?page=customerPanel';
                        });
                    </script>";
                    exit;
                }

                $bookingModel = new BookingModel();
                $result = $bookingModel->addRoundTripBooking($uuid, $bookingDate, $bookingTime, $dateFly, $timeFly, $pickupTime, $flyNumer, $originAirport, $hotelSelect, $carSelect, $passengerNum, $email, $reserveType);

                if ($result) {
                    echo "<script>
                            Swal.fire({
                                title: '¡Registrada!',
                                text: 'La reserva se ha registrado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=customerPanel';
                            });
                        </script>";
                        exit;
                }
            } catch (PDOException $e) {
                echo "Error al registrar la reserva: " . $e->getMessage();
            }
        }
    }

    public function showOneWayBookings()
    {
        $userEmail = $_SESSION['email'];

        $bookingModel = new BookingModel();

        $result = $bookingModel->getOneWayBookings($userEmail);

        return $result;
    }

    public function showReturnBookings()
    {
        $userEmail = $_SESSION['email'];

        $bookingModel = new BookingModel();

        $result = $bookingModel->getReturnBookings($userEmail);

        return $result;
    }

    public function showRoundTripBookings()
    {
        $userEmail = $_SESSION['email'];

        $bookingModel = new BookingModel();

        $result = $bookingModel->getRoundTripBookings($userEmail);

        return $result;
    }

    public function deleteBooking()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteBooking'])) {
            try {
                $id_reserva = $_POST['id_reserva'];

                $bookingModel = new BookingModel();
                $booking = $bookingModel->getBookingById($id_reserva);

                if ($booking) {
                    $now = new DateTime();
                    $validDateTimes = [];

                    if (!empty($booking['fecha_entrada']) && !empty($booking['hora_entrada'])) {
                        $oneWayDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $booking['fecha_entrada'] . ' ' . $booking['hora_entrada']);
                        if ($oneWayDateTime !== false) {
                            $validDateTimes[] = $oneWayDateTime;
                        }
                    }

                    if (!empty($booking['fecha_vuelo_salida']) && !empty($booking['hora_vuelo_salida'])) {
                        $returnDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $booking['fecha_vuelo_salida'] . ' ' . $booking['hora_vuelo_salida']);
                        if ($returnDateTime !== false) {
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
                            echo
                            "<script>
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Las eliminaciones deben realizarse con al menos 48 horas de antelación',
                                        icon: 'error'
                                    }).then(() => {
                                        window.location.href = 'index.php?page=customerPanel';
                                    });
                                </script>";
                            exit;
                        }
                    }

                    $result = $bookingModel->deleteBooking($id_reserva);
                    if ($result) {
                        echo "<script>
                            Swal.fire({
                                title: '¡Eliminada!',
                                text: 'La reserva se ha eliminado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=customerPanel';
                            });
                        </script>";
                        exit;
                    }
                } else {
                    echo
                            "<script>
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Reserva no encontrada',
                                        icon: 'error'
                                    }).then(() => {
                                        window.location.href = 'index.php?page=customerPanel';
                                    });
                                </script>";
                            exit;
                }
            } catch (Exception $e) {
                echo "Error al eliminar la reserva: " . $e->getMessage();
            }
        }
    }

    public function updateOneWayBooking()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitEditOneWayReservation'])) {
            try {
                $uuid = $_POST['uuid'];
                $bookingDate = $_POST['bookingDate'];
                $bookingTime = $_POST['bookingTime'];
                $flyNumer = $_POST['flyNumer'];
                $originAirport = $_POST['originAirport'];
                $hotelSelect = $_POST['hotelSelect'];
                $carSelect = $_POST['carSelect'];
                $passengerNum = $_POST['passengerNum'];
                $email = $_SESSION['email']; // obtenemos email de SESSION


                $bookingDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $bookingDate . ' ' . $bookingTime);
                $now = new DateTime();

                $diff = $now->diff($bookingDateTime);
                $hoursDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);

                if ($bookingDateTime < $now || $hoursDiff < 48) {
                    echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Las modificaciones deben realizarse con al menos 48 horas de antelación',
                            icon: 'error'
                        }).then(() => {
                            window.location.href = 'index.php?page=customerPanel';
                        });
                    </script>";
                    exit;
                }


                $bookingModel = new BookingModel();
                $result = $bookingModel->updateOneWayBooking($uuid, $bookingDate, $bookingTime, $flyNumer, $originAirport, $hotelSelect, $carSelect, $passengerNum, $email);

                if ($result) {
                    echo "<script>
                            Swal.fire({
                                title: '¡Actualizada!',
                                text: 'La reserva se ha modificado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=customerPanel';
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
                            window.location.href = 'index.php?page=customerPanel';
                        });
                    </script>";
                    exit;
                }
                header('Location: indexphp?page=customerPanel');
                exit;
            } catch (PDOException $e) {
                $_SESSION['flash_edit_message'] = "Error al modificar la reserva: " . $e->getMessage();
                header("Location: index.php?page=customerPanel");
                exit;
            }
        }
    }


    public function updateReturnBooking()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitEditReturnReservation'])) {
            try {
                $uuid = $_POST['uuid'];
                $dateFly = $_POST['dateFly'];
                $timeFly = $_POST['timeFly'];
                $pickupTime = $_POST['pickupTime'];
                $hotelSelect = $_POST['hotelSelect'];
                $carSelect = $_POST['carSelect'];
                $passengerNum = $_POST['passengerNum'];

                $email = $_SESSION['email']; // obtenemos email de SESSION


                $bookingDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $dateFly . ' ' . $timeFly);
                $now = new DateTime();

                $diff = $now->diff($bookingDateTime);
                $hoursDiff = ($diff->days * 24) + $diff->h + ($diff->i / 60);

                if ($bookingDateTime < $now || $hoursDiff < 48) {
                    echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Las modificaciones deben realizarse con al menos 48 horas de antelación',
                            icon: 'error'
                        }).then(() => {
                            window.location.href = 'index.php?page=customerPanel';
                        });
                    </script>";
                    exit;
                }


                $bookingModel = new BookingModel();
                $result = $bookingModel->updateReturnBooking($uuid, $dateFly, $timeFly, $pickupTime, $hotelSelect, $carSelect, $passengerNum, $email);

                if ($result) {
                    echo "<script>
                            Swal.fire({
                                title: '¡Actualizada!',
                                text: 'La reserva se ha modificado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=customerPanel';
                            });
                        </script>";
                        exit;
                } else {
                    echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'No se ha podido modificar la reserva',
                            icon: 'error'
                        }).then(() => {
                            window.location.href = 'index.php?page=customerPanel';
                        });
                    </script>";
                    exit;
                }
                header('Location: indexphp?page=customerPanel');
                exit;
            } catch (PDOException $e) {
                $_SESSION['flash_edit_message'] = "Error al modificar la reserva: " . $e->getMessage();
                header("Location: index.php?page=customerPanel");
                exit;
            }
        }
    }

    public function updateRoundTripBooking()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitEditRoundTripReservation'])) {
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

                $email = $_SESSION['email']; // obtenemos email de SESSION

                // Validación de antelación mínima (48h) tanto para ida como vuelta
                $arrivalDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $bookingDate . ' ' . $bookingTime);
                $returnDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $dateFly . ' ' . $timeFly);
                $now = new DateTime();

                $diffArrival = $now->diff($arrivalDateTime);
                $hoursArrival = ($diffArrival->days * 24) + $diffArrival->h + ($diffArrival->i / 60);

                $diffReturn = $now->diff($returnDateTime);
                $hoursReturn = ($diffReturn->days * 24) + $diffReturn->h + ($diffReturn->i / 60);

                if ($arrivalDateTime < $now || $hoursArrival < 48 || $returnDateTime < $now || $hoursReturn < 48) {
                    echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Las modificaciones deben realizarse con al menos 48 horas de antelación',
                            icon: 'error'
                        }).then(() => {
                            window.location.href = 'index.php?page=customerPanel';
                        });
                    </script>";
                    exit;
                }

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
                                title: '¡Actualizada!',
                                text: 'La reserva se ha modificado correctamente',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php?page=customerPanel';
                            });
                        </script>";
                        exit;
                } else {
                    echo
                    "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'No se ha podido modificar la reserva',
                            icon: 'error'
                        }).then(() => {
                            window.location.href = 'index.php?page=customerPanel';
                        });
                    </script>";
                    exit;
                }
                header("Location: index.php?page=customerPanel");
                exit;
            } catch (PDOException $e) {
                $_SESSION['flash_edit_message'] = "Error al modificar la reserva: " . $e->getMessage();
                header("Location: index.php?page=customerPanel");
                exit;
            }
        }
    }
}
