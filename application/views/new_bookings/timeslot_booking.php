<!-- end step 2-->
<style>
    #time-input .form-check-label {
        width: 110px;
    }
</style>
    <div class="col-12 step step-3 active" id="time-input">
        <h3 id="title">Please Choose a Time Slot</h3>
        <?php foreach ($timeSlots as $key => $timeSlot): ?>
        <form id="form-<?php echo $timeSlot['id']; ?>" action="<?php echo $this->baseUrl; ?>agenda_booking/time_slots/<?php echo $spot->id; ?>" method="post" enctype="multipart/form-data">
            <?php if($timeSlot['status'] != "soldout"): ?>
		<div class="form-check">
			<input class="form-check-input" onclick="radioVal(<?php echo $timeSlot['id']; ?>)" type="radio" id="test<?php echo $timeSlot['id']; ?>" name="selected_time_slot_id" value="<?php echo $timeSlot['id']; ?>">
			<label class="form-check-label" for="test<?php echo $timeSlot['id']; ?>">
                <?php echo date("H:i", strtotime($timeSlot['fromtime'])).' - '.date("H:i", strtotime($timeSlot['totime'])); ?>
            </label>
        </div>
            <?php endif; ?>
            <input type="hidden" name="save" value="1" />
        </form>
        <?php endforeach; ?>
		<div class="w-100 go-back-wrapper">
            <a class="go-back-button" href="javascript:location.replace('<?php echo base_url();?>agenda_booking/spots/<?php echo $this->session->userdata('eventDate'); ?>/<?php echo $this->session->userdata('eventId'); ?>')">Go Back</a>
		</div>
    </div>

    <script>
        function radioVal(timeslot){
            document.getElementById('form-'+timeslot).submit();
        }
    </script>