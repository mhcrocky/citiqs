<!DOCTYPE html>
<html><head>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/yellow-page.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/contact-page.css">
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
							<div class="testimonial testimonial-one">
								<div class="testimonial-section__text-wrapper">
									<p class="testimonial-section__text">THE <br>LOST AND FOUND<br> STANDARD. <br><br>EXCLUSIVE PARTNER DHL EXPRESS<br>
										TIQS LOST AND FOUND PARTNERS WITH THE WORLD LEADING LOGISTICS COMPANY DHL EXPRESS.
									</p>
								</div>
							</div>

						   <div class="testimonial testimonial-one">
							   <div class="testimonial-section__text-wrapper">
								   <p class="testimonial-section__text">EXCLUSIVE PARTNERSHIP WITH DHL EXPRESS <br>
									   TOGETHER WE TAKE PRIDE IN EXECUTING THE BEST GLOBAL COVERED LOST AND FOUND SERVICE FOR YOU.
								   </p>
							   </div>
						   </div>

						   <div class="testimonial testimonial-one ">
							   <div class="testimonial-section__text-wrapper ">
								   <p class="testimonial-section__text">
									   EXCELLENCE. SIMPLY DELIVERED.
								   </p>
							   </div>
						   </div>
                        </div>
                    </div><!-- single testimonial -->
					<div class="mt-5 mb-35" align="center" style="margin-top: 50px" >
						<img border="0" src="<?php echo base_url(); ?>assets/home/images/lostandfounditems.png" alt="tiqs" width="auto" height="40" />
					</div>
					<p class="text-content-light mb-35 mt-50" >
						<br>LOST BY YOU OR YOUR CUSTOMER, <br/>RETURNED BY US.
					</p>

					<div class="mb-35">
						<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('HOME-E012','GET YOUR BUSINESS ACCOUNT ');?></a>
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

<div class="main-wrapper background-yellow-DHL main-wrapper-contact" align="center">
	<div class="col-half col-slider hide-mobile background-yellow-DHL" style="min-height:700px">
		<div class="image-contact-green"></div>
	</div>
	<!-- image contact -->
	<div class="col-half background-yellow-DHL height-100 contact-text">
		<div class="flex-column align-start width-650">
			<div align="left">
				<div class="contact-text-box">

					<p style="color: green">WE ARE GREEN</p>

					<p style="font-size: medium">
						THE WORLDWIDE LOST AND FOUND STANDARD.
						PARTNER DHL EXPRESS.
						DHL EXPRESS COMPLIANT WITH ISO 9001, ISO 14001 AND ISO 50001
					</p>
					<p style="font-size: medium">
						IN ALL OUR PRODUCTS WE TAKE CARE OF THE ENVIRONMENT BY SELECTING ECO FRIENDLY SUPPLIERS AND USING ECO FRIENDLY MATERIALS.
					</p>
				</div>
				<p class="text-content-light mb-35" style="font-family: caption-light; font-size: small">
					<br>LOST BY YOU, RETURNED BY US.
				</p>
				<div class="mb-35" align="center" >
					<img border="0" src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="auto" height="70" />
				</div>
			</div>
		</div>
	</div><!-- end col half-->
</div>

<?php $this->load->view("howitworksdhl", ""); ?>
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
