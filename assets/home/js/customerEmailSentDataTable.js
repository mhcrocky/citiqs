$(document).ready(function () {

  var table = $("#emailsent").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "customeremail/get_customer_emails_sent",
      dataSrc: "",
    },

    columns:[
      {
        title: 'ID',
        data: 'id'
      },
      {
        title: 'Email Id',
        data: 'emailId'
      },
      {
        title: 'Campaign Id',
        data: 'campaignId'
      },
      {
        title: 'Email Sent',
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
  var rows_selected = $("#marketing").DataTable().column(0).checkboxes.selected();

  if(rows_selected.length < 1){
    $('#emails').text('empty');
    return ;
  }
  
  var rowIds = [];

  $.each(rows_selected, function(index, rowId){
    rowIds.push(rowId);

  });

  $('#reservationIds').text(JSON.stringify(rowIds));

  $('#sendEmailsModal').modal('show');



}



function sendMultipleEmails(){

  let ids = $('#reservationIds').text();
  let templateId = $('#templateId option:selected').val();
  if(reservationIds == 'empty'){
    alertify['error']('Please select rows');
    return;
  }

  if(templateId == 0){
    alertify['error']('Please select a email template!');
    return;
  }

  let data = {
      ids: ids,
      templateId: templateId
  }

  $.post(globalVariables.baseUrl + "events/send_multiple_emails", data, function(data){
      $('#closeEmailModal').click();
      data = JSON.parse(data);
      alertify[data.status](data.message);
  });

}