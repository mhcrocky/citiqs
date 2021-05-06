
    $(function() {
      var time = moment().startOf("day").subtract(6, 'days');
        $('#datetimegraph').daterangepicker({
          timePicker: true,
          timePicker24Hour: true,
          startDate: time,
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
        },
        function(start, end, label) {
          let min_fulldate = start._d;
          let min_month = min_fulldate.getMonth()+1;
          let min_day = min_fulldate.getDate();
          let min_year = min_fulldate.getFullYear();
          var min_time = addZero(min_fulldate.getHours()) + ':' + addZero(min_fulldate.getMinutes()) + ':' + addZero(min_fulldate.getSeconds());
        
          let max_fulldate = end._d;
          let max_month = max_fulldate.getMonth()+1;
          let max_day = max_fulldate.getDate();
          let max_year = max_fulldate.getFullYear();
          var max_time = addZero(max_fulldate.getHours()) + ':' + addZero(max_fulldate.getMinutes()) + ':' + addZero(max_fulldate.getSeconds());

          var min = min_year + '-' + min_month + '-' + min_day + ' ' + min_time;
          var max = max_year + '-' + max_month + '-' + max_day + ' ' + max_time;
          var selected = $('#group_by option:selected').val();

          $.ajax({
            method: "POST",
            url: globalVariables.baseUrl + "businessreport/get_graphs",
            data: {min:"'"+min+"'",max:"'"+max+"'",selected: selected},
            success: function(data){
              data = data.replaceAll("btnBack", "hidden");
              $("#graphs").html(JSON.parse(data.replaceAll("breadcrumb", "hidden")));
              var texts = $('text');
              $.each(texts, function(index){
              let text = $(this).text();
              if(text == 'Local'){
                  $(this).attr('onclick', 'clickLabel("Local")');
              } else if(text == 'Pickup'){
                  $(this).attr('onclick', 'clickLabel("Pickup")');
              } else if(text == 'Delivery'){
                  $(this).attr('onclick', 'clickLabel("Delivery")');
              } else if(text == 'Invoices'){
                  $(this).attr('onclick', 'clickLabel("Invoices")');
              } else if(text == 'Tickets'){
                  $(this).attr('onclick', 'clickLabel("Tickets")');
              }
             });

            }
          });
        });

        $('#datetime').daterangepicker({
          timePicker: true,
          timePicker24Hour: true,
          startDate: moment().startOf("day").subtract(29, 'days'),
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
        },
        function(start, end, label) {
          let min_fulldate = start._d;
          let min_month = min_fulldate.getMonth()+1;
          let min_day = min_fulldate.getDate();
          let min_year = min_fulldate.getFullYear();
          var min_time = addZero(min_fulldate.getHours()) + ':' + addZero(min_fulldate.getMinutes()) + ':' + addZero(min_fulldate.getSeconds());
        
          let max_fulldate = end._d;
          let max_month = max_fulldate.getMonth()+1;
          let max_day = max_fulldate.getDate();
          let max_year = max_fulldate.getFullYear();
          var max_time = addZero(max_fulldate.getHours()) + ':' + addZero(max_fulldate.getMinutes()) + ':' + addZero(max_fulldate.getSeconds());

          var min = min_year + '-' + min_month + '-' + min_day + ' ' + min_time;
          var max = max_year + '-' + max_month + '-' + max_day + ' ' + max_time;
          var selected = $('#group_by option:selected').val();

          $.ajax({
            method: "POST",
            url: globalVariables.baseUrl + "businessreport/get_totals",
            data: {min:"'"+min+"'",max:"'"+max+"'"},
            success: function(data){

              if(isJson(data)){
                data = JSON.parse(data)[0];
                $('#local').text(data.local.toFixed(2));
                $('#delivery').text(data.delivery.toFixed(2));
                $('#pickup').text(data.pickup.toFixed(2));
                $('#invoice').text(data.invoice.toFixed(2));
                $('#tickets').text(parseInt(data.booking));
              } else {
                $('#local').text('0.00');
                $('#delivery').text('0.00');
                $('#pickup').text('0.00');
                $('#invoice').text('0.00');
                $('#tickets').text('0');
              }
              
            }
          });


        });
    });
    
  $(document).ready( function () {
      var sort = '';
      $.ajax({
          url: globalVariables.baseUrl + "businessreport/sortedWidgets",
          method: "GET",
          dataType: "JSON",
          success: function(data){
              sort = data['sort'];
              row_sort = data['row_sort'];
          },
          async:false
      });
      sort = sort.split(',').reverse();
      row_sort = row_sort.split(',').reverse();
      
      $("div[data-position]").each(function(index,value){
        for(var i = 0; i < sort.length; i++){
          if ($(this).data('position') == sort[i]){
            $(this).attr( "data-sort", i );
          }
        }
        
      });

      $(".row-sort").each(function(index,value){
        for(var i = 0; i < row_sort.length; i++){
          if ($(this).data('rowposition') == row_sort[i]){
            $(this).attr( "data-rowsort", i );
          }
        }
      });
      
      setTimeout(function(){ 
        $('#sortable .col-md-3').sort(function(a, b) {
            return $(b).data('sort') - $(a).data('sort');
            }).appendTo('#sortable');
        }, 0);

      setTimeout(function(){ 
        $('.main-content-inner .row-sort').sort(function(a, b) {
          return $(b).data('rowsort') - $(a).data('rowsort');
          }).appendTo('.main-content-inner');
        }, 0);
      $('.main-content-inner').css('visibility', 'visible');
      $('#sortable').css('visibility', 'visible');

      let full_timestamp = $('#datetime').val();
      var date = full_timestamp.split(" - ");
      var min = date[0];
      var max = date[1];
      $.ajax({
        method: "POST",
        url: globalVariables.baseUrl + "businessreport/get_totals",
        data: {min:"'"+min+"'",max:"'"+max+"'"},
        success: function(data){

          if(isJson(data)){
            data = JSON.parse(data)[0];
            $('#local').text(data.local.toFixed(2));
            $('#delivery').text(data.delivery.toFixed(2));
            $('#pickup').text(data.pickup.toFixed(2));
            $('#invoice').text(data.invoice.toFixed(2));
            $('#tickets').text(parseInt(data.booking));
          } else {
            $('#local').text('0.00');
            $('#delivery').text('0.00');
            $('#pickup').text('0.00');
            $('#invoice').text('0.00');
            $('#tickets').text('0');
          }
          
        }
      });

      full_timestamp = $('#datetimegraph').val();
      var selected = $('#group_by option:selected').val();
      date = full_timestamp.split(" - ");
      min = date[0];
      max = date[1];
      
      $.ajax({
        method: "POST",
        url: globalVariables.baseUrl + "businessreport/get_graphs",
        data: {min:"'"+min+"'",max:"'"+max+"'",selected:selected},
        success: function(data){
          data = data.replaceAll("btnBack", "hidden");
          $("#graphs").html(JSON.parse(data.replaceAll("breadcrumb", "hidden")));
          //$("#graphs").html(JSON.parse(data.replaceAll("btnBack", "hidden")));
          var texts = $('text');
          $.each(texts, function(index){
              let text = $(this).text();
              if(text == 'Local'){
                  $(this).attr('onclick', 'clickLabel("Local")');
              } else if(text == 'Pickup'){
                  $(this).attr('onclick', 'clickLabel("Pickup")');
              } else if(text == 'Delivery'){
                  $(this).attr('onclick', 'clickLabel("Delivery")');
              } else if(text == 'Invoices'){
                  $(this).attr('onclick', 'clickLabel("Invoices")');
              } else if(text == 'Tickets'){
                  $(this).attr('onclick', 'clickLabel("Tickets")');
              }
          });

          }
        });
        
        $('select#group_by').on('change', function() {
          let full_timestamp = $('#datetimegraph').val();
          var selected = this.value;
          var date = full_timestamp.split(" - ");
          var min = date[0];
          var max = date[1];
          

          $.ajax({
            method: "POST",
            url: globalVariables.baseUrl + "businessreport/get_graphs",
            data: {min:"'"+min+"'",max:"'"+max+"'",selected:selected},
            success: function(data){
              data = data.replaceAll("btnBack", "hidden");
              $("#graphs").html(JSON.parse(data.replaceAll("breadcrumb", "hidden")));
              //$("#graphs").html(JSON.parse(data.replaceAll("btnBack", "hidden")));
              var texts = $('text');
              $.each(texts, function(index){
              let text = $(this).text();
              if(text == 'Local'){
                  $(this).attr('onclick', 'clickLabel("Local")');
              } else if(text == 'Pickup'){
                  $(this).attr('onclick', 'clickLabel("Pickup")');
              } else if(text == 'Delivery'){
                  $(this).attr('onclick', 'clickLabel("Delivery")');
              } else if(text == 'Invoices'){
                  $(this).attr('onclick', 'clickLabel("Invoices")');
              } else if(text == 'Tickets'){
                  $(this).attr('onclick', 'clickLabel("Tickets")');
              }
             });

            }
          });
        });


$(function () {
  $('.row').sortable({
    connectWith: ".row",
    items: ".col-md-3",
      update: function (event, ui) {
        var myTable = $(this).index();
        var positions = [];
        $("div[data-position]").each(function(index,value){
          var data = $(this).data('position');
          positions.push(data);
        });
        positions = positions.toString();
        $.post(globalVariables.baseUrl + 'businessreport/sortWidgets', {sort: positions});
        setTimeout(function(){
          //toastr["success"]("Widget positions are updated successfully!");
        }, 0);
      }
  });
});
});
$(function () {
  $('.main-content-inner').sortable({
    connectWith: ".main-content-inner",
    items: ".row-sort",
    update: function (event, ui) {
      var myTable = $(this).index();
      var positions = [];
      $("div[data-rowposition]").each(function(index,value){
        var data = $(this).data('rowposition');
        positions.push(data);
      });

      positions = positions.toString();
      $.post(globalVariables.baseUrl + 'businessreport/sortWidgets', {row_sort: positions});
      }
  });
});

