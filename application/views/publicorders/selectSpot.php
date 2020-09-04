<div class="main-wrapper-nh" style="text-align:center">
	<div class="col-half background-apricot-blue height">
		<div class="width-650"></div>
				<div class="form-group has-feedback">
					<img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="350" height="" />
				</div><!-- /.login-logo -->
		<h1 style="text-align:center"><?php echo $vendor['vendorName'] ?></h1>
		<div class="selectWrapper mb-35">
			<?php if (!empty($spots)) { ?>
				<div id="selectSpots">
					<label for="spot">Service Point Or Table:</label>
					<select class="selectBox selectSpot" id="spot" onchange="redirectTo(this.value)" class="form-control" style="color :black">
						<option value="">Select spot</option>
						<?php
							$noSpots = true;
							foreach ($spots as $spot) {
								// CHECK SPOT'S AND CURRENT TIME FOR LOCAL TYPE
								if (intval($spot['spotTypeId']) === $local) {
									$spotTimes = $spot['spotTimes'];
									$dayPosition = strpos($spotTimes, date('D'));

									if (is_null($spotTimes) || is_bool($dayPosition)) continue;

									$workingDay = substr($spotTimes, $dayPosition);
									$workingDay = explode(',', $workingDay);
									$workingDay = explode('|', $workingDay[0]);
									$timeNow = date('H:i:s');									
									if ($timeNow < $workingDay[1] || $timeNow > $workingDay[2]) continue;
								}

								$noSpots = false;
							?>
								<option value="<?php echo 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spot['spotId'] ?>">
									<?php echo $spot['spotName']; ?>
								</option>
							<?php
								
							}
						?>
					</select>
					<?php if ($vendor['requireReservation'] === '1' ) { ?>
						<div><br/></div>
						<a href="<?php echo base_url(); ?>check424/<?php echo $vendor['vendorId']; ?>">Checkout</a>
					<?php } ?>
				</div>
			<?php } else { ?>
				<p>No available spots</p>
			<?php } ?>
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
<?php if (!empty($noSpots)) { ?>
	<script>
		$('#selectSpots').html('<p>No available spots</p>');
	</script>
<?php } ?>