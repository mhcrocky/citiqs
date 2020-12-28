<div style="margin-top: 0;" class="main-wrapper">
	<div class="col-half background-apricot-blue height-100">
		<div class="flex-column align-start">
			<div class="mt-50" style="text-align:left; margin-left: -30px">
				<img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="300" height="auto" />
			</div>
			<div style="text-align:left; margin-top: 30px">
				<h1 class="heading" style="font-size: 400%; margin-bottom: 20px">
					<?php echo $this->language->line('ALFRED-VA10001A','ALFRED</a>');?>
				</h1>
				<h3 class="heading">
					<?php echo $this->language->line('ALFRED-VB100010','THE DIGITAL BUTLER');?>
				</h3>
			</div>

		</div>
	</div><!-- end col half -->



	<div class="col-half background-yankee timeline-content">
		<!--
		<div class="timeline-block background-blue" style="display:none">
			<span class='timeline-number text-light-blue hide-mobile'><img src="<?php echo base_url(); ?>assets/home/images/tiqsiconlogonew.png" alt="tiqs" width="18" height="20" /></span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-light-blue show-mobile'></span>
					<h2 style="font-weight:bold; font-family: caption-bold"><?php echo $this->language->line('ALFRED-ABCE1010101','TO GO BUSY TIME');?></h2>
				</div>
				<div>
					<p style="font-family:caption-light; font-size: medium; font-weight: bold">
					<ul style="list-style-type: disc ; font-family:caption-light; font-size: larger; margin-left: -20px;margin-bottom: 30px ">
						<div>
							<label for="min">Minutes for slow </label>
							<input style="border-radius: 50px; text-align: center" type="number" id="min" onkeydown="checkPostiveInteger(event)" oninput="checkValidLimits()" placeholder="   min">
						</div>
						<div>
							<label for="max">add minutes for busy</label>
							<input style="border-radius: 50px; text-align: center" type="number" id="max" onkeydown="checkPostiveInteger(event)" oninput="checkValidLimits()" placeholder="   max">
						</div>
					</ul>

					<div class="flex-column align-space">
						<div style="text-align:center">
							<a onclick="changeLimits()" id="limitButton" disabled class="button button-orange mb-25"><?php echo $this->language->line('NOLABELS-vPB1881A',"SET TIME");?></a>
						</div>
						<div class="mb-35" style="text-align:right" >
							MINUTES ADDED

						<span id="val"><?php echo $vendor['busyTime']; ?></span>
						</div>
						<input style="background-color: #1a2226" id="slide" type="range" min="0" max="100" value="<?php echo $vendor['busyTime']; ?>" oninput="displayValue(event)"/>

					<p></p>
					<div style="text-align:center">
						<a onclick="saveBusyTime('slide', '<?php echo $vendor['id']; ?>')" id="limitButton" disabled class="button button-orange mb-25"><?php echo $this->language->line('NOLABELS-vPB18811jKJA',"CONFIRM TIME");?></a>
					</div>

				</div>

				</div>
			</div>
		</div>-->
		<!-- end timeline block -->

		<div style="padding-left: 40px;" class="timeline-block background-yankee">
			<span class='timeline-number text-light-blue hide-mobile'>1</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-light-blue show-mobile'>1</span>
					<h2 style="font-weight:bold; margin-top: 17px;  font-family: caption-bold"><?php echo $this->language->line('ALFRED-A1010101','GO TO PROFILE');?></h2>
				</div>
				<p style="font-family:caption-light; font-size: medium; font-weight: bold">
				<ul style="list-style-type: disc ; font-family:caption-light; font-size: larger; margin-left: -20px ">
					<li><?php echo $this->language->line('ALFRED-VB10001112',"COMPLETE YOUR PROFILE DETAILS");?></>
					<li><?php echo $this->language->line('ALFRED-VB10001113',"COMPLETE YOUR FINANCIAL DETAILS");?></>
				</ul>
				<p></p>

				<div class="flex-column align-space">
					<div style="text-align:center">
						<!-- href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->
						<a href="profile" target="_self" class="button button-orange mb-25"><?php echo $this->language->line('NOLABELS-vB1000131A',"GO TO PROFILE");?></a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->

		<div style="padding-left: 40px;" class="timeline-block background-blue">
			<span class='timeline-number text-light-blue hide-mobile'>2</span>
			<div class="timeline-text">

				<div class='timeline-heading'>
					<span class='timeline-number text-light-blue show-mobile'>2</span>
					<h2 style="font-weight:bold; margin-top: 15px; font-family: caption-bold"><?php echo $this->language->line('ALFRED-VB1000101UA','GO TO SHOP SETTINGS');?></h2>
				</div>
				<p style="font-family:caption-light; font-size: medium; font-weight: bold">
				<ul style="list-style-type: disc ; font-family:caption-light; font-size: larger; margin-left: -20px ">
					<li><?php echo $this->language->line('ALFRED-VB10001111A',"MANAGE YOUR SHOP SETTINGS");?></>
				</ul>
				<p></p>
				<div class="flex-column align-space">
					<div style="text-align:center">
						<!-- <a class="button button-orange mb-25" id="show-timeline-video-4">LEARN MORE VIDEO</a> -->
						<a href="orders" target="_self" class="button button-orange mb-25"><?php echo $this->language->line('ALFRED-vB100011131B',"GO TO SETTINGS");?></a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->

		<div style="padding-left: 40px;" class="timeline-block background-apricot-blue">
			<span class='timeline-number text-light-blue hide-mobile'>3</span>
			<div class="timeline-text">

				<div class='timeline-heading'>
					<span class='timeline-number text-light-blue show-mobile'>3</span>
					<h2 style="font-weight:bold; margin-top: 17px;  font-family: caption-bold"><?php echo $this->language->line('ALFRED-NL0010A','MY DESIGNS');?></h2>
				</div>
				<p style="font-family:caption-light; font-size: medium; font-weight: bold">
				<ul style="list-style-type: disc ; font-family:caption-light; font-size: larger; margin-left: -20px ">
					<li><?php echo $this->language->line('ALFRED-NL0020A',"E-mail templates, iFrame template (colors, fonts, size), Settings landing pages (Succes payments), ");?></>
				</ul>
				<p></p>
				<div class="flex-column align-space">
					<div style="text-align:center">
						<!-- <a class="button button-orange mb-25" id="show-timeline-video-4">LEARN MORE VIDEO</a> -->
						<a href="emaildesigner" target="_self" class="button button-orange mb-25"><?php echo $this->language->line('ALFRED-NL0030A',"GO TO SETTINGS");?></a>
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
