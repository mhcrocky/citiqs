$(document).ready(function () {
  $('input').on('keyup', function() {
    $(this).attr('style', '');
  });
  var table = $("#appsettings").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "appsettings/get_appsettings",
      dataSrc: "",
    },
    columns: [
      {
        title: "ID",
        data: "id",
      },
      {
        title: "Merchandise",
        data: "merchandise",
      },
      {
        title: "Ticketshop",
        data: "ticketshop",
      },
      {
        title: "Edit",
        data: null,
        "render": function (data, type, row) {
          return '<button class="btn btn-primary" onclick="get_appsettings(\''+data.id+'\', \''+data.merchandise+'\', \''+data.ticketshop+'\')" data-toggle="modal" data-target="#editAppSettingsModal">Edit App Settings</button>';
        }
      },
      {
        title: "Delete",
        data: null,
        "render": function (data, type, row) {
          return '<button class="btn btn-sm btn-danger" onclick="deleteAppSettings(\''+data.id+'\')">Delete App Settings</button>';
        }
      }
    ],
      order: [[1, 'asc']]
  });

  $('#report_filter').addClass('text-right');
  $('#report_filter label').addClass('text-left');

});


function get_appsettings(id, merchandise, ticketshop){
  $('#id').val(id);
  $('#editMerchandise').val(merchandise);
  $('#editTicketshop').val(ticketshop);
  return ;
}

function saveAppSettings(el){
  $(el).prop('disabled', true);
  let data = {
    merchandise: $('#merchandise').val(),
    ticketshop: $('#ticketshop').val(),
  }
  if(data.merchandise == '' || data.ticketshop == ''){
    if(data.merchandise == '') { $('#merchandise').attr('style', '1px solid red'); }
    if(data.ticketshop == '') { $('#ticketshop').attr('style', '1px solid red'); }
    return ;
  }

  $.post(globalVariables.baseUrl + 'appsettings/save_appsettings', data, function(data) {
    $(el).prop('disabled', false);
    $('#ticketshop').val('');
    $('#merchandise').val('');
    $("#appsettings").DataTable().ajax.reload();
    $('#closeAppSettingsModal').click();
    let response = JSON.parse(data);
    alertify[response.status](response.message);
  });
}


function updateAppSettings(el){
  $(el).prop('disabled', true);
  let data = {
    id: $('#id').val(),
    merchandise: $('#editMerchandise').val(),
    ticketshop: $('#editTicketshop').val(),
  }
  if(data.merchandise == '' || data.ticketshop == ''){
    if(data.merchandise == '') { $('#merchandise').attr('style', '1px solid red'); }
    if(data.ticketshop == '') { $('#ticketshop').attr('style', '1px solid red'); }
    return ;
  }

  $.post(globalVariables.baseUrl + 'appsettings/update_appsettings', data, function(data) {
    $(el).prop('disabled', false);
    $('#appsettings').DataTable().ajax.reload();
    $('#closeEditAppSettingsModal').click();
    let response = JSON.parse(data);
    alertify[response.status](response.message);
  });
}

function deleteAppSettings(id){
  if (confirm("Are you sure?") == false) {
    return ;
  }

  $.post(globalVariables.baseUrl + 'appsettings/delete_appsettings', {id: id}, function(data) {
    $('#appsettings').DataTable().ajax.reload();
    $('#closeEditAppSettingsModal').click();
    let response = JSON.parse(data);
    alertify[response.status](response.message);
  });
}

