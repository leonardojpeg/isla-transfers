<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../views/Modals/OneWayAdminModal.php';
require_once __DIR__ . '/../views/Modals/ReturnAdminModal.php';
require_once __DIR__ . '/../views/Modals/RoundTripAdminModal.php';
require_once __DIR__ . '/../views/Modals/SelectReservationTypeModal.php';
require_once __DIR__ . '/../views/Modals/EditAdminModal.php';

if (isset($_SESSION['flash_add_message'])) {
    echo
    "<script>alert('" . $_SESSION['flash_add_message'] . "');</script>";
    unset($_SESSION['flash_add_message']);
}
if (isset($_SESSION['flash_delete_message'])) {
    echo
    "<script>alert('" . $_SESSION['flash_delete_message'] . "');</script>";
    unset($_SESSION['flash_delete_message']);
}
?>

<div class="container py-3 mt-5">
    <h1 class="pb-5 row justify-content-center">Panel de administración de administradores</h1>
    <div class="row justify-content-center">
        <div class="col-auto">
<<<<<<< HEAD
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#oneWayAdminModal"><i class="fa-solid fa-circle-plus"></i> Reservar Aeropuerto-Hotel</button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#returnAdminModal"><i class="fa-solid fa-circle-plus"></i> Reservar Hotel-Aeropuerto</button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#roundTripAdminModal"><i class="fa-solid fa-circle-plus"></i> Reservar ida-vuelta (Aeropuerto-Hotel/Hotel-Aeropuerto)</button>
=======

        <button type="button" class="btn text-white fw-bold" style="background-color: #007bff;" onmouseover="this.style.backgroundColor='#0056b3'" onmouseout="this.style.backgroundColor='#007bff'" data-bs-toggle="modal" data-bs-target="#oneWayAdminModal">
            <i class="fa-solid fa-circle-plus"></i> Reservar Aeropuerto-Hotel
        </button>

        <button type="button" class="btn text-white fw-bold" style="background-color: #dc3545;" onmouseover="this.style.backgroundColor='#a71d2a'" onmouseout="this.style.backgroundColor='#dc3545'" data-bs-toggle="modal" data-bs-target="#returnAdminModal">
            <i class="fa-solid fa-circle-plus"></i> Reservar Hotel-Aeropuerto
        </button>

        <button type="button" class="btn text-white fw-bold" style="background-color: #28a745;" onmouseover="this.style.backgroundColor='#1e7e34'" onmouseout="this.style.backgroundColor='#28a745'" data-bs-toggle="modal" data-bs-target="#roundTripAdminModal">
            <i class="fa-solid fa-circle-plus"></i> Reservar ida-vuelta (Aeropuerto-Hotel/Hotel-Aeropuerto)
        </button>
         <!--   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#oneWayAdminModal"><i class="fa-solid fa-circle-plus"></i> Reservar Aeropuerto-Hotel</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#returnAdminModal"><i class="fa-solid fa-circle-plus"></i> Reservar Hotel-Aeropuerto</button>
           <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roundTripAdminModal"><i class="fa-solid fa-circle-plus"></i> Reservar ida-vuelta (Aeropuerto-Hotel/Hotel-Aeropuerto)</button>
        -->
>>>>>>> a0ec7e6 (implementación de calendario con CRUD, creación, modificación, eliminación y visualización de las reservas a través del calendario. Estilo centrado para el título y los botones, aplicación de códigos de colores para identificar los distintos tipos de reserva en azul, rojo y verde.)
        </div>
    </div>
<hr>
    <div class="p-3" id='calendar' style="min-height: 600px; max-width: 1200px; margin: 0 auto;">
    </div>
</div>

<!-- CSS del calendario -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />

<!-- JS del calendario principal -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<!-- JS de todos los idiomas -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales-all.global.min.js'></script>

<script>
    let selectedDate = null;

    function openSpecificModal(type, date) {
    let formattedDate = date.toISOString().split('T')[0];
    selectedDate = formattedDate;

    const modalSelectorMap = {
        oneWay: {
            modalId: 'oneWayAdminModal',
            inputSelector: 'input[name="bookingDate"]'
        },
        return: {
            modalId: 'returnAdminModal',
            inputSelector: 'input[name="dateFly"]'
        },
        roundTrip: {
            modalId: 'roundTripAdminModal',
            inputSelector: 'input[name="bookingDate"]'
        }
    };

    const config = modalSelectorMap[type];
    if (!config) return;

    // Cierra el modal de selección si está abierto
    const selectModalEl = document.getElementById('selectReservationModal');
    const selectModal = bootstrap.Modal.getInstance(selectModalEl) || new bootstrap.Modal(selectModalEl);
    selectModal.hide();

    // Abre el modal correspondiente
    const modal = new bootstrap.Modal(document.getElementById(config.modalId));
    modal.show();

// Asigna directamente la fecha seleccionada
const input = document.querySelector(`#${config.modalId} ${config.inputSelector}`);
if (input) {
    input.value = formattedDate;
    input.dispatchEvent(new Event('input', { bubbles: true }));
}
}


    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today:    'hoy',
                month:    'mes',
                week:     'semana',
                day:      'día'
            },
            events: 'apiReservas.php',
            dateClick: function(info) {
                selectedDate = new Date(info.dateStr);
                document.getElementById('selected-date-display').textContent = info.dateStr;
                new bootstrap.Modal(document.getElementById('selectReservationModal')).show();
            },

            eventDidMount: function(info) {
    if (info.event.extendedProps && info.event.extendedProps.tooltip) {
        info.el.setAttribute('title', info.event.extendedProps.tooltip);
    }
},


eventClick: function (info) {
    const props = info.event.extendedProps;

    // Rellenar campos comunes
    document.getElementById("editIdReserva").value = props.id_reserva;
    document.getElementById("uuid").value = props.localizador;
    document.getElementById("adcustomerEmail").value = props.email_cliente;
    document.getElementById("adpassengerNum").value = props.num_viajeros;

    // Entrada (IDA)
    document.getElementById("adbookingDate").value = props.fecha_entrada || '';
    document.getElementById("adbookingTime").value = props.hora_entrada || '';
    document.getElementById("adflyNumer").value = props.numero_vuelo_entrada || '';
    document.getElementById("adoriginAirport").value = props.origen_vuelo_entrada || '';

    // Salida (VUELTA)
    document.getElementById("addateFly").value = props.fecha_vuelo_salida || '';
    document.getElementById("adtimeFly").value = props.hora_vuelo_salida || '';
    document.getElementById("adpickupTime").value = props.hora_recogida_salida || '';

    // Selección del hotel en ambos selects
    const selectsHotel = [document.getElementById("adhotelSelect"), document.getElementById("addhotelSelect")];
    selectsHotel.forEach(select => {
        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].text === props.nombre_hotel) {
                select.selectedIndex = i;
                break;
            }
        }

            // Selección del vehículo
            const carSelect = document.getElementById("adcarSelect");
    for (let i = 0; i < carSelect.options.length; i++) {
        if (parseInt(carSelect.options[i].value) === parseInt(props.id_vehiculo)) {
            carSelect.selectedIndex = i;
            break;
        }
    }

    });

    // Mostrar bloques según tipo de reserva
    mostrarCamposEdit(props.id_tipo_reserva.toString());

    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById("editAdminModal"));
    modal.show();
}

        });

        calendar.render();
    });
</script>
