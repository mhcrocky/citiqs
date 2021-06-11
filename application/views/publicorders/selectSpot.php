<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<main class="main-wrapper-nh" style="text-align:center;">
	<div id="selectSpotContainer" class="col-half background-apricot-blue height designBackgroundImage">
		<div class="width-650" style="padding-top:0px"></div>
		<?php if (!empty($_SESSION['iframe'])) { ?>
		<div
			class="form-group has-feedback"
			style="padding: 0px"
		>
			<img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="250" height="" />
		</div><!-- /.login-logo -->
		<?php } ?>
		<h1 id="selectSpotH1" style="text-align:center; text-transform: uppercase; margin: 0px 7px; border-bottom: 4px solid;"><?php echo $vendor['vendorName'] ?></h1>
		<div class="d-flex align-items-center" style="padding: 10px 15px">
			<p style="font-family: Arial; text-align:left; margin-top: 10px; margin-bottom: 5px ">
				<?php echo $this->language->tLine('Insert your table or area number');?>
			</p>
			<div class="input-group" style="margin-bottom: -5px; margin-left: -3px  ">

				<input
					style="height: 45px"
					oninput="searchTable()"
					type="text"
					id="search"
					class="form-control"
					aria-label="Search"
					placeholder="<?php echo $this->language->tLine('Search');?>"
				/>
				<span onclick="searchTable()" style="background: #fff !important;height: 45px;cursor: pointer" class="input-group-addon"><i class="fa fa-search"></i></span>
			</div>
			<div style="margin-top: 10px; margin-top: 30px; margin-bottom: -10px">
				<h4 style="font-family: Arial; font-size: 16px;text-align:left; text-transform: uppercase; ">
					<?php echo $this->language->tLine('OR');?>
				</h4>
			</div>
		</div>
		<p style="font-family: Arial; text-align:left; padding: 0px 15px; margin-top: 10px; margin-bottom: -15px ">
			<?php echo $this->language->tLine('Select your table or area number');?>
		</p>
		<div class="selectWrapper mb-35" style="padding-top:10px; font-family: Arial;">
			<?php if (!empty($spots)) { ?>
				<div id="selectSpots" style="margin-top:10px; text-align:left">
					<!--					<label id="labelColor" for="spot" style="font-family: Arial;text-align:left; ">Select your table or area number</label>-->
					<!-- <select class="selectBox selectSpot" id="spot" onchange="redirectTo(this.value)" class="form-control" style="color :black">
						<option value="">Select spot</option>
						<?php
							// $noSpots = true;
							// foreach ($spots as $spot) {
							// 	// CHECK SPOT'S AND CURRENT TIME FOR LOCAL TYPE
							// 	if (intval($spot['spotTypeId']) === $local) {
							// 		$spotTimes = $spot['spotTimes'];
							// 		$dayPosition = strpos($spotTimes, date('D'));

							// 		if (is_null($spotTimes) || is_bool($dayPosition)) continue;

							// 		$workingDay = substr($spotTimes, $dayPosition);
							// 		$workingDay = explode(',', $workingDay);
							// 		$workingDay = explode('|', $workingDay[0]);
							// 		$timeNow = date('H:i:s');
							// 		if ($timeNow < $workingDay[1] || $timeNow > $workingDay[2]) continue;
							// 	}

							// 	$noSpots = false;
							?>
								<option value="<?php #echo 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spot['spotId'] ?>">
									<?php #echo $spot['spotName']; ?>
								</option>
							<?php
							#}
						?>
					</select> -->

					<div class="custom__select; text-align:center">
						<form action="">
							<ul class='select__list bordersColor' id="productList">
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
										<li class='select__list__item bordersColor'>
											<label class="custom_style"
												data-redirect="<?php echo 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spot['spotId'] ?>"
												for="spotId_<?php echo $spot['spotId']; ?>"
											>
												<?php echo $spot['spotName']; ?>
												<input
													type="radio"
													name="Type"
													id="spotId_<?php echo $spot['spotId']; ?>"
													value="<?php echo $spot['spotName']; ?>"
												>
												<span class="checkmark"></span>
											</label>
										</li>
									<?php
									}
								?>
							</ul>
						</form>
						<?php if (empty($noSpots)) { ?>
							<button
								id="confirmButton"
								type='submit'
								class='submit-type'
								onclick="redirectToSpot('checked')"
								style="text-align:center;margin-top:30px;padding-left:0;padding-right:0"
							>
								<?php echo $this->language->tLine('CONFIRM');?>
							</button>
						<?php } ?>
					</div>
					<?php if (
							$vendor['requireReservation'] === '1'
							&& !empty($_SESSION['visitorReservationId'])
							&& intval($typeId) === $local
						) { ?>
						<div><br/></div>
						<a href="<?php echo base_url(); ?>check424/<?php echo $vendor['vendorId']; ?>">Checkout</a>
					<?php } ?>
				</div>
			<?php } else { ?>
				<p><?php echo $this->language->tLine('No available spots');?></p>
			<?php } ?>
		</div>
	</div>
	<div class="col-half background-blue height-100" id="rightSide">
		<div class="flex-column align-start">
			</div>
				<div style="text-align:center;">
						<img src="<?php echo base_url(); ?>assets/home/images/alfredmenu.png" alt="tiqs" width="auto" height="110" />
				</div>
				<h1 style="text-align:center"><?php echo $vendor['vendorName'] ?></h1>
				<div style="text-align:center; margin-top: 30px">
					<p style="font-size: larger; margin-top: 50px; margin-left: 0px"><?php echo $this->language->tLine('BUILD BY TIQS');?></p>
				</div>
			</div>
		</div>
	</div><!-- end col half -->
</main>
<?php if (!empty($noSpots)) { ?>
	<script>
		$('#selectSpots').html('<p>No available spots</p>');
	</script>
<?php } else { ?>
	<script>
		var selected_value;
		var selected__placeholder = $('#selected-value');
		var custom_dropdown_height;

		$('.select__list label').click(function(){
			$('.select__list label').removeClass('checked');
			$(this).addClass('checked');
		})
	</script>
<?php } ?>
<script>
(function(){
    $('html').height('100%');
    $('body').height('100%');
    $('.main-wrapper-nh').height('100%');
}());


function searchTable() {
	let value = $('#search').val();
	if(value == ''){
		$(':radio').closest('label').show();
		return ;
	}

	var radioButtons = $(':radio');
	radioButtons.each(function(index) {
		let str = $(this).val();
		str = str.toLowerCase();
		if(str.includes(value)){
			$(this).closest('label').show();
		} else {
			$(this).closest('label').hide();
			console.log('true');
		}

	});
}
</script>
