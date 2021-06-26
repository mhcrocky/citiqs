


$(document).ready(function () {
  var eventId = $('#eventId').val();
  var table = $("#guestlist").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    dom: "Blfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        autoFilter: true,
        footer: true,
        text: '<input type="button" value="Export to Excel" class="btn btn-success btn-export"><span class="input-group-addon input-group-export pl-2 pr-2 mb-3"><i style="color: #fff;font-size: 18px;" class="fa fa-file-text-o"></i></span>',
        className: "input-group mb-4",
        sheetName: "Exported data",
      },
    ],
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
        title: 'Exists in Bookandpay',
        data: null,
        "render": function(data, type, row) {
          if(data.bookandpay_id == null){
            return 'No';
          }
          return 'Yes';
        }
      },
      {
        title: 'Send',
        data: null,
        "render": function(data, type, row) {
          if(data.bookandpay_id == null){
            return '<button class="btn btn-primary" onclick="sendTicket(\''+data.id+'\')">Send</button>';
          }
          return '<button class="btn btn-primary" onclick="confirmResendTicket(\''+data.transactionId+'\')">Resend</button>';
          
        }
      },
      {
        title: 'Delete',
        data: null,
        "render": function(data, type, row) {
          return '<button class="btn btn-danger" onclick="confirmDelete(\''+data.id+'\')">Delete</button>';
        }
      }
      
      
    ],
    createdRow: function(row, data, dataIndex){
      $(row).attr('id', 'row-' + data.id);
    },
    columnDefs: [
      {
        targets: 0,
        checkboxes: {
          selectRow: true
        }
      }
    ],
    select: {
      style: 'multi'
    },
    order: [[0, 'asc']]
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

  $.post(globalVariables.baseUrl + "events/add_guest", data, function(response){
      $("#guestlist").DataTable().ajax.reload();
      $('#submitGuestlist').prop('disabled', false);
      $('#resetGuestForm').click();
      $('#closeGuestModal').click();
      $('.form-control').addClass('input-clear');
      alertifyAjaxResponse(JSON.parse(response));
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

  if(data.guestName == "" || data.guestEmail == "" || data.ticketQuantity == "" || data.ticketId == ""){
    alertify['error']('All fields are required!');
    return ;
  }

  //console.log(data);

  $.post(globalVariables.baseUrl + "events/import_guestlist", data, function(data){
      $("#guestlist").DataTable().ajax.reload();
      $('#resetUpload').click();
      $('.fileForm').removeClass('d-none');
      $('#tab01').click();
      $('#closeGuestModal').click();

      $('#tab01').click();
      alertify['success']('The guest list is imported successfully');
  });

}

function confirmResendTicket(transactionId){
  bootbox.confirm({
    message: "Do you want to send in the following email as well? <input class='form-control mt-2' type='email' id='supportEmail' name='supportEmail' value='support@tiqs.com' required>",
    buttons: {
        confirm: {
            label: 'Yes',
            className: 'btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn-danger'
        }
    },
    callback: function (result) {
      if(result == true){
        let email = $('#supportEmail').val();
        if(!validateEmail(email)){
          alertify.error('Please enter a valid email!');
          return false;
        }
        resendTicket(transactionId, email, 1);
      } else {
        resendTicket(transactionId);
      }
    }
});
}

function confirmDelete(id, multiple = false){
  bootbox.confirm({
    message: "Are you sure?",
    buttons: {
        confirm: {
            label: 'Yes',
            className: 'btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn-danger'
        }
    },
    callback: function (result) {
      if(result === false) return ;
      if(multiple){
        deleteMultipleGuest();
      } else {
        deleteGuest(id);
      }
    }
});
}

function resendTicket(transactionId, email = '', sendTo = 0) {
  let data = {
    transactionId: transactionId,
    email: encodeURI(email),
    sendTo: sendTo
  };
  $.post(
    globalVariables.baseUrl + "events/resend_reservation",
    data,
    function (data) {
      if(data != 'false'){
        alertify.success("Ticket is resent successfully!");
      } else {
        alertify.error("Something went wrong!");
      }
    }
  );
}

function deleteGuest(id) {

  $.post(globalVariables.baseUrl + "events/delete_guest",{id: id},
    function (data) {
      data = JSON.parse(data);
      alertify[data.status](data.message);
      $("#guestlist").DataTable().ajax.reload();
    }
  );
}

function deleteMultipleGuest() {
  var rows_selected = $("#guestlist").DataTable().column(0).checkboxes.selected();

  if(rows_selected.length < 1){
    alertify['error']('You must select a row!');
    return ;
  }
  
  var rowIds = [];

  $.each(rows_selected, function(index, rowId){
    rowIds.push(rowId);
  });

  $.post(globalVariables.baseUrl + "events/delete_multiple_guests",{ids: JSON.stringify(rowIds)},
    function (data) {
      data = JSON.parse(data);
      alertify[data.status](data.message);
      $("#guestlist").DataTable().ajax.reload();
    }
  );

}

function sendTicket(id) {

  $.post(globalVariables.baseUrl + "events/send_guest_ticket",{id: id},
    function (data) {
      data = JSON.parse(data);
      alertify[data.status](data.message);
      $("#guestlist").DataTable().ajax.reload();
    }
  );
}

function sendMultipleTickets() {
  var rows_selected = $("#guestlist").DataTable().column(0).checkboxes.selected();



  if(rows_selected.length < 1){
    alertify['error']('You must select a row!');
    return ;
  }
  
  var rowIds = [];

  $.each(rows_selected, function(index, rowId){
    let rowData = $("#guestlist").DataTable().row('#row-' + rowId).data();
    let bookandpay_id = rowData.bookandpay_id;
    if(bookandpay_id == null){
      rowIds.push(rowId);
    }
  });

  if(rowIds.length < 1){
    alertify['error']("You must select rows that aren't send yet!");
    return ;
  }

  $.post(globalVariables.baseUrl + "events/send_multiple_guests_ticket",{ids: JSON.stringify(rowIds)},
    function (data) {
      data = JSON.parse(data);
      alertify[data.status](data.message);
      $("#guestlist").DataTable().ajax.reload();
    }
  );

}

function validateEmail(email) {
  const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}