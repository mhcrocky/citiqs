<!DOCTYPE html>
<html >
<body>

<style>

	.container {
		position: relative;
		width: 100%;
		max-width: 400px;
	}

	.container img {
		width: 100%;
		height: auto;
	}

	.container .btn {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		-ms-transform: translate(-50%, -50%);
		background-color: #555;
		color: white;
		font-size: 16px;
		padding: 12px 24px;
		border: none;
		cursor: pointer;
		border-radius: 5px;
		text-align: center;
	}

	.container .btn:hover {
		background-color: black;
	}

	.column-left {
		float: left;
		width: 33.333%;
	}

	.column-right {
		float: right;
		width: 33.333%;
	}

	.column-center {
		display: inline-block;
		width: 33.333%;
	}

	[type="radio"]:checked,
	[type="radio"]:not(:checked) {
		position: absolute;
		left: -9999px;
	}
	[type="radio"]:checked + label,
	[type="radio"]:not(:checked) + label
	{
		position: relative;
		padding-left: 28px;
		cursor: pointer;
		line-height: 20px;
		display: inline-block;
		color: #666;
	}
	[type="radio"]:checked + label:before,
	[type="radio"]:not(:checked) + label:before {
		content: '';
		position: absolute;
		left: 0;
		top: 0;
		width: 18px;
		height: 18px;
		border: 1px solid #ddd;
		border-radius: 100%;
		background: #fff;
	}
	[type="radio"]:checked + label:after,
	[type="radio"]:not(:checked) + label:after {
		content: '';
		width: 30px;
		height: 30px;
		background: #f8000c;
		position: absolute;
		top: -4px;
		left: -8px;
		border-radius: 100%;
		-webkit-transition: all 0.2s ease;
		transition: all 0.2s ease;
	}
	[type="radio"]:not(:checked) + label:after {
		opacity: 0;
		-webkit-transform: scale(0);
		transform: scale(0);
	}
	[type="radio"]:checked + label:after {
		opacity: 1;
		-webkit-transform: scale(1);
		transform: scale(1);
	}
</style>


<div class="main-wrapper">
		<div class="col-half background-blue" id="info424">
			<div class="background-blue height-50">
				<div class="width-650"></div>
				<div class="text-center mb-50" style="text-align:center">
					<img src="<?php echo $this->baseUrl; ?>assets/home/images/fourontable.png" alt="tiqs" width="150" height="auto" />
				</div>
				<div align="center">
					<p class="text-content mb-50">KIES JE TIJD</p>
				</div>
				<div class="login-box" align="center">
					<form id="checkItem" action="<?php echo $this->baseUrl; ?>thuishaventime/booking" method="post" enctype="multipart/form-data"  >

						<?php
						if($spot4t1!="soldout"){ ?>
							<p>
								<input type="radio" id="test1" name="radio-group" value="1" checked>
								<label style="font-family: caption-light; font-size: large; text-align: right" for="test1">Tijdslot 1
								</label>
							<div>
								12:00 - 14:15
							</div>
							</p>
						<?php }
						?>

						<?php
						if($spot4t2!="soldout"){ ?>
							<p>
								<input type="radio" id="test2" name="radio-group" value="2">
								<label style="font-family: caption-light; font-size: large; text-align: right" for="test2">Tijdslot 2
								</label>
							<div>
								14:30 - 16:45
							</div>
							</p>
						<?php }
						?>

						<?php
						if($spot4t3!="soldout"){ ?>
							<p>
								<input type="radio" id="test3" name="radio-group" value="3">
								<label style="font-family: caption-light; font-size: large; text-align: right" for="test3">Tijdslot 3

								</label>
							<div>
								17:00 - 19:15
							</div>
							</p>

						<?php }
						?>

						<?php
						if($spot4t4!="soldout"){ ?>
							<p>
								<input type="radio" id="test4" name="radio-group" value="4">
								<label style="font-family: caption-light; font-size: large; text-align: right"  for="test4">Tijdslot 4

								</label>
							<div>
								19:30 - 21:45
							</div>
							</p>

						<?php }
						?>

						<?php
						if($spot4t5!="soldout"){ ?>

							<p>
								<input type="radio" id="test5" name="radio-group" value="5">
								<label style="font-family: caption-light; font-size: large; text-align: right"  for="test5">Tijdslot 5


								</label>
							<div>
								22:00 - 00:15
							</div>

							</p>


						<?php }
						?>

						<?php

						if($spot4!="soldout"){ ?>
							<div class="form-group has-feedback mt-35" >
								<div style="text-align: center; ">
									<button type="submit" class="button button-orange mb-25">VOLGENDE</button>
								</div>
							</div>
						<?php } else {
							redirect('thuishaven');
						} ?>

					</form>
				</div>
		</div>

	</div>
	<div class="col-half  background-orange timeline-content">

	</div>
</body>

