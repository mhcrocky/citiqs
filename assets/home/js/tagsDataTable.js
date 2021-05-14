$(document).ready(function () {
  $('input').on('keyup', function() {
    $(this).attr('style', '');
  });
  var table = $("#tags").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "events/get_event_tags",
      dataSrc: "",
    },
    columns: [
      {
        title: "ID",
        data: "id",
      },
      {
        title: "Tag",
        data: "tag",
      },
      {
        title: "User ID",
        data: "userId",
      },
      {
        title: "Edit",
        data: null,
        "render": function (data, type, row) {
          return '<button class="btn btn-primary" onclick="get_tag(\''+data.id+'\', \''+data.tag+'\', \''+data.userId+'\')" data-toggle="modal" data-target="#editEventTagModal">Edit Tag</button>';
        }
      },
      {
        title: "Delete",
        data: null,
        "render": function (data, type, row) {
          return '<button class="btn btn-sm btn-danger" onclick="deleteTag(\''+data.id+'\')">Delete Tag</button>';
        }
      }
    ],
      order: [[1, 'asc']]
  });

  $('#report_filter').addClass('text-right');
  $('#report_filter label').addClass('text-left');

});


function get_tag(id, tag, userId){
  $('#id').val(id);
  $('#editTag').val(tag);
  $('#editUserId').val(userId);
  return ;
}

function saveTag(el){
  $(el).prop('disabled', true);
  let data = {
    tag: $('#tag').val(),
    userId: $('#userId').val(),
  }
  if(data.tag == ''){
    if(data.tag == '') { $('#tag').attr('style', '1px solid red'); }
    return ;
  }

  $.post(globalVariables.baseUrl + 'events/save_event_tags', data, function(data) {
    $(el).prop('disabled', false);
    $('#userId').val('');
    $('#tag').val('');
    $("#tags").DataTable().ajax.reload();
    $('#closeTagModal').click();
    let response = JSON.parse(data);
    alertify[response.status](response.message);
  });
}


function updateTag(el){
  $(el).prop('disabled', true);
  let data = {
    id: $('#id').val(),
    tag: $('#editTag').val(),
    userId: $('#editUserId').val(),
  }
  if(data.tag == ''){
    if(data.tag == '') { $('#editTag').attr('style', '1px solid red'); }
    return ;
  }

  $.post(globalVariables.baseUrl + 'events/update_event_tags', data, function(data) {
    $(el).prop('disabled', false);
    $('#tags').DataTable().ajax.reload();
    $('#closeEditEventTagModal').click();
    let response = JSON.parse(data);
    alertify[response.status](response.message);
  });
}

function deleteTag(id){
  if (confirm("Are you sure?") == false) {
    return ;
  }

  $.post(globalVariables.baseUrl + 'events/delete_event_tags', {id: id}, function(data) {
    $('#tags').DataTable().ajax.reload();
    let response = JSON.parse(data);
    alertify[response.status](response.message);
  });
}

