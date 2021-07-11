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
        id: "tbl_events.eventname",
        label: "Event Name",
        type: "string",
        class: "eventname",
        default_value: "",
        size: 30,
        unique: true,
      },
      {
        id: 'tbl_bookandpay.ticketFee',
        label: 'Ticket Fee',
        type: 'integer',
        class: 'ticketFee',
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
        id: 'tbl_bookandpay.ticketDescription',
        label: 'Ticket Description',
        type: 'string',
        class: 'ticketDescription',
        default_value: '',
        size: 30,
        unique: true
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
        text: 'Export as Excel',
        className: 'btn btn-success mb-3 mt-5',
        autoFilter: true,
        footer: true,
        sheetName: 'Exported data'
      }
    ],
    ajax: {
      type: 'post',
      url: globalVariables.baseUrl + "events/get_financial_report",
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
           
      let amountData = api.column( 5,{ search: 'applied' } ).cache('search');
      let ticketFeeData = api.column( 6,{ search: 'applied' } ).cache('search');
      let scansTotalData = api.column( 7,{ search: 'applied' } ).cache('search');
      let noptiTotalData = api.column( 8,{ search: 'applied' } ).cache('search');
      let amountIncFeeData = api.column( 9,{ search: 'applied' } ).cache('search');

      let amount = amountData.length ? 
         amountData.reduce( function (a, b) {
             return parseFloat(a) + parseFloat(b);
           }) : 0;
      let ticketFee = ticketFeeData.length ? 
         ticketFeeData.reduce( function (a, b) {
             return parseFloat(a) + parseFloat(b);
           }) : 0;
      let scansTotal = scansTotalData.length ? 
         scansTotalData.reduce( function (a, b) {
           if (!$.isNumeric(a)) {
             a = 0;
           }
           if (!$.isNumeric(b)) {
            b = 0;
           }
             return parseInt(a) + parseInt(b);
           }) : 0;
      let noptiTotal = noptiTotalData.length ? 
         noptiTotalData.reduce( function (a, b) {
           if (!$.isNumeric(a)) {
             a = 0;
           }
           if (!$.isNumeric(b)) {
            b = 0;
           }
             return parseInt(a) + parseInt(b);
           }) : 0;
      let amountIncFee = amountIncFeeData.length ? 
         amountIncFeeData.reduce( function (a, b) {
             return parseFloat(a) + parseFloat(b);
           }) : 0;

      $(tfoot).find('th').eq(4).html(round_up(amount));
      $(tfoot).find('th').eq(5).html(round_up(ticketFee));
      $(tfoot).find('th').eq(6).html(parseInt(scansTotal));
      $(tfoot).find('th').eq(7).html(parseInt(noptiTotal));
      $(tfoot).find('th').eq(8).html(round_up(amountIncFee));
    },
    rowId: function(a) {
      return 'row_id_' + a.bookandpay_id;
    },
    columns:[
    {
      title: 'ID',
      data: 'bookandpay_id'
    },
    {
      title: 'Reservation ID',
      data: 'reservationId'
    },
    {
      title: 'Event Name',
      data: 'eventname'
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
      title: 'Price',
      data: null,
      "render": function (data, type, row) {
        let price = parseFloat(data.price);
        return price.toFixed(2);
      }
    },
    {
      title: 'Ticket Fee',
      data: null,
      "render": function (data, type, row) {
        let ticketFee = parseFloat(data.ticketFee);
        return ticketFee.toFixed(2);
      }
    },
    {
      title: 'Number of scans',
      data: 'numberofpersons'
    },
    {
      title: 'NOPTI',
      data: 'nopti'
    },
    {
      title: 'Total Amount',
      data: null,
      "render": function (data, type, row) {
        let amount = parseFloat(data.price) + parseFloat(data.ticketFee);
        return amount.toFixed(2);
      }
    },
    {
      title: 'Ticket Description',
      data: 'ticketDescription'
    },
    {
      title: 'Tag ID',
      data: 'tag'
    },
    {
      title: 'Reservation Time',
      data: 'reservationtime'
    },
    {
      title: "",
      data: null,
      render: function (data, type, row) {
        let total_amount = parseFloat(data.price) + parseFloat(data.ticketFee);
        let html =
          '<input type="hidden" id="' +
          data.reservationId +
          '" data-ticketdescription="' +
          data.ticketDescription +
          '" data-amount="' +
          total_amount +
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
      
    }
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
        var startDate = moment(data[12]);
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