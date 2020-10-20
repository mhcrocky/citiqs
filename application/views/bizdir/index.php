<style>

</style>
<main role="main" style="margin-bottom: 0px">
	<section class="jumbotron" style="background-color:#F3D0B5">
		<div class="container" style="background-color:#F3D0B5; text-align:left" >
			<h1 style="font-family: campton-bold; margin-top: 30px;color:#27253b">TIQS PLACES</h1>
			<p style="font-family: campton-light;color: #27253b; margin-bottom: 30px">One stop destination to find everything at your favorite place</p>
		</div>
	</section>

	<div class="album py-5" style="background-color: #F3D0B5">
		<div class="container" style="background-color: #F3D0B5">
			<div class="row" style="margin-bottom:20px">
				<h3 class="col-md-12" style="text-align:left">Your location</h3>

					<div class="form-group col-md-5 col-sm-12">
						<!-- <label for="cityId">City:&nbsp;</label> -->
						<input
							type="text"
							class="form-control"
							placeholder="Enter city"
							id="cityId"
							autofocus
						/>
					</div>
					<div class="form-group col-md-5 col-sm-12">
						<!-- <label for="addressId">Address:&nbsp;</label> -->
						<input
							type="text"
							class="form-control"
							placeholder="Enter address"
							id="addressId"
						/>
					</div>
					<div class="form-group col-md-2 col-sm-12">
						<input type="submit" class="btn btn-info" value="Submit" onclick="getLocation('cityId', 'addressId', 'places')">
					</div>
			</div>
			<div class="row" id="placesContainer">
			
				<?php foreach ($directories as $directory): ?>
					<div
						class="col-md-4 places"
						data-lat="<?php echo $directory['lat']; ?>"
						data-lng="<?php echo $directory['lng']; ?>"
						>
						<div class="card mb-4 shadow-sm">
							<!-- <img src="--><?php //echo $directory['image']; ?><!--" class="bd-placeholder-img card-img-top" -->
							<?php if (!$directory['placeImage']) { ?>
								<img
									src="<?php echo 'assets/home/images/bizdir.png' ?>"
									class="bd-placeholder-img card-img-top"
									height="180" alt="<?php echo $directory['business_name']; ?>"
								/>
							<?php } else { ?>
								<img
									src="<?php echo base_url() . 'assets/images/placeImages/' . $directory['placeImage']; ?>"
									class="bd-placeholder-img card-img-top"
									height="180" alt="<?php echo $directory['business_name']; ?>"
								/>
							<?php } ?>
							<div class="card-body text-center" style="background-color: #003151">
								<img src="<?php echo 'assets/home/images/tiqslogowhite.png' ?>" style="margin-left:190px; margin-top: -350px; height: 50px; width: auto"/>
								<p class="pb-2 font-weight-bold"
								   style="font-size: 24px;color: antiquewhite"><?php echo $directory['username']; ?></p>
								<p class="pb-2 font-weight-bold distance"
								   style="font-size: 24px;color: antiquewhite"></p>
								<span style="color: antiquewhite"><?php echo $directory['address']; ?></span>
								<div class="social-links align-items-center pt-3">
									<a class="contact-link" target="_blank"
									   <?php if ($directory['email']) { ?>href="<?php echo "https://tiqs.com/alfred/make_order?vendorid=".$directory['id']; ?>"<?php } ?> >
										<i class="fa fa-link fa-lg" style="color: antiquewhite"></i></a>
									<a class="contact-link"
									   <?php if ($directory['email']) { ?>href="mailto:<?php echo $directory['email']; ?>"<?php } ?>>
										<i class="fa fa-envelope fa-lg" style="color: antiquewhite"></i></a>
									<a class="contact-link"
									   <?php if ($directory['phone']) { ?>href="tel:<?php echo $directory['phone']; ?>"<?php } ?>>
										<i class="fa fa-phone fa-lg" style="color: antiquewhite"></i></a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</main>
