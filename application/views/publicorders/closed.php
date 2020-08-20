<div class="main-wrapper-nh" style="text-align:center">
	<div class="col-half background-apricot-blue height">
		<div class="width-650"></div>
				<div class="form-group has-feedback">
					<img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="350" height="" />
				</div><!-- /.login-logo -->
		<h1 style="text-align:center"><?php echo $vendor['vendorName'] ?></h1>
		<div class="selectWrapper mb-35">
			<h1>We are closed now</h1>
            <?php if ($workingTime) { ?>
                <h2 style="margin-top:20px">Working time</h2>
                <?php foreach ($workingTime as $day => $times) { ?>
                    <h3><?php echo $day ?><h3>
                    <?php foreach ($times as $time) { ?>
                    <p>From: <?php echo $time['timeFrom']; ?> To:  <?php echo $time['timeTo']; ?></p>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
		</div>
	</div>
</div>
