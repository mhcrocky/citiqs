<!DOCTYPE html>
<html><head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>
</head>
<body>
<section class="section-2 background-purple-light" id='dhl-section'>
        <div class="col-half col-testimonial">
            <div class='col-testimonial-content'>
                <div class="testimonial-row">
                    <div class="single-testimonial">
                           <div id="testimonials-wrapper" class="text">
                            <div class="testimonial testimonial-one">
                                <div class="testimonial-section__text-wrapper">
                                    <p class="testimonial-section__text">THE WORLDWIDE LOST AND FOUND STANDARD.<br><br>ENDORSED BY DHL EXPRESS <br><br>PRIVACY AND SECURITY FIRST. SECURE, FAST RETURN OF YOUR LOST AND FOUND ITEM(S). <br><br> LOST BY YOU, RETURNED BY US.
                                    </p>
                                </div>
                            </div>

                            <div class="testimonial testimonial-two">
                                <div class="testimonial-section__text-wrapper">
                                    <p class="testimonial-section__text">THE WORLDWIDE LOST AND FOUND STANDARD.<br><br>PARTNER DHL EXPRESS <br><br>PRIVACY AND SECURITY FIRST. SECURE, FAST RETURN OF YOUR LOST AND FOUND ITEM(S). <br><br> LOST BY YOU, RETURNED BY US.
                                    </p>
                                </div>

                            </div>

                            <div class="testimonial testimonial-three">
                                <div class="testimonial-section__text-wrapper">
                                    <p class="testimonial-section__text mb-30">THE WORLDWIDE LOST AND FOUND STANDARD, FOR YOUR EVENT, CLUB, FESTIVAL, BAR AND/OR RESTAURANT. </p>
                                    <p class="text-content" >
                                    <br>PARTNER DHL EXPRESS, FROM MIAMI TO IBIZA, FROM AMSTERDAM TO BERLIN, WORLDWIDE COVERAGE, NOW AVAILABLE IN 165 COUNTRIES.
                                        <br><br>CREATE THE ULTIMATE POSITIVE CUSTOMER JOURNEY,
                                    </p>
                                    <p class="text-content-light" >

                                    <br>LOST BY YOUR CUSTOMER, RETURNED BY US.
                                    </p>
                                </div>
                            </div>

                            <div class="testimonial testimonial-four">
                                <div class="testimonial-section__text-wrapper">
                                    <p class="testimonial-section__text">DHL EXPRESS ON DEMAND THE DELIVERY.
                                        <br><br>SMART (FREE!) LAST-MILE SOLUTION WITH SEVERAL DELIVERY OPTIONS
                                        <br><br>YOU HAVE COMPLETE CONTROL ON DELIVERY
                                        <br><br> NOTIFICATION THROUGH SMS AND E-MAIL
                                    </p>
                                </div>

                            </div>

                            <div class="testimonial testimonial-five">
                                <div class="testimonial-section__text-wrapper">
                                    <p class="testimonial-section__text">WORLDWIDE LOST AND FOUND STANDARD.<br><br>PARTNER BY DHL EXPRESS <br><br>PRIVACY AND SECURITY FIRST. SECURE, FAST RETURN OF YOUR LOST AND FOUND ITEM(S). <br><br> LOST BY YOU, RETURNED BY US.
                                    </p>
                                </div>
                            </div>
                        </div>


                    </div><!-- single testimonial -->

					<div class="clearfix mb-35" >
					</div>

					<div class="mb-35">
						<a type="button" href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line("HABINFO-020",'REGISTER YOUR BUSINESS');?></a>
					</div>

					<div id="images" class="images">
						<div class="image active-image" id='image-1'></div>
						<div class="image" id='image-2'></div>
						<div class="image" id='image-3'></div>
<!--						<div class="image" id='image-4'></div>-->
<!--						<div class="image" id='image-5'></div>-->
					</div>

					<p class="text-content-light" style="font-size: 18px; padding-top: 10px" >
						<br>LOST BY YOUR CUSTOMER, RETURNED BY US.
					</p>
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
<?php $this->load->view("howitworksevents", ""); ?>
</body>

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

<script type="text/javascript">

    var transitionSpeed = 400;
    var sliderWidth = 520;
    var testimonialCount = 5;
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
        testimonials.style.width = sliderWidth * 5 + 'px';
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
    var left_fifth = (-4 * sliderWidth).toString() + 'px';

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
