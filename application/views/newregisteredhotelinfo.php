<html>
<head>
	<head>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/hotel-page.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/timeline.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/timeline-page.css">

		<style>

			.width-650{
				margin: 0 auto;
			}

			.manual-content .heading{
				text-align: center;
				color: #fff;
			}

			.faq-page{
				display: flex;
				flex-direction: column;
			}

			.faq-page{
				margin: 0 auto;
			}

			.faq-login{
				flex-grow:1;
			}

			.panel {
				padding: 0 18px;
				background-color: transparent !important;
				color: #fff !important;
				border:   1px solid transparent !important;
				box-shadow: none !Important;
			}
			.panel p{
				margin: 18px 0;
				font-family: 'caption-light', sans-serif;
			}

			.svg-overflow svg{
				overflow: visible;
			}

			.background-yankee .active, .background-yankee .accordion:hover {
				background-color: #18386663;
			}

			.background-green .active, .background-green .accordion:hover {
				background-color: #66a694;
			}


		</style>

	</head>

	<script>

		function capenable() {
			document.getElementById("capsubmit").style.display = "block";
		}

		function capdisable() {
			document.getElementById("capsubmit").style.display = "none";
		}


	</script>
	<script src='https://www.google.com/recaptcha/api.js' async defer ></script>

</head>

<style type="text/css">
	input[type="checkbox"] {
		zoom: 3;
	}

	@media screen and (max-width: 680px) {
		.columns .column {
			flex-basis: 100%;
			margin: 0 0 5px 0;
		}
	}
	.selectWrapper {
		border-radius: 50px;
		overflow: hidden;
		background: #eec5a7;
		border: 0px solid #ffffff;
		padding: 5px;
		margin: 0px;
	}

	.selectBox {
		background: #eec5a7;
		width: 100%;
		height: 25px;
		border: 0px;
		outline: none;
		padding: 0px;
		margin: 0px;
	}
</style>

<body>
<!-- end header -->

<script src='https://www.google.com/recaptcha/api.js' async defer ></script>

<div class="main-wrapper">
	<div class="col-half background-yankee height-100">
		<div class="flex-column align-start">
			<div class="flex-row align-space">
				<div class="flex-column align-space">
					<div align="center">
						<p style="font-family:'caption-bold'; font-size:300%; color:#ffffff;">
						<h2 class="heading"> <?php echo $this->language->Line("registerbusiness-B1100",'THANK YOU FOR REGISTERING.');?></h2>

					</div>

					<p style="font-family:'caption-light'; font-size:150%; color:#ffffff;">
					YOU CAN NOW LOGIN


				</div>
			</div>

			<div align="left">
				<p style="font-family:'caption-bold'; font-size:300%; color:#ffffff;">
					<?php echo $this->language->Line("LOGIN-LX103400",'BUSINESS LOGIN.');?>
				</p>
			</div>
			<div class="width-650">
				<form action="<?php echo base_url(); ?>loginMe" method="post">
					<p style="font-family:'caption-light'; color: #ffffff; font-size:100%; text-align: center">
						<?php echo $this->language->Line("registerbusiness-3500",'Use your e-mail to login');?>
					</p>
					<div class="form-group has-feedback" align="center">
						<input type="email" class="form-control" style="font-family:'caption-light'; border:none; border-radius: 50px; " placeholder="<?php echo $this->language->Line("registerbusiness-3600",'Your e-mail');?>" name="email" required />
					</div>
					<p style="font-family:'caption-light'; color: #ffffff; font-size:100%; text-align: center">
						<?php echo $this->language->Line("registerbusiness-3800",'Password');?>
					</p>
					<div class="form-group has-feedback">
						<input type="password" class="form-control" style="font-family:'caption-light';border:none; border-radius: 50px" placeholder="<?php echo $this->language->Line("registerbusiness-3900",'Your Password');?>" name="password" required />
					</div>

					<br>
					<div style="text-align: center; ">
						<input type="submit" class="button button-orange" value="<?php echo $this->language->Line("registerbusiness-4100",'LOGIN');?>" style="border: none" />
					</div>
					<div class="mobile-hide" align="center" style="margin-top: 70px; margin-bottom: 30px; margin-left: 100px">
						<img border="0" src="<?php echo base_url(); ?>assets/home/images/TIQSLaptop.png" alt="tiqs" width="300" height="300" />
					</div>
					<div class="text-Left mt-50 mobile-hide" style="margin-top: -20px; margin-left: 100px">
						<img border="0" src="<?php echo base_url(); ?>assets/home/images/TIQSWallet.png" alt="tiqs" width="150" height="125" />
						<div class="text-center mt-50 mobile-hide" style="margin-top: 150px; margin-left: -50px">
							<img border="0" src="<?php echo base_url(); ?>tiqsimg/tiqslogonew.png" alt="tiqs" width="125" height="45" />
						</div>
					</div>
				</form>
			</div>
		</div>

	</div>

	<div class="col-half background-apricot timeline-content">
		<div class="timeline-block background-blue">
			<span class='timeline-number text-orange hide-mobile'>1</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-blue show-mobile'>2</span>
					<h2 style="font-weight:bold; font-family: caption-bold ">ACTIVATE</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">YOUR ACTIVATION CODE IS IN YOUR MAIL</p>
				<div class="flex-column align-space">
					<!--					<p class="text-content-light" >LOST BY YOUR CUSTOMER, <br>RETURNED BY US.</p>-->
					<div id="timeline-video-2" class="">
						<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></div>
					</div>
					<!--					<div align="center">-->
					<!--						<a class="button button-orange mb-25" id="show-timeline-video-2">LEARN MORE VIDEO</a>-->
					<!--					</div>-->
				</div>
			</div>
		</div><!-- end timeline block -->


		<div class="timeline-block background-blue-light">
			<span class='timeline-number text-orange hide-mobile'>2</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-blue show-mobile'>2</span>
					<h2 style="font-weight:bold; font-family: caption-bold">LOGIN</h2>
				</div>
				<p class="text-content-light" style="font-size: larger;">BY LINK IN YOUR MAIL OR ON THIS PAGE</p>
				<div class="flex-column align-space">
					<!--					<p class="text-content-light" >LOST BY YOUR CUSTOMER, <br>RETURNED BY US.</p>-->
					<div id="timeline-video-2" class="">
						<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></div>
					</div>
