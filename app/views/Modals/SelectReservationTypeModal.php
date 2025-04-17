<!-- Modal para elegir tipo de reserva -->
<div class="modal fade" id="selectReservationModal" tabindex="-1" aria-labelledby="selectReservationLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="selectReservationLabel">Tipo de reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <p>Selecciona el tipo de reserva para el <span id="selected-date-display"></span>:</p>
        <button class="btn btn-primary m-2" onclick="openSpecificModal('oneWay', selectedDate)">Aeropuerto → Hotel</button>
        <button class="btn btn-primary m-2" onclick="openSpecificModal('return', selectedDate)">Hotel → Aeropuerto</button>
        <button class="btn btn-primary m-2" onclick="openSpecificModal('roundTrip', selectedDate)">Ida y vuelta</button>
      </div>
    </div>
  </div>
</div>
