$("#campaign-list-form").validate({
  errorClass: "text-danger border-danger",
  submitHandler: function(form) {
    let data = new FormData(form);
    saveCampaignList(serializeData(data))
  }
 });

$(document).ready(function () {

  var table = $("#campaignslists").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "campaignslists/get_campaigns_lists",
      dataSrc: "",
    },

    columns:[
      {
        title: 'ID',
        data: 'id'
      },
      {
        title: 'Campaign Id',
        data: 'campaignId'
      },
      {
        title: 'Campaign Name',
        data: 'campaignName'
      },
      {
        title: 'Campaign Description',
        data: 'campaignDescription'
      },
      {
        title: 'Campaign Active',
        data: null,
        render: function (data, type, row) {
          if(data.campaignActive == '0'){
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
        title: 'Active',
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
          return '<button class="btn btn-danger" onclick="confirmCampaignListDelete('+ data.id + ')">Delete</button>';
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

function saveCampaignList(data){
  data.campaignId = data.campaignListId;
  data.listId = data.campListId;
  delete data.campaignListId;
  delete data.campListId;
  $.post(globalVariables.baseUrl + "campaignslists/save_campaign_list", data, function(data){
      $('.close').click();
      $("#campaignslists").DataTable().ajax.reload();
      data = JSON.parse(data);
      alertify[data.status](data.message);
  });

}

function confirmCampaignListDelete(id){
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
      deleteCampaignList(id);
     }
});
}

function deleteCampaignList(id) {
  $.post(globalVariables.baseUrl + "campaignslists/delete_campaign_list",{id: id},
    function (data) {
      data = JSON.parse(data);
      alertify[data.status](data.message);
      $("#campaignslists").DataTable().ajax.reload();
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