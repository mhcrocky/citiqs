$("#list-form").validate({
  errorClass: "text-danger border-danger",
  submitHandler: function(form) {
    let data = new FormData(form);
    saveList(serializeData(data))
  }
 });

$(document).ready(function () {

  var table = $("#lists").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "lists/get_lists",
      dataSrc: "",
    },

    columns:[
      {
        title: 'ID',
        data: 'id'
      },
      {
        title: 'List',
        data: 'list'
      },
      {
        title: 'Active',
        data: null,
        render: function (data, type, row) {
          if(data.active == '0'){
            return 'No';
          }
          return 'Yes';
        }
      },
      {
        title: 'Delete',
        data: null,
        render: function (data, type, row) {
          return '<button class="btn btn-danger" onclick="confirmDelete('+ data.id + ')">Delete</button>';
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

function saveList(data){

  $.post(globalVariables.baseUrl + "lists/save_list", data, function(data){
      $('#createListModal').modal('hide');
      $("#lists").DataTable().ajax.reload();
      setTimeout(() => {
        let lists = $("#lists").DataTable().data().toArray();
        let html = '<option value="">Select Option</option>';
        $.each(lists, function(index, list) {
          html += '<option value="'+list.id+'">'+list.list+'</option>';
        });
        $('.lists').html(html);
      }, 1500);
      data = JSON.parse(data);
      alertify[data.status](data.message);
  });

}

function confirmDelete(id){
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
      deleteList(id);
     }
});
}

function deleteList(id) {
  $.post(globalVariables.baseUrl + "lists/delete_list",{id: id},
    function (data) {
      data = JSON.parse(data);
      alertify[data.status](data.message);
      $("#lists").DataTable().ajax.reload();
      setTimeout(() => {
        let lists = $("#lists").DataTable().data().toArray();
        let html = '<option value="">Select Option</option>';
        $.each(lists, function(index, list) {
          html += '<option value="'+list.id+'">'+list.list+'</option>';
        });
        $('.lists').html(html);
      }, 1500);
    }
  );
}

function serializeData (data) {
	let obj = {};
	for (let [key, value] of data) {
		if (obj[key] !== undefined) {
			if (!Array.isArray(obj[key])) {
				obj[key] = [obj[key]];
			}
			obj[key].push(value);
		} else {
			obj[key] = value;
		}
	}
	return obj;
}