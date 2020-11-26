<!-- end booking form inputs -->
<div class="booking-form__result w-100">
			<h4 class="mb-3">Booking Info </h4>
			<p>Event Date: <span id="selected-date"><?php echo $this->session->userdata('date'); ?></span></p>
			<p>SPOT Description: <span id="spot"><?php echo $this->session->userdata('spotDescript'); ?></span></p>
			<p>SPOT Price: <span id="price"><?php echo $this->session->userdata('spotPrice'); ?></span></p>
			<p>Time Slot: <span id="selected-time"><?php echo $this->session->userdata('timeslot'); ?></span></p>
		</div>
		<!-- end booking form results -->
	</div>
	<!-- end booking form -->



<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- datepicker -->
<script>
	
	/* disable previous dates */
	var todayDate = new Date();
	todayDate.setDate(todayDate.getDate()-1);
	
	$('#date-input').datepicker({
		startDate: todayDate
	});
    
   
	/* get date from calendar on click */
	$('#date-input').on('changeDate', function() {
        let getDate = $('#date-input').datepicker('getFormattedDate');
        let d = getDate.split('/');
        let mm = d[0];
        let dd = d[1];
        let yy = d[2];
        let date = yy + '-' + mm + '-' + dd;
		$.post('<?php echo base_url(); ?>agenda_booking/get_agenda/<?php echo $shortUrl; ?>',{date:date},function(data){
            data = JSON.parse(data);
            if(typeof data[0] === 'undefined'){
              toastr.options = {
                "showDuration": "200",
                "hideDuration": "1000",
                "timeOut": "1000"
              }
              toastr["error"]("Sorry, we don't have agenda for this date!");
                return ;
            }
            let agenda_id = data[0]['id'];
            let dateFormat = date.replace('-', '').replace('-', '');
            location.href = "<?php echo base_url(); ?>agenda_booking/spots/"+dateFormat+"/"+agenda_id;
        });
	});
	
	/* get number of persons on click */
	$('#person-input .form-check-label').on('click', function() {
		$('#selected-persons').text($(this).siblings('input').val());
		$('.step-2').removeClass('active');
		$('.step-3').addClass('active');
	});
	
	/* get time slot on click */
	$('#time-input .form-check-label').on('click', function() {
		$('#selected-time').text($(this).siblings('input').val());
		$('.step').removeClass('active');
		$('.step-4').addClass('active');
	});
	
	/* show value when input field lose focus */ 
	$('#name-input').blur(function(){
		$('#personal-name').text($(this).val());
	})
	
	$('#email-input').blur(function(){
		$('#personal-email').text(', ' + $(this).val());
	})
	
	$('#phone-input').blur(function(){
		$('#personal-phone').text(', ' + $(this).val());
	})
	
	
	
	/* switch steps by clicking on title */
	$('.booking-form__date-link').click(function(){
		$('.step').removeClass('active');
		$('.step-1').addClass('active');
	})
	
	$('.booking-form__person-link').click(function(){
		$('.step').removeClass('active');
		$('.step-2').addClass('active');
	})
	
	$('.booking-form__time-link').click(function(){
		$('.step').removeClass('active');
		$('.step-3').addClass('active');
	})
	
	$('.booking-form__info-link').click(function(){
		$('.step').removeClass('active');
		$('.step-4').addClass('active');
	})
	

	/* go back button */
	$('.go-back-button').click(function(){
		$(this).parents('.step').removeClass('active');
		$(this).parents('.step').prev().addClass('active')
	})
	
</script>

</body>
</html>