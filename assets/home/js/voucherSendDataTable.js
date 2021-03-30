


$(document).ready(function () {


  var table = $("#vouchersend").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "Api/Voucher/vouchersend",
      dataSrc: "",
    },
    columns: [
      {
        title: "ID",
        data: "id",
      },
      {
        title: "Name",
        data: "name",
      },
      {
        title: "Email",
        data: "email",
      },
      {
        title: "Send",
        data: null,
        "render": function (data, type, row) {
          if(data.send == 1){
            return 'Yes';
          }
          return 'No';
        }
      },
      {
        title: "Voucher Description",
        data: "description",
      },
      {
        title: "Date Created",
        data: "datecreated",
      }
      
    ],
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

  $.post(globalVariables.baseUrl + 'Api/Voucher/create', data, function(data) {
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


function translateText(text){
  $.post(globalVariables.baseUrl + 'voucher/translate_lang', {text: text}, function(data) {
    return data;
  });
}
