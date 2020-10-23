<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/bigsquare.css">
<div class="main-wrapper-nh" style="text-align:center">
	<div class="col-half background-apricot-blue height-100">
		<div class="width-650"></div>
		<?php if (empty($_SESSION['iframe'])) { ?>
            <div class="form-group has-feedback" style="margin-top: -30px">
                <img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="250" height="auto" />
            </div><!-- /.login-logo -->
		<?php } ?>
		<h1 style="text-align:center"><?php echo $vendor['vendorName'] ?></h1>
		<div class="selectWrapper mb-35">
			<?php if (!empty($activeTypes)) { ?>
<!--				<label for="spot">Service types:</label>-->
<!--				<select class="selectBox selectSpot" id="type" onchange="redirectTo(this.value)" class="form-control" style="color :black">-->
<!--					<option value="">Select type</option>-->
<!--					<div class="middle">-->
<!--					--><?php //foreach ($activeTypes as $type) { ?>
<!--					<option value="--><?php //echo 'make_order?vendorid=' . $vendor['vendorId'] . '&typeId=' . $type['typeId'] ?><!--">-->
<!--						--><?php //echo $type['type']; ?>
<!--					</option>-->
<!---->
<!--					--><?php //} ?>
<!--				</select>-->
				<div class="middle">
					<?php foreach ($activeTypes as $type) { ?>

						<label>
							<input type="radio" name="radio" value="<?php echo 'make_order?vendorid=' . $vendor['vendorId'] . '&typeId=' . $type['typeId'] ?>" onchange="redirectTo(this.value)" class="form-control" <?php if($type['typeId']==='0') echo "checked" ?> />
							<div class="front-end box">
								<div style="margin-top: 20px">
									<img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="100px" height="" />
								</div>

								<div style="margin-top: -10px">
									<div style="margin-top: -30px">
										<span><?php echo $type['type']; ?></span>
									</div>
								</div>

								<div style="margin-top:80px">
									<i class="<?php if($type['typeId']==='1') echo "fa fa-coffee" ?>" style="font-size:48px;color:ghostwhite"></i>
									<i class="<?php if($type['typeId']==='2') echo "fa fa-bicycle" ?>" style="font-size:48px;color:ghostwhite"></i>
									<?php if($type['typeId']==='3') { ?>
									<img src="<?php if($type['typeId']==='3') echo base_url(); ?>assets/home/images/pickup.png" alt="tiqs" width="48px" height="48px" />
									<?php } ?>
								</div>

								<div style="margin-top: -70px">
									<div style="margin-top: 10px">
										<span style="font-size: xx-small" >click here</span>
									</div>
								</div>

							</div>
						</label>

					<?php } ?>
				</div>

				<?php if ($vendor['requireReservation'] === '1' && !empty($_SESSION['visitorReservationId'])) { ?>
					<div><br/></div>
					<a href="<?php echo base_url(); ?>check424/<?php echo $vendor['vendorId']; ?>">Checkout</a>
				<?php } ?>
			<?php } else { ?>
				<p>No available service</p>
			<?php } ?>
			</div>
		</div>

<!--		<div class="col-half background-blue height-100">-->
<!--			<div class="align-start">-->
<!--				</div>-->
<!--					<div style="text-align:center;">-->
<!--						<img src="--><?php //echo base_url(); ?><!--assets/home/images/alfredmenu.png" alt="tiqs" width="auto" height="110" />-->
<!--					</div>-->
<!--					<h1 style="text-align:center">QR-MENU</h1>-->
<!--					<div style="text-align:center; margin-top: 30px">-->
<!--						<p style="font-size: larger; margin-top: 50px; margin-left: 0px">--><?//=$this->language->line("HOMESTART-SPOT-X001111ABC",'BUILD BY TIQS');?><!--</p>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div> end col half -->
	</div>
</div>
