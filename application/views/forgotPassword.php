<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/hotel-page.css">
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
	<div class="col-half background-green height-100">
		<div class="flex-column align-start">
			<div align="left">
					<!-- <p class="login-box-msg" style="font-weight: bold font-family:"Century Gothic" font-size: larger">Login</p> -->
					<p  style="font-family:'caption-bold'; font-size:300%; text-align: left; color: white">FORGOT PASSWORD</p>        <?php $this->load->helper('form'); ?>
					<p style="color:white">
						WITH YOUR E-MAIL ADDRESS KNOW BY TIQS, YOU CAN REQUEST A NEW PASSWORD.<br>
						A RESET PASSWORD E-MAIL IS SEND TO YOUR ACCOUNT.
					</p>
					<div class="row">
						<div class="col-md-12">
							<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
						</div>
					</div>
					<?php
					$this->load->helper('form');
					$error = $this->session->flashdata('error');
					$send = $this->session->flashdata('send');
					$notsend = $this->session->flashdata('notsend');
					$unable = $this->session->flashdata('unable');
					$invalid = $this->session->flashdata('invalid');
					if($error)
					{
						?>
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $this->session->flashdata('error'); ?>
						</div>
					<?php }

					if($send)
					{
						?>
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $send; ?>
						</div>
					<?php }

					if($notsend)
					{
						?>
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $notsend; ?>
						</div>
					<?php }

					if($unable)
					{
						?>
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $unable; ?>
						</div>
					<?php }

					if($invalid)
					{
						?>
						<div class="alert alert-warning alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $invalid; ?>
						</div>
					<?php } ?>

					<form action="<?php echo base_url(); ?>resetPasswordUser" method="post">
						<div class="form-group has-feedback">
							<input type="email" class="form-control" placeholder="Email" name="login_email" style="font-family: 'caption-light', caption-light ;border-radius: 50px" required />
						</div>

						<div>
							<div style="text-align: left">
								<input type="submit" class="button button-orange" value="GET A NEW ONE..." />
							</div>
						</div>
					</form>
					<br>
					<div class="row">
						<div class="col-xs-8"
					</div>
					</div>
				</div>
			</div>
		</div><!-- /.login-box -->
	</div>

	<div class="col-half background-blue timeline-content">
		<div class="timeline-block background-orange">
			<div class="timeline-text">
				<div class="timeline-heading">
					<h2 style="font-weight:bold; font-family: caption-bold">LOGIN.</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">LOGIN INTO YOUR PERSONAL ACCOUNT.</p>
				<div class="flex-column align-space">
					<div align="center">
						<a href="login" class="button button-orange mb-25">LOGIN</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->

		<div class="timeline-block background-orange-light">
			<div class="timeline-text">
				<div class='timeline-heading'>
					<h2 style="font-weight:bold; font-family: caption-bold">REGISTER AN OTHER ITEM.</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">USE THIS BUTTON TO REGISTER AN OTHER ITEM</p>
				<div class="flex-column align-space">
					<div align="center">
						<a href="check" class="button button-orange mb-25">REGISTER</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->

		<div class="timeline-block background-blue">
			<div class="timeline-text">
				<div class="timeline-heading">
					<h2 style="font-weight:bold; font-family: caption-bold">QUESTIONS</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">YOU CAN ALWAYS CONTACT US WHEN HAVING A QUESTION ABOUT YOUR ORDER. PLEASE USE THE BUTTON BELOW</p>
				<!--<span class="cd-date">Feb 18</span>-->
				<div class="flex-column align-space">
					<div align="center">
						<a href="" target="_blank" class="button button-orange mb-25">CONTACT SALES</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
	</div>
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
