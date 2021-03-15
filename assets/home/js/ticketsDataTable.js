$(document).ready(function () {
  //Options
  templateGlobals.templateHtmlId = 'templateHtml';
  $("#guestTicketCheck").change(function () {
    if (this.checked) {
      $("#guestTicket").val(1);
      return $(this).prop("checked", true);
    }
    $("#guestTicket").val(0);
    return $(this).prop("checked", false);
  });

  $("#ticketSwapCheck").change(function () {
    if (this.checked) {
      $("#ticketSwap").val(1);
      return $(this).prop("checked", true);
    }
    $("#ticketSwap").val(0);
    return $(this).prop("checked", false);
  });

  $("#partialAccessCheck").change(function () {
    if (this.checked) {
      $("#partialAccess").val(1);
      return $(this).prop("checked", true);
    }
    $("#partialAccess").val(0);
    return $(this).prop("checked", false);
  });

  $("#soldout").change(function () {
    if (this.checked) {
      $("#soldoutExpired").val(1);
      return $(this).prop("checked", true);
    }
    $("#soldoutExpired").val(0);
    return $(this).prop("checked", false);
  });

  //Add Ticket
  $("#visible").change(function () {
    if (this.checked) {
      //var returnVal = confirm("Are you sure?");
      $("#ticketVisible").val(1);
      return $(this).prop("checked", true);
    }
    $("#ticketVisible").val(0);
    return $(this).prop("checked", false);
  });
  $("#group").on("change", function () {
    var group = $("#group option:selected").val();
    $("#ticketGroup").val(group);
  });
  $("#ticketType").on("change", function () {
    var type = $("#ticketType option:selected").val();
    if (type == "group") {
      $("#group").prop("disabled", true);
    } else {
      $("#group").prop("disabled", false);
    }
    $("#ticketTypeVal").val(type);
  });
  $("#ticketEvent").on("change", function () {
    var event = $("#ticketEvent option:selected").val();
    $("#eventId").val(event);
  });
  $("#ticketEmailTemplate").on("change", function () {
    var emailTemplate = $("#ticketEmailTemplate option:selected").val();
    $("#ticketEmailTemplateId").val(emailTemplate);
  });

  $("#ticketCurrency").on("change", function () {
    var event = $("#ticketCurrency option:selected").val();
    $("#ticketCurrencyVal").val(event);
  });

  var groupColumn = 2;
  var table = $("#tickets").DataTable({
    columnDefs: [
      {
        visible: false,
        targets: groupColumn,
      },
    ],
    ajax: {
      type: "post",
      url: globalVariables.baseUrl + "events/get_tickets",
      data: function (data) {
        data.id = $("#eventId").val();
      },
      dataSrc: "",
    },
    columns: [
      {
        title: "Design",
        data: null,
        render: function (data, type, row) {
          var html =
            '<div class="dropdown show">' +
            '<a class="text-dark" href="#" role="button" >' +
            '<i style="font-size: 37px;color: ' +
            data.ticketDesign +
            ';" class="fa fa-stop" aria-hidden="true"></i>&nbsp &nbsp &nbsp</a>' +
            "</div>";
          return html;
        },
      },

      {
        title: "Ticket Name",
        data: null,
        render: function (data, type, row) {
          return (
            '<input type="text" id="event-name" class="form-control" onchange="updateTicket('+data.ticketId+', this, \'ticketDescription\')" name="event-name" value="' +
            data.ticketDescription +
            '">'
          );
        },
      },
      {
        title: "Group",
        data: null,
        render: function (data, type, row) {
          return data;
        }
      },
      {
        title: "Quantity",
        data: null,
        render: function (data, type, row) {
          return (
            '<input type="text" id="quantity" class="form-control" onchange="updateTicket('+data.ticketId+', this, \'ticketQuantity\')" name="quantity" value="' +
            data.ticketQuantity +
            '">'
          );
        },
      },
      {
        title: "Price (Inc. VAT)",
        data: null,
        render: function (data, type, row) {
          return (
            '<input type="text" id="price" class="form-control" onchange="updateTicket('+data.ticketId+', this, \'ticketPrice\')" name="price" value="' +
            data.ticketPrice +
            '">'
          );
        },
      },
      {
        title: "Currency",
        data: null,
        render: function (data, type, row) {
          var html =
            '<select style="width: 100px;" class="form-control" id="currency" onchange="updateTicket('+data.ticketId+', this, \'ticketCurrency\')">';
          html += '<option value="0" disabled>Select Option</option>';
          var selectedEuro = "";
          var selectedUsd = "";
          if (data.ticketCurrency == "euro") {
            selectedEuro = "selected";
          } else {
            selectedUsd = "selected";
          }

          html += '<option value="euro" ' + selectedEuro + '>€ - EUR</option>';
          html += '<option value="usd" ' + selectedUsd + '>$ - USD</option>';

          html += '</select>';

          return html;
        },
      },
      {
        title: "Visible",
        data: null,
        render: function (data, type, row) {
          var checked = "";
          if (data.ticketVisible == 1) {
            checked = "checked";
          }
          return (
            '<ul><li><div class="custom-control custom-checkbox"><input style="transform: scale(1.5);" class="custom-control-input" onclick="updateCheck(this, '+data.ticketId+', '+data.ticketVisible+')" id="package-area-' +
            data.id +
            '"  type="checkbox" ' +
            checked +
            ' ><label class="custom-control-label" for="package-area-' +
            data.id +
            '"> </label>  </div>    </li></ul>'
          );
        },
      },
      {
        title: "Email Template",
        data: null,
        render: function (data, type, row) {
          var html =
            '<select style="min-width: 150px;" class="form-control" id="email_template" onchange="updateEmailTemplate(this, ' +
            data.ticketId +
            ')">';
          html += '<option value="0">Select Template</option>';
          var emails = JSON.parse(globalEmails);
          $.each(emails, function (index, email) {
            let template_name = email.template_name;
            if (data.emailId == email.id) {
              html +=
                '<option value="' +
                email.id +
                '" selected>' +
                template_name.replace("ticketing_", "") +
                "</option>";
            } else {
              html +=
                '<option value="' +
                email.id +
                '">' +
                template_name.replace("ticketing_", "") +
                "</option>";
            }
          });
          html += "</select>";

          return html;
        },
      },
      {
        title: "Options",
        data: null,
        render: function (data, type, row) {
          return (
            "<div class='bg-success btn-edit' style='width: 30px;height: 30px;'><a class='text-light' onclick='getTicketOptions(" +
            data.ticketId +
            ")' id='edit' href='javascript:' data-toggle='modal' data-target='#editModal'><i class='fa fa-pencil p-2'><i></a></div>"
          );
        },
      },
      {
        title: "Edit Template",
        data: null,
        render: function (data, type, row) {
          if (data.emailId != "0") {
            var emails = JSON.parse(globalEmails);
            var template_name = '';
            var template_type = '';
            $.each(emails, function (index, email) {
              if(data.emailId == email.id){
                template_name = email.template_name;
                template_type = email.template_type;
              }
              
            });

            return (
              "<div class='btn btn-primary'><a class='text-light' onclick='editEmailTemplate("+data.emailId+",\""+template_name+"\",\""+template_type+"\")' href='javascript:;' data-toggle='modal' data-target='#emailTemplateModal'>Edit Email Template</a></div>"
            );
          } else {
            return "<div class='btn btn-primary'><a class='text-light' href='javascript:;'>Edit Email Template</a></div>";
          }
        },
      },
      {
        title: "",
        data: null,
        render: function (data, type, row) {
          return "<div class='bg-dark' onclick='deleteTicket("+data.ticketId+")' style='width: 30px;height: 30px;cursor: pointer;'><i style='color: #fff;' class='fa fa-trash p-2'><i></div>";
        },
      },
    ],
    order: [[groupColumn, "asc"]],
    displayLength: 25,
    createdRow: function (row, data, dataIndex) {
      $(row).attr("id", "row-" + dataIndex);
    },
    drawCallback: function (settings) {
      $("#tickets_filter").remove();
      $("#tickets_length").remove();

      var api = this.api();
      var rows = api
        .rows({
          page: "current",
        })
        .nodes();
      var last = null;

      api
        .column(groupColumn, {
          page: "current",
        })
        .data()
        .each(function (data, i) {
          var groupname = data.groupname;
          if (last !== groupname) {
            if (groupname == "") {
            } else {
              var html =
                '<div class="dropdown show">' +
                '<a class="text-dark" href="#" role="button">' +
                '<i style="font-size: 37px;color: #39495C;" class="fa fa-stop" aria-hidden="true"></i>&nbsp &nbsp &nbsp</a>' +
                "</div>";

              $(rows)
                .eq(i)
                .before(
                  '<tr class="group">' +
                    "<td>" +
                    html +
                    '</td><td colspan="3">' +
                    '<input type="text" id="group-name" class="form-control" name="group-name" onchange="updateGroup(this, '+data.ticketGroupId+')" value="' +
                    groupname +
                    '">' +
                    '</td><td></td><td><ul><li><div class="custom-control custom-checkbox"><input style="transform: scale(1.5);" class="custom-control-input" id="package-area-0' +
                    i +
                    '" type="checkbox" checked="checked" ><label class="custom-control-label" for="package-area-0' +
                    i +
                    '"> </label>  </div>    </li></ul></td><td></td>' +
                    "<td></td><td></td>" +
                    '<td><div class="bg-dark" style="width: 30px;height: 30px;">' +
                    '<i style="color: #fff;" class="fa fa-trash p-2"><i></div></td></tr>'
                );
            }

            last = groupname;
          }
        });
    },
  });

  table.rowReordering();

  /*Order by the grouping
    $('#tickets tbody').on('click', 'tr.group', function() {
        var currentOrder = table.order()[0];
        if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
            table.order([groupColumn, 'desc']).draw();
        } else {
            table.order([groupColumn, 'asc']).draw();
        }
    });
    */
});

