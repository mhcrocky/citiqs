<div class="main-wrapper" style="text-align:center">
	<div class="col-half  background-orange-light timeline-content">
		<form id="checkItem" action="<?php echo $this->baseUrl; ?>booking/bookingpay" method="post" enctype="multipart/form-data"  >
		<div class="login-box background-orange-light">
			<div class="pricing-block-body">
				<div class="pricing-first" style="font-family: caption-bold">
					<h2 style="font-family: caption-bold">JOUW RESERVERING BIJ</h2>
					<img src="<?php echo $this->baseUrl; ?>assets/home/images/thuishaven.png" alt="tiqs" width="250" height="auto" />
					<h2 style="font-family: caption-bold" ><?php echo $Spotlabel; ?> </h2>
					<h1 style="font-family:caption-bold ">Betaal € <?php echo $price; ?></h1>
					<p style="font-family: caption-light">VAN <?php echo $timefrom; ?></p>
					<p style="font-family: caption-light">TOT <?php echo $timeto; ?></p>
					<p style="font-family: caption-light">MAX AANTAL PERSONEN <?php echo $numberofpersons; ?></p>
				</div>
			</div><!-- end pricing block body -->
			<h2 style="font-family: caption-bold">NAAM</h2>
			<div class="form-group has-feedback">
				<input type="text" id="username" name="username" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->Line("spot-reservationspay-1300",'je naam');?>" />
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
			</div>
			<h2 style="font-family: caption-bold">E-MAIL</h2>
			<div class="form-group has-feedback">
				<input type="email" id="email" name="email" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="je e-mail" />
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<h2 style="font-family: caption-bold">MOBIEL</h2>
			<div class="form-group has-feedback">
				<input name="mobile" id="mobile" type="tel" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->Line("spot-resrevationpay-2200","je Phone number");?>" required />
				<span class="glyphicon glyphicon-phone form-control-feedback"></span>
			</div>
			<div class="pricing-block-footer" style="height: 200px" >
				<button data-brackets-id="2918" type="submit" class="button button-orange">BETAAL</button>
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
