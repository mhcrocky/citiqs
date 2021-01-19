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
<div class="main-wrapper-nh">
	<div class="col-half width-650 background-blue-light height-100" style="margin-top: 30px">
		<div class="flex-column align-start">
			<div align="center">
				<h2 class="heading">
					<?php echo $this->language->line("CODE-010",'VERIFICATION CODE');?>
				</h2>
			</div>
			<div style="font-family: caption-light; font-size: larger">
				<p align="center">
					<?php echo $this->language->line("CODE-010AB","
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
										<input type="submit" class="button button-orange" value="<?php echo $this->language->line("CODE-A240",'VERIFY THAT IT IS YOU');?>" style="border: none" />
									</div>
								</div>
							</div>

						</form>

					</div><!-- /.login-box-body -->

					<div class="row" align="center" style="padding:50px ">
						<div class="profile-name text-center">
							<img class="logo-img" src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogowhite.png" alt="logo">
						</div>
					</div class="login-box">

				</div>
			</div>
		</div>
	</div>

	<div class="col background-apricot" style="margin-left: 0px ;margin-right: 0px; padding: 0px; width: 100%">
		<ul class="nav nav-tabs" style="border-bottom: none;background-color: #efd1ba;margin-top: 10px;margin-bottom: 10px " role="tablist">
			<li class="nav-item">
				<a style="border-radius: 50px; margin-left:10px" class="nav-link active" data-toggle="tab" href="#manual"> <i class="ti-pencil-alt"> </i> Manual</a>
			</li>
			<li class="nav-item">
				<a style="border-radius: 50px;margin-left:10px" class="nav-link" data-toggle="tab" href="#app"> <i class="ti-pencil-alt"> </i> VENDOR App</a>
			</li>
			<li class="nav-item">
				<a style="border-radius: 50px;margin-left:10px" class="nav-link" data-toggle="tab" href="#api"> <i class="ti-pencil-alt"> </i> Alfred API</a>
			</li>
			<li class="nav-item">
				<a style="border-radius: 50px;margin-left:10px" class="nav-link" data-toggle="tab" href="#api"> <i class="ti-pencil-alt"> </i> Alfred API</a>
			</li>
		</ul>

		<div class="tab-content no-border" style="height: 100vh; width: 100%">
			<div id="manual" class="tab-pane active" style="background: none; height: 100%;margin-left: 0px ;margin-right: 0px; width:100%">
				<embed src="<?php echo base_url(); ?>/assets/home/documents/NL-manual.pdf" height=100% width="100%">
			</div>
			<div id="app" class="tab-pane"style="background: none; height: 100%">
				<embed src="<?php echo base_url(); ?>/assets/home/documents/EN-Manual VENDOR.pdf" height=100% width="100%">
			</div>
			<div id="api" class="tab-pane" style="background: none; height: 100%">
				<embed src="<?php echo base_url(); ?>/assets/home/documents/EN-MANUAL Alfred-API.pdf" height=100% width="100%">
			</div>
		</div>
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
