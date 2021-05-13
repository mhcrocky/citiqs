var globalEmails = (function() {
  return emailsTemplates;
}());

getEmailTemplates();


$(document).ready(function () {
  $('#editModal').on('hidden.bs.modal', function () {
    $('#resetTicketOptions').click();
  });

  $('#guestlistModal').on('hidden.bs.modal', function () {
    $('#tab01').click();
  });
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

  $("#soldoutVisibility").change(function () {
    if (this.checked) {
      $("#soldoutVisible").val(0);
      $("#soldoutMessage").prop("disabled", true);
      return $(this).prop("checked", true);
    }
    $("#soldoutVisible").val(1);
    $("#soldoutMessage").prop("disabled", false);
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
      $("#ticketEmailTemplate").prop("disabled", true);
      $("#price").prop("disabled", true);
      $("#price").prop("required", false);
    } else {
      $("#group").prop("disabled", false);
      $("#ticketEmailTemplate").prop("disabled", false);
      $("#price").prop("disabled", false);
      $("#price").prop("required", true);
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

  $("#automatically").on("change", function () {
    $('.timestamp').prop("disabled", true);
  });

  $("#manually").on("change", function () {
    $('.timestamp').prop("disabled", false);
    let today = dayjs().format('DD-MM-YYYY');
    $('#startDate').val(today);
    let input = document.getElementById('endDate');
    input.select();
  });

  $("#ticketCurrency").on("change", function () {
    var event = $("#ticketCurrency option:selected").val();
    $("#ticketCurrencyVal").val(event);
  });

  var groupColumn = 3;
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
    paging:   false,
    rowCallback: function(row, data, index) {
      if(data.ticketId == 0){
        $(row).html('<td style="height: 1px;width:100%" colspan="11"></td>');
      }
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
        title: "Guestlist",
        data: null,
        render: function (data, type, row) {
          return '<a style="padding-top: 10px;display: inline-flex;" class="text-dark" href="javascript:;" onclick="addGuestModal('+data.ticketId+')" data-toggle="modal" data-target="#guestlistModal"><span class="font-weight-bold mr-2">'+data.guestlistCount+'</span><i class="gg-user-list ml-2"></i></a>';

        },
        createdCell: function (td, cellData, rowData, row, col) {
          
            $(td).css({'display': 'flex', 'justify-content': 'center', 'align-items': 'center', 'width': '100px'});
 
          
         }
      },

      {
        title: "Ticket Name",
        data: null,
        render: function (data, type, row) {
          return (
            '<input style="min-width: 120px;" type="text" id="event-name" class="form-control" onchange="updateTicket('+data.ticketId+', this, \'ticketDescription\')" name="event-name" value="' +
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
        title: "Price (Inc. VAT)",
        data: null,
        render: function (data, type, row) {
          return (
            '<input style="width: 80px;" type="text" id="price" class="form-control" onchange="updateTicket('+data.ticketId+', this, \'ticketPrice\')" name="price" value="' +
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
          if (data.ticketCurrency == "usd") {
            selectedUsd = "selected";
          } else {
            selectedEuro = "selected";
          }

          html += '<option value="euro" ' + selectedEuro + '>€ - EUR</option>';
          html += '<option value="usd" ' + selectedUsd + '>$ - USD</option>';

          html += '</select>';

          return html;
        },
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
            var template_subject = '';
            $.each(emails, function (index, email) {
              if(data.emailId == email.id){
                template_name = email.template_name;
                template_type = email.template_type;
                template_subject = email.template_subject;
              }
              
            });

            return (
              "<div class='btn btn-primary'><a class='text-light' onclick='editEmailTemplate("+data.emailId+",\""+template_name+"\",\""+template_type+"\", `"+template_subject+"`)' href='javascript:;' data-toggle='modal' data-target='#emailTemplateModal'>Edit Email Template</a></div>"
            );
          } else {
            return "<div class='btn btn-primary'><a class='text-light' onclick='editEmailTemplate("+data.ticketId+")' href='javascript:;' data-toggle='modal' data-target='#emailTemplateModal'>Add Email Template</a></div>";
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
      $(row).addClass("dataTable-row");
      $(row).attr("data-ticketId", data.ticketId);
      $(row).attr("data-groupId", data.groupId);
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
            if (groupname == "" || groupname == null || groupname == 'null') {

            } else {
              var html =
                '<div class="dropdown show">' +
                '<a class="text-dark" href="#" role="button">' +
                '<i style="font-size: 37px;color: #39495C;" class="fa fa-stop" aria-hidden="true"></i>&nbsp &nbsp &nbsp</a>' +
                "</div>";
                $(rows)
                .eq(i)
                .before(
                  '<tr class="dataTable-row group" data-ticketid="groupId'+data.groupId+'" data-groupId="'+data.groupId+'">' +
                    "<td>" +
                    html +
                    '</td><td colspan="4">' +
                    '<input type="text" id="group-name" class="form-control" name="group-name" onchange="updateGroup(this, '+data.ticketGroupId+', \'groupname\')" value="' +
                    groupname +
                    '">' +
                    '</td><td><input type="text" class="form-control" onchange="updateGroup(this, '+data.ticketGroupId+', \'groupQuantity\')" name="quantity" value="' +data.groupQuantity +'">'+
                    '</td><td><ul><li><div class="custom-control custom-checkbox"><input style="transform: scale(1.5);" class="custom-control-input" id="package-area-0' +
                    i +
                    '" type="checkbox" checked="checked" ><label class="custom-control-label" for="package-area-0' +
                    i +
                    '"> </label>  </div>    </li></ul></td><td></td>' +
                    "<td></td><td></td>" +
                    '<td><div class="bg-dark" onclick="deleteGroup('+data.groupId+')" style="width: 30px;height: 30px;cursor: pointer;">' +
                    '<i style="color: #fff;" class="fa fa-trash p-2"><i></div></td></tr>'
                );
              
              last = groupname;
            }

          }
        });
    },
  });

  $( "#tickets" ).sortable({
    items: ".dataTable-row:not(.group)",
    cursor: 'move',
    opacity: 0.6,
    update: function() {
      var lastGroupId = 0;
      var tickets = [];
      $('.dataTable-row').each(function(index,element) {
        var ticketId = $(this).attr('data-ticketId');
        if(ticketId == 0){ return; }
        if(index == 0){
          lastGroupId = $(this).attr('data-groupId');
          if(isNaN(lastGroupId)){ return; }
          var ticket = {'ticketId': $(this).attr('data-ticketId'), 'groupId': lastGroupId };
          tickets[index] = ticket;
          return;
        }

        if(isNaN(ticketId)){
          lastGroupId = $(this).attr('data-groupId');
          return;
        }
        var ticket = {'ticketId': ticketId, 'groupId':lastGroupId };
        tickets[index] = ticket;

      });

      $.post(globalVariables.baseUrl + "events/update_ticket_group", {tickets: JSON.stringify(tickets)}, function (data) {
        $("#tickets").DataTable().ajax.reload();
      });
    }
  });



  var guestlistTable = $("#guestlist").DataTable({
    processing: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    ajax: {
      type: "get",
      url: globalVariables.baseUrl + "events/get_guestlists",
      dataSrc: "",
    },
    columns: [
      {
        title: "ID",
        data: "id",
      },
      {
        title: "Guest Name",
        data: "guestName",
      },
      {
        title: "Guest Email",
        data: "guestEmail",
      },
      {
        title: "Ticket Quantity",
        data: "ticketQuantity",
      },
      {
        title: "Ticket ID",
        data: "ticketId",
      },
      {
        title: "Transaction ID",
        data: "transactionId",
      },
      {
          title: 'Resend',
          data: null,
          "render": function(data, type, row) {
            return '<button class="btn btn-primary" onclick="confirmResendTicket(\''+data.transactionId+'\')">Resend</button>';
        }
       }
      
    ],
    order: [[1, 'asc']]
  });

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
  var startPicker = new Pikaday({
    field: document.getElementById('startDate'),
    format: 'DD-MM-YYYY'
  });
  var endPicker = new Pikaday({
    field: document.getElementById('endDate'),
    format: 'DD-MM-YYYY'
  });
});

