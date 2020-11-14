<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/send-page.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/sendbags-page.css">
		<style>
			.selectWrapper {
				border-radius: 50px;
				overflow: hidden;
				background: #eec5a7;
				border: 0px solid #ffffff;
				padding: 0px;
				margin: 0px;
			}

			.selectBox {
				background: #eec5a7;
				width: 100%;
				height: 35px;
				border: 0px;
				outline: none;
				padding: 0px;
				margin: 0px;
			}
			img {
				border: 0px;
			}
		</style>
	</head>
	<body>
		<div class="main-wrapper background-blue height-100">
			<div class="flex-column align-start width-650" style="margin-left: 30px; margin-right: 30px; min-height: 700px">
				<div style="text-align:left">
					
					<div class="contact-text-box">
						<h2 style="font-family:caption-bold"><?php strtoupper($this->language->line('BUSINESS-100035B-' . $subscription['description'], $subscription['description'])); ?></h2>
						<ul style="list-style-type: none; font-family:caption-bold; font-size: medium; margin-left: -40px" >
							<ul style="list-style-type: none; font-family:caption-bold; font-size: medium; margin-left: -40px" >
						<ul style="list-style-type: none; font-family:caption-bold; font-size: medium; margin-left: -40px" >
							<li>
								<?php
									$type = strtoupper(str_replace('_', ' ', $subscription['type']));
									echo $this->language->line('BUSINESS-100033E1-' . $type  , $type . ' = ' . $subscription['amount'] . ' EURO');
								?>
							</li>
						</ul>
					</div>	
					<div class="form-group has-feedback">
						<input  type="button" onclick="sendInvoice()"  class="button button-orange" value="<?php echo $this->language->line("SENDINVOCIE-A1111000020","SEND INVOICE")?>"  style="border: none" />
					</div>
				</div>
			</div>
			<div class="col-half col-slider background-blue"  style="min-height:400px">
				<div class="image-contact-0 height-100"></div>
			</div>
		</div>



		<section class="section-2 background-yellow-DHL" id='dhl-section'>
			<div class="col-half col-testimonial">
				<div class='col-testimonial-content'>
					<div class="mt-50" style ="text-align:center" >
						<img src="<?php echo base_url(); ?>assets/home/images/DHL_express.png" alt="tiqs" width="250" height="auto" />
					</div>
					<div class="testimonial-row">
						<div class="single-testimonial">
							<div id="testimonials-wrapper" class="text">
								<div class="testimonial testimonial-layout-one">
									<div class="testimonial-section__text-wrapper">
										<p class="testimonial-section__text">
											<?php
												$this->language->line(
													"SEND-AA000001",
													"DHL BRINGS IT TO YOU.....

													EXPERIENCE YOURSELF THE LOST AND FOUND PROCESS...

													1. MAKE A PICTURE OFF THE ITEM
													2. TELL US THE PICKUP PLACE (FROM)
													3. WHERE TO DELIVERY (TO)
													4. PAY THE SHIPMENT ONLINE"
												);
											?>
										</p>
									</div>
								</div>
								<div class="testimonial testimonial-layout-two">
									<div class="testimonial-section__text-wrapper">
										<p class="testimonial-section__text">
										<?php
											$this->language->line(
												"SEND-AA000001",
												"YOUR PERSONAL COURIER.

												HOW IT WORKS.

												1. MAKE A PICTURE OFF THE ITEM
												2. TELL US THE PICKUP PLACE (FROM)
												3. WHERE TO DELIVERY (TO)
												4. PAY THE SHIPMENT ONLINE"
											);
										?>
										</p>
									</div>
								</div>
								<div class="testimonial testimonial-layout-three">
									<div class="testimonial-section__text-wrapper ">
										<p class="testimonial-section__text">
											<?php
												$this->language->line(
													"SEND-AA000001",
													"YOUR PERSONAL COURIER.

													HOW IT WORKS.

													1. MAKE A PICTURE OFF THE ITEM
													2. TELL US THE PICKUP PLACE (FROM)
													3. WHERE TO DELIVERY (TO)
													4. PAY THE SHIPMENT ONLINE"
												)
											?>
										</p>
									</div>
								</div>
							</div>
						</div><!-- single testimonial -->
						<p class="text-content-light mb-35 mt-50" >
							<?php echo $this->language->line("SEND-A000100","<br>LOST BY YOUR CUSTOMERS, <br/>RETRUNED BY US.")?>
						</p>
						<div class="clearfix">
						</div>
						<div id="images" class="images" style="padding:20px" >
							<div class="image active-image" id='image-1'></div>
							<div class="image" id='image-2'></div>
							<div class="image" id='image-3'></div>
							<div class="image" id='image-4'></div>
							<!--                        <div class="image" id='image-5'></div>-->
						</div>
					</div><!-- end testimonial slider -->
				</div>
			</div> <!--end col slider -->

			<div class="col-half col-slider mobile-hide">
				<div class="slideshow-container">

					<!-- Full-width images with number and caption text -->
					<div class="mySlides fade mySlides-1">
						<img src="" style="width:100%">
					</div>

					<div class="mySlides fade mySlides-2">
						<img src="" style="width:100%">
					</div>

					<div class="mySlides fade mySlides-3">
						<img src="" style="width:100%">
					</div>

					<div class="mySlides fade mySlides-4">
						<img src="" style="width:100%">
					</div>
					<!-- Next and previous buttons -->
					<!-- <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
					<a class="next" onclick="plusSlides(1)">&#10095;</a>-->
				</div>
				<br>
				<!-- The dots/circles -->
				<div style="text-align:center">
					<span class="dot" onclick="currentSlide(1)"></span>
					<span class="dot" onclick="currentSlide(2)"></span>
					<span class="dot" onclick="currentSlide(3)"></span>
				</div>
			</div><!-- end image slider -->
		</section>
		<script src="https://player.vimeo.com/api/player.js"></script>
		<script>

			function sendInvoice() {
				let url = globalVariables.ajax + 'sendInvoice/';
				let callBack = 'sendInvoice';
				sendAjaxPostRequest(invoiceGlobals, url, callBack);
			}
			function payInvoice() {
				console.dir(invoiceGlobals);
			}

			function getVideoLink(e){
				frame.src = e.getAttribute('data-link');
				console.log('frame');
				frame.play();
			}

			var invoiceGlobals = (function(){
				let globals = {
					'backOffice': {
						"lostandfound_user_id" : '<?php echo $user_id; ?>',
						"items" : ['<?php echo $subscription['backOfficeItemId']; ?>']
					},
					'subscription': {
						'userid' :  '<?php echo $user_id; ?>',
						'subscriptionid' : '<?php echo $subscription['id']; ?>'
					},
					'type': '<?php echo $type; ?>'
				}
				Object.freeze(globals);
				return globals;
			}());

			console.dir(invoiceGlobals);

			var acc = document.getElementsByClassName("accordion");
			var i;

			for (i = 0; i < acc.length; i++) {
				acc[i].addEventListener("click", function() {
					this.classList.toggle("active");
					var panel = this.nextElementSibling;
					if (panel.style.maxHeight) {
						panel.style.maxHeight = null;
						panel.style.border = 'none';
					} else {
						panel.style.maxHeight = panel.scrollHeight + "px";
						/* panel.style.border = '1px solid #ffffff4a';
						panel.style.borderTop = 'none';
						panel.borderTopLeftRadius = 0 + 'px';
						panel.borderTopRightRadius = 0 + 'px';*/
					}
				});
			}





			// video player script

			/* getting iframe, setting size and links */
			var frame = document.getElementById('frame');
			if (frame) {
				var frame_heigth = frame.offsetHeight;
				document.getElementsByClassName('thumbnail-video')[0].style.maxHeight = frame_heigth + 'px';
				document.getElementsByClassName('section-video')[0].style.maxHeight = frame_heigth + 'px';
				var video_links = document.getElementsByClassName('video-link');
				const buttons = document.getElementsByClassName("video-link")
				for (const button of buttons) {
					button.addEventListener('click',function(e){
							frame.src = this.getAttribute('data-link');
							document.getElementById('frame video')
						}
					)
				}
			}
			$('#show-timeline-video-2').click(function(){
				$('#timeline-video-2').toggleClass('show');
			})

			// modal script
			// Get the modal
			var modal = document.getElementById("myModal");

			// Get the button that opens the modal
			var btn = document.getElementById("modal-button");
			if (btn) {
				// When the user clicks on the button, open the modal
				btn.onclick = function() {
					modal.style.display = "block";
				}
			}
			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
			if (span) {
				// When the user clicks on <span> (x), close the modal
				span.onclick = function() {
					modal.style.display = "none";
				}
			}

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = "none";
				}
			}

			var acc = document.getElementsByClassName("accordion");
			var i;

			for (i = 0; i < acc.length; i++) {
				acc[i].addEventListener("click", function() {
					this.classList.toggle("active");
					var panel = this.nextElementSibling;
					if (panel.style.maxHeight) {
						panel.style.maxHeight = null;
						panel.style.border = 'none';
					} else {
						panel.style.maxHeight = panel.scrollHeight + "px";
						/* panel.style.border = '1px solid #ffffff4a';
						panel.style.borderTop = 'none';
						panel.borderTopLeftRadius = 0 + 'px';
						panel.borderTopRightRadius = 0 + 'px';*/
					}
				});
			}

			$('#show-timeline-video-2').click(function(){
				$('#timeline-video-2').toggleClass('show');
			})

			$('#show-timeline-video-3').click(function(){
				$('#timeline-video-3').toggleClass('show');
			})

			$('#show-timeline-video-4').click(function(){
				$('#timeline-video-4').toggleClass('show');
			})

		</script>
	<body>
</html>
