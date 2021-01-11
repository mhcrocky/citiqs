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
			<embed src="<?php echo base_url(); ?>/assets/home/documents/NL-manual.pdf" height=100% width="100%">
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