function isJson(str) {
  try {
      JSON.parse(str);
  } catch (e) {
      return false;
  }
  return true;
}

function round_up(val){
  val = parseFloat(val);
  return val.toFixed(2);
}

function total_number(number){
  if(number==0){
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

function clickBar(specific) {
  var full_timestamp = $('#datetimegraph').val();
  var date = full_timestamp.split(' - ');
  var min = date[0];
  var max = date[1];

  $.ajax({
      method: 'POST',
      url: globalVariables.baseUrl + 'businessreport/get_graphs',
      data: {
          min: "'" + min + "'",
          max: "'" + max + "'",
          selected: 'total',
          specific: specific
      },
      success: function(data) {
          data = data.replace('btnBack', 'hidden');
          data = JSON.parse(data.replaceAll('breadcrumb', 'hidden'));
          data = data.replaceAll('>Local', '>Test');
          $('#graphs').html(data);
          var texts = $('text');
          $.each(texts, function(index){
              let text = $(this).text();
              if(text == 'Local'){
                  $(this).attr('onclick', 'clickLabel("Local")');
              } else if(text == 'Pickup'){
                  $(this).attr('onclick', 'clickLabel("Pickup")');
              } else if(text == 'Delivery'){
                  $(this).attr('onclick', 'clickLabel("Delivery")');
              } else if(text == 'Invoices'){
                  $(this).attr('onclick', 'clickLabel("Invoices")');
              } else if(text == 'Tickets'){
                  $(this).attr('onclick', 'clickLabel("Tickets")');
              }
          });
      }
  });
}

var pickupClicked = 0;
var localClicked = 0;
var deliveryClicked = 0;
var bookingClicked = 0;
var invoiceClicked = 0;

function clickLabel(label) {
  

  var full_timestamp = $('#datetimegraph').val();
  var date = full_timestamp.split(' - ');
  var min = date[0];
  var max = date[1];
  var clickedArr = [];
  clickedArr['pickup'] = pickupClicked;
  clickedArr['local'] = localClicked;
  clickedArr['delivery'] = deliveryClicked;
  clickedArr['booking'] = bookingClicked;
  clickedArr['invoice'] = invoiceClicked;
  
  if(label == 'Pickup'){
    pickupClicked += 1;
    clickedArr['pickup'] = pickupClicked;
  } else if(label == 'Local'){
    localClicked += 1;
    clickedArr['local'] = localClicked;
  } else if(label == 'Delivery'){
    deliveryClicked += 1;
    clickedArr['delivery'] = deliveryClicked;
  } else if(label == 'Tickets'){
    bookingClicked += 1;
    clickedArr['booking'] = bookingClicked;
  } else if(label == 'Invoices'){
    invoiceClicked += 1;
    clickedArr['invoice'] = invoiceClicked;
  }

  console.log(JSON.stringify(Object.assign({}, clickedArr)));
  var labels = [];

  if(clickedArr['pickup'] % 2 != 0){
    labels[0] = 'pickup';
  }
  if(clickedArr['local'] % 2 != 0){
    labels[1] = 'local';
  }
  if(clickedArr['delivery'] % 2 != 0){
    labels[2] = 'delivery';
  }
  if(clickedArr['booking'] % 2 != 0){
    labels[3] = 'booking';
  }
  if(clickedArr['invoice'] % 2 != 0){
    labels[4] = 'invoice';
  }

  labelsArr = JSON.stringify(Object.assign({}, labels));

  $.ajax({
      method: 'POST',
      url: globalVariables.baseUrl + 'businessreport/get_graphs',
      data: {
          min: "'" + min + "'",
          max: "'" + max + "'",
          selected: $('#group_by option:selected').val(),
          labels: labelsArr
      },
      success: function(data) {
          data = data.replace('btnBack', 'hidden');
          data = JSON.parse(data.replaceAll('breadcrumb', 'hidden'));
          $('#graphs').html(data);
          var texts = $('text');
          $.each(texts, function(index){
              let text = $(this).text();
              if(text == 'Local'){
                  $(this).attr('onclick', 'clickLabel("Local")');
              } else if(text == 'Pickup'){
                  $(this).attr('onclick', 'clickLabel("Pickup")');
              } else if(text == 'Delivery'){
                  $(this).attr('onclick', 'clickLabel("Delivery")');
              } else if(text == 'Invoices'){
                  $(this).attr('onclick', 'clickLabel("Invoices")');
              } else if(text == 'Tickets'){
                  $(this).attr('onclick', 'clickLabel("Tickets")');
              }
          });

      }
  });
}