<div class="main-wrapper" style="text-align:center">
	<div class="col-half  background-orange-light timeline-content">
		<form id="checkItem" action="<?php echo $this->baseUrl; ?>resendreservations/resend" method="post" enctype="multipart/form-data"  >
		<div class="login-box background-orange-light">
			<h2 style="font-family: caption-bold">E-MAIL</h2>
			<div class="form-group has-feedback">
				<input type="email" id="email" name="email" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="je e-mail" />
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="date" id="eventdate" name="eventdate" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="de datum" />
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="text" id="reservationrecord" name="reservationrecord" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="recordnumber" />
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>

			<div class="pricing-block-footer" style="height: 200px" >
				<button data-brackets-id="2918" type="submit" class="button button-orange">RESEND</button>
			</div>

		</div><!-- end pricing block -->
	</div>
	<div class="col-half  background-orange timeline-content">
	</div>
</div>
<script>
	$(document).ready(function(){
		if($(document).width() <= 768){
			var pricing_details_button = $('.pricing-details-button');
			$('.pricing-details-list').hide();
			$( document ).width();
			$(pricing_details_button).click(function(){
				$(this).parents('.pricing-component-body').find('.pricing-details-list').toggle('300');
			})
		}
	})
</script>