<!--					<div align="center">-->
<!--						<a class="button button-orange mb-25" id="show-timeline-video-2">LEARN MORE VIDEO</a>-->
<!--					</div>-->
				</div>
			</div>
		</div><!-- end timeline block -->


	<div class="mobile-hide" align="center" style="margin-top: 50px; margin-bottom: 50px; margin-left: 50px">
		<img border="0" src="<?php echo base_url(); ?>assets/home/images/lostandfounditemswhite.png" alt="tiqs" width="500" height="auto" />
		<div class="mobile-hide" style="margin-left: 150px; margin-top: -20px; margin-bottom: 0px">
			<img border="0" src="<?php echo base_url(); ?>assets/home/images/StickerNew.png" alt="tiqs" width="125" height="auto" />
		</div>
	</div>
	<div class="text-left mt-50 mobile-hide" style="margin-left: 100px; margin-bottom: 100px;  margin-top: -30px">
		<div class="text-left mobile-hide" style="margin-left: 100px; margin-bottom: -40px; ">
			<img border="0" src="<?php echo base_url(); ?>assets/home/images/Keychain.png" alt="tiqs" width="110" height="50" />
		</div>
		<img border="0" src="<?php echo base_url(); ?>assets/home/images/TIQSKeys.png" alt="tiqs" width="250" height="200" />
		<div class="text-center mt-50 mobile-hide" align="center">
			<img border="0" src="<?php echo base_url(); ?>assets/home/images/DHL_express.png" alt="tiqs" width="300" height="auto" />
		</div>
	</div>
	</div><!-- end timeline block -->

	<!-- time-line -->
	<!-- end col half -->
</div>
<!-- end main wrapper -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

<script type="text/javascript">
	// modal script
	// Get the modal
	var modal = document.getElementById("myModal");

	// Get the button that opens the modal
	var btn = document.getElementById("modal-button");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on the button, open the modal
	btn.onclick = function() {
		modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

</script>

<script>

	var acc = document.getElementsByClassName("accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			if (panel.style.maxHeight) {
				panel.style.maxHeight = null;
				panel.style.border = 'none';
			} else {
				panel.style.maxHeight = panel.scrollHeight + "px";
				/* panel.style.border = '1px solid #ffffff4a';
				   panel.style.borderTop = 'none';
				   panel.borderTopLeftRadius = 0 + 'px';
				   panel.borderTopRightRadius = 0 + 'px';*/
			}
		});
	}

</script>

<script>

	$('#show-timeline-video-2').click(function(){
		console.log('da');
		$('#timeline-video-2').toggleClass('show');
	})

	$('#show-timeline-video-3').click(function(){
		console.log('da');
		$('#timeline-video-3').toggleClass('show');
	})

	$('#show-timeline-video-4').click(function(){
		console.log('da');
		$('#timeline-video-4').toggleClass('show');
	})

</script>

</html>
<?php
if(isset($_SESSION['error'])){
	unset($_SESSION['error']);
}
if(isset($_SESSION['success'])){
	unset($_SESSION['success']);
}
if(isset($_SESSION['message'])){
	unset($_SESSION['message']);
}
?>
