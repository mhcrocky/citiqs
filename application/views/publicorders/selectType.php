<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/bigsquare.css">
<div class="main-wrapper-nh" style="text-align:center">
	<div class="col-half background-apricot-blue height">
		<div class="width-650"></div>
            <div class="form-group has-feedback">
                <img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="350" height="" />
            </div><!-- /.login-logo -->
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
							<input type="radio" name="radio" value="<?php echo 'make_order?vendorid=' . $vendor['vendorId'] . '&typeId=' . $type['typeId'] ?>" onchange="redirectTo(this.value)" class="form-control" checked />
							<div class="front-end box">
								<span><?php echo $type['type']; ?></span>
							</div>
						</label>

					<?php } ?>
				</div>


				<?php if ($vendor['requireReservation'] === '1' ) { ?>
					<div><br/></div>
					<a href="<?php echo base_url(); ?>check424/<?php echo $vendor['vendorId']; ?>">Checkout</a>
				<?php } ?>
			<?php } else { ?>
				<p>No available types</p>
			<?php } ?>
			</div>
		</div>
	</div>
	<div class="col-half background-blue height-100">
		<div class="flex-column align-start">
			</div>
				<div style="text-align:center;">
                    <img src="<?php echo base_url(); ?>assets/home/images/alfredmenu.png" alt="tiqs" width="auto" height="110" />
				</div>
				<h1 style="text-align:center">MENU</h1>
				<div style="text-align:center; margin-top: 30px">
					<p style="font-size: larger; margin-top: 50px; margin-left: 0px"><?=$this->language->line("HOMESTART-SPOT-X001111ABC",'BUILD BY TIQS');?></p>
				</div>
			</div>
		</div>
	</div><!-- end col half -->
</div>
