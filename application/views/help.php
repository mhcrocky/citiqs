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
	<div class="col-half background-yellow height-100">
		<div class="flex-column align-start">
			<div align="left">
				<h2 class="heading mb-35">
					<?php echo $this->language->line('HELP-A10001','ASK A QUESTION');?>
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
					<h2 style="font-weight:bold; font-family: caption-bold">UPDATE YOUR PROFILE</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">- GO TO PROFILE AND COMPLETE YOUR DETAILS FOR INVOICING
					- CREATE A NEW PASSWORD
				</p>
				<div class="flex-column align-space">
<!--					<p class="text-content-light" style="font-weight: bold">LOST BY YOUR CUSTOMER, <br>RETURNED BY US.							</p>-->
					<div id="timeline-video-3">
						<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></div>
					</div><!-- time line video for third block -->
					<div align="center">
						<!--                                href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->
						<a class="button button-orange mb-25" id="show-timeline-video-3">LEARN MORE VIDEO</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->

		<div class="timeline-block background-orange-light">
			<span class='timeline-number text-orange hide-mobile'>2</span>
			<div class="timeline-text">
				<div class='timeline-heading'>
					<span class='timeline-number text-blue show-mobile'>2</span>
					<h2 style="font-weight:bold; font-family: caption-bold">UPDATE YOUR SETTINGS</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">- SET YOUR ADMINISTRATION FEE
					- SET THE PICK-UP DATE AND TIME FOR YOUR CUSTOMERS AND / OR DHL
					- PERSONALIZE YOUR LOST & FOUND PAGE IN YOUR CORPORATE IDENTITY
					- MAKE YOUR LOST & FOUND PAGE PUBLIC OR NOT PUBLIC
					- PERSONALIZE THE OUTGOING MAIL TO YOUR CUSTOMERS (USE OR MAKE A TEMPLATE)
				</p>
				<div class="flex-column align-space">
<!--					<p class="text-content-light" style="font-weight: bold">LOST BY YOUR CUSTOMER, <br>RETURNED BY US.</p>-->
					<div id="timeline-video-4">
						<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></div>
					</div><!-- time line video for fourth block -->
					<div align="center">
						<!--                                href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->
						<a class="button button-orange mb-25" id="show-timeline-video-4">LEARN MORE VIDEO</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->

		<div class="timeline-block background-green-environment">
			<span class='timeline-number text-orange hide-mobile'>3</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-apricot show-mobile'>3</span>
					<h2 style="font-weight:bold; font-family: caption-bold">MAKE USERS</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">- CREATE ONE OR MORE USERS TO REGISTER THE LOST & FOUND ITEMS </p>
				<!--<span class="cd-date">Feb 18</span>-->
				<div class="flex-column align-space">
					<div align="center">
						<a href="" target="_blank" class="button button-orange mb-25">LEARN MORE VIDEO</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->

		<div class="timeline-block background-apricot timeblock-last">
			<span class='timeline-number text-orange hide-mobile'>4</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-blue show-mobile'>4</span>
					<h2>
						<h2 style="font-weight:bold; font-family: caption-bold">LOST AND FOUND ITEMS</h2>
					</h2>
				</div>

				<p class="text-content-light" style="font-size: larger">- VIEW ALL LOST & FOUND ITEMS IN YOUR ACCOUNT WITH A CLEAR OVERVIEW OF CLAIMED AND UNCLAIMED ITEMS. </p>
				<div class="flex-column align-space">
					<!--					<p class="text-content-light" style="font-weight: bold">LOST BY YOUR CUSTOMER, <br>RETURNED BY US.</p>-->
					<div id="timeline-video-4">
						<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></div>
					</div><!-- time line video for fourth block -->
					<div align="center">
						<!--                                href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->
						<a class="button button-orange mb-25" id="show-timeline-video-4">LEARN MORE VIDEO</a>
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
