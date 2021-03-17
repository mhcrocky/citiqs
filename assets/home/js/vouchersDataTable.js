var globalEmails = (function() {
  return '';
}());

getEmailTemplates();

$('.js-select2').select2({
  placeholder: "Select product",
  allowClear: true,
});
$('.select2-container').width('100%');

$('b[role="presentation"]').hide();
$('.select2-selection__arrow').append('<i class="fa fa-sort-desc"></i>');


$(document).ready(function () {

  var table = $("#voucher").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "Api/Voucher/vouchers",
      dataSrc: "",
    },
    columns: [
      {
        title: "ID",
        data: "id",
      },
      {
        title: "Code",
        data: "code",
      },
      {
        title: "Description",
        data: "description",
      },
      {
        title: "Percent",
        data: "percent",
      },
      {
        title: "Amount",
        data: "amount",
      },
      {
        title: "Percent Used",
        data: "percentUsed",
      },
      {
        title: "Active",
        data: null,
        "render": function (data, type, row) {
          if(data.active == 1){
            return 'Yes';
          }
          return 'No';
        }
      },
      {
        title: "Number Of Times",
        data: "numberOfTimes",
      },
      {
        title: "Activated",
        data: null,
        "render": function (data, type, row) {
          if(data.activated == 1){
            return '<button class="btn btn-primary" onclick="toggleActivated(this, '+data.id+', 0)">Activated</button>';
          }
          return '<button style="color: #343a40 !important; background: #ffc72a !important" class="btn btn-primary" onclick="toggleActivated(this, '+data.id+', 1)">Deactivate</button>';
        }
      },
      {
        title: "Email Template",
        data: null,
        "render": function (data, type, row) {
          var html = '<select style="min-width: 150px;" class="form-control" id="email_template" onchange="updateEmailTemplate(this, ' + data.id +')">';
          html += '<option value="0">Select Template</option>';
          var emails = JSON.parse(globalEmails);
          $.each(emails, function (index, email) {
            let template_name = email.template_name;
            if (data.emailId == email.id) {
              html += '<option value="' + email.id + '" selected>' + template_name + '</option>';
            } else {
              html += '<option value="' + email.id +'">' + template_name + '</option>';
            }
          });
          html += "</select>";

          return html;
        }
      },
      {
        title: "Product Id",
        data: "productId",
      }
    ],
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
      order: [[1, 'asc']]
  });

  $('#report_filter').addClass('text-right');
  $('#report_filter label').addClass('text-left');

});

function toggleActivated(el, id, activated) {
  let data = {
    id: id,
    activated: activated
  };
  $.post(globalVariables.baseUrl + 'Api/Voucher/voucher_activated', data, function(data) {
    let text = (activated == 1) ? 'Activated' : 'Deactivate';
    let color = (activated == 1) ? '#fff' : '#343a40';
    let background = (activated == 1) ? '#007bff' : '#ffc72a';
    $(el).text(text);
    $(el).attr('style', 'color: '+color+' !important; background:'+background+' !important');
    let onclickVal = (activated == 1) ? 0 : 1;
    $(el).attr('onclick','toggleActivated(this, '+id+', '+onclickVal+')');
    return;
}).fail(function(response) {
    response = JSON.parse(response.responseText);
    return;
});
}

function getEmailTemplates() {
  $.get(globalVariables.baseUrl + "Api/Voucher/email_templates",function (data) {
      globalEmails = data;
    }
  );
}


function emailTemplatesOptions() {
  $.get(globalVariables.baseUrl + "Api/Voucher/email_templates",function (data) {
      let emails = JSON.parse(data);
      var html = '<option value="">Select Option</option>';
      $.each(emails, function (index, email) {
          html += '<option value="' + email.id + '" >' + email.template_name + '</option>';
      });
      $('#emailId').html(html);
      $('#emailTemplate').html(html);


    }
  );
}

function updateEmailTemplate(el, id) {
  let emailId = $(el).find("option:selected").val();
  $.post(
    globalVariables.baseUrl + "Api/Voucher/update_email_template",
    { id: id, emailId: emailId },
    function (data) {
      return true;
    }
  );
}

function voucherForm() {
  $("#submitForm").click();
}

function voucherCode() {
  let val = $('#status option:selected').val();
  if (val != 'unique') {
      $("#code_input").append(
          '<input type="text" id="code" class="input-w border-50 form-control" name="code" required>');
      $("#voucher_code").fadeIn("slow", function() {
          $('#voucher_code').show();
      });

  } else {
      $("#voucher_code").fadeIn("slow", function() {
          $('#voucher_code').hide();
          $("#code_input").empty();
      });
  }
}

