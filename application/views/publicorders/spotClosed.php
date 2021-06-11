<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="main-wrapper-nh designBackgroundImage" style="text-align:center; width:100vw: height:100vh" id="spotClosed">
	<div class="col-half background-apricot-blue height">
		<div class="width-650"></div>
		<div class="form-group has-feedback">
			<img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="350" height="" />
		</div><!-- /.login-logo -->
		<h1 style="text-align:center"><?php echo $vendor['vendorName'] ?></h1>
		<div class="selectWrapper mb-35">
			<h1><?php echo $this->language->tLine('Spot');?> "<?php echo $spot->spotName; ?>" <?php echo $this->language->tLine('is closed');?></h1>
            <?php if ($workingTime) { ?>
                <h2 style="margin-top:20px"><?php echo $this->language->tLine('Working time');?></h2>
                <?php foreach ($workingTime as $day => $times) { ?>
                    <h3><?php echo $day ?><h3>
                    <?php foreach ($times as $time) { ?>
                    <p>
						<?php echo $this->language->tLine('From');?>: <?php echo $time['timeFrom']; ?>&nbsp;
						<?php echo $this->language->tLine('To');?>:  <?php echo $time['timeTo']; ?>
					</p>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
		</div>
	</div>
</div>
