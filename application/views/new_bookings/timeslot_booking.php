<!-- end step 2-->
<style>
#time-input .form-check-label {
    width: 110px;
}
</style>
<div class="col-12 step step-3 active" id="time-input">
    <h3 id="title">
        <span id="choose-timeslot">Please Choose a Time Slot</span>
    </h3>
    <?php foreach ($timeSlots as $key => $timeSlot): ?>
    <?php 
    if($timeSlot['multiple_timeslots'] == 1):
        $fromtime = explode(':',$timeSlot['fromtime']);
        $totime = explode(':', $timeSlot['totime']);
        $duration = explode(':', $timeSlot['duration']);
        $overflow = explode(':', $timeSlot['overflow']);

        $time_diff = ($totime[0]*60 - $fromtime[0]*60) + ($totime[1] - $fromtime[1]);
        $time_duration = ($duration[0]*60 + $overflow[0]*60) + ($duration[1] + $overflow[1]);
        $time_div = intval($time_diff/$time_duration);
        $start_time = '';
        $end_time = '';
        for($i=0; $i < $time_div; $i++):
        
        if($i == 0){

            $start_time = Agenda_booking::explode_time($timeSlot['fromtime']);
            $end_time = $start_time + Agenda_booking::explode_time($timeSlot['duration']);
        } else {
            $start_time = $end_time + Agenda_booking::explode_time($timeSlot['overflow']);
            $end_time = $start_time + Agenda_booking::explode_time($timeSlot['duration']);
        }
    ?>
    <form id="form-<?php echo $timeSlot['id']; ?>_<?php echo $i; ?>"
        action="<?php echo $this->baseUrl; ?>agenda_booking/time_slots/<?php echo $spot->id; ?>" method="post"
        enctype="multipart/form-data">
        <?php if($timeSlot['status'] != "soldout"): ?>
        <div class="form-check">
            <input class="form-check-input" onclick="radioVal(this, '<?php echo $timeSlot['id']; ?>_<?php echo $i; ?>')" type="radio"
                id="test<?php echo $timeSlot['id']; ?>_<?php echo $i; ?>" name="selected_time_slot_id" data-starttime="<?php echo $start_time; ?>" data-endtime="<?php echo $end_time; ?>"
                value="<?php echo $timeSlot['id']; ?>">
            <label class="form-check-label" for="test<?php echo $timeSlot['id']; ?>_<?php echo $i; ?>">
                <?php echo Agenda_booking::second_to_hhmm($start_time).' - '.Agenda_booking::second_to_hhmm($end_time); ?>
            </label>
        </div>
        <?php endif; ?>
        <input type="hidden" name="save" value="1" />
    </form>
    <?php endfor; ?>
    <?php else: ?>
    <form id="form-<?php echo $timeSlot['id']; ?>"
        action="<?php echo $this->baseUrl; ?>agenda_booking/time_slots/<?php echo $spot->id; ?>" method="post"
        enctype="multipart/form-data">
        <?php if($timeSlot['status'] != "soldout"): ?>
        <div class="form-check">
            <input class="form-check-input" onclick="radioVal(this, <?php echo $timeSlot['id']; ?>)" type="radio"
                id="test<?php echo $timeSlot['id']; ?>" name="selected_time_slot_id"
                value="<?php echo $timeSlot['id']; ?>">
            <label class="form-check-label" for="test<?php echo $timeSlot['id']; ?>">
                <?php echo date("H:i", Agenda_booking::explode_time($timeSlot['fromtime'])).' - '.date("H:i", Agenda_booking::explode_time($timeSlot['totime'])); ?>
            </label>
        </div>
        <?php endif; ?>
        <input type="hidden" name="save" value="1" />
    </form>
    <?php endif; ?>
    <?php endforeach; ?>
    <div class="w-100 go-back-wrapper">
        <a class="go-back-button"
            href="javascript:location.replace('<?php echo base_url();?>agenda_booking/spots/<?php echo $this->session->userdata('eventDate'); ?>/<?php echo $this->session->userdata('eventId'); ?>')">Go
            Back</a>
    </div>
</div>

<script>
function radioVal(el, timeslot) {
    let startTime = $(el).data('starttime');
    let endTime = $(el).data('endtime');
    $('#startTime').remove();
    $('#endTime').remove();
    $(el).append('<input type="hidden" id="startTime" name="startTime" value="'+startTime+'">');
    $(el).append('<input type="hidden" id="endTime" name="endTime" value="'+endTime+'">');
    document.getElementById('form-' + timeslot).submit();
}
</script>