<div class="main-wrapper">
	<div class="col-half background-orange div-only-mobile height-100">
		<div class="background-orange height-100">
			<?php $this->load->helper('form'); ?>
			<?php echo $this->session->flashdata('fail'); ?>
			<div class="row">
				<div class="col-md-12" id="mydivs-fail">
					<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
				</div>
			</div>
			<?php
			$this->load->helper('form');
			$error = $this->session->flashdata('error');
			if($error){
				?>
				<div class="alert alert-danger alert-dismissable" id="mydivs1">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $error; ?>
				</div>
			<?php }
			$success = $this->session->flashdata('success');
			if($success){
				?>
				<div class="alert alert-success alert-dismissable" id="mydivs2">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $success; ?>
				</div>
			<?php }
			?>
			<div style="text-align:left;">
				<p style="font-family:'caption-bold'; font-size:300%; color:#ffffff;">
					<?php echo $this->language->Line("registerbusiness-3400",'LOGIN.');?>
				</p>
			</div>
			<div class="width-650">
				<form action="<?php echo base_url(); ?>loginMe" method="post">
					<p style="font-family:'caption-light'; color: #ffffff; font-size:100%; text-align: center">
						<?php echo $this->language->Line("registerbusiness-3500",'Use your e-mail to login');?>
					</p>
					<div class="form-group has-feedback" style="text-align:center;">
						<input type="email" class="form-control" style="font-family:'caption-light'; border:none; border-radius: 50px; " placeholder="<?php echo $this->language->Line("registerbusiness-3600",'Your e-mail');?>" name="email" required />
					</div>
					<p style="font-family:'caption-light'; color: #ffffff; font-size:100%; text-align: center">
						<?php echo $this->language->Line("registerbusiness-3800",'Password');?>
					</p>
					<div class="form-group has-feedback">
						<input type="password" class="form-control" style="font-family:'caption-light';border:none; border-radius: 50px" placeholder="<?php echo $this->language->Line("registerbusiness-3900",'Your Password');?>" name="password" required />
					</div>

					<br>
					<div style="text-align: center; margin-bottom: 10px ">
						<input type="submit" class="button button-orange" value="<?php echo $this->language->Line("registerbusiness-4100",'LOGIN');?>" style="border: none" />
					</div>
				</form>
			</div>
		</div>
	</div><!-- end col half -->

	<div class="col-half background-yankee" style="100%">
			<div id="map" style="height: 100%">
				<h2>Please wait...</h2>
			</div>
	</div><!-- end col half -->

	<div class="col-half background-orange height-100 div-no-mobile">
		<div class="flex-column align-start">
			<div style="text-align:left;">
				<p style="font-family:'caption-bold'; font-size:300%; color:#ffffff;">
					<?php echo $this->language->Line("LOGIN-L203400",'PERSONAL LOGIN.');?>
				</p>
			</div>
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

			<div class="width-650">
				<form action="<?php echo base_url(); ?>loginMe" method="post">
					<p style="font-family:'caption-light'; color: #ffffff; font-size:100%; text-align: center">
						<?php echo $this->language->Line("registerbusiness-3500",'Use your e-mail to login');?>
					</p>
					<div class="form-group has-feedback" style="text-align:center;">
						<input type="email" class="form-control" style="font-family:'caption-light'; border:none; border-radius: 50px; " placeholder="<?php echo $this->language->Line("registerbusiness-3600",'Your e-mail');?>" name="email" required />
					</div>
					<p style="font-family:'caption-light'; color: #ffffff; font-size:100%; text-align: center">
						<?php echo $this->language->Line("registerbusiness-3800",'Password');?>
					</p>
					<div class="form-group has-feedback">
						<input type="password" class="form-control" style="font-family:'caption-light';border:none; border-radius: 50px" placeholder="<?php echo $this->language->Line("registerbusiness-3900",'Your Password');?>" name="password" required />
					</div>

					<br>
					<div style="text-align: center; margin-bottom: 30px ">
						<input type="submit" class="button button-orange" value="<?php echo $this->language->Line("registerbusiness-4100",'LOGIN');?>" style="border: none" />
					</div>
				</form>
			</div>
			<div class="mobile-hide" style="text-align:center; margin-top: 0px; margin-bottom: 50px; margin-left: 100px">
				<img src="<?php echo base_url(); ?>assets/home/images/Mobilephone.png" alt="tiqs" width="125" height="250" />
				<div class="mobile-hide" style="margin-left: 150px; margin-top: -30px; margin-bottom: 0px">
					<img src="<?php echo base_url(); ?>assets/home/images/StickerNew.png" alt="tiqs" width="125" height="50" />
				</div>
			</div>
			<div class="text-left mt-50 mobile-hide" style="margin-left: 100px; margin-bottom: 100px;  margin-top: -30px">
				<div class="text-left mobile-hide" style="margin-left: 100px; margin-bottom: -40px; ">
					<img src="<?php echo base_url(); ?>assets/home/images/Keychain.png" alt="tiqs" width="110" height="50" />
				</div>
				<img src="<?php echo base_url(); ?>assets/home/images/TIQSKeys.png" alt="tiqs" width="250" height="200" />
				<div class="text-center mt-50 mobile-hide" style="margin-top: 110px; margin-left: -150px">
					<img src="<?php echo base_url(); ?>tiqsimg/tiqslogonew.png" alt="tiqs" width="125" height="45" />
				</div>
			</div>
		</div>
	</div><!-- end col half -->
</div><!-- end main wrapper -->

<script>
	function getGloablsMapVariablse() {
		return {
			url : "<?php base_url(); ?>",
			hotels : <?php $hotels; ?>,
			saveLocationUrl : '<?php echo base_url() . "saveLocation" ?>',
			id : "<?php echo $this->session->userdata("userId"); ?>",
			markerSrc: "<?php base_url(); ?>assets/home/images/mapicon.png"
		}
	}
</script>
