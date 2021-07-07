$(document).ready(function () {
  var options = {
    allow_empty: true,
    filters: [
      {
        id: "tbl_bookandpay.reservationId",
        label: "Reservation Id",
        type: "string",
        class: "reservationId",
        default_value: "",
        size: 40,
        unique: true,
      },
      {
        id: "tbl_bookandpay.TransactionID",
        label: "Transation Id",
        type: "string",
        class: "TransactionID",
        default_value: "",
        size: 40,
        unique: true,
      },
      {
        id: "tbl_bookandpay.email",
        label: "Email",
        type: "string",
        class: "email",
        default_value: "",
        size: 70,
        unique: true,
      },
      {
        id: "tbl_bookandpay.mobilephone",
        label: "Mobile Phone",
        type: "string",
        class: "mobilephone",
        default_value: "",
        size: 30,
        unique: true,
      },
      {
        id: "tbl_event_tickets.ticketPrice",
        label: "Price",
        type: "integer",
        class: "price",
        default_value: "",
        size: 30,
        unique: true,
      },
      {
        id: "tbl_events.eventname",
        label: "Event Name",
        type: "string",
        class: "eventname",
        default_value: "",
        size: 30,
        unique: true,
      },
      {
        id: "tbl_bookandpay.numberofpersons",
        label: "Quantity",
        type: "integer",
        class: "numberofpersons",
        default_value: "",
        size: 30,
        unique: true,
      },
      {
        id: "tbl_bookandpay.reservationtime",
        label: "Date",
        type: "datetime",
        class: "reservationtime",
        default_value: "",
        size: 30,
        unique: true,
      },
      {
        id: "tbl_bookandpay.tag",
        label: "Tag ID",
        type: "integer",
        class: "tag",
        default_value: "",
        size: 30,
        unique: true,
      },
    ],
  };

  $("#query-builder").queryBuilder(options);
  var sql;
  $(".parse-json").on("click", function () {
    ticketTable.ajax.reload();
    ticketTable.clear().draw();
  });

  var ticketTable = $("#report").DataTable({
    processing: true,
    colReorder: true,
    fixedHeader: true,
    deferRender: true,
    scroller: true,
    lengthMenu: [
      [5, 10, 20, 50, 100, 200, 500, -1],
      [5, 10, 20, 50, 100, 200, 500, "All"],
    ],
    pageLength: 5,
    dom: "Blfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        autoFilter: true,
        footer: true,
        text: "Export as Excel",
        className: "btn btn-success p-2 mb-3",
        sheetName: "Exported data",
      },
    ],
    ajax: {
      type: "post",
      url: globalVariables.baseUrl + "events/get_tickets_report",
      data: function (data) {
        let query = $("#query-builder").queryBuilder("getSQL", false, true).sql;
        let sql = query.replace(/\n/g, " ");
        sql = "AND (" + sql + ")";
        if (query == "") {
          data.sql = "";
        } else {
          data.sql = encodeURI(sql);
        }
        $('.has-error').removeClass('has-error');
      },
      dataSrc: "",
    },
    rowId: function (a) {
      return "row_id_" + a.order_id;
    },

    columns: [
      {
        title: "",
        data: null,
        render: function (data, type, row) {
          return (
            '<a href="javascript:;" onclick="confirmResendTicket(\'' + data.reservationId + '\')" class="btn btn-primary">Resend Ticket</a>'
          );
        },
      },
      {

        title: 'ID',
        data: 'id'

      },
      {
        title: "Event Name",
        data: "eventname",
      },
      {
        title: "Buyer Name",
        data: "name",
      },
      {
        title: "Buyer Email",
        data: "email",
      },
      {
        title: "Reservation Id",
        data: "reservationId",
      },
      {
        title: "Transaction Id",
        data: "TransactionID",
      },
      {
        title: "Buyer Mobile",
        data: "mobilephone",
      },
      {
        title: "Buyer Gender",
        data: "gender",
      },
      {
        title: "Buyer Age",
        data: "age",
      },
      {
        title: "Buyer Address",
        data: "address",
      },
      {
        title: "ZIP Code",
        data: "zipcode",
      },
      {
        title: "City",
        data: "city",
      },
      {
        title: "Country",
        data: "country",
      },
      {
        title: "Ticket Description",
        data: "ticketDescription",
      },
      {
        title: "Amount",
        data: null,
        render: function (data, type, row) {
          let amount = parseFloat(data.amount);
          return amount.toFixed(2);
        },
      },
      {
        title: "Price",
        data: null,
        render: function (data, type, row) {
          let price = parseFloat(data.price);
          return price.toFixed(2);
        },
      },
      {
        title: "Quantity",
        data: "numberofpersons",
      },
      {
        title: "Tag ID",
        data: "tag",
      },
      {
        title: "Date",
        data: "reservationtime",
      },
      /*
      {
        title: "",
        data: null,
        render: function (data, type, row) {
          let html =
            '<input type="hidden" id="' +
            data.reservationId +
            '" data-ticketdescription="' +
            data.ticketDescription +
            '" data-amount="' +
            data.amount +
            '" data-ticketquantity="' +
            data.numberofpersons +
            '" data-price="' +
            data.price +
            '">' +
            '<a href="#" onclick="refundModal(\'' +
            data.reservationId +
            '\')" class="btn btn-warning btn-refund" data-toggle="modal" data-target="#refundModal">Refund</a>';
          return html;
        },
      },
      */
      
    ],
    order: [[15, "desc"]]
  });


  var getTodayDate = new Date();
      var month = getTodayDate.getMonth()+1;
      var day = getTodayDate.getDate();
      var todayDate = getTodayDate.getFullYear() + '-' +
      (month<10 ? '0' : '') + month + '-' +
      (day<10 ? '0' : '') + day;

    
      //table.on( 'search.dt', function () {
        //null
      //});
      

      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          if(settings.nTable.id == 'report'){
          let full_timestamp = $('input[name="datetimes"]').val();
          var date = full_timestamp.split(" - ");
          var min = moment(date[0]);
          var max = moment(date[1]);
          var startDate = moment(data[19]); // data['Position of date's column -1']
   
          if (min == '' && max == '') { min = todayDate; }
          if (min == '' && startDate <= max) { return true;}
          if(max == '' && startDate >= min) {return true;}
          if (startDate <= max && startDate >= min) { return true; }
            return false;
          } else {
            return true;
          }
        });
        
        $('input[name="datetimes"]').change(function () {
          ticketTable.draw();
        });
       

});
      //DateTime Picker
      var getTodayDate = new Date();
      var month = getTodayDate.getMonth()+1;
      var day = getTodayDate.getDate();
      var todayDate = getTodayDate.getFullYear() + '-' +
      (month<10 ? '0' : '') + month + '-' +
      (day<10 ? '0' : '') + day;

      $(function() {
        var time = moment().hours(0).minutes(0).seconds(0);
        $('input[name="datetimes"]').daterangepicker({
          timePicker: true,
          timePicker24Hour: true,
          startDate: todayDate+' 00:00:00',
          locale: {
            format: 'YYYY-MM-DD HH:mm:ss'
          },
          ranges: {
           'Today': [time, moment()],
           'Yesterday': [moment().startOf("day").subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().startOf("day").subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().startOf("day").subtract(29, 'days'), moment()],
           'This Month': [moment().startOf("day").startOf('month'), moment().endOf('month')],
           'Last Month': [moment().startOf("day").subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'This Quarter': [moment().startOf("day").subtract(1, 'quarter'), moment()],
           'Last Quarter': [moment().startOf("day").subtract(2, 'quarter'), moment().subtract(1, 'quarter')],
           'This Year': [moment().startOf("day").startOf('year'), moment().endOf('year')],
           'Last Year': [moment().startOf("day").subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
           }
        });
      });


function round_up(val) {
  val = parseFloat(val);
  return val.toFixed(2);
}

function total_number(number) {
  if (number == 0) {
    return "€ " + number;
  }
  return "€ " + number.toFixed(2);
}

function num_percentage(number) {
  return num_format(number) + "%";
}

function addZero(i) {
  if (i < 10) {
    i = "0" + i;
  }
  return i;
}

function num_format(num) {
  var num1 = parseInt(num);
  var num2 = parseFloat(num) - parseFloat(num1);
  if (num2 == "0") {
    num2 = "00";
  } else {
    num2 = Math.round(num2 * 100);
  }

  var full_num = addZero(num1) + "." + num2;
  return full_num;
}

function refundModal(reservationId) {
  var data = $("#" + reservationId).data();
  console.log(data);
  console.log(data.amount);

  $("#productsRefund").empty();
  $(".amount").each(function () {
    $(this).val("€0.00");
  });
  $("#amount").val("€0.00");
  $("#order_amount").empty();
  $("#description").val(reservationId);
  let html =
    '<input type="hidden" id="total_amount" name="total_amount" value="' +
    data.amount +
    '">' +
    '<table class="refundTable text-center w-100">' +
    "<tr><th>Quantity</th><th>Name</th><th>Quantity</th><th>Price</th><th>Total</th></tr>";

  html +=
    "<tr><th>" +
    data.ticketquantity +
    "</th>" +
    "<th>" +
    data.ticketdescription +
    "</th>" +
    '<th><input type="number" style="-moz-appearance: auto;" max="0" min="-' +
    data.ticketquantity +
    '" oninput="validateQuantity(this,' +
    data.ticketquantity +
    ')" onkeyup="validateQuantity(this,' +
    data.ticketquantity +
    ')" onchange="refundAmount(this)" class="form-control ml-auto quantity mb-2" value="0"></th>' +
    '<th class="pl-2 pr-2">€<span id="price">' +
    data.price.toFixed(2) +
    "</span></th>" +
    "<th>" +
    '<input type="text" class="form-control amount amount_40 mb-2 ml-auto mr-1" value="€0.00" disabled></th></tr>';

  html += "</table>";
  $("#order_amount").text(parseFloat(data.amount).toFixed(2));
  $("#freeamount").attr("min", "-" + data.amount);
  $("#amount_limit").val(data.amount);
  $("#productsRefund").append(html);
}

function refundAmount(el) {
  let price = $("#price").text();
  let quantity = $(el).val();
  let total_amount = parseFloat($("#total_amount").val());
  let free_amount = parseFloat($("#freeamount").val());
  let amount =
    parseFloat(price.replace("€", "")) * parseInt(quantity.replace("€", ""));
  $(".amount").val("-€" + Math.abs(amount).toFixed(2));
  let amount2 = 0;
  $(".amount").each(function () {
    let val = parseFloat($(this).val().replace("€", ""));
    amount2 = amount2 + val;
  });
  total_amount = total_amount - Math.abs(amount2);
  if (free_amount > 0 && free_amount > total_amount) {
    $("#freeamount").val(total_amount.toFixed(2));
  }
  $("#amount_limit").val(total_amount);
  $("#amount").val("-€" + Math.abs(amount2).toFixed(2));
}

function validateQuantity(el, quantity) {
  let num = parseInt($(el).val());
  quantity = -parseInt(quantity);
  if (num > 0) {
    $(el).val("0");
  }
  if (quantity > num) {
    $(el).val(quantity);
  }
  return;
}

function freeAmountValidate(el) {
  let num = parseFloat($(el).val());
  let total_amount = parseFloat($("#amount_limit").val());
  if (num < total_amount) {
    $(el).val(num.toFixed(2));
  } else {
    $(el).val(total_amount.toFixed(2));
  }
}

function confirmResendTicket(reservationId, email){
  bootbox.confirm({
    message: "Do you want to send in the following email as well? <input class='form-control mt-2' type='email' id='supportEmail' name='supportEmail' value='support@tiqs.com' required>",
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
        let email = $('#supportEmail').val();
        if(!validateEmail(email)){
          alertify.error('Please enter a valid email!');
          return false;
        }

        resendTicket(reservationId, email, 1);
      } else {
        resendTicket(reservationId);
      }
    }
});
}

function resendTicket(reservationId, email = '', sendTo = 0) {
  let data = {
    reservationId: reservationId,
    email: encodeURI(email),
    sendTo: sendTo
  };

  $.post(
    globalVariables.baseUrl + "events/resend_ticket",
    data,
    function (data) {
      if(data != 'false'){
        alertify.success("Ticket is resent successfully!");
      } else {
        alertify.error("Something went wrong!");
      }
      
    }
  );
}

function validateEmail(email) {
  const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}