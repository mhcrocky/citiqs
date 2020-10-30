<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/how-it-works.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/hotel-page.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/timeline-page.css">


	<style>
		.width-650{
			margin: 0 auto;
		}

		.manual-content .heading{
			text-align: center;
			color: #fff;
		}

		.faq-page{
			display: flex;
			flex-direction: column;
		}

		.faq-page{
			margin: 0 auto;
		}

		.faq-login{
			flex-grow:1;
		}

		.panel {
			padding: 0 18px;
			background-color: transparent !important;
			color: #fff !important;
			border:   1px solid transparent !important;
			box-shadow: none !Important;
		}
		.panel p{
			margin: 18px 0;
			font-family: 'caption-light', sans-serif;
		}

		.svg-overflow svg{
			overflow: visible;
		}

		.background-yankee .active, .background-yankee .accordion:hover {
			background-color: #18386663;
		}

		.background-green .active, .background-green .accordion:hover {
			background-color: #66a694;
		}


	</style>

</head>
<body>

<div class="main-wrapper" style="margin: 0px">
        <div class="col-half background-yankee timeline-content">
			<div class="timeline-block background-yellow">
				<span class='timeline-number text-orange hide-mobile'>1</span>
				<div class="timeline-text">
					<div class="timeline-heading">
						<span class='timeline-number text-green show-mobile'>1</span>
						<h2 style="font-weight:bold; font-family: caption-bold">REGISTER LOST AND FOUND ITEMS</h2>
					</div>
					<p class="text-content-light" style="font-size: larger">YOUR LOST AND FOUND PROCESS, GIVE LIMITED ACCESS TO YOU STAFF FOR LOST AND FOUND ITEM REGISTRATION, CONNECT TIQS LOST AND FOUND TO YOUR HOSPITALITY SYSTEM.</p>
					<div class="flex-column align-space">
						<!--					<p class="text-content-light" style="font-weight: bold">LOST BY YOUR CUSTOMER, <br>RETURNED BY US.							</p>-->
						<div id="timeline-video-3">
							<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></div>
						</div><!-- time line video for third block -->
						<div align="center">
							<!--                                href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->
							<a class="button button-orange mb-25" id="show-timeline-video-3">LEARN MORE VIDEO</a>
						</div>
					</div>
				</div>
			</div><!-- end timeline block -->

			<div class="timeline-block background-orange-light">
				<span class='timeline-number text-orange hide-mobile'>2</span>
				<div class="timeline-text">
					<div class='timeline-heading'>
						<span class='timeline-number text-blue show-mobile'>2</span>
						<h2 style="font-weight:bold; font-family: caption-bold">MAKE LOST AND FOUND ITEMS VISIBLE ON YOUR WEBSITE</h2>
					</div>
					<p class="text-content-light" style="font-size: larger">FULLY INTEGRATE LOST AND FOUND IN YOUR CORPORATE WEBSITE, OR USE OUR STANDARD LINK. </p>
					<div class="flex-column align-space">
						<!--					<p class="text-content-light" style="font-weight: bold">LOST BY YOUR CUSTOMER, <br>RETURNED BY US.</p>-->
						<div id="timeline-video-4">
							<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></div>
						</div><!-- time line video for fourth block -->
						<div align="center">
							<!--                                href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->
							<a class="button button-orange mb-25" id="show-timeline-video-4">LEARN MORE VIDEO</a>
						</div>
					</div>
				</div>
			</div><!-- end timeline block -->

			<div class="timeline-block background-green-environment">
				<span class='timeline-number text-orange hide-mobile'>3</span>
				<div class="timeline-text">
					<div class="timeline-heading">
						<span class='timeline-number text-apricot show-mobile'>3</span>
						<h2 style="font-weight:bold; font-family: caption-bold">ORDER EXTRA LOST AND FOUND TIQS-BAGS</h2>
					</div>
					<p class="text-content-light" style="font-size: larger">ORDER MORE LOST AND FOUND BAGS ONLINE</p>
					<!--<span class="cd-date">Feb 18</span>-->
					<div class="flex-column align-space">
						<div align="center">
							<a href="" target="_blank" class="button button-orange mb-25">LEARN MORE VIDEO</a>
						</div>
					</div>
				</div>
			</div><!-- end timeline block -->

