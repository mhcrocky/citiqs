'use strict';

(function() {
  var time = moment().startOf("day").subtract(6, 'days');

  $('input[name="datetimes"]').daterangepicker({
    timePicker: true,
    timePicker24Hour: true,
    startDate: time,
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

})();

function getEventGraph() {
  let eventId = $('#events option:selected').val();
  let dateRange = $('input[name="datetimes"]').val();
  $.post(globalVariables.baseUrl + 'events/get_tags_stats', {
      eventId: eventId,
      dateRange: encodeURI(dateRange)
  }, function(data) {
      $('#graph').fadeOut("slow", function() {
          $('#graph').empty();
      });
      $('#graph').fadeIn("slow", function() {
          $('#graph').html(JSON.parse(data));
          $('#graph').css('visibility', 'visible');
      });

  });

}
