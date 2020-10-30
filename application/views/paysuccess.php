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

		/*.panel p{*/
		/*	margin: 18px 0;*/
		/*	font-family: 'caption-light', sans-serif;*/
		/*}*/

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
				<h2 class="heading mb-35">
					<?php echo $this->language->line('PAYMENTERROR-SAB100010','THANK YOU FOR YOUR PAYMENT');?>
				</h2>
				<?php
				$this->load->helper('form');
				echo $this->session->flashdata('fail'); ?>
				<div class="row">
					<div class="col-md-12" id="mydivs">
						<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
					</div>
				</div>
				<?php
				$this->load->helper('form');
				$error = $this->session->flashdata('error');
				if($error){
					?>
					<div id="mydivs1">
						<div class="alert alert-danger alert-dismissable" id="mydivs">
							<button id="mydevs" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $error; ?>
						</div>
					</div>
				<?php }
				$success = $this->session->flashdata('success');
				if($success){
					?>
					<div class="alert alert-success alert-dismissable" id="mydivs2">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $success; ?>
					</div>
				<?php } ?>
				<div class="mb-35" style=" font-size: x-large">
					<div>You successfully paid<span></div>
					<div class="or" style="font-family: 'caption-light', caption-light; font-size: smaller"><span>- <?php $description;?></span></div>
				</div>
				<p style="font-family: caption-light" class="text-content mb-35"><?php echo $this->language->line("PAYMENTERROR-A003",'LOST BY YOU,<br> RETURNED BY US.');?></p>
			</div>
			<div class="text-Left mt-50 mobile-hide" style="margin-top: 0px; margin-left: 0px">
				<img border="0" src="<?php echo base_url(); ?>assets/home/images/lostandfounditemswhite.png" alt="tiqs" width="500" height="auto" />
			</div>
			<div class="mt-50" align="center" >
				<img border="0" src="<?php echo base_url(); ?>assets/home/images/tiqsiconlogonew.png" alt="tiqs" width="75" height="auto" />
			</div>
		</div>
	</div><!-- end col half -->

	<div class="col-half background-blue timeline-content">
		<div class="timeline-block background-orange">
			<div class="timeline-text">
				<div class="timeline-heading">
					<h2 style="font-weight:bold; font-family: caption-bold">LOGIN.</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">LOGIN INTO YOUR PERSONAL ACCOUNT.</p>
				<div class="flex-column align-space">
					<div align="center">
						<a href="login" class="button button-orange mb-25">CONTACT US</a>
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
