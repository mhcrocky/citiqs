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

</style>

<div class="main-wrapper">
	<div class="col-half background-blue" id="info424">
		<div class="background-blue height-50">
			<div class="width-650"></div>
			<div align="center">
				<p class="text-content mb-50"><?php echo date("d.m.yy", strtotime($eventdate)) ?></p>
			</div>
			<div class="text-center mb-50" style="text-align:center">
				<img src="<?php echo $this->baseUrl; ?>assets/home/images/twoontable.png" alt="tiqs" width="150" height="auto" />
			</div>

			<?php
			if($spot2!="soldout"){ ?>

					<div align="center">
						<p class="text-content mb-50">MAAK EEN RESERVERING VOOR EEN 2 PERSOONS TAFEL</p>
					</div>
					<div align="center">
						<p class="text-content mb-50">BETAAL € 10,00 TEGOED</p>
					</div>
					<div class="form-group has-feedback mt-35" >
						<div style="text-align: center; ">
							<a href="<?php echo $this->baseUrl; ?>thuishaventime/2" class="button button-orange mb-25">KIES EEN TIJD</a>
						</div>
					</div>


			<?php } else { ?>

			<div align="center">
				<p class="text-content mb-50">DEZE RESERVERINGEN ZIJN UITVERKOCHT</p>
			</div>

			<?php }

			?>


			<div class="form-group has-feedback mt-35" >
				<div style="text-align: right">
					<a href="#top" ><i class="fa fa-arrow-circle-up" style="font-size:48px; color:white"></i></a>
				</div>
			</div>

		</div>
		<div class="background-blue-light height-50">
			<div class="width-650"></div>
			<div align="center">
				<p class="text-content mb-50"><?php echo date("d.m.yy", strtotime($eventdate)) ?></p>
			</div>

			<div class="text-center mb-50" style="text-align:center">
				<img src="<?php echo $this->baseUrl; ?>assets/home/images/fourontable.png" alt="tiqs" width="150" height="auto" />
			</div>

			<?php
			if($spot4!="soldout"){ ?>

				<div align="center">
					<p class="text-content mb-50">MAAK EEN RESERVERING VOOR EEN 4 PERSOONS TAFEL</p>
				</div>
				<div align="center">
					<p class="text-content mb-50">BETAAL € 20,00 TEGOED</p>
				</div>
				<div class="form-group has-feedback mt-35" >
					<div style="text-align: center; ">
						<a href="<?php echo $this->baseUrl; ?>thuishaventime/4" class="button button-orange mb-25">KIES EEN TIJD</a>
					</div>
				</div>

			<?php } else { ?>

				<div align="center">
					<p class="text-content mb-50">DEZE RESERVERINGEN ZIJN UITVERKOCHT</p>
				</div>

			<?php }

			?>

			<div class="form-group has-feedback mt-35" >
				<div style="text-align: right">
					<a href="#top" ><i class="fa fa-arrow-circle-up" style="font-size:48px; color:white"></i></a>
				</div>
			</div>

		</div>
	</div>

	<div class="col-half background-yellow" id="info424">
		<div class="background-orange-light height-50">

			<div class="width-650"></div>
			<div align="center">
				<p class="text-content mb-50"><?php echo date("d.m.yy", strtotime($eventdate)) ?></p>
			</div>
			<div class="text-center mb-50" style="text-align:center">
				<img src="<?php echo $this->baseUrl; ?>assets/home/images/terracereservation.png" alt="tiqs" width="150" height="auto" />
			</div>
				<?php
				if($spot3!="soldout"){ ?>

					<div align="center">
						<p class="text-content mb-50">MAAK EEN RESERVERING VOOR HET PRIVÉ DAKTERRAS MAX 15 PERSONEN</p>
					</div>
					<div align="center">
						<p class="text-content mb-50">BETAAL €150,00 HUUR</p>
					</div>
					<div class="form-group has-feedback mt-35" >
						<div style="text-align: center; ">
							<a href="<?php echo $this->baseUrl; ?>thuishaventime/3" class="button button-orange mb-25">KIES EEN TIJD</a>
						</div>
					</div>

				<?php } else { ?>

					<div align="center">
						<p class="text-content mb-50">DEZE RESERVERINGEN ZIJN UITVERKOCHT</p>
					</div>

				<?php }

				?>
			<div class="form-group has-feedback mt-35" >
				<div style="text-align: right">
					<a href="#top" ><i class="fa fa-arrow-circle-up" style="font-size:48px; color:white"></i></a>
				</div>
			</div>
		</div>
</div>
	</div>
</body>

