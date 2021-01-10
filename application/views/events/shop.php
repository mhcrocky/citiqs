<style>
<?php
if(isset($design)){
	$design = $design['selectType'];
	
	$design_ids = $design['id'];
	foreach($design_ids as $key => $design_id){
		echo '#'. $key . '{';
		echo array_keys($design_id)[0].':';
		echo array_values($design_id)[0].'!important } ';
	}

	$design_classes = $design['class'];
	foreach($design_classes as $key => $design_class){
		echo '.'. $key . '{';
		echo array_keys($design_class)[0].':';
		echo array_values($design_class)[0].'!important } ';
	}
} ?>
</style>
<main class="main-wrapper-nh" style="text-align:center">
	<div class="background-apricot-blue height-100 designBackgroundImage" id="selectTypeBody" style="width:100vw; height:100vh">

		<div class="form-group has-feedback" >
			<img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="250" height="auto" />
		</div><!-- /.login-logo -->
		


		<!-- EMXAMPLE HOW TO ADD CSS PROPETY TO ELEMENT IN DESIGN -->
		<h1 style="text-align:center" id="selectTypeH1"><?php //echo $vendor['vendorName'] ?></h1>


		<div class="selectWrapper mb-35">
			<?php if (!empty($events)) { ?>
			<div class="middle">
				<?php foreach ($events as $event) { ?>
				<a href="<?php echo base_url(); ?>events/tickets/<?php echo $event['id']; ?>">
					<label>
						<div class="front-end box selectTypeLabels">
							<div style="margin-top: 20px">
								<img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="100px" height="" />
							</div>

							<div style="margin-top: -10px">
								<div style="margin-top: -30px">
									<span  class="selectTypeLabelsColor"><?php echo $event['eventname']; ?></span>
								</div>
							</div>

							<div style="margin-top:80px">
								
							</div>

							<div style="margin-top: -70px">
								<div style="margin-top: 10px">
									<span style="font-size: xx-small" class="selectTypeLabelsColor"><?php echo $event['eventdescript']; ?></span>
								</div>
							</div>

						</div>
					</label>
					</a>

				<?php } ?>
			</div>
			<?php } ?>

		</div>
	</div>

<!--	<div class="col-half background-blue height-100">-->
<!--		<div class="align-start">-->
<!--			</div>-->
<!--				<div style="text-align:center;">-->
<!--					<img src="--><?php //echo base_url(); ?><!--assets/home/images/alfredmenu.png" alt="tiqs" width="auto" height="110" />-->
<!--				</div>-->
<!--				<h1 style="text-align:center">QR-MENU</h1>-->
<!--				<div style="text-align:center; margin-top: 30px">-->
<!--					<p style="font-size: larger; margin-top: 50px; margin-left: 0px">--><?php //$this->language->line("HOMESTART-SPOT-X001111ABC",'BUILD BY TIQS');?><!--</p>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->

</main>
