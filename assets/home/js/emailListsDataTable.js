

$(document).ready(function () {

  var table = $("#emaillists").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "emaillists/get_email_lists",
      dataSrc: "",
    },

    columns:[
      {
        title: 'ID',
        data: 'id'
      },
      {
        title: 'Email Id',
        data: 'customerEmailId'
      },
      {
        title: 'Email',
        data: 'customerEmail'
      },
      {
        title: 'Name',
        data: 'customerName'
      },
      {
        title: 'Customer Active',
        data: null,
        render: function (data, type, row) {
          if(data.customerActive == '0'){
            return 'No';
          }
          return 'Yes';
        }
      },
      {
        title: 'List Id',
        data: 'listId'
      },
      {
        title: 'List',
        data: 'list'
      },
      {
        title: 'List Active',
        data: null,
        render: function (data, type, row) {
          if(data.listActive == '0'){
            return 'No';
          }
          return 'Yes';
        }
      },
      {
        title: 'Delete',
        data: null,
        render: function (data, type, row) {
          return '<button class="btn btn-danger" onclick="confirmEmailListDelete('+ data.id + ')">Delete</button>';
        }
      }
    ],
    createdRow: function(row, data, dataIndex){
      $(row).attr('id', 'row-' + data.id);
      $(row).addClass('row-' + data.id);
    },
    order: [[0, 'desc']]
  });


});


function confirmEmailListDelete(id){
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
      deleteEmailList(id);
     }
});
}

function deleteEmailList(id) {
  $.post(globalVariables.baseUrl + "emaillists/delete_email_list",{id: id},
    function (data) {
      data = JSON.parse(data);
      alertify[data.status](data.message);
      $("#emaillists").DataTable().ajax.reload();
    }
  );
}

function goToCustomerEmail()  {
  window.location.href = globalVariables.baseUrl + 'customeremail';
}