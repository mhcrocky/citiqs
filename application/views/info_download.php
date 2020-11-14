<!DOCTYPE html>

<html><head>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/tags-page.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/download-page.css">

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
<div class="main-wrapper" align="center">
	<div class="col-half background-blue height-100">
		<div class="flex-column align-start width-650">
			<div align="center">
				<form action="info_download/actiondownloadpdf" method="post" id="downloadForm" role="form">
					<h2 class="heading mb-35"><?php echo $this->language->line("DOWNLOADPDF-10000","DOWNLOAD YOUR DOCUMENT");?></h2>
					<div class="flex-row align-space">
						<div class="flex-column align-space width-650" style="font-family: caption-light">
							<div class="mb-35" style="font-family: caption-light">
								<p for="name">
									<?php echo $this->language->line("DOWNLOADPDF-10001","
									Name
									");?>
								</p>
								<div>
									<input type="text" class="form-control" id="name" name="name" style="border-radius: 50px; font-family: caption-light" placeholder="<?php echo $this->language->line("DOWNLOADPDF-10001","
									Name
									");?>" maxlength="128">
									<input type="hidden" value="1" name="nameId" id="nameId">
								</div>
							</div>
							<div class="form-group has-feedback">
								<p for="phone">
									<?php echo $this->language->line("DOWNLOADPDF-10002","
									Phone
									");?>
									</p>
								<div class="form-group has-feedback">
									<input type="number" class="form-control" id="phone" style="border-radius: 50px; font-family: caption-light"  name="phone" placeholder="<?php echo $this->language->line("DOWNLOADPDF-10002","Phone
									");?>" maxlength="128">
									<input type="hidden" value="1" name="" id="">
								</div>
							</div>
							<div class="form-group has-feedback">
								<p for="phone">
									<?php echo $this->language->line("DOWNLOADPDF-10003","
									E-mail Address
									");?>
								</p>
								<div class="form-group has-feedback">
									<input type="email" class="form-control" id="email" style="border-radius: 50px; font-family: caption-light"  name="email" placeholder="<?php echo $this->language->line("DOWNLOADPDF-10003","
									E-mail Address
									");?>" maxlength="128">
									<input type="hidden" value="" name="" id="">
								</div>
							</div>

							<div class="form-group has-feedback submit-form">
								<div>
									<input type="submit" class="button button-orange" value="<?php echo $this->language->line("DOWNLOADPDF-10004","SEND" );?>" style="border: none" class='button-submit'>
								</div>
							</div>
						</div>
					</div>
				</form>
				<!-- end form -->
			</div>
		</div>
	</div><!-- end col half-->

	<div class="col-half col-slider background-blue height-100">
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
