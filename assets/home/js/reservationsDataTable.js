


$(document).ready(function () {


  var table = $("#vouchersend").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "customer_panel/get_reservations",
      dataSrc: "",
    },
    columns: [
      {
        title: "ID",
        data: "id",
      },
      {
        title: "Reservation ID",
        data: "reservationId",
      },
      {
        title: "Name",
        data: "name",
      },
      {
        title: "Email",
        data: "email",
      },
      {
        title: "Reservation Time",
        data: "reservationtime",
      },
      
      
    ],
    order: [[1, 'asc']]
  });

  $('#report_filter').addClass('text-right');
  $('#report_filter label').addClass('text-left');

});


function bookReservationForm() {
  $('#submitBookReservation').click();
}

function bookReservation(e){
  e.preventDefault();
  $('.form-control').removeClass('input-clear');
  if ($('.form-control:invalid').length > 0) {
    return;
  }
  let data = {
      name: $('#name').val(),
      email: encodeURI($('#email').val()),
      mobile: $('#mobile').val(),
      event_date: encodeURI($('#agendas option:selected').val()),
      agenda_id: $('#agendas option:selected').attr('data-agenda'),
      timeslot: $('#agendas option:selected').attr('data-timeslot'),
      spot_id: $('#agendas option:selected').attr('data-spot'),
      fromtime: encodeURI($('#agendas option:selected').attr('data-fromtime')),
      totime: encodeURI($('#agendas option:selected').attr('data-totime'))
  }


  //console.log(data);

  $('#submitBookReservation').prop('disabled', true);

  $.post(globalVariables.baseUrl + "customer_panel/book_reservation", data, function(data){
      $('#vouchersend').DataTable().ajax.reload();
      $('#submitBookReservation').prop('disabled', false);
      $('#resetForm').click();
      $('#closeModal').click();
      $('.form-control').addClass('input-clear');
      //alertify[data.status](data.message);

  });

}
