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
	<script src='https://www.google.com/recaptcha/VACANCIES.js' async defer ></script>

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

<script src='https://www.google.com/recaptcha/VACANCIES.js' async defer ></script>

<div class="main-wrapper">
	<div class="col-half background-yellow height-100">
		<div class="flex-column align-start">
			<div align="left">
				<h2 class="heading mb-35">
					<?php echo $this->language->line('VACANCIES-A10001a','JOIN OUR TEAM !');?>
				</h2>
				<iframe width="600" height="850" src="https://tiqs.com/backoffice/forms/ticket" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
	</div><!-- end col half -->

	<div class="col-half background-apricot timeline-content">
		<div class="timeline-block background-yellow">
			<span class='timeline-number text-orange hide-mobile'>1</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-green show-mobile'>1</span>
					<h2 style="font-weight:bold; font-family: caption-bold">
						<?php echo $this->language->line('VACANCIES-A100011','
					     WE LOVE TO HAVE YOU ONBOARD.
					');?></h2>
				</div>
				<p class="text-content-light" style="font-size: larger">
					<?php echo $this->language->line('VACANCIES-A100012','
					FILL IN THE FORM ON THIS PAGE AND WE WILL CONTACT YOU AS SOON AS POSSIBLE! 
					');?>
				</p>
			</div>
		</div><!-- end timeline block -->

		<div class="timeline-block background-orange-light">
			<span class='timeline-number text-orange hide-mobile'>2</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-green show-mobile'>2</span>
					<h2 style="font-weight:bold; font-family: caption-bold">
						<?php echo $this->language->line('VACANCIES-A100013','
					     BECOME AN AMBASSADOR 
					');?></h2>
				</div>
				<p class="text-content-light" style="font-size: larger">
					<?php echo $this->language->line('VACANCIES-A100014a','
					APPLY TO BECOME AN AMBASSADOR AND WE GET YOU STARTED IMMEDIATELY.  
					');?>
				</p>
			</div>
		</div><!-- end timeline block -->

		<div class="timeline-block background-green-environment">
			<span class='timeline-number text-orange hide-mobile'>3</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-green show-mobile'>3</span>
					<h2 style="font-weight:bold; font-family: caption-bold">
						<?php echo $this->language->line('VACANCIES-A100015','
					     EARN MONEY
					');?></h2>
				</div>
				<p class="text-content-light" style="font-size: larger">
					<?php echo $this->language->line('VACANCIES-A100016','
					EARN MONEY AS AN AFFILIATE APPLY THROUGH THE FORM! AND GET STARTED.   
					');?>
				</p>
			</div>
		</div><!-- end timeline block -->

		<div class="timeline-block background-apricot timeblock-last">
			<span class='timeline-number text-orange hide-mobile'>4</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-green show-mobile'>4</span>
					<h2 style="font-weight:bold; font-family: caption-bold">
						<?php echo $this->language->line('VACANCIES-A100017a','
					     TIQS MANAGER
					');?></h2>
				</div>
				<p class="text-content-light" style="font-size: larger">
					<?php echo $this->language->line('VACANCIES-A100018a','
					WE ARE STILL EXPANDING WORLD WIDE BECOME A TIQS MANAGER. APPLY THROUGH THE FORM ON THIS PAGE.   
					');?>
				</p>
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
