<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<div style="margin: auto;width: 100%;display: flex;justify-content: center;" class="mt-4 ml-auto">
  <input style="width: 330px;ma" id="datetime" class="date form-control form-control-sm mb-2" type="text" name="datetimes" />
</div>
<div id="graphs"></div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(function() {
    var getTodayDate = new Date();
      var month = getTodayDate.getMonth()+1;
      var day = getTodayDate.getDate();
      var todayDate = getTodayDate.getFullYear() + '-' +
      (month<10 ? '0' : '') + month + '-' +
      (day<10 ? '0' : '') + day;
        $('input[name="datetimes"]').daterangepicker({
          timePicker: true,
          timePicker24Hour: true,
          startDate: todayDate+' 00:00:00',
          locale: {
            format: 'YYYY-MM-DD HH:mm:ss'
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

        $.ajax({
            method: "POST",
            url: "<?php echo base_url() ;?>businessreport/get_graphs",
            data: {min:"'"+min+"'",max:"'"+max+"'"},
            success: function(data){
                $("#graphs").html(JSON.parse(data));
                //$(".panel-heading").hide();
            }
        });
    });
      });
$(document).ready(function(){

let full_timestamp = $('input[name="datetimes"]').val();
var date = full_timestamp.split(" - ");
var min = date[0];
var max = date[1];
console.log(min);
$.ajax({
  method: "POST",
  url: "<?php echo base_url() ;?>businessreport/get_graphs",
  data: {min:"'"+min+"'",max:"'"+max+"'"},
  success: function(data){
      $("#graphs").html(JSON.parse(data));
      //console.log(data);
      //$(".panel-heading").hide();
  }
});

});
function addZero(i) {
  if (i < 10) {
    i = "0" + i;
  }
  return i;
}
</script>