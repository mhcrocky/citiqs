$(document).ready(function () {

  var table = $("#customeremail").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "customeremail/get_customer_emails",
      dataSrc: "",
    },

    columns:[
      {
        title: 'ID',
        data: 'id'
      },
      {
        title: 'Name',
        data: 'name'
      },
      {
        title: 'Email',
        data: 'email'
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
      }
    ],
    createdRow: function(row, data, dataIndex){
      $(row).attr('id', 'row-' + data.id);
      $(row).addClass('row-' + data.id);
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
    order: [[0, 'desc']]
  });


});




function sendMultipleEmailsModal(){
  
  var rows_selected = $("#customeremail").DataTable().column(0).checkboxes.selected();
  if(rows_selected.length < 1){
    $('#emails').text('empty');
    return ;
  }
  


  $('#sendEmailsModal').modal('show');

}


function saveEmailsListModal(){
  
  var rows_selected = $("#customeremail").DataTable().column(0).checkboxes.selected();
  if(rows_selected.length < 1){
    $('#emails').text('empty');
    return ;
  }
  

  $('#saveEmailsListModal').modal('show');



}




function sendMultipleEmails(){

  var rows_selected = $("#customeremail").DataTable().column(0).checkboxes.selected();
  let campaignId = $('#campaignId option:selected').val();

  if(campaignId == 0){
    alertify['error']('You must select a campaign id');
    return ;
  }

  var rowIds = [];

  $.each(rows_selected, function(index, rowId){
    rowIds.push(rowId);

  });

  let data = {
    ids: JSON.stringify(rowIds),
    campaignId: campaignId
  }

  $.post(globalVariables.baseUrl + "customeremail/send_multiple_emails", data, function(data){
      $('.close').click();
      data = JSON.parse(data);
      alertify[data.status](data.message);
      $("#campaignslists").DataTable().ajax.reload();
  });

}


function sendCampaignEmails(){

  let campaignId = $("#fromCampaignId option:selected").val();


  if(campaignId == 0){
    alertify['error']('You must select a campaign id');
    return ;
  }

  $.post(globalVariables.baseUrl + "customeremail/send_emails_from_campaign", {campaignId: campaignId}, function(data){
      $('.close').click();
      data = JSON.parse(data);
      alertify[data.status](data.message);
  });

}

function saveEmailsList(){

  var rows_selected = $("#customeremail").DataTable().column(0).checkboxes.selected();
  let listId = $('#listId option:selected').val();

  if(listId == 0){
    alertify['error']('You must select a list id');
    return ;
  }

  var rowIds = [];

  $.each(rows_selected, function(index, rowId){
    rowIds.push(rowId);

  });

  let data = {
    ids: JSON.stringify(rowIds),
    listId: listId
  }

  $.post(globalVariables.baseUrl + "customeremail/save_emails_list", data, function(data){
      $('.close').click();
      data = JSON.parse(data);
      alertify[data.status](data.message);
  });

}

function goToEmailLists()  {
  window.location.href = globalVariables.baseUrl + 'emaillists';
}