<!--			<div class="timeline-block background-apricot timeblock-last">-->
<!--				<span class='timeline-number text-orange hide-mobile'>4</span>-->
<!--				<div class="timeline-text">-->
<!--					<div class="timeline-heading">-->
<!--						<span class='timeline-number text-blue show-mobile'>4</span>-->
<!--						<h2 style="font-weight:bold; font-family: caption-bold">FREQUENTLY ASKED QUESTIONS</h2>-->
<!--					</div>-->
<!--					<p class="text-content-light" style="font-size: larger">MOST QUESTIONS AND ANSWERS IN ONE PAGE.</p>-->
<!--					<div class="flex-column align-space">-->
<!--						<div align="center">-->
<!--							<a href="" target="_blank" class="button button-orange mb-25">LEARN MORE VIDEO</a>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div> -->
<!--		</div>-->
<!--		-->

			<div class="background-yankee" align="center"  >
				<form action="" method="post" id="contactForm" role="form">
					<h2 class="heading mb-35">CONTACT FORM</h2>
					<div class="flex-column align-space" style="font-family: caption-light">
						<div class="form-group has-feedback" style="font-family: caption-light">

							<div class="form-group has-feedback">
								<p for="name">Name</p>
								<div class="form-group has-feedback">
									<input type="text" class="form-control" id="name" name="name" style="border-radius: 50px; border: none" placeholder="Name" maxlength="128">
									<input type="hidden" value="1" name="nameId" id="nameId">
								</div>
							</div>
							<div class="form-group has-feedback">
								<p for="phone">Phone</p>
								<div class="form-group has-feedback">
									<input type="number" class="form-control" id="phone" name="phone" style="border-radius: 50px; border: none" placeholder="Phone" maxlength="128">
									<input type="hidden" value="1" name="" id="">
								</div>
							</div>
							<div class="form-group has-feedback">
								<p for="phone">E-mail Address</p>
								<div class="form-group has-feedback">
									<input type="email" class="form-control" id="email" name="email" style="border-radius: 50px; border: none" placeholder="Email Address" maxlength="128">
									<input type="hidden" value="" name="" id="">
								</div>
							</div>
							<div class="form-group has-feedback">
								<p for="Language">Language</p>
								<div class="selectWrapper"  id="language">
									<select class="selectBox" id="languageselect" name="country" style="background-color:#eec5a7; font-family:'caption-light';" style="border-radius: 50px; border: none" />
									<option value="">
										<?php echo $this->language->line("CONTACT-A360","Select your language");?>
									</option>
									<option value="tenglish">English</option>
									<option value="german">German</option>
									<option value="dutch">Dutch</option>
									<option value="french">French</option>
									<option value="italian">Italian</option>
									<option value="spain">Spanish</option>
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


    <div class="col-half background-blue faq-page height-100">
		<div class="manual-content width-650">
			<h2 class="heading mb-35">MANUALS</h2>
            <button class="accordion">HOW TO SETUP AND TRAIN YOUR STAFF IN YOUR HOTEL LOST AND FOUND PROCEDURE</button>
            <div class="panel px-0">
                <div class="col-testimonial-content background-blue height-100 align-center">
                    <iframe align="center" src="https://docs.google.com/gview?url=<?php echo base_url(); ?>Housekeeping.pdf&embedded=true" style="width: 100%; height:  450px; margin-top: 35px" frameborder="0"&gt;&lt;/iframe&gt; ></iframe>
