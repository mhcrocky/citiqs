<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html"><head>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/send-page.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/how-it-works.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/timeline-page.css">
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
	</style>

</head>
<body>


<section class="section-2 background-yellow-DHL" id='dhl-section'>
	<div class="col-half col-testimonial">
		<div class='col-testimonial-content'>
			<div class="mt-50" align="center" >
				<img border="0" src="<?php echo base_url(); ?>assets/home/images/DHL_express.png" alt="tiqs" width="250" height="auto" />
			</div>
			<div class="testimonial-row">
				<div class="single-testimonial">
					<div id="testimonials-wrapper" class="text">
						<div class="testimonial testimonial-layout-one">
							<div class="testimonial-section__text-wrapper">
								<p class="testimonial-section__text"><?php echo $this->language->line("SEND-AA000001","
									YOUR PERSONAL COURIER.

									HOW IT WORKS.

									1. MAKE A PICTURE OFF THE ITEM
									2. TELL US THE PICKUP PLACE (FROM)
									3. WHERE TO DELIVERY (TO)
									4. PAY THE SHIPMENT ONLINE
									")?>
								</p>

							</div>

						</div>

						<div class="testimonial testimonial-layout-two">
							<div class="testimonial-section__text-wrapper">
								<p class="testimonial-section__text"><?php echo $this->language->line("SEND-AA000001","
									YOUR PERSONAL COURIER.

									HOW IT WORKS.

									1. MAKE A PICTURE OFF THE ITEM
									2. TELL US THE PICKUP PLACE (FROM)
									3. WHERE TO DELIVERY (TO)
									4. PAY THE SHIPMENT ONLINE
									")?>
								</p>
							</div>
						</div>

						<div class="testimonial testimonial-layout-three">
							<div class="testimonial-section__text-wrapper ">
								<p class="testimonial-section__text"><?php echo $this->language->line("SEND-AA000001","
									YOUR PERSONAL COURIER.

									HOW IT WORKS.

									1. MAKE A PICTURE OFF THE ITEM
									2. TELL US THE PICKUP PLACE (FROM)
									3. WHERE TO DELIVERY (TO)
									4. PAY THE SHIPMENT ONLINE
									")?>
								</p>
							</div>
						</div>
					</div>
				</div><!-- single testimonial -->
				<p class="text-content-light mb-35 mt-50" >
					<?php echo $this->language->line("SEND-A000100","
					<br>SHIPMENT HAS NEVER BEEN SO SIMPLE, <br/>FROM YOU - WITH US - TO YOUR LOVED ONES.
					")?>
				</p>

				<div class="clearfix">
				</div>
				<!--                    <div class="clearfix">-->
				<!--                    </div>-->
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
</div>
</body>

<div class="main-wrapper-nh">
	<div class="col-half background-yankee height-100">
		<div class="flex-column align-start">
			<div style="text-align:left">
				<h2 class="heading mb-35"><?php echo $this->language->line("SEND-0395",'YOUR ADDRESS (FROM)');?></h2>
                <input type="text" id="sender_IsDropOffPoint"  value="<?php echo $sender_IsDropOffPoint; ?>" readonly requried hidden />
                <input type="text" id="sender_roleId"  value="2" readonly requried hidden />				
                <p style="font-family:'caption-light'; font-size:100%; color: #ffffff;  text-align: center">
					<?php echo $this->language->line("SEND-0390",'Your e-mail');?>
                </p>
                <div class="form-group has-feedback">
                    <input 
						type="email" 
						id="sender_email"
						requried 
						onblur="checkEmail(this, 'sender_')" 
						class="form-control" 
						style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->line("SEND-040",'Your e-mail');?>" />
                </div>
                <div>
                    <p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  text-align: center">
                        <?php echo $this->language->line("SEND-130",'Validate Your e-mail address');?>
                    </p>
                </div>
                <div class="form-group has-feedback">
                    <input 
						type = "email" 
						id = "sender_emailverify" 
						requried 
						class = "form-control" 
						style="font-family:'caption-light'; border-radius: 50px;"
						placeholder="<?php echo $this->language->line("SEND-140",'Repeat email for verification');?>"
						/>
                </div>
                <div class="form-group has-feedback">
                    <input type="tel" id="sender_mobile"  disabled  class="form-control" style="display: none; font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->line("SEND-160",'Your mobile number');?>" />
                </div>
				<div class="form-group has-feedback">
					<input id="sender_username" disabled type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-070",'Your full name');?>" />
				</div>
				<div class="form-group has-feedback">
					<input id="sender_address" disabled type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-080",'Your address');?>" />
				</div>
				<div class="form-group has-feedback">
					<input id="sender_addressa" disabled type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-090",'Extra address line');?>" />
				</div>
				<div class="form-group has-feedback">
					<input type="text" id="sender_zipcode" disabled class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-100",'Your zipcode');?>" />
				</div>
				<div class="form-group has-feedback">
					<input type="text" id="sender_city" disabled class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-110",'City');?>" />
				</div>
				<div class="form-group has-feedback">
					<select class="form-control selectBox" id="sender_country" disabled  style="display: none; font-family:'caption-light';  border-radius:50px; ">
						<?php include FCPATH . 'application/views/includes/countrySelectOptions.php'; ?>
					</select>
				</div>
				<div class="form-group has-feedback" style="padding: 10px">
					<img id="labelImg" class="img-responsive center-block" />                    
				</div>
                <div style="text-align:center" class="mb-35">
                    <input type="text" id="label_code" readonly requried hidden />
					<input type="text" id="label_image" readonly requried hidden/>
					<input type="text" id="label_imageResponseFullName" readonly requried hidden />
					<label for="labelImage" onclick="triger('labelImage')" class="button button-orange"><?php echo $this->language->line("SEND-AB1100001",'MAKE AN ITEM PICTURE')?></label>
					<input type="file" name="image" id="labelImage" style="display:none" />
                </div>
                <div class="form-group has-feedback" style="padding: 10px;">
                    <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
                        <?php echo $this->language->line("SEND-A1100001",'ITEM CATEGORY')?>
                    </p>
                    <select class="form-control" 
						id="label_categoryid"						
						style="font-family:'caption-light'; border-radius: 50px; " >
                        <option value="">Select</option>
                        <?php
							foreach ($categories as $row) {
								echo '<option value="' . $row->id . '">' . $row->description . '</option>';
							}
                        ?>
                    </select>
                </div>
                <div class="form-group has-feedback" style="padding: 10px;">
                    <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
						<?php echo $this->language->line("SEND-A1100002",'ITEM DESCRIPTION')?>
                    </p>
                    <input
						type="text" id="label_descript"
						class="form-control"  style="font-family:'caption-light'; border-radius: 50px; " maxlength="254"
					/>
                </div>
                <div>
                    <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
						<?php echo $this->language->line("SEND-A1100003",'ITEM WIDTH (IN CM)')?>
                    </p>
                </div>
                <div class="form-group has-feedback" style="padding: 10px;">
                    <input 
						type="number" 
						id="label_dclw"
						requried
						step="0.01" min="1" 						 
						class="form-control" style="font-family:'caption-light'; border-radius: 50px;"
						/>
                </div>
                <div>
                    <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
						<?php echo $this->language->line("SEND-A1100004",'ITEM LENGTH (IN CM)')?>
                    </p>
                </div>
                <div class="form-group has-feedback" style="padding: 10px;">
                    <input
						type="number" 
						id="label_dcll" 
						requried
						step="0.01" min="1" 						 
						class="form-control" style="font-family:'caption-light'; border-radius: 50px;"
						/>
                </div>
                <div>
                    <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
						<?php echo $this->language->line("SEND-A1100005",'ITEM HEIGHT (IN CM)')?>
                    </p>
                </div>
                <div class="form-group has-feedback" style="padding: 10px;">
                    <input 
						type="number" 
						id="label_dclh"
						requried
						step="0.01" min="1" 						 
						class="form-control" style="font-family:'caption-light'; border-radius: 50px;"
						/>
                </div>
                <div>
                    <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
						<?php echo $this->language->line("SEND-A1100006",'ITEM WEIGHT (IN KG)')?>
                    </p>
                </div>
                <div class="form-group has-feedback" style="padding: 10px;">
                    <input 
						type="number" 
						id="label_dclwgt" 
						requried 
						step="0.01" min="1" 						 
						class="form-control" style="font-family:'caption-light'; border-radius: 50px;"
						/>
                </div>
			</div>
		</div>
	</div><!-- end col half -->


    <div class="col-half background-yellow-DHL">
		<div class=" background-orange height-40">
			<div class="width-650">
				<h2 class="heading mb-35"><?php echo $this->language->line("SEND-4395",'DELIVERY ADDRESS (TO)');?></h2>
                <input type="text" id="recipient_IsDropOffPoint"  value="0" readonly requried hidden />
                <input type="text" id="recipient_roleId"  value="2" readonly requried hidden />
                <p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  text-align: center">
					<?php echo $this->language->line("SEND-4397",'Recipient email address');?>
                </p>
                <div class="form-group has-feedback">
                    <input 
						type="email"
						id="recipient_email"
						onblur="checkEmail(this, 'recipient_')"
						required
						class="form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="<?php echo $this->language->line("SEND-A11000010","RECIPIENT EMAIL ADDRESS")?>" />
                </div>
                <div>
                    <p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  text-align: center">
                        <?php echo $this->language->line("SEND-130",'Validate Your e-mail address');?>
                    </p>
                </div>
                <div class="form-group has-feedback" style="padding: 10px;">
                    <input
						type = "email"
						id = "recipient_emailverify"
						required
						class = "form-control"
						style="font-family:'caption-light'; border-radius: 50px; "
						placeholder="<?php echo $this->language->line("SEND-A1100011","VERIFY RECIPIENT EMAIL ADDRESS")?>"
						/>
                </div>
                <!-- <div>
                    <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
                        Phone or mobile number
                    </p>
                </div> -->
                <div class="form-group has-feedback">
                    <input type="tel" id="recipient_mobile"  disabled  class="form-control" style="display: none; font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->line("SEND-A1100012","RECIPIENT MOBILE NUMBER")?>"  />
                </div>
                <div class="form-group has-feedback">
                    <input id="recipient_username" disabled type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-A1100013","RECIPIENT FULL NAME")?>"  />
                </div>
                <div class="form-group has-feedback">
                    <input id="recipient_address" disabled type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-A1100014","RECIPIENT ADDRESS")?>"  />
                </div>
                <div class="form-group has-feedback">
                    <input id="recipient_addressa" disabled type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-A1100015",'EXTRA ADDRESS LINE');?>" />
                </div>
                <div class="form-group has-feedback">
                    <input type="text" id="recipient_zipcode" disabled class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-A1100016","RECIPIENT  ZIPCODE")?>""  />
                </div>
                <div class="form-group has-feedback">
                    <input type="text" id="recipient_city" disabled class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("SEND-A11000017","RECIPIENT CITY")?>""  />
                </div>
                <div class="form-group has-feedback">
                    <select class="form-control selectBox" id="recipient_country" disabled  style="display: none; font-family:'caption-light';  border-radius:50px; ">
                        <?php include FCPATH . 'application/views/includes/countrySelectOptions.php'; ?>
                    </select>
                </div>
                <div class="form-group has-feedback">
                    <input  type="button" onclick="checkEmailsAndSubmit('sender_email', 'sender_emailverify', 'recipient_email', 'recipient_emailverify')" class="button button-orange" value="<?php echo $this->language->line("SEND-A11000020","SEND THE ITEM")?>"  style="border: none" />
                </div>
			</div>
		</div>
		<div class="background-yellow-DHL height-60">
<!--			<span class='timeline-number text-orange hide-mobile'>1</span>-->
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-green show-mobile'>1</span>
					<h2 style="font-weight:bold; font-family: caption-bold"><?php echo $this->language->line("SEND-A1100030","SEND YOUR PACKAGE WITH TIQS")?> </h2>
				</div>
				<p class="text-content-light" style="font-size: larger"><?php echo $this->language->line("SEND-A1100035","LOST AND FOUND HAS A UNIQUE PACKAGE SENDING PROCESS INTEGRATED WITH DHL AND YOU CAN TAKE ADVANTAGE OF THAT!. SIMPLE SECURE AND FAST. LEARN HOW IN THE VIDEO BELOW.")?></p>
				<div class="flex-column align-space">
					<!--					<p class="text-content-light" style="font-weight: bold">LOST BY YOUR CUSTOMER, <br>RETURNED BY US.							</p>-->
					<div id="timeline-video-3">
						<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></div>
					</div><!-- time line video for third block -->
					<div align="center" class="mt-50">
						<!--                                href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->
						<a class="button button-orange mb-25" id="show-timeline-video-3"><?php echo $this->language->line("SEND-A1100040","LEARN MORE VIDEO")?></a>
					</div>
				</div>
			</div>
		</div>
    </div><!-- end col half -->



</div>

</html>

<script>

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
</script>

<script src="https://player.vimeo.com/api/player.js"></script>
<script type="text/javascript">
	function getVideoLink(e){
		frame.src = e.getAttribute('data-link');
		console.log('frame');
		frame.play();
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
		console.log('da');
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
		console.log('da');
		$('#timeline-video-2').toggleClass('show');
	})

	$('#show-timeline-video-3').click(function(){
		console.log('da');
		$('#timeline-video-3').toggleClass('show');
	})

	$('#show-timeline-video-4').click(function(){
		console.log('da');
		$('#timeline-video-4').toggleClass('show');
	})

</script>
