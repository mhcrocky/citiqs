<div class="main-wrapper">
	<div class="col-half background-yellow height-100">
		<div class="flex-column align-start">
			<div style="text-align:left">
				<h2 class="heading mb-35">
					<?=$this->language->line('ALFRED-A10001','QRCODE ORDERING SYSTEM QUICK REFERENCE</a>');?>
				</h2>
				<h3 class="heading mb-35">
					<?=$this->language->line('ALFRED-B100010','LEARN HOW IN THE STEPS ON THIS PAGE');?>
				</h3>

			</div>
			<div class="mt-50" style="text-align:center">
				<img src="<?php echo base_url(); ?>assets/home/images/tiqsiconlogonew.png" alt="tiqs" width="75" height="auto" />
			</div>

		</div>
	</div><!-- end col half -->
	<div class="col-half background-apricot timeline-content">
		<div class="timeline-block background-yellow">
			<span class='timeline-number text-orange hide-mobile'>1</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-green show-mobile'>1</span>
					<h2 style="font-weight:bold; font-family: caption-bold"><?=$this->language->line('ALFRED-A1010101','GO TO PROFILE');?></h2>
				</div>
				<p style="font-family:caption-light; font-size: medium; font-weight: bold">
					<ul style="list-style-type: disc ; font-family:caption-light; font-size: larger; margin-left: -20px ">
						<li><?=$this->language->line('ALFRED-B1000111',"COMPLETE YOUR DETAILS");?></>
				<p></p>
				<div class="flex-column align-space">
					<div style="margin-left: -20px; text-align:center">
						<!-- href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->
						<a href="profile" target="_self" class="button button-orange mb-25"><?=$this->language->line('NOLABELS-B1000131A',"GOTO PROFILE");?></a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-orange-light">
			<span class='timeline-number text-orange hide-mobile'>2</span>
			<div class="timeline-text">

				<div class='timeline-heading'>
					<span class='timeline-number text-blue show-mobile'>2</span>
					<h2 style="font-weight:bold; font-family: caption-bold"><?=$this->language->line('ALFRED-B1000101UA','GO TO QRCODE ORDERING SETTINGS');?></h2>
				</div>
				<p style="font-family:caption-light; font-size: medium; font-weight: bold">
					<ul style="list-style-type: disc ; font-family:caption-light; font-size: larger; margin-left: -20px ">
						<li><?=$this->language->line('ALFRED-B10001111A',"MANAGE YOUR QRCODE ORDERING SYSTEM");?></>
					</ul>
				<p></p>
				<div class="flex-column align-space">
					<div style="text-align:center">
						<!-- <a class="button button-orange mb-25" id="show-timeline-video-4">LEARN MORE VIDEO</a> -->
						<a href="warehouse" target="_self" class="button button-orange mb-25"><?=$this->language->line('ALFRED-B100011131B',"GOTO SETTINGS");?></a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->

	</div>
	<!-- time-line -->
<!-- end col half -->
</div>
<!-- end main wrapper -->
<script>
	// modal script
	// Get the modal
	var modal = document.getElementById("myModal");

	// Get the button that opens the modal
	var btn = document.getElementById("modal-button");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	if (btn) {
		// When the user clicks on the button, open the modal
		btn.onclick = function() {
			if (modal) {
				modal.style.display = "block";
			}
		}
	}

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
<?php
	if(isset($_SESSION['error'])){
		unset($_SESSION['error']);
	}
	if(isset($_SESSION['success'])){
		unset($_SESSION['success']);
	}
	if(isset($_SESSION['message'])){
		unset($_SESSION['message']);
	}
?>
