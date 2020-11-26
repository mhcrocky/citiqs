<style>
    #personal-active {
        background: #b32400 !important;
    }
</style>
	<div class="col-12 step step-4 active">
      <form id="checkItem" class="w-100" action="<?php echo $this->baseUrl; ?>agenda_booking/pay" method="post">
		<div class="form-group w-100">
			<label class="form-check-label" for="11">Name</label>
			<input class="form-control" type="text" id="username" name="username" placeholder="Your Name" required>
		</div>
		<div class="form-group w-100">
			<label class="form-check-label" for="11">Email</label>
			<input class="form-control" id="email" name="email" placeholder="Your Email" required>
		</div>
		<div class="form-group w-100">
		    <label class="form-check-label" for="11">Phone Number</label>
			<input class="form-control" name="mobile" id="mobile" type="tel" placeholder="Your Phone Number" required>
		</div>
		<button data-brackets-id="2918" type="submit" class="btn-primary btn" id="button-submit">BOOK NOW</button>
		<div class="w-100 go-back-wrapper">
		    <a class="go-back-button" href="javascript:history.back()">Go Back</a>
        </div>
      </form>
	</div>
<script>
$('input').on('change', function(){
		let info = $('#username').val() + ', ' + $('#email').val() + ', '+ $('#mobile').val();
		$('#personal-info').text(info);
	});
</script>