<!--                    <iframe align="center" src="https://docs.google.com/gview?url=<?php echo base_url(); ?>Housekeeping.pdf&embedded=true" style="width: 300px; height:  450px;" frameborder="0"&gt;&lt;/iframe&gt; ></iframe>-->
                </div>
            </div>
				<button class="accordion">HOW TO MAKE A HOSPITALITY ACCOUNT</button>
				<div class="panel">
				  <p>This video will show you how to create an account.</p>
                    <div class="flex-column align-space mb-35">
                        <div align="center">
                            <a href="<?php echo base_url(); ?>menuapp" target="_blank" class="button button-orange mb-25"><?php echo $this->language->line("HOWITORKSBUSINESS-2000",'SHOW VIDEO');?></a>
                        </div>
                    </div>
				</div>
				<button class="accordion">HOW TO REGISTER A LOST AND FOUND ITEM FOR THE WEB</button>
            <div class="panel">
                <p>This video will show you how to create an account.</p>
                <div class="flex-column align-space mb-35">
                    <div align="center">
                        <a href="<?php echo base_url(); ?>menuapp" target="_blank" class="button button-orange mb-25"><?php echo $this->language->line("HOWITORKSBUSINESS-2100",'SHOW VIDEO');?></a>
                    </div>
                </div>
            </div>
				<button class="accordion">HOW TO SET COLLECTION OF LOST AND FOUND ITEMS TIMES</button>
            <div class="panel">
                <p>This video will show you how to create an account.</p>
                <div class="flex-column align-space mb-35">
                    <div align="center">
                        <a href="<?php echo base_url(); ?>menuapp" target="_blank" class="button button-orange mb-25"><?php echo $this->language->line("HOWITORKSBUSINESS-2200",'SHOW VIDEO');?></a>
                    </div>
                </div>
            </div>
			<div class="text-center mt-50 mobile-hide">
				<img border="0" src="<?php echo base_url(); ?>assets/home/images/TIQSKeys.png" alt="tiqs" width="250" height="200" />
			</div class="login-box">
		</div><!-- end manual content -->

	   <div class="background-blue-light faq-login height-50">
           <div class="flex-column align-start width-650">
               <div class="flex-row align-space">
                   <div class="flex-column align-space">
                       <div class="faq-content">
                           <h2 class="heading mb-35">FAQ</h2>
                           <button class="accordion">DO I HAVE TO PAY FOR A SUBSCRIPTION</button>
                           <div class="panel">
                               <p>.</p>
                           </div>
                           <button class="accordion">CAN I GIVE LIMITED ACCESS TO MY STAFF TO REGISTER A FOUND ITEM</button>
                           <div class="panel">
                               <p>YES</p>
                           </div>
                           <button class="accordion">HOW DO I ORDER EXTRA TIQS LOST+FOUND BAGS</button>
                           <div class="panel">
                               <p>You can order TIQS LOST+FOUND BAGS through this link.</p>
                           </div>
                           <button class="accordion">WHAT IF AN ITEM IS NEVER COLLECTED</button>
                           <div class="panel">
                               <p>SET YOU TIME PERIOD TO COLLECT AN ITEM</p>
                           </div>
                           <button class="accordion">HOW DOES THIS WORK WITH DHL</button>
                           <div class="panel">
                               <p>WE ARE PARTNERING WITH DHL EXPRESS. OUR IT SYSTEMS ARE CONNECTED AND EVERYTHING WORKS AUTOMATICALLY</p>
                           </div>
                       </div><!-- end faq content -->
                   </div>
               </div><!-- end flex row -->


			   <div class="text-center mt-50 mobile-hide">
				   <img border="0" src="<?php echo base_url(); ?>assets/home/images/TIQSWallet.png" alt="tiqs" width="250" height="200" />
			   </div class="login-box">
           </div>
       </div>
	</div><!-- end col half section -->

</div><!-- end main wrapper -->

