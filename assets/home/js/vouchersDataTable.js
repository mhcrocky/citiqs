var globalEmails = (function() {
  return '';
}());

getEmailTemplates();
$(document).ready(function () {

  var table = $("#report").DataTable({
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
          return '<button class="btn btn-primary" onclick="toggleActivated(this, '+data.id+', 1)">Deactivate</button>';
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
    $(el).text(text);
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
