


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
      url: globalVariables.baseUrl + "Api/Voucher/vouchersend",
      dataSrc: "",
    },
    columns: [
      {
        title: "ID",
        data: "id",
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
        title: "Number Of Times",
        data: "numberOfTimes",
      },
      {
        title: "Send",
        data: null,
        "render": function (data, type, row) {
          if(data.send == 1){
            return 'Yes';
          }
          return 'No';
        }
      },
      {
        title: "Voucher Code",
        data: "code",
      },
      {
        title: "Voucher Description",
        data: "description",
      },
      {
        title: "Date Created",
        data: "datecreated",
      },
      {
        title: "Action",
        data: null,
        "render": function (data, type, row) {
          if(data.send == 1){
            return '<button class="btn btn-primary" onclick="send_vouchersend(\''+data.id+'\', \''+data.name+'\', \''+data.email+'\', '+data.voucherId+')">Resend</button>';
          }
          return '<button class="btn btn-primary" onclick="send_vouchersend(\''+data.id+'\', \''+data.name+'\', \''+data.email+'\', '+data.voucherId+', '+data.send+')">Send</button>';
        }
      }
      
    ],
    order: [[0, 'asc']]
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
  var voucherId = $('#voucherId option:selected').val();
  let data = {
      name: $('#name').val(),
      email: encodeURI($('#email').val()),
      voucherId: voucherId
  }
  var times = $('#option_'+voucherId).attr('data-times');

  //console.log(data);

  $('#submitVoucherSend').prop('disabled', true);

  $.post(globalVariables.baseUrl + "Api/Voucher/create_vouchersend", data, function(data){
      $('#vouchersend').DataTable().ajax.reload();
      $('#submitVoucherSend').prop('disabled', false);
      $('#resetForm').click();
      $('#closeModal').click();
      $('.form-control').addClass('input-clear');
      alertify[data.status](data.message);
      if(times == 1){
          $('#option_'+voucherId).remove()
      } else {
          $('#option_'+voucherId).attr('data-times', times-1);
      }
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