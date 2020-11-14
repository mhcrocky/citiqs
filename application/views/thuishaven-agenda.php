<!DOCTYPE html>
<body>

<style>

	.column-left {
		float: left;
		width: 30%;
	}

	.column-center {
		display: inline-block;
		width: 40%;
	}

	.column-right {
		display: inline-flex;
		width: 10%;
	}


</style>

<div class="main-wrapper">
	<div class="col-half background-blue height-100">
			<?php
			//TIQS TO DO DO BETTER

			if(!empty($agenda))
				{
				foreach ($agenda as $day)
					{
						$date = $day->ReservationDateTime;
						$unixTimestamp = strtotime($date);
						$dayOfWeek = date("N", $unixTimestamp);
						$dayOfWeekWords = date("l", $unixTimestamp);
					?>

					<div class="timeline-block background-<?php echo $day->Background?>" height-25 >

						<div style="font-size: large; color:white" align="center">

							<div class="column-left">

								<div align="center">
									<p>
										<img src="<?php echo $this->baseUrl; ?>assets/home/images/<?php echo $dayOfWeek?>.png" alt="tiqs" width="150" height="auto" />
									</p>
								</div>
							</div>

							<div class="column-center" align="left">
								<div>
									<p>
										<img src="<?php echo $this->baseUrl; ?>assets/home/images/thuishavenwhite.png" alt="tiqs" width="150" height="auto" />
									</p>
									</div>
								<div>
									<p style="text-align=left; font-family: caption-light;font-size: x-large" >
										<?php echo $day->ReservationDescription?>
									</p>
									<p>
										<?php echo $this->language->Line(date("l", strtotime($date)), date("l", strtotime($date)));?>
									</p>

								</div>
								<p style="font-family: caption-bold" >
									<?php echo date("d.m.yy", strtotime($day->ReservationDateTime)) ?>
								</p>
							</div>

							<div class="column-right">
								<div  align="right">
									<a href="<?php echo $this->baseUrl; ?>thuishavensales/<?php echo date("yymd", strtotime($day->ReservationDateTime)).'/'.$day->id ?>" target="_self" class="button button-<?php echo $day->Background?> mb-25" style="font-family: caption-light;font-size: small;margin-left: -10px">
										<?php echo $this->language->Line("BOOKING-001A","BOEK");?>
									</a>
								</div>
							</div>

						</div>

					</div>
					<?php } ?>
			<?php } ?>
		</div>
	<div class="col-half  background-yankee timeline-content">

	</div>
	</div>

</body>

</body>

