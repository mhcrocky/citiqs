$(document).ready( function () {

  
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
        startDate: todayDate+' 00:00:00',
        locale: {
          format: 'YYYY-MM-DD HH:mm:ss'
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
          autoFilter: true,
          footer: true,
          text: 'Export as Excel',
          className: "btn btn-success p-2 mb-3",
          sheetName: 'Exported data'
      }],
      ajax: {
        type: 'post',
        url: globalVariables.baseUrl + "events/get_booking_report",
        data: function(data){
          let eventId = $('#eventId').val();
          data.eventId = eventId;
        },
        dataSrc: '',
      },
      rowId: function(a) {
        return 'row_id_' + a.order_id;
      },

      columns:[
      {
        title: 'Reservation Id',
        data: 'reservationId'
      },
      {
        title: 'Buyer Email',
        data: 'email'
      },
      {
        title: 'Buyer Mobile',
        data: 'mobilephone'
      },
      {
        title: 'Ticket Description',
        data: 'ticketDescription'
      },
      {
        title: 'Amount',
        data: null,
        "render": function (data, type, row) {
          let amount = parseFloat(data.amount);
          return amount.toFixed(2);
        }
      },
      {
        title: 'Price',
        data: null,
        "render": function (data, type, row) {
          let price = parseFloat(data.price);
          return price.toFixed(2);
        }
      },
      {
        title: 'Quantity',
        data: 'numberofpersons'
      },
      {
        title: 'Date',
        data: 'reservationtime'
      },
      {
        title: '',
        data: null,
        "render": function (data, type, row) {
          return '<a href="javascript:;" class="btn btn-warning">Refund</a>';
        }
      },
      {
        title: '',
        data: null,
        "render": function (data, type, row) {
          return '<a href="javascript:;" class="btn btn-primary">Resend Ticket</a>';
        }
      },
      ],
    });




  
    var getTodayDate = new Date();
    var month = getTodayDate.getMonth()+1;
    var day = getTodayDate.getDate();
    var todayDate = getTodayDate.getFullYear() + '-' +
    (month<10 ? '0' : '') + month + '-' +
    (day<10 ? '0' : '') + day;

  
    
    

      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          let full_timestamp = $('input[name="datetimes"]').val();
          var date = full_timestamp.split(" - ");
          var min = moment(date[0]);
          var max = moment(date[1]);
          var startDate = moment(data[7]);
          if (min == '' && max == '') { min = todayDate; }
          if (min == '' && startDate <= max) { return true;}
          if(max == '' && startDate >= min) {return true;}
          if (startDate <= max && startDate >= min) { return true; }
            return false;
        });
        $('input[name="datetimes"]').change(function () {
          table.draw();
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
let html = '<input type="hidden" id="total_amount" name="total_amount" value="'+total_amount+'">'+
'<table class="refundTable text-center w-100">'+
'<tr><th>Quantity</th><th>Name</th><th>Quantity</th><th>Price</th><th>Total</th></tr>';
$('.productName_'+order_id).each(function(index){
  let productName = $(this).text();
  let productPrice = $(this).data('price');
  let productQuantity = $(this).data('quantity');
  html += '<tr><th>'+productQuantity+'</th>'+
  '<th>'+productName+'</th>'+
  '<th><input type="number" style="-moz-appearance: auto;" max="0" min="-'+productQuantity+'" oninput="validateQuantity(this,'+productQuantity+')" onkeyup="validateQuantity(this)" onchange="refundAmount(this,'+index+')" class="form-control ml-auto quantity mb-2" value="0"></th>'+
  '<th class="pl-2 pr-2">€<span id="price_'+index+'">'+productPrice+'</span></th>'+
  '<th>'+
  '<input type="text" class="form-control amount amount_'+index+' mb-2 ml-auto mr-1" value="€0.00" disabled></th></tr>';
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