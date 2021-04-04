<?php 
$loginUrl = base_url() . "loginMe";
$employeeUrl = base_url() . "loginEmployee";
$current_url = current_url();
if($current_url == $employeeUrl || $current_url == $employeeUrl){
	$loginUrl = $employeeUrl;
}
?>
<div class="main-wrapper">

	<div class="col-half background-orange div-only-mobile">
		<div class="background-orange height-100">
			<div class="col-md-4">
				<?php
				$error = $this->session->flashdata('error');
				if ($error) {
					?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $this->language->Line($this->session->flashdata('error'), $this->session->flashdata('error')); ?>
					</div>
				<?php } ?>
				<?php
				$success = $this->session->flashdata('success');
				if ($success) {
					?>
					<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $this->language->Line($this->session->flashdata('success'), $this->session->flashdata('success')); ?>
					</div>
				<?php } ?>
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $this->language->Line(validation_errors(), validation_errors()); ?>
				</div>
			</div>

			<div style="text-align:left">
				<p style="font-family:'caption-bold'; font-size:300%; color:#ffffff;">
					<?php echo $this->language->Line("LOGIN-ELL3400",'EMPLOYEE LOGIN.');?>
				</p>
			</div>

			<div class="width-650">
				<?php include_once APPPATH . 'views/includes/sessionMessages.php' ?>
				<form action="<?php echo $employeeUrl; ?>" method="post">
					<p style="font-family:'caption-light'; color: #ffffff; font-size:100%; text-align: center">
						<?php echo $this->language->Line("registerbusiness-3500",'Use your e-mail to login');?>
					</p>
					<div class="form-group has-feedback" style="text-align:center">
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
					<div>
						<a href="forgotPassword" ><?php echo $this->language->Line("registerbusiness-F4001ab","I FORGOT MY PASSWORD, CAN I GET A NEW ONE?");?></a>
					</div>
				</form>
			</div>
		</div>
	</div><!-- end col half -->

	<div class="col-half background-blue height-100">
		<div class="flex-column align-start">
			<div class="col-md-4">
				<?php
				$error = $this->session->flashdata('error');
				if ($error) {
					?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $this->language->Line($this->session->flashdata('error'), $this->session->flashdata('error')); ?>
					</div>
				<?php } ?>
				<?php
				$success = $this->session->flashdata('success');
				if ($success) {
					?>
					<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $this->language->Line($this->session->flashdata('success'), $this->session->flashdata('success')); ?>
					</div>
				<?php } ?>


				<div class="row">
					<div class="col-md-12">
						<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
					</div>
				</div>

			</div>
			<div style="text-align:left">
				<p style="font-family:'caption-bold'; font-size:300%; color:#ffffff;">
					<?php echo $this->language->Line("LOGIN-LX103400",'BUSINESS LOGIN.');?>
				</p>
			</div>
			<div class="width-650">
				<form action="<?php echo $loginUrl; ?>" method="post">
					<p style="font-family:'caption-light'; color: #ffffff; font-size:100%; text-align: center">
						<?php echo $this->language->Line("registerbusiness-3500",'Use your e-mail to login');?>
					</p>
					<div class="form-group has-feedback" style="text-align:center">
						<input type="email" id="businessEmail" class="form-control" style="font-family:'caption-light'; border:none; border-radius: 50px; " placeholder="<?php echo $this->language->Line("registerbusiness-3600",'Your e-mail');?>" name="email" required />
						<div class="virtual-keyboard-hook" data-target-id="businessEmail" data-keyboard-mapping="qwerty"><i class="fa fa-keyboard-o" aria-hidden="true"></i></div>
					</div>
					<p style="font-family:'caption-light'; color: #ffffff; font-size:100%; text-align: center">
						<?php echo $this->language->Line("registerbusiness-3800",'Password');?>
					</p>
					<div class="form-group has-feedback">
						<input type="password" id="businessPassword" class="form-control" style="font-family:'caption-light';border:none; border-radius: 50px" placeholder="<?php echo $this->language->Line("registerbusiness-3900",'Your Password');?>" name="password" required />
						<div class="virtual-keyboard-hook" style="text-align:center" data-target-id="businessPassword" data-keyboard-mapping="qwerty"><i class="fa fa-keyboard-o" aria-hidden="true"></i></div>
					</div>

					<br>
					<div class="mb-35" style="text-align: center; ">
						<input type="submit" class="button button-orange" value="<?php echo $this->language->Line("registerbusiness-4100",'LOGIN');?>" style="border: none" />
					</div>
				</form>
				<div>
					<a href="forgotPassword" ><?php echo $this->language->Line("registerbusiness-F4100A","I FORGOT MY PASSWORD");?></a>
				</div>
				<div style="margin-top: 10%">
					<img src="<?php echo $this->baseUrl; ?>assets/home/images/analytics.png" alt="tiqs" width="100%" height="auto" />
				</div>
			</div>
		</div>
	</div><!-- end col half -->

	<div class="col-half background-orange height-100 div-no-mobile">
		<div class="flex-column align-start">
			<div class="col-md-4">
				<?php
				$error = $this->session->flashdata('error');
				if ($error) {
					?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $this->language->Line($this->session->flashdata('error'), $this->session->flashdata('error')); ?>
					</div>
				<?php } ?>
				<?php
				$success = $this->session->flashdata('success');
				if ($success) {
					?>
					<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $this->language->Line($this->session->flashdata('success'), $this->session->flashdata('success')); ?>
					</div>
				<?php } ?>
				<div class="row">
					<div class="col-md-12">
						<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
					</div>
				</div>
			</div>

			<div style="text-align:left;">
				<p style="font-family:'caption-bold'; font-size:300%; color:#ffffff;">
					<?php echo $this->language->Line("LOGIN-EEL203400",'EMPLOYEE LOGIN.');?>
				</p>
			</div>

			<div class="width-650">
				<div style="margin-top:-10%" align="right">
					<img src="<?php echo $this->baseUrl; ?>assets/home/images/girl.png" alt="tiqs" width="50%"/>
					<form action="<?php echo $employeeUrl; ?>" method="post">
					<p style="font-family:'caption-light'; color: #ffffff; font-size:100%; text-align: center">
						<?php echo $this->language->Line("registerbusiness-3500",'Use your e-mail to login');?>
					</p>
					<div class="form-group has-feedback" style="text-align:center;">
						<input id="personEmail"type="email" class="form-control" style="font-family:'caption-light'; border:none; border-radius: 50px; " placeholder="<?php echo $this->language->Line("registerbusiness-3600",'Your e-mail');?>" name="email" required />
						<div class="virtual-keyboard-hook" data-target-id="personEmail" data-keyboard-mapping="qwerty"><i class="fa fa-keyboard-o" aria-hidden="true"></i></div>
					</div>
					<p style="font-family:'caption-light'; color: #ffffff; font-size:100%; text-align: center">
						<?php echo $this->language->Line("registerbusiness-3800",'Password');?>
					</p>
					<div class="form-group has-feedback">
						<input id="personPassword" type="password" class="form-control" style="font-family:'caption-light';border:none; border-radius: 50px" placeholder="<?php echo $this->language->Line("registerbusiness-3900",'Your Password');?>" name="password" required />
						<div class="virtual-keyboard-hook" style="text-align:center" data-target-id="personPassword" data-keyboard-mapping="qwerty"><i class="fa fa-keyboard-o" aria-hidden="true"></i></div>
					</div>

					<br>
					<div style="text-align: center; margin-bottom: 30px ">
						<input type="submit" class="button button-orange" value="<?php echo $this->language->Line("registerbusiness-4100",'LOGIN');?>" style="border: none" />
					</div>
				</form>

				<div >
					<a style="color: orange" href="forgotPassword" ><?php echo $this->language->Line("registerbusiness-F4100A","I FORGOT MY PASSWORD");?></a>
				</div>
				</div>



			</div>
			<div class="mobile-hide" style="text-align:center; margin-top: 0px; margin-bottom: 50px; margin-left: 100px">

			</div>
				<div class="text-left mt-50 mobile-hide" style="margin-left: 100px; margin-bottom: 100px;  margin-top: -30px">
			</div>
		</div>
	</div><!-- end col half -->
</div><!-- end main wrapper -->
