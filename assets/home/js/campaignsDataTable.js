$("#campaign-form").validate({
  errorClass: "text-danger border-danger",
  submitHandler: function(form) {
    let data = new FormData(form);
    saveCampaign(serializeData(data))
  }
 });

$(document).ready(function () {

  var table = $("#campaigns").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "campaigns/get_campaigns",
      dataSrc: "",
    },

    columns:[
      {
        title: 'ID',
        data: 'id'
      },
      {
        title: 'Campaign',
        data: 'campaign'
      },
      {
        title: 'Description',
        data: 'description'
      },
      {
        title: 'Template Id',
        data: 'templateId'
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
          return '<button class="btn btn-danger" onclick="confirmCampaignDelete('+ data.id + ')">Delete</button>';
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

function saveCampaign(data){

  $.post(globalVariables.baseUrl + "campaigns/save_campaign", data, function(data){
      $('#createCampaignModal').modal('hide');
      $("#campaigns").DataTable().ajax.reload();
      setTimeout(() => {
        let campaigns = $("#campaigns").DataTable().data().toArray();
        let html = '<option value="">Select Option</option>';
        $.each(campaigns, function(index, campaign) {
          html += '<option value="'+campaign.id+'">'+campaign.campaign+'</option>';
        });
        $('.campaigns').html(html);
      }, 1500);
      
      data = JSON.parse(data);
      alertify[data.status](data.message);
  });

}

function confirmCampaignDelete(id){
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
      deleteCampaign(id);
     }
});
}

function deleteCampaign(id) {
  $.post(globalVariables.baseUrl + "campaigns/delete_campaign",{id: id},
    function (data) {
      data = JSON.parse(data);
      alertify[data.status](data.message);
      $("#campaigns").DataTable().ajax.reload();
      $("#campaigns").DataTable().ajax.reload();
      setTimeout(() => {
        let campaigns = $("#campaigns").DataTable().data().toArray();
        let html = '<option value="">Select Option</option>';
        $.each(campaigns, function(index, campaign) {
          html += '<option value="'+campaign.id+'">'+campaign.campaign+'</option>';
        });
        $('.campaigns').html(html);
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