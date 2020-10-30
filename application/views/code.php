<html>
<head>

	<!-- Google Font -->
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

	<script>

		function myFunctionBrand(str) {
			$(document).ready(function() {
				$.get("<?php echo base_url('index.php/ajax/users/'); ?>" + encodeURIComponent(str), function(data) {
					var result = JSON.parse(data);

					$('#myTable tbody').append('<tr><td>' + result.username + '</td><td>' + result.email + '</td></tr>');
					if (result.username == true) {
						document.getElementById("brandUnkownAddressText").style.display = "block";
						document.getElementById("brandname").style.display = "block";
						document.getElementById("brandaddress").style.display = "block";
						document.getElementById("brandaddressa").style.display = "block";
						document.getElementById("brandzipcode").style.display = "block";
						document.getElementById("brandcity").style.display = "block";
						document.getElementById("brandzip").style.display = "block";
						document.getElementById("brandcountry").style.display = "block";
						document.getElementById("brandcountry1").style.display = "block";
					}
				});
			});
		}

	</script>

</head>

<body>
<!-- end header -->
<div class="main-wrapper">

	<div class="col-half background-blue-light height-100">
		<div class="flex-column align-start">
			<div align="center">
				<h2 class="heading">
					<?php $this->language->line("CODE-010",'VERIFICATION CODE');?>
				</h2>
			</div>
			<div style="font-family: caption-light; font-size: larger">
				<p align="center">
					<?php $this->language->line("CODE-010AB","
					FOR BUSINESS AND PERSONAL
					");?>
				</p>
			</div>
			<div class="flex-row align-space">
				<div class="flex-column align-space">
					<div>
						<?php $this->load->helper('form'); ?>

						<div class="alert alert-danger alert-dismissable" id="mydivs">
							<button id="mydevs" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $this->language->Line(validation_errors(),validation_errors() ); ?>
						</div>
						<div class="row">
							<div class="col-md-12" id="mydivs">

							</div>
						</div>

						<?php
						$this->load->helper('form');
						$error = $this->session->flashdata('fail');
						if($error)
						{
						?>
						<div id="mydivs1">
							<div class="alert alert-danger alert-dismissable" id="mydivs1">
								<button id="mydevs" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<?php echo $this->language->Line($this->session->flashdata('fail'), $this->session->flashdata('fail')); ?>
							</div>
						</div>
						<?php }
						?>

						<?php
						$this->load->helper('form');
						$error = $this->session->flashdata('error');
						if($error)
						{
							?>
							<div id="mydivs1">
								<div class="alert alert-danger alert-dismissable" id="mydivs1">
									<button id="mydevs" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<?php echo $this->language->Line($this->session->flashdata('error'), $this->session->flashdata('error')); ?>
								</div>
							</div>
						<?php }

						$success = $this->session->flashdata('success');
						if($success)
						{
							?>
							<div class="alert alert-success alert-dismissable" id="mydivs2">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<?php echo $this->language->Line($this->session->flashdata('success'), $this->session->flashdata('success')); ?>
							</div>
						<?php }
						$success = $this->session->flashdata('code');
						if($success)
						{
							?>
							<div class="alert alert-success alert-dismissable" id="mydivs3">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<?php echo $this->language->Line($this->session->flashdata('code'), $this->session->flashdata('code')); ?>
							</div>
						<?php } ?>


						<form action="<?php echo base_url(); ?>loginMe" method="post">

							<div class="form-group has-feedback" align="center">
								<input style="border-radius: 50px" type="password" class="form-control" placeholder="Code" name="code" required />
							</div>

							<div class="row">
								<div class="form-group has-feedback" >
									<div style="text-align: center; ">
										<input type="submit" class="button button-orange" value="<?php $this->language->line("CODE-A240",'VERIFY THAT IT IS YOU');?>" style="border: none" />
									</div>
								</div>
							</div>

						</form>

					</div><!-- /.login-box-body -->

					<div style=" font-size: x-large">
						<p align="center">LOST BY YOU, RETURNED BY US
						</p>
					</div>

					<div class="row" align="center" style="padding:50px ">
						<img border="0" src="<?php echo base_url(); ?>tiqsimg/tiqslogonew.png" alt="tiqs" width="125" height="45" />
					</div class="login-box">

				</div>
			</div>
		</div>
	</div>

	<div class="col-half background-orange height-100 div-no-mobile">
		<div class="background-blue div-no-mobile height-100">
			<div class="flex-column align-start">
				<div style="text-align:center">
					<div style="margin-top: 0px; margin-left: 0px">
						<img border="0" src="<?php echo base_url(); ?>assets/home/images/tiqsbusiness.png" alt="tiqs" width="auto" height="110" />
					</div>
					<p style="font-size: larger; margin-top: 50px; margin-left: 0px"><?php $this->language->line("HOMESTART-001C",'THE NUMBER ONE PLATFORM <br> FOR LOST AND FOUND');?></p>
				</div>
				<div style="text-align:center; margin-top: 30px">
					<img border="0" src="<?php echo base_url(); ?>assets/home/images/dhlpoweredby.png" alt="tiqs" width="auto" height="15" />
				</div>
			</div>
		</div>

		<div class="background-orange div-no-mobile height-100">
			<div class="flex-column align-start">
				<div style="text-align:center">
					<div style="margin-top: 0px; margin-left: 0px">
						<img border="0" src="<?php echo base_url(); ?>assets/home/images/tiqscustomer.png" alt="tiqs" width="auto" height="110" />
					</div>
					<p style=" font-size: larger; margin-top: 50px; margin-left: 0px"><?php $this->language->line("HOMESTART-002A",'WE REUNITE LOST AND FOUND ITEMS <br>WITH THEIR RIGHTFUL OWNERS');?></p>
				</div>
				<div style="text-align:center; margin-top: 30px">
					<img border="0" src="<?php echo base_url(); ?>assets/home/images/dhlpoweredby.png" alt="tiqs" width="auto" height="15" />
				</div>
			</div>
		</div><!-- end col half -->
	</div>

	<div class="col-half background-orange height-100 div-only-mobile" style="min-height: 100%">
		<div class="flex-column align-start">
			<div style="text-align:center">
				<div style="margin-top: 0px; margin-left: 0px">
					<img border="0" src="<?php echo base_url(); ?>assets/home/images/tiqscustomer.png" alt="tiqs" width="auto" height="80" />
				</div>
				<p style="font-family: caption-light; font-size: larger; margin-top: 50px; margin-left: 30px ; margin-right: 30px"><?php $this->language->line("HOMESTART-002C",'WE REUNITE LOST AND FOUND ITEMS <br>WITH THEIR RIGHTFUL OWNERS');?></p>
			</div>
			<div style="text-align:center; margin-top: 30px">
				<img border="0" src="<?php echo base_url(); ?>assets/home/images/dhlpoweredby.png" alt="tiqs" width="auto" height="15" />
			</div>
		</div>
	</div><!-- end col half -->

	<div class="col-half background-blue height-100 div-only-mobile">
		<div class="flex-column align-start">
			<div style="text-align:center">
				<div style="margin-top: 0px; margin-left: 0px">
					<img border="0" src="<?php echo base_url(); ?>assets/home/images/tiqsbusiness.png" alt="tiqs" width="auto" height="80" />
				</div>
				<p style="font-family: caption-light;font-size: larger; margin-top: 50px; margin-left: 30px ; margin-right: 30px"><?php $this->language->line("HOMESTART-001A",'THE NUMBER ONE PLATFORM <br> FOR LOST AND FOUND');?></p>
			</div>
			<div style="text-align:center; margin-top: 30px">
				<img border="0" src="<?php echo base_url(); ?>assets/home/images/dhlpoweredby.png" alt="tiqs" width="auto" height="15" />
			</div>
		</div>
	</div><!-- end col half -->

</div>
</div>
</body>

</html>

<!-- end col half -->

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