$(function () {
  $(".input-group.date").datepicker({
    format: "yyyy-mm-dd",
    calendarWeeks: true,
    todayHighlight: true,
    autoclose: true,
  });
});

function getTicketOptions(ticketId) {
  defaultOptions();
  $('.ql-snow').remove();
  $("#ticketId").val(ticketId);
  $.get(
    globalVariables.baseUrl + "events/get_ticket_options/" + ticketId,
    function (data) {
      if (data == "") {
        return defaultOptions();
      }
      data = JSON.parse(data);
      $.each(data, function (index, value) {
        if (index == "ticketExpired") {
          $("#" + value).prop("checked", true);
        }
        if (index == "ticketExpired") {
          $("#" + value).prop("checked", true);
        }
        //$('.ql-editor').html('test')
        console.log(index);
        $("#" + index).val(value);
      });
    }
  );
}

function defaultOptions() {
  $("#ticketId").val("");
  $("#guestTicket").val(1);
  $("#ticketSwap").val(1);
  $("#partialAccess").val(1);
  $("#nonSharedTicketFee").val(1);
  $("#sharedTicketFee").val(1);
  $("#manually").prop("checked", true);
  $("#startDate").val("");
  $("#startTime").val("");
  $("#endDate").val("");
  $("#endTime").val("");
  $("#soldoutExpired").val(0);
  $("#mailPerAmount").val(1);
  $("#emailAddress").val("");
}

