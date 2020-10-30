<div class="main-wrapper main-wrapper-contact" style="text-align:center">
	<div class="col-half background-purple-light timeline-content">
		<div class="pricing-block background-orange-light">
			<div class="pricing-block-body">
				<div class="pricing-first" style="font-family: caption-bold">
					<h2 style="font-family: caption-bold">PERSONAL STARTER</h2>
					<h6 style="font-family: caption-bold">PRICE PER YEAR</h6>
					<h1 style="font-family:caption-bold ">€ <?php echo $starterPackagePrice; ?></h1>
					<p style="font-family: caption-light">STRAIGHT FORWARD ONE FEE PER YEAR EASY REGISTRATION</p>
				</div>
			</div><!-- end pricing block body -->
			<div class="pricing-block-footer">
				<a data-brackets-id="2918" href="<?php echo base_url(); ?>pay/1" class="button button-orange"><img src="pay.png" alt="">SELECT</a>
			</div>
		</div><!-- end pricing block -->
		<div class="pricing-block background-orange">
			<div class="pricing-block-body">
				<div class="pricing-first" style="font-family: caption-bold">
					<h2 style="font-family: caption-bold">BASIC PERSONAL MONTHLY</h2>
					<h6 style="font-family: caption-bold">PRICE PER MONTH</h6>
					<h1 style="font-family: caption-bold">€ <?php echo $basicPackagePrice; ?></h1>
					<p style="font-family: caption-light">STRAIGHT FORWARD FEE PER MONTH EASY REGISTRATION OF UNLIMTED ITEMS</p>
				</div>
			</div><!-- end pricing block body -->
			<div class="pricing-block-footer">
				<a data-brackets-id="2918" href="<?php echo base_url(); ?>pay/3" class="button button-orange"><img src="pay.png" alt="">SELECT</a>
			</div>
		</div><!-- end pricing block -->

		<div class="pricing-block background-purple-light">
			<div class="pricing-block-body">
				<div class="pricing-first" style="font-family: caption-bold">
					<h2 style="font-family: caption-bold">KIDS PACKAGE</h2>
					<h6 style="font-family: caption-bold">PRICE PER YEAR</h6>
					<h1 style="font-family: caption-bold">€ <?php echo $kidsPackagePrice; ?></h1>
					<p style="font-family: caption-light">STRAIGHT FORWARD ONE FEE PER YEAR EASY REGISTRATION</p>
				</div>
			</div><!-- end pricing block body -->
			<div class="pricing-block-footer">
				<a data-brackets-id="2918" href="<?php echo base_url(); ?>pay/5" class="button button-orange"><img src="pay.png" alt="">SELECT</a>
			</div>
		</div><!-- end pricing block -->

		<div class="pricing-block background-yellow">
			<div class="pricing-block-body">
				<div class="pricing-first" style="font-family: caption-bold">
					<h2 style="font-family: caption-bold">STICKER PACK</h2>
					<h6 style="font-family: caption-bold">10 STICKER-PAPERS</h6>
					<h1 style="font-family: caption-bold">€ <?php echo $kidsPackagePrice; ?></h1>
					<p style="font-family: caption-light"></p>
				</div>
			</div><!-- end pricing block body -->
			<div class="pricing-block-footer">
				<a data-brackets-id="2918" href="<?php echo base_url(); ?>pay/6" class="button button-orange"><img src="pay.png" alt="">SELECT</a>
			</div>
		</div><!-- end pricing block -->

	</div>
	<div class="col-half background-yankee height-100">
		<div class="flex-column align-start "><!-- width-650 -->
			<div style="text-align:left; font-family: caption-light">
				<h2 style="font-family: caption-light">
					PAY YOUR SUBSCRIPTION FOR </h2>
				<div class="heading mb-35" style="font-size: larger">
					</br> <?php echo $message; ?></div>
				<?php
					include_once FCPATH . 'application/views/includes/sessionMessages.php';
				?>
				<form action="<?php echo base_url(); ?>payregisterandpaysubscription" method="post">
					<input type="number" name="subscriptionid" required readonly hidden value="<?php echo $subscriptionid;?>" />
					<div class="form-group has-feedback">
						<input style="font-family:'caption-light'; border-radius: 50px" type="email" name="user[email]" required value="<?php echo $email;?>"  onblur="checkEmail(this)" class="form-control" placeholder="Email" />
					</div>
					<div class="form-group has-feedback">
						<input style="font-family:'caption-light'; border-radius: 50px" type="email"  name="emailverify" required value="<?php echo $email; ?>" onblur="checkEmail(this)" class="form-control" placeholder="Repeat email for verification"  />
					</div>
					<div class="form-group has-feedback">
						<input type="tel" id="mobile" name="user[mobile]" disabled  class="form-control" style="display: none; font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->line("SEND-160",'Your mobile number');?>" />
					</div>
					<div class="form-group has-feedback">
						<input id="username" disabled type="text" name="user[username]" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-070",'Your full name');?>" />
					</div>
					<div class="form-group has-feedback">
						<input id="address" disabled type="text" name="user[address]" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-080",'Your address');?>" />
					</div>
					<div class="form-group has-feedback">
						<input id="addressa" disabled type="text" name="user[addressa]" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-090",'Extra address line');?>" />
					</div>
					<div class="form-group has-feedback">
						<input type="text" id="zipcode" name="user[zipcode]" disabled class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-100",'Your zipcode');?>" />
					</div>
					<div class="form-group has-feedback">
						<input type="text" id="city" disabled  name="user[city]" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-110",'City');?>" />
					</div>
					<div class="form-group has-feedback">
						<select class="form-control selectBox" id="country" name="user[country]" disabled style="display: none; font-family:'caption-light';  border-radius:50px; ">
							<?php include FCPATH . 'application/views/includes/countrySelectOptions.php'; ?>
						</select>
					</div>
					<?php if ($subscriptionid === '3') { ?>
					<div class="row">
						<div>
							<p style="font-family:'Century Gothic W01'; font-size:100%; color: #ff5722; text-align: center"><span>Payment option & Consent</span></p>
						</div>
						<div>
							<p style="font-family:'Century Gothic W01'; font-size:100%; color: #000000; text-align: center">By clicking the "PayPal" or "Visa" or "Mastercard" button or fill e-mail above with "facebook" button, you agree to our Terms of use, Privacy policy and Disclaimer<br /></p>
						</div>
						<br>
						<div style="text-align: center">
							<input name="paypal" type="image" src="<?php echo base_url(); ?>tiqsimg/paypal.png" alt="Paypal" />
							<input name="visamastercard" type="image" src="<?php echo base_url(); ?>tiqsimg/visamastercard.png" alt="Visa or Mastercard" />
						</div>
						<br>
					</div>
					<?php } else { ?>
					<div style="text-align: center">
						<input type="submit" class="button button-orange" value="PAY"/>
					</div>
					<?php } ?>
				</form>
			</div>
		</div>
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
