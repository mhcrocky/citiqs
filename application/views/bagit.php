<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/hotel-page.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/timeline-page.css">
</head>
<body>


<div class="main-wrapper">
	<div class="col-half background-yellow height-100">
		<div class="flex-column align-start">
			<div align="left">
				<p style="font-family:'caption-bold'; font-size:200%; color:#ffffff; text-align: center; ">
					<?php echo $this->language->line("BAGIT-010",'UNIQUE CODE');?>
				</p>
				<p style="font-family:'caption-bold'; font-size:100%; color:#ffffff; text-align: center; ">
					<?php echo $this->language->line("BAGIT-A010",'WRITE THIS NUMBER ON THE TIQS-BAG');?>
				</p>
				<p style="font-family:'caption-bold'; font-size:300%; color:#ffffff; text-align: center;">
					<?php echo $code ?>
				</p>
			</div>
			<div class="text-Left mt-50 mobile-hide" style="margin-top: 0px; margin-left: 0px">
				<img border="0" src="<?php echo base_url(); ?>assets/home/images/lostandfounditemswhite.png" alt="tiqs" width="500" height="auto" />
			</div>
			<div class="mt-50" align="center" >
				<img border="0" src="<?php echo base_url(); ?>assets/home/images/tiqsiconlogonew.png" alt="tiqs" width="75" height="auto" />
			</div>
			<div class="mt-50" align="center" >
				<img border="0" src="<?php echo base_url(); ?>assets/home/images/DHL_express.png" alt="tiqs" width="250" height="auto" />
			</div>
		</div>
	</div><!-- end col half -->

	<div class="col-half background-apricot timeline-content">
		<div class="timeline-block background-yellow">
			<span class='timeline-number text-orange hide-mobile'>1</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-green show-mobile'>1</span>
					<h2 style="font-weight:bold; font-family: caption-bold">PLACE THE ITEM IN THE TIQS-BAG</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">PUT THE ITEM IN THE TIQS BAG, BUT FIRST WRITE ON THE BAG THE UNIQUE CODE!.</p>
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
					<h2 style="font-weight:bold; font-family: caption-bold">REGISTER AN OTHER ITEM!</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">YOU CAN REGISTER AN OTHER FOUND ITEM WITH THE BUTTON BELOW.</p>
				<div class="flex-column align-space">
					<!--					<p class="text-content-light" style="font-weight: bold">LOST BY YOUR CUSTOMER, <br>RETURNED BY US.</p>-->
					<div align="center">
						<!--                                href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->
							<a href="<?php echo base_url()?>itemfound/<?php echo $token?>/<?php echo $userId?>" class="button button-orange mb-25"><?php echo $this->language->line("BAGIT-LA1900",'REGISTER AN OTHER FOUND ITEM');?></a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
	</div>
</div>

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
