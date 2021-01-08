$(document).ready( function () {


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
        className: "btn btn-primary mb-3 ml-1",
        sheetName: 'Exported data'
    } ],
    ajax: {
      type: 'get',
      url: globalVariables.baseUrl + "finance/get_marketing_data",
      data: function(data) {
          /*
        let query = $('#query-builder').queryBuilder('getSQL', false, true).sql;
        sql = query.replace(/\n/g, " ");
        sql = "AND ("+sql+")";
        if(query == ""){
          data.sql = "";
        } else {
          data.sql = sql;
        }
        $('.has-error').removeClass('has-error');
        */
      },
      dataSrc: '',
    },
    /*footerCallback: function( tfoot, data, start, end, display ) {
       var api = this.api(), data;
      //Totals For Current Page

      let pageAmountTotalData = api.column( 2, { page: 'current'}  ).cache('search');
      let pageAmountTotal = pageAmountTotalData.length ? 
      pageAmountTotalData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;

      let pageServiceFeeData = api.column( 5,  { page: 'current'} ).cache('search');
      let pageServiceFeeTotal = pageServiceFeeData.length ? 
      pageServiceFeeData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;

      let pageVatServiceData = api.column( 7,  { page: 'current'} ).cache('search');
      let pageVatServiceTotal = pageVatServiceData.length ? 
      pageVatServiceData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;

      let pageExvatServiceData = api.column( 8,  { page: 'current'} ).cache('search');
      let pageExvatServiceTotal = pageExvatServiceData.length ? 
      pageExvatServiceData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;

      let pageWaiterTipData = api.column( 9, { page: 'current'}  ).cache('search');
      let pageWaiterTipTotal = pageWaiterTipData.length ? 
      pageWaiterTipData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;

      let pageAmountData = api.column( 10, { page: 'current'}  ).cache('search');
      let pageAmount = pageAmountData.length ? 
      pageAmountData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;
      let pageExvatData = api.column( 11, { page: 'current'} ).cache('search');
      let pageExvatTotal = pageExvatData.length ? 
        pageExvatData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;
      let pageVatData = api.column( 12, { page: 'current'} ).cache('search');
      let pageVatTotal = pageVatData.length ? 
        pageVatData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;


      //Totals For All Pages

      let amountTotalData = api.column( 2,{ search: 'applied' } ).cache('search');
      let amountTotal = amountTotalData.length ? 
      amountTotalData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;

      let vatServiceData = api.column( 7,  { search: 'applied' } ).cache('search');
      let vatServiceTotal = vatServiceData.length ? 
      vatServiceData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;

      let exvatServiceData = api.column( 8, { search: 'applied' }).cache('search');
      let exvatServiceTotal = exvatServiceData.length ? 
      exvatServiceData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;

      let waiterTipData = api.column( 9,{ search: 'applied' } ).cache('search');
      let waiterTipTotal = waiterTipData.length ? 
      waiterTipData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;

      let amountData = api.column( 10,{ search: 'applied' } ).cache('search');
      let amount = amountData.length ? 
      amountData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;

      let exvatData = api.column( 11,{ search: 'applied' } ).cache('search');
      let exvatTotal = exvatData.length ? 
        exvatData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0; 

      let vatData = api.column( 12, { search: 'applied' }).cache('search');
      let vatTotal = vatData.length ? 
        vatData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;

      let serviceFeeData = api.column( 5,  { search: 'applied' } ).cache('search');
      let serviceFeeTotal = serviceFeeData.length ? 
      serviceFeeData.reduce( function (a, b) {
          return parseFloat(a) + parseFloat(b);
        }) : 0;

       $(tfoot).find('th').eq(1).html(round_up(pageAmountTotal)+'('+round_up(amountTotal)+')');
       $(tfoot).find('th').eq(2).html('-');
       $(tfoot).find('th').eq(3).html('-');
       $(tfoot).find('th').eq(4).html(round_up(pageServiceFeeTotal)+'('+round_up(serviceFeeTotal)+')');
       $(tfoot).find('th').eq(5).html('-');
       $(tfoot).find('th').eq(6).html(round_up(pageVatServiceTotal)+'('+round_up(vatServiceTotal)+')');
       $(tfoot).find('th').eq(7).html(round_up(pageExvatServiceTotal)+'('+round_up(exvatServiceTotal)+')');
       $(tfoot).find('th').eq(8).html(round_up(pageWaiterTipTotal)+'('+round_up(waiterTipTotal)+')');
       $(tfoot).find('th').eq(9).html(round_up(pageAmount)+'('+round_up(amount)+')');
       $(tfoot).find('th').eq(10).html(round_up(pageExvatTotal)+'('+round_up(exvatTotal)+')');
       $(tfoot).find('th').eq(11).html(round_up(pageVatTotal)+'('+round_up(vatTotal)+')');
       $('.buttons-excel').addClass('btn').addClass('btn-success').addClass('mb-3');
       $('.buttons-excel').text('Export as Excel');
    
      
    },
    rowId: function(a) {
      return 'row_id_' + a.order_id;
    },*/

    columns:[
    {
      title: 'Invoice Number',
      data: null,
      "render": function (data, type, row) {
        return data.prefix + '000' + data.number;
      }
    },
    {
      title: 'Subtotal',
      data: null,
      "render": function (data, type, row) {
        let subtotal = parseFloat(data.subtotal);
        return subtotal.toFixed(2);
      }
    },
    {
      title: 'Total TAX',
      data: null,
      "render": function (data, type, row) {
        let total_tax = parseFloat(data.total_tax);
        return total_tax.toFixed(2);
      }
    },
    {
      title: 'Total',
      data: null,
      "render": function (data, type, row) {
        let total = parseFloat(data.total);
        return total.toFixed(2);
      }
    },
    {
      title: 'Invoice Date',
      data: 'date'
    },
    {
      title: 'Total',
      data: null,
      "render": function (data, type, row) {
        return '<a class="btn btn-primary" href="https://tiqs.com/backoffice/invoice/'+data.id+'/'+data.hash+'" target="_blank">View Details</a>';
      }
    }
    ],
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

  /*

  table.on( 'search.dt', function () {
    if(table['context'][0]['aiDisplay'].length == 0){
      //$('#report_length').hide();
      $("#total-percentage").hide();
    } else {
      //$('#report_length').show();
    }
  });
  */
  $.fn.dataTable.ext.search.push(
    function (settings, data, dataIndex) {
        
      let full_timestamp = $('input[name="datetimes"]').val();
      var date = full_timestamp.split(" - ");
      var min = moment(date[0]);
      var max = moment(date[1]);
      var startDate = moment(data[4]);
      if(startDate <= max){
        console.log(todayDate+' 00:00:01');
      }
      //if (min == '' && max == '') { min = todayDate; }
      if (min == '' && startDate <= max) { return true;}
      if(max == '' && startDate >= min) {return true;}
      if (startDate <= max && startDate >= min) { return true; }
      return false; 

    });

    $('input[name="datetimes"]').change(function () {
        table.draw();
      });
    

  $('#serviceType').change(function() {
    var category = this.value;
    table
    .columns( 4 )
    .search( category )
    .draw();
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
number = parseInt(number*100);
number = number/100;
return number + "%";
}

function addZero(i) {
if (i < 10) {
i = "0" + i;
}
return i;
}