function chooseEmailTemplate(emailId, ticketId) {
  var html =
    '<select style="min-width: 150px;" class="form-control" id="email_template" onchange="updateEmailTemplate(this, ' +
    ticketId +
    ')">';
  html += '<option value="0">Select Template</option>';
  var emails = JSON.parse(globalEmails);
  $.each(emails, function (index, email) {
    let template_name = email.template_name;
    if (emailId == email.id) {
      html +=
        '<option value="' +
        email.id +
        '" selected>' +
        template_name.replace("ticketing_", "") +
        "</option>";
    } else {
      html +=
        '<option value="' +
        email.id +
        '">' +
        template_name.replace("ticketing_", "") +
        "</option>";
    }
  });
  html += "</select>";
  $("#selectEmailTemplate").html(html);
  $("#saveEmailTemplates").attr(
    "onclick",
    "saveEmailTemplate(this, " + emailId + ")"
  );
}

function saveEmailTemplate(el, id) {
  updateEmailTemplate(el, id);
  setTimeout(() => {
    window.location.reload();
  }, 500);
}

function updateTicket(id, el, param) {
  var value = '';
  if(param == 'ticketCurrency'){
    value = $(el).find("option:selected").val();
  } else {
    value = $(el).val();
  }
  
  let data = { 
    id: id,
    param: param,
    value: value
  };

  $.post(globalVariables.baseUrl + "events/update_ticket", data, function (data) {
    return true;
  });
}

function updateGroup(el, id) {
  let data = { 
    id: id,
    groupname: $(el).val()
  };

  $.post(globalVariables.baseUrl + "events/update_group", data, function (data) {
    return true;
  });
}

function updateCheck(el, id, val) {
  let updateVal = (val == 1) ? 0 : 1;
  $(el).attr('onclick', 'updateCheck(this, '+updateVal+')');
  let data = { 
    id: id,
    param: 'ticketVisible',
    value: updateVal
  };

  $.post(globalVariables.baseUrl + "events/update_ticket", data, function (data) {
    return true;
  });
}

function deleteTicket(ticketId) {
  if (window.confirm("Are you sure?")) {
  let data = { 
    ticketId: ticketId
  };

  $.post(globalVariables.baseUrl + "events/delete_ticket", data, function (data) {
    $("#tickets").DataTable().ajax.url(globalVariables.baseUrl + "events/get_tickets").load();
  });
}
}

function updateEmailTemplate(el, id) {
  let emailId = $(el).find("option:selected").val();
  $.post(
    globalVariables.baseUrl + "events/update_email_template",
    { id: id, emailId: emailId },
    function (data) {
      return true;
    }
  );
}

function editEmailTemplate(id, template_name, template_type) {
  $.post(
    globalVariables.baseUrl + "events/get_email_template",
    { id: id },
    function (data) {
      let templateContent = JSON.parse(data);
      $('#customTemplateName').val(template_name);
      $('#templateType').val(template_type);
      $('#updateEmailTemplate').attr('onclick','createEmailTemplate("selectTemplateName", "customTemplateName", "templateType", "'+id+'")');
      tinymce.activeEditor.setContent(templateContent);
      
    }
  );
}

$('#updateEmailTemplate').on('click', function(){
  setTimeout(() => {
    $('#closeEmailTemplate').click();
  }, 777);
});
