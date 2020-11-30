
	<div class="footer-container">
		<div class="footer-box background-yankee">
			<p class='footer-heading'>Business</p>
			<a href="APIrequest"><?php echo $this->language->line('FOOTERSPOT-API1A',"API developers integration tools");?></a>
			<a href="info_download"><?php echo $this->language->line('FOOTERSPOT-brochure1A',"More info in this brochure about tiqs SPOT");?></a>
		</div>
		<div class="footer-box background-orange">
			<p class='footer-heading'>Consumer</p>
			<a href="<?php echo $this->baseUrl; ?>contactform">Contact</a><br>
			<a target="_blank" href="https://www.dhl.nl/en/express/tracking.html"><?php echo $this->language->line('FOOTERSPOT-DHL1A',"");?></a><br>
			<a target="_blank" href="https://locator.dhl.com/"><?php echo $this->language->line('FOOTERSPOT-DHL2A',"");?></a><br>
			<a href=""></a><br>
		</div>
		<div class="footer-box background-apricot">
			<p class='footer-heading'>About Us</p>
			<a href="<?php echo $this->baseUrl; ?>info_spot#why-section">About us</a><br>
			<a href="<?php echo $this->baseUrl; ?>contactform">Contact</a><br>
			<a href="vancancies">Vacancies</a><br>
			<a target="_blank" href="https://tiqs.com/branding">Brand Identity</a>
		</div>
		<div class="footer-box background-green">
			<p class='footer-heading' style="color: white">Legal</p>
			<a class="link" href="<?php echo $this->baseUrl; ?>legal">Terms and Conditions <br>Privacy Policy <br> Cookie statement</a><br>
		</div>
	</div>

	<main role="main" style="background-image: url('https://tiqs.com/alfred/assets/home/images/backgroundshop.png');  background-repeat: no-repeat;
  		background-size: 100% 100%;"
		align="center" >
		<section  align="center" style="padding-top: 150px; padding-bottom: 150px" >
			<div  align="center" >
				<h1 style="font-family: caption-bold;color: #ffffff; margin-bottom: 0px"><?php echo $this->language->Line("PLACES-ABCD0020",'YOUR ONE STOP FAVORITE STREET ONLINE-PICKUP AND DELIVERY SHOPPING');?></h1>
				<!--			<div class="mb-35" align="center">-->
				<!--						<img src="--><?php //echo $this->baseUrl; ?><!--assets/home/images/tiqslocation.png" alt="tiqs" width=250 height="auto" align="center" />-->
				<!--			</div>-->

		</section>

	</main>

	</div>
	<div id="myCookieConsent">
		<a id="cookieButton">ACCEPT</a>
		<div>THIS WEBSITE USES COOKIES. <a href="<?php echo $this->baseUrl; ?>legal">MORE INFO HOW WE USE COOKIES</a>
		</div>
	</div>




<!-- LANGUAGE VIEW -->
<?php
$this->load->view('includes/selectlanguage.php');
?>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/languageModal.js"></script>
<?php include_once FCPATH . 'application/views/includes/jsGlobalVariables.php'; ?>
<?php include_once FCPATH . 'application/views/includes/customJs.php'; ?>
<?php include_once FCPATH . 'application/views/includes/alertifySessionMessage.php'; ?>
</body>
</html>
<?php
if(isset($_SESSION['error'])) {
	unset($_SESSION['error']);
}
if(isset($_SESSION['success'])) {
	unset($_SESSION['success']);
}
if(isset($_SESSION['message'])) {
	unset($_SESSION['message']);
}
?>
