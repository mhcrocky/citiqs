'use strict';
function submitTimeslotForm(){
    let timeslotId = $('input[name="selected_time_slot_id"]:checked').val();
    let startTime = $('input[name="selected_time_slot_id"]:checked').data('starttime');
    let endTime = $('input[name="selected_time_slot_id"]:checked').data('endtime');
    $('#startTime').val(startTime);
    $('#endTime').val(endTime);
    $('#checkItem').submit();
}