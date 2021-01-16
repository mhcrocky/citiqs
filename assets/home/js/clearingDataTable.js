$(document).ready( function () {
  var table = $('#clearing').DataTable({
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
      url: globalVariables.baseUrl + "finance/get_clearings",
      dataSrc: '',
    },
    columns:[
	{
		title: 'Cleared on',
		data: 'paidby'
	},
    {
      title: 'Clearing date',
		data: 'clearingdate'
    },
	{
		title: 'Pay-out',
		data: 'payout'
	},
	{
		title: 'Invoice',
		data: 'settledinvoice'
	},
	{
		title: 'invoice Amount',
		data: 'settled'
	},
	{
		title: 'Total Sales',
		data: 'totaltobepaid'
	},
	{
		title: 'From',
		data: 'settlementdatefrom'
	},
	{
		title: 'to',
		data: 'settlementdateto'
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
      var startDate = moment(data[1]);
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
