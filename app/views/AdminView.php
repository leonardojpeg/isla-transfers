<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../views/Modals/OneWayAdminModal.php';
require_once __DIR__ . '/../views/Modals/ReturnAdminModal.php';
require_once __DIR__ . '/../views/Modals/RoundTripAdminModal.php';

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
    <h1 class="pb-5">Panel de administración de administradores</h1>
    <div class="row justify-content-end">
        <div class="col-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#oneWayAdminModal"><i class="fa-solid fa-circle-plus"></i> Reservar Aeropuerto-Hotel</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#returnAdminModal"><i class="fa-solid fa-circle-plus"></i> Reservar Hotel-Aeropuerto</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roundTripAdminModal"><i class="fa-solid fa-circle-plus"></i> Reservar ida-vuelta (Aeropuerto-Hotel/Hotel-Aeropuerto)</button>
        </div>
    </div>

    <div class="p-5" id='calendar' style="min-height: 300px; max-width: 800px; margin: 0 auto;">
    </div>
</div>

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: 'apiReservas.php',
            eventClick: function(info) {
                const reserva = info.event;
                alert(`Reserva: ${reserva.title}\nFecha: ${reserva.start.toLocaleString()}`);
            }
        });
        calendar.render();
    });
</script>
