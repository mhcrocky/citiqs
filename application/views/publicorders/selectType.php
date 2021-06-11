<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<main class="main-wrapper-nh" style="text-align:center">
	<div class="background-apricot-blue height-100 designBackgroundImage" id="selectTypeBody" style="width:100vw; height:auto">
		<?php if (empty($_SESSION['iframe'])) { ?>
		<div class="form-group has-feedback mt-50" >
			<?php {
				if (is_null($vendor['logo'])) {
					$logoFile = base_url() . "assets/home/images/tiqslogowhite.png";
				} else {
					$logoFile = base_url(). "assets/images/vendorLogos/". $vendor['logo'];
				}
				// echo var_dump($logoFile);
				// echo var_dump($vendor['logo']);
			} ?>
			<!-- <img src="<?php //echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="250" height="auto" /> -->
			<img src="<?php echo $logoFile; ?>" alt="tiqs" width="250" height="auto" />

		</div><!-- /.login-logo -->
		<?php } ?>


		<!-- EMXAMPLE HOW TO ADD CSS PROPETY TO ELEMENT IN DESIGN -->
		<h3 style="text-align:center" id="selectTypeH1"><?php echo $vendor['vendorName'] ?></h3>


		<div class="selectWrapper mb-35">
			<?php if (!empty($activeTypes)) { ?>
			<div class="middle">
				<?php foreach ($activeTypes as $type) { ?>

					<label>
						<input
							type="radio"
							name="radio"
							value="<?php echo 'make_order?vendorid=' . $vendor['vendorId'] . '&typeid=' . $type['typeId'] ?>"
							onchange="redirectTo(this.value)" class="form-control" <?php if($type['typeId']==='0') echo "checked" ?>
						/>
						<div class="front-end box selectTypeLabels">
							<!--							--><?php //{
							//								if (is_null($vendor['logo'])) {
							//									$logoFile = base_url() . "assets/home/images/tiqslogowhite.png";
							//								} else {
							//									$logoFile = base_url(). "assets/images/vendorLogos/". $vendor['logo'];
							//								}
							//							} ?>

							<!--							<div style="margin-top: 20px" align="center">-->
							<!--								<img src="--><?php //echo $logoFile; ?><!--" alt="tiqs" width="100" height="auto" align="center"/>-->
							<!--							</div>-->

							<div style="margin-top: 10px">
								<div style="margin-top: -60px">
									<span class="selectTypeLabelsColor typeLabel"><?php echo $this->language->tLine($type['type']);?></span>
								</div>
							</div>
							<div style="margin-top:100px">
								<i class="<?php if($type['typeId']==='1') echo "fa fa-coffee selectTypeLabelsColor" ?>" style="font-size:48px;color:ghostwhite"></i>
								<i class="<?php if($type['typeId']==='2') echo "fa fa-bicycle selectTypeLabelsColor" ?>" style="font-size:48px;color:ghostwhite"></i>
								<?php if($type['typeId']==='3') { ?>
								<img src="<?php if($type['typeId']==='3') echo base_url(); ?>assets/home/images/pickup.png" alt="tiqs" width="48px" height="48px" style="margin-top: -20px"/>
								<?php } ?>
							</div>

							<div style="margin-top: -80px">
								<div style="margin-top: 10px">
									<span style="font-size: xx-small" class="selectTypeLabelsColor"><?php echo $this->language->tLine('click here');?></span>
								</div>
							</div>
						</div>
					</label>

				<?php } ?>
			</div>

			<?php if ($vendor['requireReservation'] === '1' && !empty($_SESSION['visitorReservationId'])) { ?>
				<div><br/></div>
				<a href="<?php echo base_url(); ?>check424/<?php echo $vendor['vendorId']; ?>"><?php echo $this->language->tLine('Checkout');?></a>
			<?php } ?>
			<?php } else { ?>
				<p><?php echo $this->language->tLine('No available service');?></p>
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
	<!--					<p style="font-size: larger; margin-top: 50px; margin-left: 0px">--><?php //$this->language->tLine('BUILD BY TIQS');?><!--</p>-->
	<!--				</div>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--	</div>-->

</main>

<script>
(function(){
	$('.main-wrapper-nh').attr('style','text-align: center;min-height: 100%;');
	$('html').height('100%');
	$('body').height('100%');
	//$('.main-wrapper-nh').height('100%');
}())
</script>
