<!-- end step 2-->

<div class="col-12 step step-3 active" id="time-input">
    <table style="background: none !important;" class="table table-striped w-100 text-center">
        <tr>
            <th><?php echo $this->language->tLine('Time'); ?></th>
            <th><?php echo $this->language->tLine('Price'); ?></th>
        </tr>
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

        $timeslotSoldout = Agenda_booking::check_if_soldout($timeSlot['id'], Agenda_booking::second_to_hhmm($start_time), Agenda_booking::second_to_hhmm($end_time), $timeSlot['available_items']);
        $timeSlot['status'] = ($timeslotSoldout === true) ? 'soldout' : 'open';
        
    ?>
        <tr>
            <?php if($timeSlot['status'] != "soldout"): ?>
            <td class="text-center">
                <form style="padding-left: 16px;" id="form-<?php echo $timeSlot['id']; ?>_<?php echo $i; ?>"
                    action="<?php echo $this->baseUrl; ?>agenda_booking/time_slots/<?php echo $spot->id; ?>?order=<?php echo $orderRandomKey; ?>"
                    method="post" enctype="multipart/form-data">

                    <div class="form-check">
                        <input class="form-check-input" data-timeslot="<?php echo $timeSlot['id']; ?>_<?php echo $i; ?>"
                            type="radio" id="test<?php echo $timeSlot['id']; ?>_<?php echo $i; ?>"
                            name="selected_time_slot_id" data-starttime="<?php echo $start_time; ?>"
                            data-endtime="<?php echo $end_time; ?>" value="<?php echo $timeSlot['id']; ?>">
                        <label class="radioLabel btn btn-primary"
                            for="test<?php echo $timeSlot['id']; ?>_<?php echo $i; ?>">
                            <?php echo Agenda_booking::second_to_hhmm($start_time).' - '.Agenda_booking::second_to_hhmm($end_time); ?>
                        </label>
                    </div>

                    <input type="hidden" name="save" value="1" />
                </form>
            </td>
            <td><?php echo $timeSlot['price']; ?>€</td>
        </tr>
        <?php else: ?>
        <tr>
            <td class="text-center">
                <label class="radioLabel btn btn-primary">
                    <?php echo Agenda_booking::second_to_hhmm($start_time).' - '.Agenda_booking::second_to_hhmm($end_time); ?>
                </label>
            </td>
            <td>Sold Out</td>
        </tr>
            <?php endif; ?>

            <?php endfor; ?>
            <?php else: ?>
            <?php if($timeSlot['status'] != "soldout"): ?>
        <tr>
            <td class="text-center">
                <form style="padding-left: 16px;" id="form-<?php echo $timeSlot['id']; ?>"
                    action="<?php echo $this->baseUrl; ?>agenda_booking/time_slots/<?php echo $spot->id; ?>?order=<?php echo $orderRandomKey; ?>"
                    method="post" enctype="multipart/form-data">

                    <div class="form-check">
                        <input class="form-check-input" data-timeslot="<?php echo $timeSlot['id']; ?>" type="radio"
                            id="test<?php echo $timeSlot['id']; ?>" name="selected_time_slot_id"
                            value="<?php echo $timeSlot['id']; ?>">
                        <label class="radioLabel btn btn-primary" for="test<?php echo $timeSlot['id']; ?>">
                            <?php $dt1 = new DateTime($timeSlot['fromtime']);
                $fromtime = $dt1->format('H:i');
                $dt2 = new DateTime($timeSlot['totime']);
                $totime = $dt2->format('H:i');
                echo $fromtime.' - '.$totime; ?>

                        </label>
                    </div>

                    <input type="hidden" name="save" value="1" />
                </form>
            </td>
            <td><?php echo $timeSlot['price']; ?>€</td>
        </tr>
        <?php else: ?>
        <tr>
            <td class="text-center">
                <label class="radioLabel btn btn-primary">
                    <?php $dt1 = new DateTime($timeSlot['fromtime']);
                $fromtime = $dt1->format('H:i');
                $dt2 = new DateTime($timeSlot['totime']);
                $totime = $dt2->format('H:i');
                echo $fromtime.' - '.$totime; ?>
                </label>

            </td>
            <td>Sold Out</td>
        </tr>
        <?php endif; ?>
        <?php endif; ?>
        <?php endforeach; ?>
    </table>
    <div class="w-100 go-back-wrapper">
        <a class="go-back-button"
            href="javascript:location.replace('<?php echo base_url();?>agenda_booking/spots/<?php echo $eventDate; ?>/<?php echo $eventId; ?>?order=<?php echo $orderRandomKey; ?>')"><?php echo $this->language->tLine('Go Back'); ?></a>
    </div>
</div>

<script>
$('.form-check-input').change(function() {
    let timeslot = $(this).data('timeslot');
    radioVal(this, timeslot)
});

function radioVal(el, timeslot) {
    let startTime = $(el).data('starttime');
    let endTime = $(el).data('endtime');
    $('#startTime').remove();
    $('#endTime').remove();
    $(el).append('<input type="hidden" id="startTime" name="startTime" value="' + startTime + '">');
    $(el).append('<input type="hidden" id="endTime" name="endTime" value="' + endTime + '">');
    document.getElementById('form-' + timeslot).submit();
}
</script>