<!--<section class='section-3 section-video' id='hit-section' >-->
<!--    <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:50%;height:50%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen id='frame'></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>-->
<!--    <div class='video-content'>-->
<!---->
<!--        <ul class='thumbnail-video'>-->
<!--            <li data-link='https://player.vimeo.com/external/350504740.hd.mp4?s=cb64bf5c6a0144294be6133077f7c8d1949b48f1&profile_id=175' class='video-link'>-->
<!--                <img src="<?php echo base_url(); ?>assets/home/images/slide2.jpg" alt="">-->
<!--                <p>Long Heading Long Heading Long Heading</p>-->
<!--            </li>-->
<!--            <li data-link='https://player.vimeo.com/external/354548249.hd.mp4?s=636e439c5280ac90081e4679e529694f3d296c87&profile_id=175'  class='video-link'>-->
<!--                <img src="<?php echo base_url(); ?>assets/home/images/slide2.jpg" alt="">-->
<!--                <p>Heading</p>-->
<!--            </li>-->
<!--            <li data-link='https://player.vimeo.com/external/352480169.hd.mp4?s=401dc0b739451a9e77efb35c09c5435e9b0914c3&profile_id=169' class='video-link'>-->
<!--                <img src="<?php echo base_url(); ?>assets/home/images/slide2.jpg" alt="">-->
<!--                <p>Heading</p>-->
<!--            </li>-->
<!--            <li data-link='https://player.vimeo.com/external/351190317.hd.mp4?s=ef0688cdf77bd81cc4c4ddca8321a11b6d3e1b54&profile_id=175' class='video-link'>-->
<!--                <img src="<?php echo base_url(); ?>assets/home/images/slide2.jpg" alt="">-->
<!--                <p>Heading</p>-->
<!--            </li>-->
<!--            <li data-link='https://player.vimeo.com/external/351190317.hd.mp4?s=ef0688cdf77bd81cc4c4ddca8321a11b6d3e1b54&profile_id=175' class='video-link'>-->
<!--                <img src="<?php echo base_url(); ?>assets/home/images/slide2.jpg" alt="">-->
<!--                <p>Heading</p>-->
<!--            </li>-->
<!--            <li data-link='https://player.vimeo.com/external/351190317.hd.mp4?s=ef0688cdf77bd81cc4c4ddca8321a11b6d3e1b54&profile_id=175' class='video-link'>-->
<!--                <img src="<?php echo base_url(); ?>assets/home/images/slide2.jpg" alt="">-->
<!--                <p>Heading</p>-->
<!--            </li>-->
<!--            <li data-link='https://player.vimeo.com/external/351190317.hd.mp4?s=ef0688cdf77bd81cc4c4ddca8321a11b6d3e1b54&profile_id=175' class='video-link'>-->
<!--                <img src="<?php echo base_url(); ?>assets/home/images/slide2.jpg" alt="">-->
<!--                <p>Heading</p>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </div>-->
<!--</section>-->

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

<script src="https://player.vimeo.com/api/player.js"></script>
<script type="text/javascript">
    // video player script

    /* getting iframe, setting size and links */
    var frame = document.getElementById('frame');
    var frame_heigth = frame.offsetHeight;
    document.getElementsByClassName('thumbnail-video')[0].style.maxHeight = frame_heigth + 'px';
    document.getElementsByClassName('section-video')[0].style.maxHeight = frame_heigth + 'px';

    function getVideoLink(e){
        frame.src = e.getAttribute('data-link');
        console.log('frame');
        frame.play();
    }

    var video_links = document.getElementsByClassName('video-link');

    const buttons = document.getElementsByClassName("video-link")
    for (const button of buttons) {
        button.addEventListener('click',function(e){
                frame.src = this.getAttribute('data-link');
                document.getElementById('frame video')
            }
        )}

    </script>

<script>

	$('#show-timeline-video-2').click(function(){
		console.log('da');
		$('#timeline-video-2').toggleClass('show');
	})

</script>
<script type="text/javascript">
	// modal script
	// Get the modal
	var modal = document.getElementById("myModal");

	// Get the button that opens the modal
	var btn = document.getElementById("modal-button");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on the button, open the modal
	btn.onclick = function() {
		modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

</script>

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

<script>

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

</html>
