<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/tags-page.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/business-spot-page.css">

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

		p.smalltext {
			font-family: caption-light;
			font-size: medium;
		}

		ul.smalltext {
			font-family: caption-light;
			font-size: medium;
		}



	</style>

</head>

<body>
<section id='why-section'>
	<div class="main-wrapper background-blue" align="center">
		<div class="col-half col-slider background-blue"  style="min-height:400px">
			<div class="image-contact-0 height-100"></div>
			<div style="text-align:center; margin-top: 30px">
				<img border="0" src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="auto" height="90" />
			</div>
		</div>
		<div class="mt-50 div-only-mobile" >
			<div class="contact-text-box align-center" style="margin-left: 100px">
				<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-SPOT-A0101','GET YOUR ACCOUNT');?></a>
			</div>

		</div>
		<div class="col-half background-blue col-half-mobile height-100 contact-text">
				<div align="left">
					<p ><?php echo $this->language->line("BUSINESS-SPOT-100001",'WHY TIQS-SPOT?');?></p>
					<div class="contact-text-box">
						<div class="mb-35 div-no-mobile" align="right" style="margin-top: -50px">
							<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-SPOT-A0101','GET YOUR ACCOUNT');?></a>
						</div>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-SPOT-100002",'1. ABOUT SPOT')?><br>
						</p>
						<p class="smalltext">
							<?php echo $this->language->line("BUSINESS-SPOT-100003a",' Our online reservation system is a feature-rich web solution which enables you to set
							it up as per your specific needs, manage time slots and availability online,
							handle clients data and requests, add staff to manage reservations, and more.');?>
						</p>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-SPOT-100004",'2. STANDARDIZED WORKFLOW');?>
						</p>
						<p class="smalltext">
							<?php echo $this->language->line("BUSINESS-SPOT-100005",'Upload an interactive restaurant & table map to your website.
							Add your terms & conditions that each customer has to accept before booking.
							Manage capacity and adjust booking availability accordingly.
							Print booking schedule & details to organize your work better.
							Add and edit your restaurant opening hours online.');?>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-SPOT-100006",'3. RESERVATION BOOKING AUTOMATION');?>
						</p>

						<p class="smalltext">
							<?php echo $this->language->line("BUSINESS-SPOT-100007",'Set up your own customized 24/7 open online reservation booking system. 
							Reduce phone calls
							and eliminate the risk of double bookings. You can choose your own booking rules and create an
							automated booking process by editing various admin options and settings.
						');?>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-SPOT-100003b",'4. LESS IMPACT ON THE INTERNAL PROCESS');?>
						</p>
						<p class="smalltext">
							<?php echo $this->language->line("BUSINESS-SPOT-100008",'Set maximum reservation length for a booking.
						Define and charge users a booking deposit fee, if applicable.
						Advise how many hours in advance bookings should be made.
						Customize the reservation form to match your business model.
						');?>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-SPOT-100009",'5. EASY ACCESS CHECK');?>
						</p>
						<p class="smalltext">
							<?php echo $this->language->line("BUSINESS-SPOT-100010",'Our platform relieves you from the logistic handling of the reservation via our integrated and automated scanning solution.');?>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-SPOT-100011",'6. HIGHER RESERVATION PERCENTAGE');?>
						</p>
						<p class="smalltext">
							<?php echo $this->language->line("BUSINESS-SPOT-100012",'Our end-to-end tailored and time saving solution increases the percentage of your reservations thanks to its efficiency.');?>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-SPOT-100013",'7. REVENUE MODEL');?>
						</p>
						<p class="smalltext">
							<?php echo $this->language->line("BUSINESS-SPOT-100014a","In addition to cost efficiency and time savings, Tiqs offers you more revenue with less resources. Tiqs transforms from a cost to a revenue model and creates an extra value proposition for your organisation.");?>
						</p>
						<p></p>
					</div>

				</div>
		</div><!-- end col half-->
	</div>
</section>

<section id='how-section'>
	<div class="main-wrapper main-wrapper-contact height-100" align="center">
		<div class="col-half background-apricot-blue col-half-mobile contact-text">
			<div class="width-650 mb-50" style="min-height:600px">
				<div align="left">
					<div class="contact-text-box mb-50">
						<p><?php echo $this->language->line("BUSINESS-SPOT-100015",'HOW?');?></p>
						<div class="mb-35 div-no-mobile" align="right" style="margin-top: -50px">
							<a href="<?php echo base_url(); ?>registerbusiness" style="background-color:#eb5d16; color: white" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-SPOT-A0101','GET YOUR ACCOUNT');?></a>
						</div>
						<p style="font-size: medium; font-weight: bold">
						<?php echo $this->language->line("BUSINESS-SPOT-100016A",'OUR SOLUTION IS MAKING THINGS SIMPLE!');?>
						</p>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-SPOT-100017",'A - GET YOUR COMPANY RESERVATION ONLINE');?>
						<p class="smalltext">
						<ul style="list-style-type:none; font-size: small; font-weight: lighter; margin-left: -40px">
							<li><?php echo $this->language->line("BUSINESS-SPOT-100018",'1. UPLOAD YOUR FLOORPLAN');?></>
							<li><?php echo $this->language->line("BUSINESS-SPOT-100019",'2. ASSIGN S.P.O.T. (Service Points Or Tables)');?>
							<li><?php echo $this->language->line("BUSINESS-SPOT-100020",'3. SET YOUR PREFERENCES');?></>
						</ul>
						<p style="font-size: medium; font-weight: bold">
						<?php echo $this->language->line("BUSINESS-SPOT-100014",'B - YOUR CUSTOMER');?>
						<p class="smalltext">
						<ul style="list-style-type:none; font-size: small; font-weight: lighter; margin-left: -40px">
							<li><?php echo $this->language->line("BUSINESS-SPOT-100021",'4. RESERVES A SPOT (SPACE ON FLOORPLAN) ON YOUR COMPANY PAGE');?></>
							<li><?php echo $this->language->line("BUSINESS-SPOT-100022",'5. COMMITS TO THE RESERVATION WITH A RESERVATION PAYMENT ONLINE');?></>
							<li><?php echo $this->language->line("BUSINESS-SPOT-100023",'6. AUTOMATICALLY GETS AN E-MAIL WITH THE RESERVATION AND QRCODE TO CHECK IN');?></>
						</ul>
						<p style="font-size: medium; font-weight: bold;">
							<?php echo $this->language->line("BUSINESS-SPOT-100024",'C - YOU');?>
						<p class="smalltext">
						<ul style="list-style-type:none; font-size: small; font-weight: lighter; margin-left: -40px">
							<li><?php echo $this->language->line("BUSINESS-SPOT-100025",'7. COLLECT THE RESREVATION FEE, MINIMAL SPENDING FEE DAILY');?></>
							<li><?php echo $this->language->line("BUSINESS-SPOT-100026",'8. FULL BACK-END OVERVIEW OF RESERVATIONS');?></>
							<li><?php echo $this->language->line("BUSINESS-SPOT-100027",'9. OFFLINE MANUAL RESERVATION HANDLING OPTION ');?></>
						</ul>
						</p>
					</div>
					<div style="text-align:center; margin-top: 30px">
						<img border="0" src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="auto" height="90" />
					</div>
				</div>
			</div>

		</div><!-- end col half-->
		<div class="col-half background-apricot-blue col-half-mobile div-no-mobile"  style="min-height:400px">
			<div class="image-contact-1"></div>
		</div>

	</div>
</section>

<section id='who-section'>
	<div class="main-wrapper-nh height-100"  align="center">
		<div class="col-half col-slider background-blue hide-mobile">
			<div class="image-contact-2"></div>

		</div>

		<div class="col-half background-blue col-half-mobile height-100 contact-text">
			<div class="flex-column align-start width-650" style="min-height: 700px">
				<div align="left">
					<div class="contact-text-box">
						<p><?php echo $this->language->line("BUSINESS-SPOT-100028",'FOR WHO?');?></p>
						<div class="contact-text-box mb-50">
							<div class="mb-35 div-no-mobile" align="right" style="margin-top: -50px">
								<a href="<?php echo base_url(); ?>registerbusiness" style="background-color:#eb5d16; color: white" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-SPOT-A0101','GET YOUR ACCOUNT');?></a>
							</div>
							<p class="smalltext">
								<?php echo $this->language->line("BUSINESS-SPOT-3100016A",'OUR SOLUTION IS MAKING THINGS SIMPLE!');?>
							</p>
							<p style="font-size: medium; font-weight: bold">
								<?php echo $this->language->line("BUSINESS-SPOT-3100017",'RESERVATIONS MANAGEMENT');?>
							<p class="smalltext">
							<ul class="smalltext" style="list-style-type:none; margin-left: -40px">
								<li><?php echo $this->language->line("BUSINESS-SPOT-3100018",'The reservation management system allows you to add, edit and delete bookings, manage client details and availability. 
								');?></>
								<li><?php echo $this->language->line("BUSINESS-SPOT-3100019",'Reservations schedule - See daily bookings per table and a timeline showing reserved hours.');?>
								<li><?php echo $this->language->line("BUSINESS-SPOT-3100020",'Check all bookings for a selected date using an intuitive drop-down calendar.');?></>
							</ul>
							<ul class="smalltext" style="list-style-type:none; margin-left: -40px">
								<li><?php echo $this->language->line("BUSINESS-SPOT-3100021",'Add reservations manually - Just click on the given hour and fill in the booking details.');?></>
								<li><?php echo $this->language->line("BUSINESS-SPOT-3100022",'Reservations list - See all bookings ordered by date. Check status and all booking details.');?></>
								<li><?php echo $this->language->line("BUSINESS-SPOT-3100023",'Client details - Review customers name and a detailed contact information.');?></>
							</ul>

							<ul class="smalltext" style="list-style-type:none;  margin-left: -40px">
								<li><?php echo $this->language->line("BUSINESS-SPOT-3100025",'Collect payments using various methods available with the reservation System. 
								Use one or all of the
								payment options: PayPal, Authorize.Net, wire transfers, CC processing, cash or see other alternatives, with PAY.NL.
								Set a default currency and deposit fee, if applicable.
								Enable/disable payments - Allow payments or take reservations only.
								Enable/disable cash payments depending on your booking terms.
								DIRECT ACCESS TO THE PAYMENTS AS AFFILIATE PAY.NL PROVIDER');?></>
							</ul>
							</p>
						</div>
						<div style="text-align:center; margin-top: 30px">
							<img border="0" src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="auto" height="90" />
						</div>
					</div>
				</div>
			</div><!-- end col half-->
		</div>
	</div>
</section>
</div>


	<div class="background-blue" style="height: 150px" >
		<div style="text-align:left; margin-left: 30px">
			<img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="auto" height="100" />
		</div>
		<div class="div-no-mobile" style="margin-top: -95px; margin-left: 280px">
			<h1 style="font-family:caption-bold; font-size: 60px; font-weight: bold" ><?php echo $this->language->line("BUSINESS-SPOT-pack1100031",'S.P.O.T.S.');?></h1>
		</div>
	</div>

<section id='packages-section'>
	<div class="main-wrapper main-wrapper-contact height-30" style="text-align:center">
		<div class="col-half background-orange-light col-half-mobile contact-text" style="margin-bottom: 0px">
			<div style="text-align:left">
				<div class="contact-text-box" style="margin-bottom: 0px">
					<h2 style="font-family:caption-bold"><?php echo $this->language->line("BUSINESS-SPOT-1100031",'ON THE FLY PACKAGE');?></h2>
					<p style=" font-size: medium; font-weight: bold">
						<ul style="list-style-type: disc ;  font-size: larger; margin-left: -20px ">
							<li>
								<?php strtoupper($this->language->line('BUSINESS-SPOT-100031-'.$subscriptions['Fly'][0]['description'], $subscriptions['Fly'][0]['description'])); ?>
							</li>
							<li><?php echo $this->language->line("BUSINESS-SPOT-1100032C","NO MONTHLY SUBSCRIPTION");?></li>

						</ul>
						<ul style="list-style-type: none; font-family:caption-bold; font-size: medium; margin-left: -40px" >
							<li><?php echo $this->language->line("BUSINESS-SPOT-1100032F","PRICE = 0 EURO + transaction cost");?></li>
						</ul>
					</p>
				</div>
			</div>
		</div>
		<div class="col-half background-orange col-half-mobile contact-text">
			<div style="text-align:left">
				<div class="contact-text-box">
					<h2 style="font-family:caption-bold"><?php echo $this->language->line("BUSINESS-SPOT-A100035",'BASIC SPOT PACKAGE');?></h2>
					<p style=" font-size: medium; font-weight: bold">
						<ul style="list-style-type: disc ;  font-size: larger; margin-left: -20px ">
							<li>
								<?php strtoupper($this->language->line('BUSINESS-SPOT-2100035B-' . $subscriptions['basic_spot_year'][0]['description'], $subscriptions['basic_spot_year'][0]['description'])); ?>
							</li>
							<li><?php echo $this->language->line("BUSINESS-SPOT-2100035C","ADVANCED RESERVATION MODULE");?></li>
							<li><?php echo $this->language->line("BUSINESS-SPOT-2100035D","RESERVATION MANAGEMENT, TABLE PLAN, STATISTICS,AUTOMATIC FEEDBACK,RESERVATIONS THROUGH DIFFERENT CHANNELS");?></li>
						</ul>
						</ul>						
					</ul>
						</ul>						
					</ul>
						</ul>						
						<ul style="list-style-type: none; font-family:caption-bold; font-size: medium; margin-left: -40px" >
							<li><?php echo $this->language->line("BUSINESS-SPOT-2{$subscriptions['basic_spot_year'][0]['amount']}", 'YEARLY SUBSCRIPTION = ' . $subscriptions['basic_spot_year'][0]['amount'] . ' EURO');?></li>
							<li><?php echo $this->language->line("BUSINESS-SPOT-2{$subscriptions['basic_spot_month'][0]['amount']}12", 'MONTHLY SUBSCRIPTION = ' . $subscriptions['basic_spot_month'][0]['amount'] . ' EURO');?></li>
						</ul>
					</p>
				</div>				
			</div>
		</div><!-- end col half-->

		<div class="col-half background-apricot col-half-mobile contact-text" style="margin-bottom: 0px">
			<div style="text-align:left">
				<div class="contact-text-box">
					<h2 style="font-family:caption-bold"><?php echo $this->language->line("BUSINESS-SPOT-100033",'STANDARD PACKAGE');?></h2>
					<p style=" font-size: medium; font-weight: bold">
						<ul style="list-style-type: disc ; margin-left: -20px ">
							<li>
								<?php strtoupper($this->language->line('BUSINESS-SPOT-3100035B1-' . $subscriptions['standard_spot_year'][0]['description'], $subscriptions['standard_spot_year'][0]['description'])); ?>
							</li>
							<li><?php echo $this->language->line("BUSINESS-SPOT-31100033C","YOUR STANDARD TIQS HOSPITALITY RESERVATION INCLUDING LOST AND FOUND");?></li>
							<li><?php echo $this->language->line("BUSINESS-SPOT-31100033D","PHONE RESERVATION SYSTEM PAYMENTS AND ADVANCES PROMOTIONS - ARRANGEMENTS GIFT CARDS ADDITIONAL RESERVATION QUESTIONS LINK WITH POS SYSTEMS");?></li>
						</ul>
					</p>
				</div>
			</div>
		</div>
	</div>

	<div style="text-align:left">

			<div class="main-wrapper div-no-mobile" style="min-height: 20px; margin-top: -40px; text-align:left">
				<div class="col-half background-orange-light" align="left">
					<div align="left">
						<div class="contact-text-box">
							<div class="" align="left" style="margin-top: 0px">
								<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-SPOT-A0101','GET YOUR ACCOUNT');?></a>
							</div>
						</div>
					</div>
				</div><!-- end col half-->

				<div class="col-half background-orange" align="left">
					<div align="left">
						<div class="contact-text-box">
							<div class="div-no-mobile" align="left" style="margin-top: 0px">
								<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-SPOT-A0101','GET YOUR ACCOUNT');?></a>
							</div>
						</div>
					</div>
				</div><!-- end col half-->

				<div class="col-half background-apricot div-no-mobile" align="left">
					<div align="left">
						<div class="contact-text-box">
							<div class="" align="left" style="margin-top: 0px">
								<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-SPOT-A0101','GET YOUR ACCOUNT');?></a>
							</div>
						</div>
					</div>
				</div>


			</div>


	</div>

</section>
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
