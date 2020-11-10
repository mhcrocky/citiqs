<?php 
		if (!empty($directories)): 
		foreach ($directories as $directory): ?>
					<div
						class="col-md-4 places fade"
						style="background-color: #fbd19a; "
						data-lat="<?php echo $directory['lat']; ?>"
						data-lng="<?php echo $directory['lng']; ?>"
						data-distance="<?php echo $directory['distance']; ?>"
						>
						<div class="card mb-4 shadow-sm" >
							<!-- <img src="--><?php //echo $directory['image']; ?><!--" class="bd-placeholder-img card-img-top" -->
							<?php if (!$directory['placeImage']) { ?>
								<img
									src="<?php echo 'assets/home/images/bizdir.png' ?>"
									class="bd-placeholder-img card-img-top"
									height="220px" width="100%" alt="<?php echo $directory['business_name']; ?>"
								/>
							<?php } else { ?>
								<img
									src="<?php echo base_url() . 'assets/images/placeImages/' . $directory['placeImage']; ?>"
									class="bd-placeholder-img card-img-top"
									height="220px" width="100%" alt="<?php echo $directory['business_name']; ?>"
								/>
							<?php } ?>
							<div class="card-body text-center" style="background-color: #0d173b">
								<img src="<?php echo 'assets/home/images/tiqslogowhite.png' ?>" style="margin-left:-50%; margin-top: -350px; height: 50px; width: auto"/>
								<p class="pb-2 font-weight-bold"
								   style="font-size: 24px;color: antiquewhite"><?php echo $directory['username']; ?></p>
								<p class="pb-2 font-weight-bold distance"
								   style="font-size: 24px;color: antiquewhite"><?php echo $directory['distance']." km"; ?></p>
								<span style="color: antiquewhite"><?php echo $directory['address']; ?></span>
								<div class="social-links align-items-center pt-3">
									<a class="contact-link" target="_blank; color: white; --text-color: white"
									   <?php if ($directory['email']) { ?>href="<?php echo "https://tiqs.com/alfred/make_order?vendorid=".$directory['id']; ?>"<?php } ?> >
										<button data-brackets-id="2918" type="submit" class="button button-orange"><?php echo $this->language->line("BIZDIR",'ORDER HERE');?></button>

								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				<?php endif; ?>
