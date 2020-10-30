<!DOCTYPE html>
<html><head>
    <link rel="stylesheet" href="assets/home/styles/how-it-works.css">
    <link rel="stylesheet" href="assets/home/styles/personal-page.css">
    <link rel="stylesheet" href="assets/home/styles/timeline.css">
   <!--<link rel="stylesheet" href="../../assets/home/styles/styles.css">-->
</head>
<body>

<div class="main-wrapper">

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

    <div class="col-half background-orange height-100">
        <div class="flex-column align-start width-650">
            <p style="font-family:'caption-bold'; font-size:300%; color:#ffffff; text-align: center">
                <?php echo $this->language->line("HOWCONSUMER-1000",'HOW IT WORKS. ');?>
            </p>
            <section id="cd-timeline" >
                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-picture">
                        <span>1</span>
                    </div>
					<div class="cd-timeline-content">
                        <h2>TAG YOUR ITEM</h2>
                        <p class="text-content-light">PUT YOUR STICKERS ON ANYTHING YOU DO NOT WANT TO LOSE. </p>
						<div class="row" align="center" style="padding:10px ">
							<img border="0" src="<?php echo base_url(); ?>assets/home/images/HOWITWORKSCONSUMER-001.jpg" alt="tiqs" width="125" height="125" />
						</div class="login-box">
                        <div class="flex-column align-space">
                            <p class="text-content-light"><?php echo $this->language->line("HOWCONSUMER-1100",'LOST BY YOU, <br>RETURNED BY US.');?>
                            </p>
                        </div>
                    </div> <!-- cd-timeline-content -->
                    <div id="timeline-video-2">
                        <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div>
                    </div><!-- time line video for second block -->
                </div> <!-- cd-timeline-block -->

                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-movie">
                        <span>2</span>
                    </div> <!-- cd-timeline-img -->

                    <div class="cd-timeline-content">
                        <h2>REGISTER THE ITEM</h2>
                        <p class="text-content-light">TAKES 1 MINUTE PER ITEM TO REGISTER. </p>
                        <div class="flex-column align-space">
							<div align="center" style="padding:10px">
								<!--                                href="<?php echo base_url(); ?>menuapp target="_blank"" -->
								<a  class="button button-orange mb-25" id='show-timeline-video-2'><?php echo $this->language->line("HOWCONSUMER-01500",'SHOW HOW TO');?></a>
							</div>
							<p class="text-content-light"><?php echo $this->language->line("HOWCONSUMER-1100",'LOST BY YOU, <br>RETURNED BY US.');?>
                            </p>

                        </div>
                        <!--<span class="cd-date">Jan 18</span>-->
                    </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->

                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-picture">
                        <span>3</span>
                    </div>
                    <div class="cd-timeline-content">
                        <h2>MAKE THE ITEMS VISIBLE ON YOUR WEBSITE</h2>
                        <p class="text-content-light">AFTER REGISTRATION OF LOST AND FOUND ITEMS IN YOUR ACCOUNT, YOU CAN MAKE AN OVERVIEW AVAILABLE ON YOUR WEBSITE, OR USE THE TIQS LOST AND FOUND WEB-PAGE. </p>
                        <div class="flex-column align-space">
                            <p class="text-content-light"><?php echo $this->language->line("HOWCONSUMER-1600",'LOST BY YOUR CUSTOMER, <br>RETURNED BY US.');?>
                            </p>
                            <div align="center">
                                <a href="<?php echo base_url(); ?>menuapp" target="_blank" class="button button-orange mb-25"><?php echo $this->language->line("HOWCONSUMER-1700",'HOW TO SHOW ITEMS');?></a>
                            </div>
                        </div>
                        <!--<span class="cd-date">Jan 18</span>-->
                    </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->

                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-location">
                        <span>4</span>
                    </div> <!-- cd-timeline-img -->

                    <div class="cd-timeline-content">
                        <h2>YOUR ALL SETUP NOW!</h2>
                        <p class="text-content-light">You are all setup now! You are now able to have guest claim lost and found items, without any cumbersome procedures and handling costs.</p>
                        <!-- <span class="cd-date">Feb 14</span>-->
                    </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->

                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-location">
                        <span>5</span>
                    </div>

                    <div class="cd-timeline-content">
                        <h2>ADDITIONAL OPTIONS</h2>
                        <p class="text-content-light">Learn more about all the posibilities TIQS lost and found offers. Set your lost and found collect times, give limited access to you housekeeping for lost and found item registration, connect TIQS lost and found to your hospitality system. Change standard forms and e-mails in line with your corporate house style.  </p>
                        <!--<span class="cd-date">Feb 18</span>-->
                        <div class="flex-column align-space">
                            <div align="center">
                                <a href="" target="_blank" class="button button-orange mb-25"><?php echo $this->language->line("HOWCONSUMER-1800",'LEARN MORE VIDEO');?></a>
                            </div>
                        </div>
                    </div> <!-- cd-timeline-content -->

                </div> <!-- cd-timeline-block -->

                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-movie">
                        <span>6</span>
                    </div> <!-- cd-timeline-img -->

                    <div class="cd-timeline-content">
                        <h2>FINALLY</h2>
                        <p class="text-content-light">Any questions or suggestions contact us with the button below. </p>
                        <!-- <span class="cd-date">Feb 26</span>-->
                        <div class="flex-column align-space">
                            <div align="center">
                                <a href="" target="_blank" class="button button-orange mb-25"><?php echo $this->language->line("HOWCONSUMER-1900",'CONTACT');?></a>
                            </div>
                        </div>
                    </div> <!-- cd-timeline-content -->

                </div> <!-- cd-timeline-block -->
            </section> <!-- cd-timeline -->
            <div class="row" align="center" style="padding:50px ">
                <img border="0" src="<?php echo base_url(); ?>tiqsimg/tiqslogonew.png" alt="tiqs" width="125" height="45" />
            </div class="login-box">
        </div>
    </div><!-- end col half -->

    <div class="col-half background-blue faq-page">
        <div class="manual-content width-650">
			<h2 class="heading mb-35">FAQ</h2>
			<button class="accordion">HOW DOES IT WORK?</button>
			<div class="panel">
				<p>Put your stickers on anything you don’t want to lose. Register them by scanning or go to https://tiqs.com/register. You are now secured and go about your day as usual.
					When this tagged item goes missing, the person who finds it can now communicate with you directly. This person can scan the QRCode directly by the mobile camera or can go to https://tiqs.com/lost. No personal information is ever shared. TIQS just matches the item to the rightful owner and enables a conversation – that’s all.
					Once you are connected with the finder, you decide the best way to get your item back. And you decide whether or not to share any personal information with the person who has it. TIQS supports complete anonymous return shipments through our partner DHL.</p>
			</div>
			<button class="accordion">WHAT DOES IT COST</button>
			<div class="panel">
				<p>REGISTRATION AND THE STICKERS ARE 100% FREE! We're focused on creating the world's largest lost-and-found community. </p>
			</div>
			<button class="accordion">DO I HAVE TO PUT A STICKER ON ALL ITEMS?</button>
			<div class="panel">
				<p>Yes. The sticker confirms the item is registered and it identifies you as the rightful owner (without sharing any personal data).</p>
			</div>
			<button class="accordion">HOW MANY ITEMS CAN I REGISTER FOR ME?</button>
			<div class="panel">
				<p>As many as you want! There is no limit on the number of items you can tag and keep track of with the stickers, TIQS-TAGs and Keychains.</p>
			</div>
			<button class="accordion">I ALREADY HAVE TIQS-TAGS/KEYCHAIN/STICKERS CAN I ORDER MORE?</button>
			<div class="panel">
				<p>YES! Whether you're registering more items, replacing stickers or items, or gifting stickers to friends and family, you can always order more.</p>
			</div>
			<button class="accordion">I HAVE SOME STICKERS LEFT CAN I GIVE THEM TO A RELATIVE?</button>
			<div class="panel">
				<p>YES! No problem, we encourage you to do this, help us build a worldwide lost and found community. </p>
			</div>
			<button class="accordion">HOW CAN I GET MY ITEM BACK?</button>
			<div class="panel">
				<p>You can get your item back through the finder. We have made this process for you and the finder very simple</p>
			</div>
			<button class="accordion">HOW CAN PEOPLE REACH ME WHEN I HAVE LOST MY PHONE?</button>
			<div class="panel">
				<p>A lost phone can still be returned to you! In your account you can set your lost and found buddy and you have the ability just sign into your account on another device so that you can still get alerted and communicate with the person who found it.</p>
			</div>
			<button class="accordion">HOW PRIVATE IS MY DATA?</button>
			<div class="panel">
				<p>TIQS does not share any personal information.</p>
			</div>
		</div><!-- end faq content -->


        <div class="background-blue-light faq-login">
            <div class="flex-column align-start width-650">

                <div class="flex-row align-space">
                    <div class="flex-column align-space">
                        <div class="faq-content">
							<h2 class="heading mb-35">PRIVACY AND SECURITY BY DESIGN</h2>
							<button class="accordion">HOW DO WE GUARANTEE YOUR PRIVACY</button>
							<div class="panel px-0">
								<div class="col-testimonial-content background-blue height-100 align-center">
									<!--                    <iframe align="center" src="https://docs.google.com/gview?url=<?php echo base_url(); ?>Housekeeping.pdf&embedded=true" style="width: 100%; height:  450px; margin-top: 35px" frameborder="0"&gt;&lt;/iframe&gt; ></iframe>-->
									<!--                    <iframe align="center" src="https://docs.google.com/gview?url=<?php echo base_url(); ?>Housekeeping.pdf&embedded=true" style="width: 300px; height:  450px;" frameborder="0"&gt;&lt;/iframe&gt; ></iframe>-->
								</div>
							</div>
							<button class="accordion">HOW DO WE ENSURE YOUR ANONYMITY</button>
							<div class="panel">
								<p>Your ANONYMITY is guaranteed through a secure process. </p>
								<div class="flex-column align-space mb-35">
									<div align="center">
										<a href="<?php echo base_url(); ?>menuapp" target="_blank" class="button button-orange mb-25"><?php echo $this->language->line("HOWCONSUMER-1900",'SHOW VIDEO');?></a>
									</div>
								</div>
							</div>
							<button class="accordion">HOW TO REGISTER A LOST AND FOUND ITEM</button>
							<div class="panel">
								<p>This video will show you how to create an account.</p>
								<div class="flex-column align-space mb-35">
									<div align="center">
										<a href="<?php echo base_url(); ?>menuapp" target="_blank" class="button button-orange mb-25"><?php echo $this->language->line("HOWCONSUMER-2000",'SHOW VIDEO');?></a>
									</div>
								</div>
							</div>
							<button class="accordion">HOW TO CHANGE LOST AND FOUND ITEMS IMAGE</button>
							<div class="panel">
								<p>This video will show you how to create an account.</p>
								<div class="flex-column align-space mb-35">
									<div align="center">
										<a href="<?php echo base_url(); ?>menuapp" target="_blank" class="button button-orange mb-25"><?php echo $this->language->line("HOWCONSUMER-2100",'SHOW VIDEO');?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div><!-- end flex row -->


				<div class="text-center mt-50 mobile-hide">
					<img border="0" src="<?php echo base_url(); ?>assets/home/images/TIQSKeys.png" alt="tiqs" width="250" height="200" />
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

</html>
