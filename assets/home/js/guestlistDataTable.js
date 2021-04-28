


$(document).ready(function () {
  var eventId = $('#eventId').val();
  var table = $("#guestlist").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "events/get_guestlist/"+eventId,
      dataSrc: "",
    },
    columns: [
      {
        title: "ID",
        data: "id",
      },
      {
        title: "Guest Name",
        data: "guestName",
      },
      {
        title: "Guest Email",
        data: "guestEmail",
      },
      {
        title: "Ticket Quantity",
        data: "ticketQuantity",
      },
      {
        title: "Ticket ID",
        data: "ticketId",
      },
      {
        title: "Transaction ID",
        data: "transactionId",
      },
      {
        title: 'Resend',
        data: null,
        "render": function(data, type, row) {
          return '<button class="btn btn-primary" onclick="resendReservation(\''+data.transactionId+'\')">Resend</button>';
        }
      }
      
      
    ],
    order: [[1, 'asc']]
  });

  $('#report_filter').addClass('text-right');
  $('#report_filter label').addClass('text-left');

});


function addGuestModal(ticketId) {
  $('#guestTicketId').val(ticketId);
}

function addGuestForm() {
  $('#submitGuestlist').click();
}

function addGuest(e){
  e.preventDefault();
  $('.form-control').removeClass('input-clear');
  let guestName = $('#guestName').val();
  let guestEmail = $('#guestEmail').val();
  let ticketQuantity = $('#guestTickets').val();
  let ticketId = $('#guestTicketId option:selected').val();

  if (guestName == '' || guestEmail == '' || ticketQuantity == '' || ticketId == '') {
    return;
  }
  let data = {
      guestName: guestName,
      guestEmail: guestEmail,
      ticketQuantity: ticketQuantity,
      eventId: $('#eventId').val(),
      ticketId: ticketId
  }


  //console.log(data);

  $('#submitGuestlist').prop('disabled', true);

  $.post(globalVariables.baseUrl + "events/add_guest", data, function(data){
    $("#guestlist").DataTable().ajax.reload();
      $('#submitGuestlist').prop('disabled', false);
      $('#resetGuestForm').click();
      $('#closeGuestModal').click();
      $('.form-control').addClass('input-clear');
      alertify['success']('Guest is added successfully');

  });

}

function importExcelFile(){

  let data = {
      eventId: $('#eventId').val(),
      guestName: $('#importGuestName option:selected').val(),
      guestEmail: $('#importGuestEmail option:selected').val(),
      ticketQuantity: $('#importTickets option:selected').val(),
      ticketId: $('#importTicketId option:selected').val(),
      jsonData: $('#jsonData').text(),
  }

  //console.log(data);

  $.post(globalVariables.baseUrl + "events/import_guestlist", data, function(data){
      $("#guestlist").DataTable().ajax.reload();
      $('#resetUpload').click();
      $('#fileForm').removeClass('d-none');
      $('#filterFormSection').addClass('d-none');
      $('#uploadExcel').removeClass('d-none');
      $('#importExcelFile').addClass('d-none');
      $('#guestlistModal').modal('toggle');
      $('#tab01').click();
      alertify['success']('The guest list is imported successfully');
  });

}

function resendReservation(transactionId){
  $.post(globalVariables.baseUrl + "events/resend_reservation", {transactionId: transactionId}, function(data){
      alertify['success']('Resent Successfully!');
  });
}