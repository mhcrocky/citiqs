$(document).ready(function () {
  $('input').on('keyup', function() {
    $(this).attr('style', '');
  });
  var table = $("#inputs").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "post",
      url: globalVariables.baseUrl + "events/get_event_inputs",
      data: function (data) {
        data.eventId = $('#eventId').val();
      },
      dataSrc: "",
    },
    columns: [
      {
        title: "ID",
        data: "id",
      },
      {
        title: "Name",
        data: "fieldName",
      },
      {
        title: "Label",
        data: "fieldLabel",
      },
      {
        title: "Type",
        data: "fieldType",
      },
      {
        title: "Required",
        data: null,
        "render": function (data, type, row) {
          if(data.requiredField == 1){
            return 'Yes';
          }
          return 'No';
        }
      },
      {
        title: "Edit",
        data: null,
        "render": function (data, type, row) {
          let html = '<input type="hidden" id="inputData_'+data.id+'" value="'+data.fieldLabel+'" data-label="'+data.fieldLabel+'" data-name="'+data.fieldName+'" data-type="'+data.fieldType+'" data-required="'+data.requiredField+'">';
          html += '<button class="btn btn-primary" onclick="get_input(\''+data.id+'\')" data-toggle="modal" data-target="#editEventTagModal">Edit Input</button>';
          return html;
        }
      },
      {
        title: "Delete",
        data: null,
        "render": function (data, type, row) {
          return '<button class="btn btn-sm btn-danger" onclick="deleteInput(\''+data.id+'\')">Delete Input</button>';
        }
      }
    ],
      order: [[1, 'asc']]
  });

  $('#report_filter').addClass('text-right');
  $('#report_filter label').addClass('text-left');

});


function get_input(id){
  let el = $('#inputData_'+id);
  $('#id').val(id);
  $('#editFieldName').val(el.attr('data-name'));
  $('#editFieldLabel').val(el.attr('data-label'));
  $('#editFieldType').val(el.attr('data-type'));
  $('#editRequiredField').val(el.attr('data-required'));
  return ;
}

function saveInput(el){
  if(!isFieldNameValid($('#fieldName').val().toLowerCase())){
    alertify['error']("Please don't use special characters or space for input name!");
    return ;
  }
  $(el).prop('disabled', true);
  let data = {
    fieldName: $('#fieldName').val(),
    fieldLabel: $('#fieldLabel').val(),
    fieldType: $('#fieldType option:selected').val(),
    requiredField: $('#requiredField option:selected').val(),
    eventId: $('#eventId').val()
  }
  if(data.fieldLabel == ''){
    if(data.fieldLabel == '') { $('#tag').attr('style', '1px solid red'); }
    return ;
  }


  $.post(globalVariables.baseUrl + 'events/save_event_inputs', data, function(data) {
    $(el).prop('disabled', false);
    $('#fieldLabel').val('');
    $('#fieldName').val('');
    $('#requiredField option:selected').val(0);
    $("#inputs").DataTable().ajax.reload();
    $('#closeTagModal').click();
    let response = JSON.parse(data);
    alertify[response.status](response.message);
  });
}


function updateInput(el){
  if(!isFieldNameValid($('#editFieldName').val().toLowerCase())){
    alertify['error']("Please don't use special characters or space for input name!");
    return ;
  }
  $(el).prop('disabled', true);
  let data = {
    id: $('#id').val(),
    fieldName: $('#editFieldName').val(),
    fieldLabel: $('#editFieldLabel').val(),
    fieldType: $('#editFieldType option:selected').val(),
    requiredField: $('#editRequiredField option:selected').val(),
    eventId: $('#eventId').val()
  }
  if(data.fieldLabel == ''){
    if(data.fieldLabel == '') { $('#editTag').attr('style', '1px solid red'); }
    return ;
  }

  

  $.post(globalVariables.baseUrl + 'events/update_event_inputs', data, function(data) {
    $(el).prop('disabled', false);
    $("#inputs").DataTable().ajax.reload();
    $('#closeEditEventTagModal').click();
    let response = JSON.parse(data);
    alertify[response.status](response.message);
  });
}

function deleteInput(id){
  if (confirm("Are you sure?") == false) {
    return ;
  }

  $.post(globalVariables.baseUrl + 'events/delete_event_inputs', {id: id}, function(data) {
    $("#inputs").DataTable().ajax.reload();
    let response = JSON.parse(data);
    alertify[response.status](response.message);
  });
}


function isFieldNameValid(name) {

  const res = /^[a-z0-9_]+$/.exec(name);
  const valid = !!res;
  return valid;
}

