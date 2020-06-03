<div class="main-wrapper" style="text-align:center">
	<div class="col-half  background-orange-light timeline-content">
		<form id="checkItem" action="<?php echo $this->baseUrl; ?>booking/bookingpay" method="post" enctype="multipart/form-data"  >
			<div class="login-box background-orange-light">
				<div class="pricing-block-body">
					<div class="pricing-first" style="font-family: caption-bold">
						<h2 style="font-family: caption-bold">WIL JE NOG EEN TIJDSLOT RESERVEREN?</h2>
						<div>
							<img src="<?php echo $this->baseUrl; ?>assets/home/images/thuishaven.png" alt="tiqs" width="250" height="auto" />
						</div>
						<div class="mb-35">
							<button href="" type="button" class="button button-orange">VOLGENDE</button>
						</div>
						<div>
							<img src="<?php echo $this->baseUrl; ?>assets/home/images/paymentcheckout.png" alt="tiqs" width="150" height="auto" />
						</div>
					</div>
				</div><!-- end pricing block body -->

				<div class="pricing-block-footer" style="height: 200px" >
					<div>
						<h2 style="font-family: caption-bold">OF GA NAAR BETALEN</h2>
					</div>

					<button href="booking" type="button" class="button button-orange">BETALEN</button>
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
