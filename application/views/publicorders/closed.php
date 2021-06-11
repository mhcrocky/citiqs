<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<main class="main-wrapper-nh" style="text-align:center; width:100vw: height:100vh">
	<div
		class="col-half background-apricot-blue height designBackgroundImage"
		id="closedContainer"
	>
		<div class="width-650"></div>
		<div class="form-group has-feedback">
			<img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="350" height="" />
		</div><!-- /.login-logo -->
		<h1 id="closedContainerH1" style="text-align:center"><?php echo $vendor['vendorName'] ?></h1>
		<div class="selectWrapper mb-35">
			<?php  if ($isClosedPeriod) { ?>
                <h2 class="closedContainerFontColor">
					<?php echo $this->language->tLine('We are closed from');?>&nbsp;
					'<?php echo $vendor['nonWorkFrom']; ?>'&nbsp;
					<?php echo $this->language->tLine('to');?>&nbsp;'<?php echo $vendor['nonWorkTo']; ?>'
				</h2>
			<?php } else { ?>				
				<?php if ($workingTime) { ?>
					<h2 class="closedContainerFontColor">
						<?php echo $this->language->tLine('We are closed now');?>
					</h2>
					<h2 class="closedContainerFontColor" style="margin-top:20px">
						<?php echo $this->language->tLine('Working time');?>
					</h2>
					<?php foreach ($workingTime as $day => $times) { ?>
						<h3 class="closedContainerFontColor"><?php echo $day ?><h3>
						<?php foreach ($times as $time) { ?>
							<p class="closedContainerFontColor">
								<?php echo $this->language->tLine('From');?>:&nbsp;<?php echo substr($time['timeFrom'],0,5); ?> &nbsp;
								<?php echo $this->language->tLine('To');?>::  <?php echo substr($time['timeTo'],0,5); ?>
							</p>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</main>
