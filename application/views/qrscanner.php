<!DOCTYPE html>
<head>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/qrscanner-page.css">
	<meta charset="UTF-8">
</head>
<body>

<style>

	video{
		display:block;
		width:90%;
		height:auto;
	}
	video.scale2{
		-moz-transform:scale(1.1);
		-webkit-transform:scale(1.1);
		-o-transform:scale(1.1);
		-ms-transform:scale(1.1);
		transform:scale(1.1);
	}

</style>

<div class="main-wrapper">
	<div class="col-half background-blue height-100 ">
		<div class="flex-column background-blue width-650">
			<!--BEGIN SCANNER CAMERA-->
			<h2 class="heading mb-35">
				<?php echo $this->language->line('SCAN-10001','SCAN YOUR QRCODE');?>
			</h2>
			<div>
				<b style="font-family: caption-light">Device has camera to scan: </b>
				<span id="cam-has-camera"></span>
				<br>
				<video width="100%" class="scale2" muted playsinline id="qr-video"></video>
			</div>

			<!--SET THE VALUE TO BOTH AS STANDARD -->
			<div hidden>
				<select id="inversion-mode-select">
					<option value="original">Scan QRCode)</option>
					<option value="invert">Scan QRCode on dark background)</option>
					<option value="both">Scan both</option>
				</select>
				<br>
			</div>

			<!--		NEED TO PUT HERE THE SCAN RESULT AS HREF TO REGISTER THE ITEM. -->

			<a href="#cam-qr-result" id="registertag" class="button button-orange mb-35"><?php echo $this->language->line("Home-01610",'REGISTER YOUR ITEMS');?></a>

			<!--END QRSCANNER CAMERA-->
			<b>Detected QR code: </b>
			<a id="cam-qr-result"></a>
			<br>

			<div hidden>
				<b>Last detected at: </b>
				<span id="cam-qr-result-timestamp"></span>
					</div>
			</div>


	</div>

	<div class="col-half background-apricot">
		<div class=" background-orange height-50">
			<div class="width-650">
				<h2 class="heading"><?php echo $this->language->line("Home-10005",'<a href="https://tiqs.com/lostandfound/personaltagsinfo">REGISTER YOUR PERSONAL ITEMS WITH THE LOST + FOUND <br>KEYCHAIN, TIQS-TAG AND STICKERS OR PHOTO</a>');?></h2>
				<a style="color:#ffffff" class='how-we-works-link' href="https://tiqs.com/lostandfound/howitworksconsumer"><?php echo $this->language->line("Home-006",'MORE INFO, HOW IT WORKS');?></a>
				<p class="text-content mb-50"><?php echo $this->language->line("Home-0065",'LOST BY YOU, <br> RETURNED BY US');?></p>
				<a href="<?php echo base_url(); ?>check" class="button button-orange mb-35"><?php echo $this->language->line("Home-01610",'REGISTER YOUR ITEMS');?></a>
			</div>
		</div>
		<div class="background-apricot height-50">
			<div class="width-650">
				<h2 class="heading mb-35"><?php echo $this->language->line("Home-007",'LOGIN.');?></h2>
				<form action="<?php echo base_url(); ?>loginMe" method="post" class='homepage-form'>
					<p>
						<?php echo $this->language->line("Home-008",'Use your e-mail to login');?>
					</p>
					<div  align="center" >
						<input type="email" class="form-control" placeholder="<?php echo $this->language->line("Home-009",'Your e-mail');?>" name="email" required />
					</div>
					<p>
						<?php echo $this->language->line("Home-008a",'Password');?>
					</p>
					<div >
						<input type="password" class="form-control"placeholder="<?php echo $this->language->line("Home-010",'Your Password');?>" name="password" required />
					</div>

					<br>
					<div style="text-align: center; ">
						<input type="submit" class="button button-apricot" value="<?php echo $this->language->line("Home-011",'LOGIN');?>" style="border: none"/>
					</div>
				</form>
			</div>
		</div>
	</div><!-- end col half -->
</div><!-- end main wrapper -->

<script type="module">
	import QrScanner from "<?phpbase_url()?>assets/home/js/qr-scanner.min.js";
	QrScanner.WORKER_PATH = '<?phpbase_url()?>assets/home/js/qr-scanner-worker.min.js';

	const video = document.getElementById('qr-video');
	const camHasCamera = document.getElementById('cam-has-camera');
	const camQrResult = document.getElementById('cam-qr-result');
	const camQrResultTimestamp = document.getElementById('cam-qr-result-timestamp');
	const fileSelector = document.getElementById('file-selector');
	const fileQrResult = document.getElementById('file-qr-result');

	function setResult(label, result) {
		label.textContent = result;
		camQrResultTimestamp.textContent = new Date().toString();
		label.style.color = 'teal';
		clearTimeout(label.highlightTimeout);
		label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
	}

	// ####### Web Cam Scanning #######

	QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);

	const scanner = new QrScanner(video, result => setResult(camQrResult, result));

	scanner.start();

	document.getElementById('inversion-mode-select').addEventListener('change', event => {
		scanner.setInversionMode(event.target.value);
	});


</script>
</body>
</html>
