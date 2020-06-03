<!DOCTYPE html>
<html>
<head>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/pricing-style.css">
</head>
<body>
<div class="col" style="margin-top: 50px; background-color: indigo">
<div class="pricing-section">
	<div class="pricing-row">
		<div class="pricing-component" >
			<div class="pricing-component-header" style="background-color: #72B19F; font-family: caption-bold"" >
				<div class="pricing-header-content" style="background-color: #72B19F; font-family: caption-bold" >
					<p >BASIC</p>
				</div>
			</div>
			<!-- end header-->
			<div class="pricing-component-body">
				<div class="pricing-body-top-content">
					<h6 style="font-family: caption-light">NO HIDDEN FEE, PRICE PER YEAR</h6>
					<h1 style="font-family: caption-bold">€ 7,24</h1>
					<p class='font-light'>Easy protection only e-mail notification</p>
					<small class='pricing-details-button'>plan description</small>
				</div>
				<div class="pricing-body-main">
					<ul class='pricing-details-list'>
						<li>
							<a href='#'><span class='pricing-list-bold'></span>UNLIMITED REGISTRATION OF STICKERS, TAGS, KEY-CHAIN</a>
						</li>
						<li>
							<a href='#'><span class='pricing-list-bold'></span>NOTIFICATION ONLY BY MAIL</a>
						</li>
						<li>
							<a href='#'><span class='pricing-list-bold'></span>PERSONAL E-MAILS WITH PROMOTIONS AND ADVERTISEMENT</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="pricing-component-footer pricing-footer-darker" style="background-color: #72B19F">
				<a href="<?php echo base_url(); ?>/pay/1">Get your subscription</a>
			</div>
		</div>
		<!-- end pricing component -->

		<div class="pricing-component pricing-component-bigger">
			<div class="pricing-component-header" style="background-color: #E25F2A">
				<div class="pricing-header-content" style="background-color: #E25F2A">
					<p>PERSONAL</p>
				</div>
			</div>
			<!-- end header-->
			<div class="pricing-component-body">
				<div class="pricing-body-top-content">
					<h6 style="font-family: caption-light">MONTHLY PAYMENT, NO HIDDEN FEE'S</h6>
					<h1 style="font-family: caption-bold">€ 1,50</h1>
					<p class='font-darker'>Full service protection instant notification</p>
					<small class='pricing-details-button'>plan description</small>
				</div>
				<div class="pricing-body-main">
					<ul class='pricing-details-list'>
						<li>
							<a href='#'><span class='pricing-list-bold'></span>UNLIMITED REGISTRATION OF STICKERS, TAGS, KEY-CHAIN</a>
						</li>

						<li>
							<a href='#'><span class='pricing-list-bold'></span>DIRECT NOTIFICATION BY SMS</a>
						</li>
						<li>
							<a href='#'><span class='pricing-list-bold'></span>DIRECT NOTIFICATION BY E-MAIL</a>
						</li>
						<li>
							<a href='#'><span class='pricing-list-bold'></span>PERSONAL E-MAILS WITH PROMOTIONS AND ADVERTISEMENT WITH SPECIAL OFFERINGS</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="pricing-component-footer pricing-footer-bigger" style="background-color: #E25F2A">
				<a href="<?php echo base_url(); ?>/pay/3">MOST CHOSEN PLAN!<br/>Get your subscription</a>
			</div>
		</div>
		<!-- end pricing component -->

		<div class="pricing-component">
			<div class="pricing-component-header" style="background-color: #446087">
				<div class="pricing-header-content" style="background-color: #446087">
					<p>BUSINESS</p>
				</div>
			</div>
			<!-- end header-->
			<div class="pricing-component-body ">
				<div class="pricing-body-top-content ">
					<h6 style="font-family: caption-light">BECOME A TIQS DROP-OFF POINT</h6>
					<h1 style="font-family: caption-bold">CALL US</h1>
					<p class='font-dark'>Easy plan</p>
					<small class='pricing-details-button'>plan description</small>
				</div>
				<div class="pricing-body-main">
					<ul class='pricing-details-list'>
						<ul class='pricing-details-list'>
							<li>
								<a href='#'><span class='pricing-list-bold'></span>UNLIMITED REGISTRATION OF STICKERS, TAGS, KEY-CHAIN</a>
							</li>

							<li>
								<a href='#'><span class='pricing-list-bold'></span>DIRECT NOTIFICATION BY SMS</a>
							</li>
							<li>
								<a href='#'><span class='pricing-list-bold'></span>DIRECT NOTIFICATION BY E-MAIL</a>
							</li>
							<li>
								<a href='#'><span class='pricing-list-bold'></span>PERSONAL E-MAILS WITH PROMOTIONS AND ADVERTISEMENT WITH SPECIAL OFFERINGS</a>
							</li>
					</ul>
				</div>
			</div>
			<div class="pricing-component-footer" style="background-color: #446087">
				<a href="#">CONTACT US</a>
			</div>
		</div>
		<!-- end pricing component -->
	</div>
	<!-- end pricing row -->
</div>
<!-- end pricing section -->
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
</body>
</html>
