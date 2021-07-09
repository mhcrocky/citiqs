$("#eventClearing-form").validate({
  errorClass: "text-danger border-danger",
  submitHandler: function(form) {
    let data = new FormData(form);
    saveEventClearing(serializeData(data))
  }
});

$("#editEventClearing-form").validate({
  errorClass: "text-danger border-danger",
  submitHandler: function(form) {
    let data = new FormData(form);
    updateEventClearing(serializeData(data))
  }
});

$(document).ready(function () {

  var table = $("#eventClearings").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "events/get_event_clearings",
      dataSrc: "",
    },

    columns:[
      {
        title: 'ID',
        data: 'id'
      },
      {
        title: 'Event',
        data: 'eventname'
      },
      {
        title: 'Description',
        data: 'description'
      },
      {
        title: 'Amount',
        data: 'amount'
      },
      {
        title: 'Date',
        data: 'date'
      },
      {
        title: 'Edit',
        data: null,
        render: function (data, type, row) {
          let html = '<input id="eventClearingData_'+ data.id + '" type="hidden" value="'+data.description+'" data-amount="'+data.amount+'" data-eventId="'+data.eventId+'"  data-date="'+data.date+'">'
          html += '<button class="btn btn-primary" onclick="editEventClearing('+ data.id + ')">Edit</button>';
          return html;
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
    order: [[0, 'asc']]
  });


});

function saveEventClearing(data){

  $.post(globalVariables.baseUrl + "events/save_event_clearing", data, function(data){
      $('#createEventClearingModal').modal('hide');
      $("#eventClearings").DataTable().ajax.reload();
      data = JSON.parse(data);
      alertify[data.status](data.message);
  });

}

function updateEventClearing(data){

  $.post(globalVariables.baseUrl + "events/update_event_clearing", data, function(data){
      $('#editEventClearingModal').modal('hide');
      $("#eventClearings").DataTable().ajax.reload();
      data = JSON.parse(data);
      alertify[data.status](data.message);
  });

}

function editEventClearing(id){
  let el = $('#eventClearingData_'+id);
  let eventId = el.attr('data-eventId');
  let amount = el.attr('data-amount');
  let date = el.attr('data-date');
  let description = el.val();

  $('#clearingId').val(id);
  $('#eventId').val(eventId);
  $('.amount').val(amount);
  $('#description').val(description);
  $('#date').val(date);

  $('#editEventClearingModal').modal('show');

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
      deleteEventClearing(id);
     }
});
}

function deleteEventClearing(id) {
  $.post(globalVariables.baseUrl + "events/delete_event_clearing",{id: id},
    function (data) {
      data = JSON.parse(data);
      alertify[data.status](data.message);
      $("#eventClearings").DataTable().ajax.reload();

    }
  );
}

function getPromoterAmount(el, amountId) {
  let val = $(el).children('option:selected').val();
  if(typeof promoterPaid[val] !== 'undefined'){
    $('.'+amountId).val(promoterPaid[val].replaceAll(',', '.'));
    return;
  }

  $('.'+amountId).val('0.00');
  
}