function saveVoucher(e) {
  e.preventDefault();
  $('.form-control').removeClass('input-clear');
  if ($('.form-control:invalid').length > 0) {
      return;
  }

  let data = {
      vendorId: $('#vendorId').val(),
      codes: $('#codes').val(),
      description: $('#description').val(),
      status: $('#status option:selected').val(),
      percentUsed: $('#percentUsed option:selected').val(),
      expire: $('#expire').val(),
      active: $('#active').val(),
      productId: $('#productId').find(':selected').val(),
      emailId: $('#emailId option:selected').val()
  }

  if ($('#code').length > 0) {
      data.code = $('#code').val();
  }

  let amount = $('#amount').val();
  let productId = $('#productId').find(':selected').val();

  if (amount === "") {
      data.percent = $('#percent').val();
  } else {
      data.amount = $('#amount').val();
  }

  if (productId !== "") {
      data.productId = $('#productId').find(':selected').val();
  }

  $.post('<?php echo base_url(); ?>Api/Voucher/create', data, function(data) {
      $('#voucher').DataTable().ajax.reload();
      alertify[data.status](data.message);
      $('.form-control').addClass('input-clear');
      $('#my-form').trigger("reset");
      $('#closeAddVoucherModal').click();
      $('#voucher_code').hide();
      $("#code_input").empty()
      return;
  }).fail(function(response) {
      response = JSON.parse(response.responseText);
      alertify[response.status](response.message);
      return;
  });

}

function disabledField(el, field) {
  let value = $(el).val();
  $('#' + field).attr('required', true);
  if (value != '') {
      $('#' + field).attr('disabled', true);
      $('#' + field).attr('required', false);
      $('.form-control:disabled').attr('style', 'background-color: rgb(233, 236, 239) !important;');
  } else {
      $('#' + field).attr('disabled', false);
      $('#' + field).attr('required', true);
      $('#' + field).attr('style', 'background-color: #fff');
  }
}

function saveVoucherTemplate() {
  if (typeof templateGlobals.templateId === 'undefined') {
      createEmailTemplate('selectTemplateName', 'customTemplateName', 'templateType');
  } else {
      createEmailTemplate('selectTemplateName', 'customTemplateName' , 'templateType', templateGlobals.templateId);
  }
  emailTemplatesOptions();
  getEmailTemplates();
  $('#voucher').DataTable().ajax.reload();
  $('#emailTemplateClose').click();
  setTimeout(() => {
      //window.location.reload();
  }, 2500);
  return;
}
function redirectToTemplates(){
  window.location.href = globalVariables.baseUrl + "voucher/listTemplates";
}

function updateActivated(value) {
  var rows_selected = $("#voucher").DataTable().column(0).checkboxes.selected();
  var rowIds = [];
  $.each(rows_selected, function(index, rowId){
    rowIds[index] = rowId;
  });

  var data = {
    ids: JSON.stringify(rowIds),
    value: value,
    action: 'update_activated'
  }
  
  if(rowIds.length > 0){
    $.post(globalVariables.baseUrl + 'Api/Voucher/multiple_actions', data, function(data) {
      $('#voucher').DataTable().ajax.reload();
      alertify[data.status](data.message);
      return;
  }).fail(function(response) {
      response = JSON.parse(response.responseText);
      alertify[response.status](response.message);
      return;
  });

    
  }
  
}

function deleteVouchers() {
  var rows_selected = $("#voucher").DataTable().column(0).checkboxes.selected();
  var rowIds = [];
  $.each(rows_selected, function(index, rowId){
    rowIds[index] = rowId;
  });

  var data = {
    ids: JSON.stringify(rowIds),
    value: '',
    action: 'delete'
  }
  
  if(rowIds.length > 0){
    if (window.confirm("Are you sure?")) {
      $.post(globalVariables.baseUrl + 'Api/Voucher/multiple_actions', data, function(data) {
        $('#voucher').DataTable().ajax.reload();
        alertify[data.status](data.message);
        return;
      }).fail(function(response) {
        response = JSON.parse(response.responseText);
        alertify[response.status](response.message);
        return;
      });
    }
    
  }
  
}

function updateEmailTemplates() {
  var rows_selected = $("#voucher").DataTable().column(0).checkboxes.selected();
  var rowIds = [];
  $.each(rows_selected, function(index, rowId){
    rowIds[index] = rowId;
  });

  var data = {
    ids: JSON.stringify(rowIds),
    value: $('#emailTemplate option:selected').val(),
    action: 'update_emailId'
  }
  
  if(rowIds.length > 0){

      $.post(globalVariables.baseUrl + 'Api/Voucher/multiple_actions', data, function(data) {
        $('#voucher').DataTable().ajax.reload();
        $('closeEditVoucherTemplateModal').click();
        $('#emailTemplate').val('');
        alertify[data.status](data.message);
        return;
      }).fail(function(response) {
        response = JSON.parse(response.responseText);
        alertify[response.status](response.message);
        return;
      });
    
  }
  
}
