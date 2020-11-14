<div class="main-wrapper">
	<div class="col-half background-blue height-100">
		<div class="flex-column align-start">
			<div style="text-align:center">
				<div style="margin-top: 0px; margin-left: 0px">
					<img border="0" src="<?php echo base_url(); ?>assets/home/images/alfredmenu.png" alt="tiqs" width="auto" height="110" />
				</div>
				<p style="font-size: larger; margin-top: 50px; margin-left: 0px"><?php echo $this->language->line("HOMESTART-SPOT-001AC",'THE NUMBER ONE PLATFORM <br> SERVICE PLATFORM');?></p>

				<p style="font-size: larger; margin-top: 50px; margin-left: 0px"><?php echo $this->language->line("HOMESTART-SPOT-0011B",'IN MORE THAN 107 LANGUAGES <br> WITH SERVICES IN MORE THAN 201 COUNTRIES');?></p>
				<div style="margin-top: 30px">
					<a href="<?php echo base_url(); ?>info_spot" class="button button-orange mb-35"><?php echo $this->language->line("HOMESTART-SPOT-004",'TIQS FOR  BUSINESS');?></a>
				</div>
			</div>
			<div style="text-align:center; margin-top: 30px">
				<p style="font-size: larger; margin-top: 50px; margin-left: 0px"><?php echo $this->language->line("HOMESTART-SPOT-X001111ABC",'BUILD BY TIQS');?></p>

			</div>
		</div>
	</div><!-- end col half -->
	<div class="col-half background-orange height-100">
		<div class="flex-column align-start">
			<div style="text-align:center">
				<div style="margin-top: 0px; margin-left: 0px">
					<img border="0" src="<?php echo base_url(); ?>assets/home/images/alfredmenu.png" alt="tiqs" width="auto" height="110" />
				</div>
				<p style=" font-size: larger; margin-top: 50px; margin-left: 0px"><?php echo $this->language->line("HOMESTART-ALFREDSPOT-002A",'GET YOUR FAVOURITE DRINKS AND FOOD SERVED AT YOUR FAVOURITE SPOT');?></p>
				<p style="font-size: larger; margin-top: 0px; margin-left: 0px"><?php echo $this->language->line("HOMESTART-SPOT-00111AB",'(Service  Point Or Table)');?></p>
				<p style="font-size: larger; margin-top: 50px; margin-left: 0px"><?php echo $this->language->line("HOMESTART-SPOT-0011B",'IN MORE THAN 107 LANGUAGES <br> AND MORE THAN 201 COUNTRIES');?></p>
				<div style="margin-top: 30px">
					<a href="https://tiqs.com/places" class="button button-orange mb-35"><?php echo $this->language->line("HOMESTART-SPOT-003",'TIQS SPOT PLACES FOR CONSUMERS');?></a>
				</div>
			</div>
			<div style="text-align:center; margin-top: 30px">
				<p style="font-size: larger; margin-top: 50px; margin-left: 0px"><?php echo $this->language->line("HOMESTART-SPOT-X001111ABC",'BUILD BY TIQS');?></p>
			</div>
		</div>
	</div><!-- end col half -->
</div>
<!--</div>-->
<div id="myCookieConsent">
	<a id="cookieButton">ACCEPT</a>
	<div>THIS WEBSITE USES COOKIES. <a href="<?php echo $this->baseUrl; ?>legal">MORE INFO HOW WE USE COOKIES</a>
	</div>
</div>
<script>
	function isInIframe () {
		try {
			if (window.self !== window.top) {
				let src = window.self['frameElement']['attributes'][0]['nodeValue'];
				window.self.location = src;
			}
		} catch (e) {
			return true;
		}
	}
	isInIframe();
</script>
