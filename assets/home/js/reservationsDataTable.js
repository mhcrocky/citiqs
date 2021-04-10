


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


function vouchersendForm(params) {
  $('#submitVoucherSend').click();
}

function save_vouchersend(e){
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

  $('#submitVoucherSend').prop('disabled', true);

  $.post(globalVariables.baseUrl + "customer_panel/save_reservation", data, function(data){
      $('#vouchersend').DataTable().ajax.reload();
      $('#submitVoucherSend').prop('disabled', false);
      $('#resetForm').click();
      $('#closeModal').click();
      $('.form-control').addClass('input-clear');
      //alertify[data.status](data.message);

  });

}


function send_vouchersend(id, name, email, voucherId, send=1){
  let data = {
      id: id,
      name: name,
      email: encodeURI(email),
      send: send,
      voucherId: voucherId
  }
  $.post(globalVariables.baseUrl + "Api/Voucher/vouchersend_email", data, function(data){
      $('#vouchersend').DataTable().ajax.reload();
      alertify[data.status](data.message);
  });

}