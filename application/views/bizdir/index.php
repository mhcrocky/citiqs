<style>

</style>
<main role="main" style="margin-bottom: 0px">
	<section class="jumbotron" style="background-color:#F3D0B5">
		<div class="container" style="background-color:#F3D0B5 " align="left" >
			<h1 style="font-family: campton-bold; margin-top: 30px;color:#27253b">TIQS PLACES</h1>
			<p style="font-family: campton-light;color: #27253b; margin-bottom: 30px">One stop destination to find everything at your favorite place</p>
		</div>
	</section>

	<div class="album py-5" style="background-color: #F3D0B5">
		<div class="container" style="background-color: #F3D0B5">
			<div class="row">
				<?php foreach ($directories as $directory): ?>
					<div class="col-md-4">
						<div class="card mb-4 shadow-sm">
<!--							<img src="--><?php //echo $directory['image']; ?><!--" class="bd-placeholder-img card-img-top"-->
							<img src="<?php echo 'assets/home/images/bizdir.png' ?>" class="bd-placeholder-img card-img-top"
								 height="180" alt="<?php echo $directory['business_name']; ?>"/>

							<div class="card-body text-center" style="background-color: #003151">
								<img src="<?php echo 'assets/home/images/tiqslogowhite.png' ?>" style="margin-left:190px; margin-top: -350px; height: 50px; width: auto"/>
								<p class="pb-2 font-weight-bold"
								   style="font-size: 24px;color: antiquewhite"><?php echo $directory['username']; ?></p>
								<span style="color: antiquewhite"><?php echo $directory['address']; ?></span>
								<div class="social-links align-items-center pt-3">
									<a class="contact-link" target="_blank"
									   <?php if ($directory['email']) { ?>href="<?php echo $directory['website']; ?>"<?php } ?> >
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