function checkTicketTimestamp(){

    let startDate = $('#startDate').val().split('-');
    let endDate = $('#endDate').val().split('-');
    let startTime = startDate[2] + '-' + startDate[1] + '-' + startDate[0] +' '+ $('#startTime').val();
    let endTime = endDate[2] + '-' + endDate[1] + '-' + endDate[0] + ' '+ $('#endTime').val();
    if(dayjs(endTime) < dayjs(startTime)){
      $('#submitEventForm').prop('disabled', true);
      $('.timestamp-error').show();
      $('#endDate').removeClass('clear-border-color').addClass('invalid-timestamp');
      $('#endTime').removeClass('clear-border-color').addClass('invalid-timestamp');
  }
  return ;
}

function timestampTicketOnFocus(){
  $('#submitEventForm').prop('disabled', false);
  $('.invalid-timestamp').addClass('clear-border-color').removeClass('invalid-timestamp');
  $('#timestamp-error').empty();
  return ;
}

function getTicketOptions(ticketId) {
  $('#resetTicketOptions').click();
  $('.ql-snow').remove();
  $("#ticketId").val(ticketId);
  $.get(
    globalVariables.baseUrl + "events/get_ticket_options/" + ticketId,
    function (data) {
      if (data == "") {
        return ;
      }
      data = JSON.parse(data);
      $.each(data, function (index, value) {
        if (index == "ticketExpired") {
          $("#" + value).prop("checked", true);
        }
        if (index == "soldoutExpired") {
          let checked = (value == 1) ? true : false;
          $("#soldout").prop("checked", checked);
        }

        if (index == "soldoutVisible") {
          let checked = (value == 0) ? true : false;
          $("#soldoutMessage").prop("disabled", checked);
          $("#soldoutVisibility").prop("checked", checked);
        }

        if (index == "guestTicket") {
          let checked = (value == 1) ? true : false;
          $("#guestTicketCheck").prop("checked", checked);
        }
        //$('.ql-editor').html('test')
        $("#" + index).val(value);
      });
    }
  );
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

function updateGroup(el, id, param) {
  console.log('updateGroup');
  let data = { 
    id: id,
    param: param,
    value: $(el).val()
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

function saveTicket(e){
  e.preventDefault();
  let data = $('#ticketForm').serialize();
  $.post(globalVariables.baseUrl + 'events/save_ticket', data, function(data){
      alertify['success']('Ticket is saved successfully!');
      $("#tickets").DataTable().ajax.reload();
      $('#ticketForm').trigger("reset");
      $('#ticketClose').click();
  });
}

function saveTicketOptions(e){
  e.preventDefault();
  let data = $('#editTicketOptions').serialize();
  $.post(globalVariables.baseUrl + 'events/save_ticket_options', data, function(data){
      alertify['success']('Ticket options are saved successfully!');
      $("#tickets").DataTable().ajax.reload();
      $('#ticketOptionsClose').click();
  });
}

function deleteTicket(ticketId) {
  if (window.confirm("Are you sure?")) {
    let data = { 
      ticketId: ticketId
    };
    
    $.post(globalVariables.baseUrl + "events/delete_ticket", data, function (data) {
      $("#tickets").DataTable().ajax.reload(); $("#tickets").DataTable().clear().draw();
    });
  }
}

function deleteGroup(groupId) {
  if (window.confirm("Are you sure?")) {
    let data = { 
      groupId: groupId
    };
    
    $.post(globalVariables.baseUrl + "events/delete_group", data, function (data) {
      $('#group_'+groupId).remove();
      $("#tickets").DataTable().ajax.reload();
    });
  }
}

function updateEmailTemplate(el, id) {
  let emailId = $(el).find("option:selected").val();
  $.post(
    globalVariables.baseUrl + "events/update_email_template",
    { id: id, emailId: emailId },
    function (data) {
      $("#tickets").DataTable().ajax.reload();
      return true;
    }
  );
}

function editEmailTemplate(id, template_name = '', template_type = '', template_subject = '') {
  if(template_name == ''){
    $('#templateType').val('tickets');
    $('#updateEmailTemplate').attr('onclick','createTicketEmailTemplate("selectTemplateName", "customTemplateName", "templateType", '+id+')');
    return ;
      
  }
  $.post(
    globalVariables.baseUrl + "events/get_email_template",
    { id: id },
    function (data) {
      let templateContent = JSON.parse(data);
      $('#customTemplateName').val(template_name);
      $('#customTemplateSubject').val(template_subject);
      $('#templateType').val(template_type);
      $('#updateEmailTemplate').attr('onclick','createEmailTemplate("selectTemplateName", "customTemplateName", "customTemplateSubject", "templateType", "'+id+'")');
      templateContent = templateContent.replaceAll('[QRlink]', globalVariables.baseUrl+'assets/images/qrcode_preview.png');
      tinymce.activeEditor.setContent(templateContent);
      
    }
  );
}

function getEmailTemplates() {
  $.get(globalVariables.baseUrl + "events/get_email_templates",function (data) {
      globalEmails = data;
    }
  );
}

function emailTemplatesOptions() {
  $.get(globalVariables.baseUrl + "events/get_email_templates",function (data) {
      let emails = JSON.parse(data);
      var html = '<option value="">Select Option</option>';
      $.each(emails, function (index, email) {
          html += '<option value="' + email.id + '" >' + email.template_name + '</option>';
      });
      $('#ticketEmailTemplate').html(html);

    }
  );
}

$('#updateEmailTemplate').on('click', function(){
  getEmailTemplates();
  $("#tickets").DataTable().ajax.reload();
  setTimeout(() => {
    $('#closeEmailTemplate').click();
    emailTemplatesOptions();
  }, 777);
});





function createTicketEmailTemplate(selectTemplateValueId, customTemplateNameId, customTemplateSubjectId, customTemplateTypeId, ticketId) {
  let selectTemplate = document.getElementById(selectTemplateValueId);
  let customTemplate = document.getElementById(customTemplateNameId);
  let customTemplateSubject = document.getElementById(customTemplateSubjectId);
  let customTemplateType = document.getElementById(customTemplateTypeId);

  let selectTemplateName = selectTemplate.value.trim();
  let customTemplateName = customTemplate.value.trim();
  let templateSubject = customTemplateSubject.value.trim();
  let templateType = customTemplateType.value.trim();
  let templateHtml = tinyMCE.get(templateGlobals.templateHtmlId).getContent().replaceAll(globalVariables.baseUrl + 'assets/images/qrcode_preview.png', '[QRlink]').trim();
  if (!templateHtml) {
      let message = 'Empty template.'
      alertify.error(message);
      return;
  }

  if (selectTemplateName && customTemplateName) {
      let message = 'Not allowed. Select template or give template custom name.'
      alertify.error(message);
      selectTemplate.style.border = '1px solid #f00';
      customTemplate.style.border = '1px solid #f00';
      return;
  }

  if (!selectTemplateName && !customTemplateName) {
      alertify.error('Select template or give template custom name');
      selectTemplate.style.border = '1px solid #f00';
      customTemplate.style.border = '1px solid #f00';
      return;
  }

  selectTemplate.style.border = 'initial';
  customTemplate.style.border = 'initial';

  let templateName = (selectTemplateName) ? selectTemplateName : customTemplateName;
  let url = globalVariables.baseUrl + 'Ajaxdorian/createEmailTemplate';
  let post = {
      'templateName' : templateName,
      'templateHtml' : templateHtml,
      'ticketId' : ticketId,
      'templateType' : templateType,
      'templateSubject' : templateSubject,
  };

  sendAjaxPostRequest(post, url, 'createEmailTemplate', createTicketEmailTemplateResponse, [selectTemplate, customTemplate]);
}

function createTicketEmailTemplateResponse(selectTemplate, customTemplate, response) {
  alertifyAjaxResponse(response);

  $.post(globalVariables.baseUrl + "events/update_email_template",{ id: response['ticketId'], emailId: response['id'] },
    function (data) {
      $("#tickets").DataTable().ajax.reload();
      return true;
    }
  );
  selectTemplate.value = '';
  customTemplateSubject.value = '';
  customTemplate.value = '';
  tinymce.get(templateGlobals.templateHtmlId).setContent('');
  return;
}

function addGuestModal(ticketId) {
  $('#guestTicketId').val(ticketId);
  $("#guestlist").DataTable()
        .columns( 4 )
        .search( '^'+ticketId+'$', true, false )
        .draw();
}

function addGuestForm() {
  $('#submitGuestlist').click();
}

function addGuest(e){
  e.preventDefault();
  $('.form-control').removeClass('input-clear');
  let guestName = $('#guestName').val();
  let guestEmail = $('#guestEmail').val();
  let ticketQuantity = $('#guestTickets').val();

  if (guestName == '' || guestEmail == '' || ticketQuantity == '') {
    return;
  }
  let data = {
      guestName: guestName,
      guestEmail: guestEmail,
      ticketQuantity: ticketQuantity,
      eventId:  $('#eventId').val(),
      ticketId: $('#guestTicketId').val()
  }


  //console.log(data);

  $('#submitGuestlist').prop('disabled', true);

  $.post(globalVariables.baseUrl + "events/add_guest", data, function(data){
      $('#submitGuestlist').prop('disabled', false);
      $('#resetGuestForm').click();
      $('#closeModal').click();
      $('.form-control').addClass('input-clear');
      $("#tickets").DataTable().ajax.reload();
      $("#guestlist").DataTable().ajax.reload();
      alertify['success']('Guest is added successfully');

  });

}


function importExcelFile(){

  let data = {
      eventId: $('#eventId').val(),
      guestName: $('#importGuestName option:selected').val(),
      guestEmail: $('#importGuestEmail option:selected').val(),
      ticketQuantity: $('#importTickets option:selected').val(),
      ticketId: $('#guestTicketId').val(),
      jsonData: $('#jsonData').text(),
  }

  //console.log(data);

  $.post(globalVariables.baseUrl + "events/import_guestlist", data, function(data){
      $("#guestlist").DataTable().ajax.reload();
      $('#resetUpload').click();
      $('#fileForm').removeClass('d-none');
      $('#filterFormSection').addClass('d-none');
      $('#uploadExcel').removeClass('d-none');
      $('#importExcelFile').addClass('d-none');
      $('#guestlistModal').modal('toggle');
      $('#tab01').click();
      $("#tickets").DataTable().ajax.reload();
      alertify['success']('The guest list is imported successfully');
  });

}

function confirmResendTicket(transactionId){
  bootbox.confirm({
    message: "Do you  to send the mail to support@tiqs.com as well?",
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
      if(result == true){
        resendTicket(transactionId, 1);
      } else {
        resendTicket(transactionId);
      }
    }
});
}

function resendTicket(transactionId, sendTo = 0) {
  let data = {
    transactionId: transactionId,
    sendTo: sendTo
  };
  $.post(
    globalVariables.baseUrl + "events/resend_reservation",
    data,
    function (data) {
      alertify.success("Ticket is resend successfully!");
    }
  );
}
