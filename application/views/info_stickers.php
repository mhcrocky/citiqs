<!DOCTYPE html>
<html><head>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/tags-page.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/sticker-page.css">

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
<section class="section-2 background-orange-light" id='dhl-section'>
        <div class="col-half col-testimonial">
            <div class='col-testimonial-content'>
				<div class="mt-50" align="center" >
					<img border="0" src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="250" height="auto" />
				</div>
				<div class="mb-35" align="center" style="margin-top: 10px" >
					<img border="0" src="<?php echo base_url(); ?>assets/home/images/lostandfounditems.png" alt="tiqs" width="auto" height="40" />
				</div>

                <div class="testimonial-row">
                    <div class="single-testimonial">
						   <div id="testimonials-wrapper" class="text">
							<div class="testimonial testimonial-one">
								<div class="testimonial-section__text-wrapper">
									<p class="testimonial-section__text">THE <br>LOST AND FOUND<br> STANDARD. <br><br>EXCLUSIVE PARTNER DHL EXPRESS
									</p>

								</div>

							</div>

						   <div class="testimonial testimonial-one">
							   <div class="testimonial-section__text-wrapper">
								   <p class="testimonial-section__text">EXCLUSIVE PARTNERSHIP WITH<br><br>DHL EXPRESS SERVING 165 COUNTRIES.
								   </p>
							   </div>
						   </div>

						   <div class="testimonial testimonial-one ">
							   <div class="testimonial-section__text-wrapper ">
								   <p class="testimonial-section__text ">
									   SECURE, FAST AND GREEN.
									   Excellence, simply Delivered.
								   </p>
							   </div>
						   </div>


                        </div>
                    </div><!-- single testimonial -->
					<p class="text-content-light mb-35 mt-50" >
						<br>LOST BY YOU OR YOUR CUSTOMER, <br/>RETURNED BY US.
					</p>

					<div class="mb-35">
						<a href="<?php echo base_url(); ?>ordertags" class="button button-orange"><?php echo $this->language->line('TAGS-A0010','ORDER YOUR PERSONAL TIQS-TAGS');?></a>
					</div>

					<div class="clearfix">
					</div>
<!--                    <div class="clearfix">-->
<!--                    </div>-->
		           <div id="images" class="images" style="padding:20px" >
                        <div class="image active-image" id='image-1'></div>
                        <div class="image" id='image-2'></div>
                        <div class="image" id='image-3'></div>
<!--                        <div class="image" id='image-4'></div>-->
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

    </section><!-- end section 2 -->


</div>

<div class="main-wrapper background-blue main-wrapper-contact" align="center">
	<div class="col-half col-slider background-yellow col-half-mobile"  style="min-height:700px">
		<div class="image-contact-1"></div>
	</div>
	<!-- image contact -->
	<div class="col-half background-yellow col-half-mobile height-100 contact-text">
		<div class="flex-column align-start width-650">
			<div align="left">
				<div class="contact-text-box">

					<p>SINDS 2019, ONE MILLION DISTRIBUTED</p>

					<p style="font-size: medium">
						THE WORLDWIDE LOST AND FOUND STANDARD.
						PARTNER DHL EXPRESS.
						DHL EXPRESS COMPLIANT WITH ISO 9001, ISO 14001 AND ISO 50001
					</p>
					<p style="font-size: medium">
						TIQS HAS SET THE STANDARD IN LOST AND FOUND SINCE 2019. WITH DHL EXPRESS AS EXCLUSIVE PARTNER WE ARE PROUD TO HAVE YOU AS OUR NEXT MEMBER.
					</p>
				</div>
				<p class="text-content-light mb-35" style="font-family: caption-light; font-size: small">
					<br>LOST BY YOU, RETURNED BY US.
				</p>
				<div class="mb-35" align="left">
					<a href="<?php echo base_url(); ?>legal" class="button button-orange"><?php echo $this->language->line('INFODHL-A0101','GDPR AND LEGAL STATEMENTS');?></a>
				</div>
				<div class="mb-35" align="center" >
					<img border="0" src="<?php echo base_url(); ?>assets/home/images/tiqslogogreen.png" alt="tiqs" width="auto" height="70" />
				</div>
			</div>
		</div>
	</div><!-- end col half-->
</div>

