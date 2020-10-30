<!DOCTYPE html>
<html><head>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/tags-page.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/business-page.css">

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
<section id='why-section'>
	<div class="main-wrapper background-blue" align="center">
		<div class="col-half col-slider background-blue"  style="min-height:400px">
			<div class="image-contact-0 height-100"></div>
			<div style="text-align:center; margin-top: 30px">
				<img border="0" src="<?php echo base_url(); ?>assets/home/images/dhlpoweredby.png" alt="tiqs" width="auto" height="30" />
			</div>
		</div>
		<div class="mt-50 div-only-mobile" >
			<div class="contact-text-box align-center" style="margin-left: 100px">
				<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-A0101','GET YOUR ACCOUNT');?></a>
			</div>

		</div>
		<div class="col-half background-blue col-half-mobile height-100 contact-text">
				<div align="left">
					<p><?php echo $this->language->line("BUSINESS-100001",'WHY TIQS?');?></p>
					<div class="contact-text-box">
						<div class="mb-35 div-no-mobile" align="right" style="margin-top: -50px">
							<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-A0101','GET YOUR ACCOUNT');?></a>
						</div>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-100002",'1. INCREASED CUSTOMER LOYALTY')?><br>
						</p>
						<p style="font-family:caption-light; font-size: medium">
							<?php echo $this->language->line("BUSINESS-100003a",'Our platform supports you enabling higher customer satisfaction, greater customer experience leading to increased customer loyalty');?>
						</p>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-100004",'2. STANDARDIZED WORKFLOW');?>
						</p>
						<p style="font-family:caption-light; font-size: medium">
							<?php echo $this->language->line("BUSINESS-100005",'Our platform simplifies your internal and external Lost & Found process through a standardized workflow which is developed on registration, claim and return of the Lost & Found items to the rightful owner.');?>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-100006",'3. ALL LOST & FOUND ITEMS IN ONE PLACE');?>
						</p>
						<p style="font-family:caption-light; font-size: medium">
							<?php echo $this->language->line("BUSINESS-100007",'All Lost & Found items are stored in one secured digital database, that you and your customer can easily acces through the personal Tiqs Lost & Found page of your company.');?>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-100003b",'4. LESS IMPACT ON THE INTERNAL PROCESS');?>
						</p>
						<p style="font-family:caption-light; font-size: medium">
							<?php echo $this->language->line("BUSINESS-100008",'Our intuitive software interface, standardized workflow and integrated shipping solution lowers the impact on your operational workload, so your organisation can focus on its core business.');?>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-100009",'5. INTEGRATED SHIPPING SOLUTION (DHL)');?>
						</p>
						<p style="font-family:caption-light; font-size: medium">
							<?php echo $this->language->line("BUSINESS-100010",'Our platform relieves you from the logistic handling of the Lost & Found items to their owners via our integrated and automated shipping solution. Our exclusive partnership with DHL guarantees insured Track & Trace returns and pick-up worldwide.');?>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-100011",'6. HIGHER RETURN RATE');?>
						</p>
						<p style="font-family:caption-light; font-size: medium">
							<?php echo $this->language->line("BUSINESS-100012",'Our end-to-end tailored and time saving solution increases the return percentage of your Lost & Found thanks to its efficiency.');?>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-100013",'7. REVENUE MODEL');?>
						</p>
						<p style="font-family:caption-light; font-size: medium">
							<?php echo $this->language->line("BUSINESS-100014a","In addition to cost efficiency and time savings, Tiqs offers you more revenue with less resources. Tiqs transforms from a cost to a revenue model and creates an extra value proposition for your organisation.");?>
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
						<p><?php echo $this->language->line("BUSINESS-100015",'HOW?');?></p>
						<div class="mb-35 div-no-mobile" align="right" style="margin-top: -50px">
							<a href="<?php echo base_url(); ?>registerbusiness" style="background-color:#eb5d16; color: white" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-A0101','GET YOUR ACCOUNT');?></a>
						</div>
						<p style="font-size: medium; font-weight: bold">
						<?php echo $this->language->line("BUSINESS-100016",'OUR SOLUTION IS ALL ABOUT (A) REGISTRATION, (B) CLAIM AND (C) RETURN OF LOST & FOUND ITEMS TO THEIR RIGHTFUL OWNERS - YOUR CLIENTS!');?>
						</p>
						<p style="font-size: medium; font-weight: bold">
							<?php echo $this->language->line("BUSINESS-100017",'A - YOUR COMPANY');?>
						</p>
						<ul style="list-style-type:none;font-family:caption-light; font-size: small; font-weight: lighter; margin-left: -40px">
							<li><?php echo $this->language->line("BUSINESS-100018",'1. FOUNDS A LOST ITEM');?></>
							<li><?php echo $this->language->line("BUSINESS-100019",'2. REGISTERS THE ITEM WITH THE TIQS SCAN AND SECURES IT WITH A UNIQUE QR CODE');?>
							<li><?php echo $this->language->line("BUSINESS-100020",'3. PLACES THE ITEM IN A TIQS BAG AND SEALES IT');?></>
						</ul>
						<p style="font-size: medium; font-weight: bold">
						<?php echo $this->language->line("BUSINESS-100014",'B - YOUR CLIENT');?>
						</p>
						<ul style="list-style-type:none;font-family:caption-light; font-size: small; font-weight: lighter; margin-left: -40px">
							<li><?php echo $this->language->line("BUSINESS-100021",'4. CLAIMS THE ITEM ON THE COMPANY LOST & FOUND PAGE');?></>
							<li><?php echo $this->language->line("BUSINESS-100022",'5. HAS TO IDENTIFY HIMSELF AND TIQS VERIFIES WITH A SECURE ALGORITHM THE OWNERSHIP');?></>
							<li><?php echo $this->language->line("BUSINESS-100023",'6. CHOOSES PICK-UP OR DELIVERY BY DHL AND PAYS ONLINE');?></>
						</ul>
						<p style="font-size: medium; font-weight: bold;">
							<?php echo $this->language->line("BUSINESS-100024",'C - RETURN & HAPPY CUSTOMER');?>
						</p>
						<ul style="list-style-type:none;font-family:caption-light; font-size: small; font-weight: lighter; margin-left: -40px">
							<li><?php echo $this->language->line("BUSINESS-100025",'7. DHL COLLECTS THE LOST ITEM AND PREPARES IT FOR SHIPMENT');?></>
							<li><?php echo $this->language->line("BUSINESS-100026",'8. DHL DELIVERS THE LOST ITEM WITH TRACK & TRACE');?></>
							<li><?php echo $this->language->line("BUSINESS-100027",'9. YOU JUST CREATED A NEW HAPPY CUSTOMER');?></>
						</ul>
						</p>
					</div>
					<div style="text-align:center; margin-top: 30px">
						<img border="0" src="<?php echo base_url(); ?>assets/home/images/DHL_express.png" alt="tiqs" width="auto" height="30" />
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
						<div class=" mb-35 div-only-mobile" align="center" style="text-align: center">
							<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-A0101','GET YOUR ACCOUNT');?></a>
						</div>
						<p><?php echo $this->language->line("BUSINESS-100028",'FOR WHO?');?></p>
						<div class="mb-35 div-no-mobile" align="right" style="margin-top: -50px">
							<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-A0101','GET YOUR ACCOUNT');?></a>
						</div>
						<p style="font-size: medium; font-weight: bold">
						<?php echo $this->language->line("BUSINESS-100029",'TIQS IS DEVELOPED FOR ALL COMPANIES WHOSE CUSTOMERS ARE VISITORS AND IS RECOGNIZED AS THE UNIVERSAL STANDARD FOR YOUR LOST AND FOUND PROCESS AND MANAGEMENT.');?><br>
						</p>
						<p style="font-family:caption-light; font-size: small; font-weight: lighter">
						<?php echo $this->language->line("BUSINESS-100030",'
							AIR BNB,
							AMUSEMENT PARK AVIATION,
							BAR,
							BNB,
							CAMPING,
							CAR RENTAL,
							CLUB,
							CRUISE,
							EVENT,
							EVENT HALL FESTIVAL,
							GYM,
							HOSPITAL,
							HOTEL,
							MALL,
							MARKET,
							MOVIE THEATER,
							MUNICIPALITY MUSEUM,
							PUBLIC TRANSPORT NIGHTCLUB,
							PUBLIC SWIMMING POOL RESTAURANT,
							SPORT ASSOCIATION SPORT CLUB,
							STORE,
							TAXI,
							THEATER,
							THEME PARK,
							TOUR OPERATOR,
							TRANSPORT,
							UNIVERSITY,
							ZOO,
							....
							');?>
						</p>
						<div style="text-align:center; margin-top: 30px">
							<img border="0" src="<?php echo base_url(); ?>assets/home/images/dhlpoweredby.png" alt="tiqs" width="auto" height="30" />
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
			<h1 style="font-family:caption-bold; font-size: 60px; font-weight: bold" ><?php echo $this->language->line("BUSINESS-pack100031",'PACKAGES');?></h1>
		</div>
	</div>

<section id='packages-section'>
	<div class="main-wrapper main-wrapper-contact height-30" style="text-align:center">
		<div class="col-half background-orange-light col-half-mobile contact-text" style="margin-bottom: 0px">
			<div style="text-align:left">
				<div class="contact-text-box" style="margin-bottom: 0px">
					<h2 style="font-family:caption-bold"><?php echo $this->language->line("BUSINESS-100031",'FREE STARTERS PACKAGE');?></h2>
					<p style="font-family:caption-light; font-size: medium; font-weight: bold">
						<ul style="list-style-type: disc ; font-family:caption-light; font-size: larger; margin-left: -20px ">
							<li>
								<?php strtoupper($this->language->line('BUSINESS-100031-' . $subscriptions['Free'][0]['description'], $subscriptions['Free'][0]['description'])); ?>
							</li>
							<li><?php echo $this->language->line("BUSINESS-100032C","20 TIQS BAGS (EX SHIPPING COSTS) MULTI TIQS SCAN USERS");?></li>
							<li><?php echo $this->language->line("BUSINESS-100032D","INTEGRATED SHIPPING SOLUTION (DHL) SET-UP PICK-UP TIME");?></li>
						</ul>
						<ul style="list-style-type: none; font-family:caption-bold; font-size: medium; margin-left: -40px" >
							<li><?php echo $this->language->line("BUSINESS-100032E","PRICE = 0 EURO + SHIPPING COSTS");?></li>
						</ul>
					</p>
				</div>
			</div>
		</div>
		<div class="col-half background-orange col-half-mobile contact-text">
			<div style="text-align:left">
				<div class="contact-text-box">
					<h2 style="font-family:caption-bold"><?php echo $this->language->line("BUSINESS-100035",'BASIC PACKAGE');?></h2>
					<p style="font-family:caption-light; font-size: medium; font-weight: bold">
						<ul style="list-style-type: disc ; font-family:caption-light; font-size: larger; margin-left: -20px ">
							<li>
								<?php strtoupper($this->language->line('BUSINESS-100035B-' . $subscriptions['basic_yearly'][0]['description'], $subscriptions['basic_yearly'][0]['description'])); ?>
							</li>
							<li><?php echo $this->language->line("BUSINESS-100035C","WEBSITE INTEGRATION AND PERSONALISATION MULTI TIQS SCAN USERS");?></li>
							<li><?php echo $this->language->line("BUSINESS-100035D","INTEGRATED SHIPPING SOLUTION (DHL) PICK-UP TIME AND LOCATION");?></li>
						</ul>
						</ul>						
					</ul>
						</ul>						
					</ul>
						</ul>						
						<ul style="list-style-type: none; font-family:caption-bold; font-size: medium; margin-left: -40px" >
							<li><?php echo $this->language->line("BUSINESS-{$subscriptions['basic_yearly'][0]['amount']}", 'YEARLY SUBSCRIPTION = ' . $subscriptions['basic_yearly'][0]['amount'] . ' EURO');?></li>
							<li><?php echo $this->language->line("BUSINESS-{$subscriptions['basic_monthly'][0]['amount']}12", 'MONTHLY SUBSCRIPTION = ' . $subscriptions['basic_monthly'][0]['amount'] . ' EURO');?></li>
						</ul>
					</p>
				</div>				
			</div>
		</div><!-- end col half-->

		<div class="col-half background-apricot col-half-mobile contact-text" style="margin-bottom: 0px">
			<div style="text-align:left">
				<div class="contact-text-box">
					<h2 style="font-family:caption-bold"><?php echo $this->language->line("BUSINESS-100033",'STANDARD PACKAGE');?></h2>
					<p style="font-family:caption-light; font-size: medium; font-weight: bold">
						<ul style="list-style-type: disc ; font-family:caption-light; font-size: larger; margin-left: -20px ">
							<li>
								<?php strtoupper($this->language->line('BUSINESS-100035B1-' . $subscriptions['standard_yearly'][0]['description'], $subscriptions['standard_yearly'][0]['description'])); ?>
							</li>
							<li><?php echo $this->language->line("BUSINESS-100033C","100 FREE TIQS BAGS (EX SHIPPING COSTS) REVENUE MODEL WITH OWN ADMINISTRATION FEE WEBSITE INTEGRATION AND PERSONALISATION MULTI TIQS SCAN USERS");?></li>
							<li><?php echo $this->language->line("BUSINESS-100033D","INTEGRATED SHIPPING SOLUTION (DHL) SET-UP PICK-UP TIME AND LOCATION");?></li>
						</ul>
						<ul style="list-style-type: none; font-family:caption-bold; font-size: medium; margin-left: -40px" >
							<li><?php echo $this->language->line("BUSINESS-100033E1-{$subscriptions['standard_yearly'][0]['amount']}",'YEARLY SUBSCRIPTION = ' . $subscriptions['standard_yearly'][0]['amount'] . ' EURO');?></li>
							<li><?php echo $this->language->line("BUSINESS-100033E1-{$subscriptions['standard_monthly'][0]['amount']}",'MONTHLY SUBSCRIPTION = ' . $subscriptions['standard_monthly'][0]['amount'] . ' EURO');?></li>
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
								<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-A0101','GET YOUR ACCOUNT');?></a>
							</div>
						</div>
					</div>
				</div><!-- end col half-->

				<div class="col-half background-orange" align="left">
					<div align="left">
						<div class="contact-text-box">
							<div class="div-no-mobile" align="left" style="margin-top: 0px">
								<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-A0101','GET YOUR ACCOUNT');?></a>
							</div>
						</div>
					</div>
				</div><!-- end col half-->

				<div class="col-half background-apricot div-no-mobile" align="left">
					<div align="left">
						<div class="contact-text-box">
							<div class="" align="left" style="margin-top: 0px">
								<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-A0101','GET YOUR ACCOUNT');?></a>
							</div>
						</div>
					</div>
				</div>


			</div>


	</div>

	<div class="main-wrapper main-wrapper-contact height-50" align="center">
		<div class="col-half background-blue col-half-mobile contact-text">
			<div align="left">
				<div class="contact-text-box">
					<p><?php echo $this->language->line("BUSINESS-100037",'VOLUME PACKAGE');?></p>
					<p style="font-family:caption-light; font-size: medium; font-weight: bold">
						<ul style="list-style-type: none ; font-family:caption-light; font-size: larger; margin-left: -40px ">
							<li><?php echo $this->language->line("BUSINESS-1X100037B1","FOR BUSINESSES WITH A LARGE QUANTITY OF VISITORS. FULLY COMMITTED TO CUSTOMER LOYALTY");?></>
						<p></p>
					</ul>
					</p>
				</div>
			</div>
		</div>

		<div class="col-half background-blue col-half-mobile contact-text">
			<div align="left">
				<div class="contact-text-box">
					<p style="font-family:caption-light; font-size: small; font-weight: bold">
						<ul style="list-style-type: disc ; font-family:caption-light; font-size: small; margin-left: -20px ">
							<li><?php echo $this->language->line("BUSINESS-2X100037B","FROM 200 TILL 10.000 LOST & FOUND ITEMS A YEAR 100 OR MORE FREE TIQS BAGS (EX SHIPPING COSTS) REVENUE MODEL WITH OWN ADMINISTRATION FEE WEBSITE INTEGRATION AND PERSONALISATION MULTI TIQS SCAN USERS");?></>
							<li><?php echo $this->language->line("BUSINESS-2X100037C","INTEGRATED SHIPPING SOLUTION (DHL) PICK-UP TIME AND LOCATION / +100 SECURE TIQS-BAGS / REGISTRATION BY MULTIPLE EMPLOYEES");?></>

							<p></p>
						</ul>
					</p>
				</div>


			</div>
		</div>
		<div class="col-half background-blue col-half-mobile contact-text">
			<div align="left">
				<div class="contact-text-box">
					<p style="font-family:caption-light; font-size: medium; font-weight: bold">
						<ul style="list-style-type: disc ; font-family:caption-light; font-size: larger; margin-left: -20px ">
							<li><?php echo $this->language->line("BUSINESS-2X100037D","OVERVIEW OF ALL LOST AND FOUND ITEMS");?></>
							<li><?php echo $this->language->line("BUSINESS-3X100037B","24/7 support");?></>
							<li><?php echo $this->language->line("BUSINESS-3X100037C","iFRAME INTEGRATION");?></>
							<li><?php echo $this->language->line("BUSINESS-3X100037D","API CONNECTION / INTEGRATION");?></>
							<li><?php echo $this->language->line("BUSINESS-3X100037E","YOUR OWN BUSINESS BRANDING");?></>
					<p></p>
					</ul>
					</p>
				</div>
				<div class="" align="left" style="margin-top: 50px">
					<a href="<?php echo base_url(); ?>registerbusiness" class="button button-orange"><?php echo $this->language->line('INFOBUSINESS-A0101','GET YOUR ACCOUNT');?></a>
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
