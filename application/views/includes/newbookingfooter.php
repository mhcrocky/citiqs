<!-- end booking form inputs -->
<div id="booking-footer" class="booking-form__result w-100 d-none">
    <h4 id="footer-title" class="mb-3">Booking Info </h4>
    <p class="booking-info"><span class="event-text">Event Date</span>: <span id="selected-date">
            <?php $shorturl = $this->session->userdata('shortUrl');
			 if(base_url("agenda_booking/$shorturl") != current_url()):
              echo date("d.m.Y", strtotime($this->session->userdata('eventDate')));
            endif; ?>
        </span></p>
    <p class="booking-info"><span class="spot-text">SPOT Description</span>: <span
            id="spot"><?php echo $this->session->userdata('spotDescript'); ?></span></p>
    <p class="booking-info"><span>SPOT Price:</span> <span id="price"><?php echo $this->session->userdata('spotPrice'); ?></span></p>
    <p class="booking-info"><span class="timeslot-text">Time Slot</span>: <span
            id="selected-time"><?php echo (!is_numeric($this->session->userdata('timeslot'))) ? $this->session->userdata('timeslot') : ''; ?></span></p>
    <p class="booking-info"><span class="personal-info-text">Personal Info</span>: <span id="personal-info"></span></p>
</div>
<!-- end booking form results -->
</div>
<!-- end booking form -->



<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>
<script src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>

<!-- datepicker -->

<script>
(function() {
    customDesignLoad();
    var url = '<?php echo current_url(); ?>';
    url = url.split('/');

    if (url.includes('spots')) {
        $("#spot-active").addClass('booking-active');
    } else if (url.includes('time_slots')) {
        $("#timeslot-active").addClass('booking-active');
    } else if (url.includes('pay')) {
        $("#personal-active").addClass('booking-active');
        $('#booking-footer').removeClass('d-none');
    } else {
        $("#agenda-active").addClass('booking-active');
    }
})();



/* get number of persons on click */
$('#person-input .form-check-label').on('click', function() {
    $('#selected-persons').text($(this).siblings('input').val());
    $('.step-2').removeClass('active');
    $('.step-3').addClass('active');
});

/* get time slot on click */
$('#time-input .form-check-label').on('click', function() {
    //$('#selected-time').text($(this).siblings('input').val());
    $('.step').removeClass('active');
    $('.step-4').addClass('active');
});

/* show value when input field lose focus */
$('#name-input').blur(function() {
    $('#personal-name').text($(this).val());
})

$('#email-input').blur(function() {
    $('#personal-email').text(', ' + $(this).val());
})

$('#phone-input').blur(function() {
    $('#personal-phone').text(', ' + $(this).val());
})



/* go back button */
$('.go-back-button').click(function() {
    $(this).parents('.step').removeClass('active');
    $(this).parents('.step').prev().addClass('active')
})
</script>

</body>

</html>