<div class="main-wrapper main-wrapper-contact" align="center">
	<div class="col-half background-orange height-100">
		<div class="flex-column align-start  width-650">
			<div align="center">
				<form action="" method="post" id="contactForm" role="form">
					<h2 class="heading mb-35">A QUESTION, PLEASE ASK!</h2>
					<div class="flex-row align-space">
						<div class="flex-column align-space" style="font-family: caption-light">
							<div class="form-group has-feedback" style="font-family: caption-light">
								<p for="name">Name</p>
								<div class="form-group has-feedback">
									<input type="text" class="form-control" id="name" name="name" style="" placeholder="Name" maxlength="128">
									<input type="hidden" value="1" name="nameId" id="nameId">
								</div>
							</div>
							<div class="form-group has-feedback">
								<p for="phone">Phone</p>
								<div class="form-group has-feedback">
									<input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" maxlength="128">
									<input type="hidden" value="1" name="" id="">
								</div>
							</div>
							<div class="form-group has-feedback">
								<p for="phone">E-mail Address</p>
								<div class="form-group has-feedback">
									<input type="email" class="form-control" id="email" name="email" placeholder="Email Address" maxlength="128">
									<input type="hidden" value="" name="" id="">
								</div>
							</div>
							<div class="form-group has-feedback">
								<p for="Language">Language</p>
								<div class="selectWrapper"  id="language">
									<select class="selectBox" id="languageselect" name="country" style="background-color:#eec5a7; font-family:'caption-light';" required />
									<option value="">
										<?php echo $this->language->line("CONTACT-A360","Select your language");?>
									</option>
										<option value="tenglish">English</option>
										<option value="german">German</option>
										<option value="dutch">Dutch</option>
										<option value="french">French</option>
										<option value="italian">Italian</option>
										<option value="spain">Spain</option>
									</select>
								</div>
							</div>
							<div class="form-group has-feedback">
								<p for="msg">Message:</p>
								<textarea id="msg" name="user_message" style="border: none; padding:10px; color: black; border-radius: 10px; width: 100%; height: 100px"></textarea>
							</div>
							<div class="form-group has-feedback submit-form">
								<div>
									<input type="submit" class="button button-orange" value="SEND" style="border: none" class='button-submit'>
								</div>
							</div>
						</div>
					</div>
					<!-- edn flex row -->
				</form>
				<!-- end form -->
			</div>
		</div>
	</div><!-- end col half-->
	<div class="col-half col-slider background-orange hide-mobile">
		<div class="image-contact-0"></div>
	</div>


	<!-- image contact -->
</div>
</body>

<script type="text/javascript">
    var transitionSpeed = 400;
    var sliderWidth = 520;
    var testimonialCount = 3;
    var testimonialImages = document.getElementById("images").children;
    var testimonials = document.getElementById("testimonials-wrapper");
    var testimonialsStyles = window.getComputedStyle(testimonials);
    var newleft;
    var testimonialBox = document.getElementsByClassName("testimonial-section__text");
    var singleTestimonial = document.getElementsByClassName("single-testimonial")[0];
    var testimonialHeight = 0;

    for(var i = 0; i < testimonialBox.length; i++){
        console.log('++++', testimonialHeight)
        if(testimonialHeight < testimonialBox[i].offsetHeight){
            testimonialHeight = testimonialBox[i].offsetHeight + 10;
        }
    }

    singleTestimonial.style.height = testimonialHeight + 10 + 'px';
    testimonials.style.height = testimonialHeight + 10 + 'px';
    console.log(testimonialHeight, 'ovo')

    if(window.innerWidth > 1024){

    }else{
        sliderWidth = document.getElementsByClassName("testimonial")[0].offsetWidth;
        console.log(sliderWidth, 'else',document.getElementsByClassName("testimonial")[0].offsetWidth)
        testimonials.style.width = sliderWidth * 3 + 'px';
        testimonials.style.left = (sliderWidth * (-2) + 'px');
    }

    function disableEnable ( elementId ) {
        var element = document.getElementById(elementId);
        element.disabled = true;
        setTimeout( function() {
            element.disabled = false;
        }, transitionSpeed );
    }

    function moveRight () {
        var left = parseInt(testimonialsStyles.getPropertyValue('left'));
        if ( left > - (testimonialCount - 1 ) * sliderWidth ) {
            newleft = left - sliderWidth + 'px';
            testimonials.style.left = newleft;
            disableEnable("right");
            for (var counter = 0; counter < (testimonialImages.length -1); counter += 1) {
                if (testimonialImages[counter].className.indexOf("active-image") !== -1) {
                    testimonialImages[counter].className = "image";
                    testimonialImages[counter].nextElementSibling.className += " active-image";
                    return;
                }
            }
        }
    }

    function moveLeft () {
        var left = parseInt(testimonialsStyles.getPropertyValue('left'));
        if ( left < 0 ) {
            newleft = left + sliderWidth + 'px';
            testimonials.style.left = newleft;
            disableEnable("left");
            for (var counter = 1; counter < testimonialImages.length ; counter += 1) {
                if (testimonialImages[counter].className.indexOf("active-image") !== -1) {
                    testimonialImages[counter].className = "image";
                    testimonialImages[counter].previousElementSibling.className += " active-image";
                    return;
                }
            }
        }
    }

    function showTestimonialByImage ( imagePixelValue) {
        var allImages = event.target.parentElement.children;
        for (var counter = 0; counter < allImages.length; counter += 1 ) {
            allImages[counter].className = "image";
        }
        event.target.className += " active-image";
        var testimonials = document.getElementById("testimonials-wrapper");
        testimonials.style.left = imagePixelValue;
        disableEnable("left");
        disableEnable("right");
        console.log('click')
    }

    var left_first = '0px';
    var left_second = (-1 * sliderWidth).toString() + 'px';
    var left_third = (-2 * sliderWidth).toString() + 'px';
    var left_fourth = (-3 * sliderWidth).toString() + 'px';

    document.getElementById('image-1').addEventListener('click', function(){
        showTestimonialByImage(left_first)
    });
    document.getElementById('image-2').addEventListener('click', function(){
        showTestimonialByImage(left_second)
    });
    document.getElementById('image-3').addEventListener('click', function(){
        showTestimonialByImage(left_third)
    });
    // document.getElementById('image-4').addEventListener('click', function(){
    //     showTestimonialByImage(left_fourth)
    // });
    // document.getElementById('image-5').addEventListener('click', function(){
    //     showTestimonialByImage(left_fifth)
    // });

    var slideIndex = 0;
    showSlides();

    function showSlides() {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}
        slides[slideIndex-1].style.display = "block";
        setTimeout(showSlides, 4000); // Change image every 2 seconds
    }


</script>


</html>
