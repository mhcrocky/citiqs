$(document).ready( function () {
  var options = {
    allow_empty: true,
    filters: [
      {
        id: 'tbl_bookandpay.reservationId',
        label: 'Reservation Id',
        type: 'string',
        class: 'reservationId',
        default_value: '',
        size: 30,
        unique: true
      },
      {
        id: 'tbl_bookandpay.price',
        label: 'Price',
        type: 'integer',
        class: 'price',
        default_value: '',
        size: 30,
        unique: true
      },
      {
        id: 'tbl_bookandpay.numberofpersons',
        label: 'Quantity',
        type: 'integer',
        class: 'numberofpersons',
        default_value: '',
        size: 30,
        unique: true
      },
      {
        id: 'tbl_bookandpay.name',
        label: 'Buyer Name',
        type: 'string',
        class: 'name',
        default_value: '',
        size: 30,
        unique: true
      },
      {
        id: 'tbl_bookandpay.email',
        label: 'Buyer Email',
        type: 'string',
        class: 'email',
        default_value: '',
        size: 30,
        unique: true
      },
      {
        id: 'tbl_bookandpay.Spotlabel',
        label: 'Spot Label',
        type: 'string',
        class: 'Spotlabel',
        default_value: '',
        size: 30,
        unique: true
      }
    ]
  };
  
  $('#query-builder').queryBuilder(options);
  var sql;
  $('.parse-json').on('click', function() {
    table.ajax.reload();
    table.clear().draw();
  });
  

  var getTodayDate = new Date();
  var month = getTodayDate.getMonth()+1;
  var day = getTodayDate.getDate();
  var todayDate = getTodayDate.getFullYear() + '-' +
  (month<10 ? '0' : '') + month + '-' +
  (day<10 ? '0' : '') + day;

  $(function() {
    var time = moment().startOf("day");

    $('input[name="datetimes"]').daterangepicker({
      timePicker: true,
      timePicker24Hour: true,
      startDate: todayDate,
      locale: {
        format: 'YYYY-MM-DD'
      },
      ranges: {
       'Today': [moment().startOf("day"), moment()],
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

  var table = $('#report').DataTable({
    processing: true,
    colReorder: true,
    fixedHeader: true,
    deferRender: true,
    scroller: true,
    lengthMenu: [[5, 10, 20, 50, 100, 200, 500, -1], [5, 10, 20, 50, 100, 200, 500, 'All']],
    pageLength: 5,
    dom: 'Blfrtip',
    buttons: [  {
        extend: 'excelHtml5',
        text: 'Export as Excel',
        className: 'btn btn-success mb-3 mt-5',
        autoFilter: true,
        footer: true,
        sheetName: 'Exported data'
      }
    ],
    ajax: {
      type: 'post',
      url: globalVariables.baseUrl + "customer_panel/get_financial_report",
      data: function(data) {
        let query = $('#query-builder').queryBuilder('getSQL', false, true).sql;
        sql = query.replace(/\n/g, " ");
        sql = "AND ("+sql+")";
        if(query == ""){
          data.sql = "";
        } else {
          data.sql = encodeURI(sql);
        }
        $('.has-error').removeClass('has-error');
      },
      dataSrc: '',
    },
    footerCallback: function( tfoot, data, start, end, display ) {
      var api = this.api(), data;
           
      let amountTotalData = api.column( 9,{ search: 'applied' } ).cache('search');
      let amountTotal = amountTotalData.length ? 
         amountTotalData.reduce( function (a, b) {
             return parseFloat(a) + parseFloat(b);
           }) : 0;

      let numberOfPersonsTotalData = api.column( 10,{ search: 'applied' } ).cache('search');
      let numberOfPersonsTotal = numberOfPersonsTotalData.length ? 
            numberOfPersonsTotalData.reduce( function (a, b) {
             return parseInt(a) + parseInt(b);
           }) : 0;

      $('#total_amount').text(round_up(amountTotal));
      $('#total_numberofpersons').text(numberOfPersonsTotal);
    },
    rowId: function(a) {
      return 'row_id_' + a.id;
    },
    columns:[
    {
      title: "",
      data: null,
      render: function (data, type, row) {
        return (
          '<a href="javascript:;" onclick="confirmResendTicket(\'' +
            data.reservationId +
            "', '" +
            data.email +
            "', '" +
            data.TransactionID +
            '\')" class="btn btn-primary">Resend Ticket</a>'
        );
      },
    },
    {
      title: 'ID',
      data: 'id'
    },
    {
      title: 'Reservation ID',
      data: 'reservationId'
    },
    {
      title: 'Spot Label',
      data: 'Spotlabel'
    },
    {
      title: 'Voucher',
      data: null,
      "render": function (data, type, row) {
        if(vouchers.length > 0 && inArray(data.voucher, vouchers)){
          return '<span class="text-success">' + data.voucher + '</span>';
        }
        return '<span class="text-danger">' + data.voucher + '</span>';
      }
    },
    {
      title: 'Timeslot',
      data: null,
      "render": function (data, type, row) {
        let fromtime = data.timefrom.split(':');
        let totime = data.timeto.split(':');
        return fromtime[0] + ':' + fromtime[1] + ' - ' + totime[0] + ':' + totime[1];
      }
    },
    {
      title: 'Buyer Name',
      data: 'name'
    },
    {
      title: 'Buyer Email',
      data: 'email'
    },
    {
      title: 'Buyer Phone',
      data: 'mobilephone'
    },
    {
      title: 'Price',
      data: null,
      "render": function (data, type, row) {
        return round_up(data.price);
      }
    },
    {
      title: 'Number of persons',
      data: 'numberofpersons'
    },
    {
      title: 'Date',
      data: 'eventdate'
    },
    {
      title: 'Spot ID',
      data: 'SpotId'
    }
    ],
    columnDefs: [
      { visible: false, "targets": [12] }
    ],
  });



  var getTodayDate = new Date();
  var month = getTodayDate.getMonth()+1;
  var day = getTodayDate.getDate();
  var todayDate = getTodayDate.getFullYear() + '-' +
  (month<10 ? '0' : '') + month + '-' +
  (day<10 ? '0' : '') + day;


  table.on( 'search.dt', function () {
    //$('#report_length').hide();
  });
  

    $.fn.dataTable.ext.search.push(
      function (settings, data, dataIndex) {
        
        let full_timestamp = $('input[name="datetimes"]').val();
        var date = full_timestamp.split(" - ");
        var min = moment(date[0]);
        var max = moment(date[1]);
        var startDate = moment(data[11]);
        if (min == '' && max == '') { min = todayDate; }
        if (min == '' && startDate <= max) { return true;}
        if(max == '' && startDate >= min) {return true;}
        if (startDate <= max && startDate >= min) { return true; }
        return false;
      });
    
    $('input[name="datetimes"]').change(function () {
      table.draw();
    });
   

  $('#serviceType').change(function() {
    //var category = this.value;
    /*
    table
    .columns( 4 )
    .search( category )
    .draw();
    */
  });


  // Report Table

  table.on( 'search.dt', function () {
    if(table['context'][0]['aiDisplay'].length == 0){
      $("#total-percentage").hide();
    } else {
      let tbl_datas = table.rows({ search: 'applied'}).data()
      var reservationStats = [];
      var html = '';
      var totalAmount = 0;
      var totalNumberOfPersons = 0;
      var totalBookings = 0;

      $.each(tbl_datas, function( index, tbl_data ) {

        totalAmount = totalAmount + parseFloat(tbl_data.price);
        totalNumberOfPersons = totalNumberOfPersons + parseInt(tbl_data.numberofpersons);
        totalBookings = totalBookings + 1;

        if(reservationStats[parseInt(tbl_data.SpotId)] !== undefined){
          reservationStats[parseInt(tbl_data.SpotId)]['spotId'] = tbl_data.SpotId;
          reservationStats[parseInt(tbl_data.SpotId)]['bookings'] = reservationStats[parseInt(tbl_data.SpotId)]['bookings'] + 1;
          reservationStats[parseInt(tbl_data.SpotId)]['description'] = tbl_data.Spotlabel;
          reservationStats[parseInt(tbl_data.SpotId)]['amount'] = parseFloat(reservationStats[parseInt(tbl_data.SpotId)]['amount']) + parseFloat(tbl_data.price);
          reservationStats[parseInt(tbl_data.SpotId)]['numberofpersons'] = parseInt(reservationStats[parseInt(tbl_data.SpotId)]['numberofpersons']) + parseInt(tbl_data.numberofpersons);
        } else {
          reservationStats[parseInt(tbl_data.SpotId)] = [];
          reservationStats[parseInt(tbl_data.SpotId)]['spotId'] = tbl_data.SpotId;
          reservationStats[parseInt(tbl_data.SpotId)]['bookings'] = 1;
          reservationStats[parseInt(tbl_data.SpotId)]['description'] = tbl_data.Spotlabel;
          reservationStats[parseInt(tbl_data.SpotId)]['amount'] = parseFloat(tbl_data.price);
          reservationStats[parseInt(tbl_data.SpotId)]['numberofpersons'] = parseInt(tbl_data.numberofpersons);
        }

      
      });

      reservationStats = reservationStats.filter(function (el) {
        return el != null;
      });
      
      html += '<tr>' +
      '<td class="text-right" colspan="4"><b id="daterange">'+$('#reportDateTime').val()+'</b></td>' +
      '<th class="text-center">Spot Number</td>' +
      '<th class="text-center">Amount</td>' +
      '<th class="text-center">Number Of Persons</td>' +
      '</tr>' +
      '<tr>';

      $.each(reservationStats, function(index, reservationStat) {
        
        html += '<tr class="tr-totals">' +
        '<td class="text-right" colspan="4"><b> Spot ID: ' + reservationStat['spotId'] + ' |  Spot Label: ' + reservationStat['description'] + '</b></td>' +
        '<td class="text-center">' + parseInt(reservationStat['bookings']) + '</td>' +
        '<td class="text-center">' + reservationStat['amount'].toFixed(2) + '</td>' +
        '<td class="text-center">' + parseInt(reservationStat['numberofpersons']) + '</td>' +
        '</tr>';
        
      });

      

      html += '<tr>' +
      '<td class="text-right" colspan="4"><b>Total:</b></td>' +
      '<td class="text-center">' + parseInt(totalBookings) + '</td>' +
      '<td class="text-center">' + totalAmount.toFixed(2) + '</td>' +
      '<td class="text-center">' + parseInt(totalNumberOfPersons) + '</td>' +
      '</tr>' ;
      $("#total-percentage").show();
      $("#total-percentage").empty();
      $("#total-percentage").html(html);

    }
  });





});

function round_up(val){
val = parseFloat(val);
return val.toFixed(2);
}

function total_number(number){
if(number == 0){
return '€ '+number;
}
return '€ '+number.toFixed(2);
}

function num_percentage(number){
return num_format(number) + "%";
}

function addZero(i) {
if (i < 10) {
i = "0" + i;
}
return i;
}

function num_format(num){
var num1 = parseInt(num);
var num2 = parseFloat(num) - parseFloat(num1);
if(num2 == '0'){
  num2 = '00';
} else {
  num2 = Math.round(num2 * 100);
}

var full_num = addZero(num1) + "." + num2;
return full_num;
}

function refundModal(order_id, total_amount) {
$('#productsRefund').empty();
$('.amount').each(function(){
$(this).val('€0.00');
});
$('#amount').val('€0.00');
$('#order_amount').empty();
$('#description').val('tiqs - '+order_id);
let html = ';'
html += '<input type="hidden" id="refundOrderId" name="refundOrderId" value="'+order_id+'" readonly>';
html += '<input type="hidden" id="total_amount" name="total_amount" value="'+total_amount+'" readonly>';
html += '<table class="refundTable text-center w-100">';
html += '<tr><th>Quantity</th><th>Name</th><th>Quantity</th><th>Price</th><th>Total</th></tr>';

$('.productName_'+order_id).each(function(index){
let productName = $(this).text();
let productPrice = $(this).data('price');
let productQuantity = $(this).data('quantity');
html += '<tr><th>'+productQuantity+'</th>'+
'<th>'+productName+'</th>'+
'<th><input type="number" style="-moz-appearance: auto;" max="0" min="-'+productQuantity+'" oninput="validateQuantity(this,'+productQuantity+')" onkeyup="validateQuantity(this)" onchange="refundAmount(this,'+index+')" class="form-control ml-auto quantity mb-2" value="0"></th>'+
'<th class="pl-2 pr-2">€<span id="price_'+index+'">'+productPrice+'</span></th>'+
'<th>'+
'<input type="text" class="form-control amount amount_'+index+' mb-2 ml-auto mr-1" value="0" readonly></th></tr>';
});
html += '</table>';
$('#order_amount').text(parseFloat(total_amount).toFixed(2));
$('#freeamount').attr('min', '-'+total_amount);
$('#amount_limit').val(total_amount);
$('#productsRefund').append(html);
}

function refundAmount(el, index){
let price = $('#price_'+index).text();
let quantity = $(el).val();
let total_amount = parseFloat($('#total_amount').val());
let free_amount = parseFloat($('#freeamount').val());
let amount = parseFloat(price.replace('€', '')) * parseInt(quantity.replace('€', ''));
$('.amount_'+index).val('-€'+Math.abs(amount).toFixed(2));
let amount2 = 0;
$('.amount').each(function(){
let val = parseFloat($(this).val().replace('€', ''));
amount2 = amount2 + val;
});
total_amount = total_amount - Math.abs(amount2);
if(free_amount > 0 && free_amount > total_amount){
$('#freeamount').val(total_amount.toFixed(2));
}
$('#amount_limit').val(total_amount);
$('#amount').val('-€'+Math.abs(amount2).toFixed(2));
}

function validateQuantity(el, quantity){
let num = parseInt($(el).val());
quantity = -parseInt(quantity);
if(num > 0){
$(el).val('0');
}
if(quantity > num){
$(el).val(quantity);
}
return ;
}

function freeAmountValidate(el){
let num = parseFloat($(el).val());
let total_amount = parseFloat($('#amount_limit').val());
if(num < total_amount){
$(el).val(num.toFixed(2));
} else {
$(el).val(total_amount.toFixed(2))
}

}

function confirmResendTicket(reservationId, email, transactionId){
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
        resendTicket(transactionId, reservationId, email, 1);
      } else {
        resendTicket(transactionId, reservationId, email);
      }
    }
});
}

function resendTicket(transactionId, reservationId, email, sendTo = 0) {
  let data = {
    reservationId: reservationId,
    email: encodeURI(email),
    sendTo: sendTo,
    transactionId: transactionId
  };
  $.post(
    globalVariables.baseUrl + "customer_panel/resend_reservation",
    data,
    function (data) {
      alertify.success("Reservation is resend successfully!");
    }
  );
}


function inArray(needle, haystack){
  var length = haystack.length;
  for(var i = 0; i < length; i++){
    if(haystack[i] == needle) return true;
  }
  return false;
}
