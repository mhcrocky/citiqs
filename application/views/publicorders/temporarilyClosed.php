<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="main-wrapper-nh" style="text-align:center; width:100vw: height:100vh">
	<div class="col-half background-apricot-blue height">
		<div class="width-650"></div>
		<div class="form-group has-feedback">
			<img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="350" height="" />
		</div><!-- /.login-logo -->
		<h1 style="text-align:center"><?php echo $vendor['vendorName'] ?></h1>
		<div class="selectWrapper mb-35">
			<h2>
				<?php echo $this->language->tLine('We are temporarily closed');?>
			</h2>
			<p><?php echo $this->language->tLine('Registration error. Please contact staff');?></p>
		</div>
		<div>
			<a
				href="<?php echo base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spotId; ?>"
				class="button"
			>
				<?php echo $this->language->tLine('TRY AGAIN');?>
			</a>
		</div>
	</div>
</div>
