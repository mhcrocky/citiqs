
    $(function() {
      var getTodayDate = new Date();
      var month = getTodayDate.getMonth()+1;
      var day = getTodayDate.getDate();
      var todayDate = getTodayDate.getFullYear() + '-' +
      (month<10 ? '0' : '') + month + '-' +
      (day<10 ? '0' : '') + day;
        $('#datetime').daterangepicker({
          timePicker: true,
          timePicker24Hour: true,
          startDate: todayDate+' 00:00:00',
          locale: {
            format: 'YYYY-MM-DD HH:mm:ss'
          },
          ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'This Quarter': [moment().subtract(1, 'quarter'), moment()],
           'Last Quarter': [moment().subtract(2, 'quarter'), moment().subtract(1, 'quarter')],
           'This Year': [moment().startOf('year'), moment().endOf('year')],
           'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
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
                $("#graphs").html(JSON.parse(data.replaceAll("btnBack", "fade")));
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
      var selected = $('#group_by option:selected').val();
      var date = full_timestamp.split(" - ");
      var min = date[0];
      var max = date[1];
      $.ajax({
        method: "POST",
        url: globalVariables.baseUrl + "businessreport/get_graphs",
        data: {min:"'"+min+"'",max:"'"+max+"'",selected:selected},
        success: function(data){
          $("#graphs").html(JSON.parse(data.replaceAll("btnBack", "hidden")));
          }
        });
        
        $('select#group_by').on('change', function() {
          let full_timestamp = $('#datetime').val();
          var selected = this.value;
          var date = full_timestamp.split(" - ");
          var min = date[0];
          var max = date[1];
          $.ajax({
            method: "POST",
            url: globalVariables.baseUrl + "businessreport/get_graphs",
            data: {min:"'"+min+"'",max:"'"+max+"'",selected:selected},
            success: function(data){
              $("#graphs").html(JSON.parse(data.replaceAll("btnBack", "hidden")));
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