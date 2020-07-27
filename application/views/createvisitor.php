<div class="main-wrapper" style="text-align:center">
	<div class="col-half  background-orange-light timeline-content">
		<form id="checkItem" action="<?php echo $this->baseUrl; ?>createvisitor/registration" method="post" enctype="multipart/form-data"  >
		<div class="login-box background-orange-light">
			<h2 style="font-family: caption-bold">REGISTREREN ALS BEZOEKER</h2>
<!--			<div class="form-group has-feedback">-->
<!--				DATUM VAN BEZOEK-->
<!--				<input type="date" id="eventdate" name="eventdate" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="eventid" />-->
<!--			</div>-->

			<div class="form-group has-feedback">
				<input type="text" id="bar" name="bar" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="cafe/bar/restaurant" />
			</div>

			<div class="form-group has-feedback">
				<input type="text" id="name" name="name" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="name" />
			</div>
			<div class="form-group has-feedback">
				<input type="text" id="surname" name="surname" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="surname" />
			</div>

			<div class="form-group has-feedback">
				<input type="email" id="email" name="email" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="email" />
			</div>
			<div class="form-group has-feedback">
				<input type="text" id="mobile" name="mobile" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="mobile" />
			</div>
			<div class="form-group has-feedback">
				<input type="text" id="tablenr" name="tablenr" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="tafelnummer" />
			</div>


			<h2 style="font-family: caption-bold">IN</h2>

			<div class="form-group has-feedback">
				<input type="checkbox" id="NEWSLETTER" name="NEWSLETTER" value="IN">
<!--				<label for="vehicle1">IK BEVIND MIJ OP DE LOACATIE</label><br>-->
			</div>

			<h2 style="font-family: caption-bold">OUT</h2>
			<div class="form-group has-feedback">
				<input type="checkbox" id="NEWSLETTER" name="NEWSLETTER" value="OUT">
<!--				<label for="vehicle1">IK HEB DE LOCATIE VERLATEN</label><br>-->
			</div>


			<div class="pricing-first" style="font-family: caption-bold">
				<h2 style="font-family: caption-bold">LET OP!</h2>
				<p style="font-family: caption-bold" ></p>
				<p style="font-family: caption-light">1. WANNEER NAAR U VAN BUITEN NAAR BINNEN GAAT,. MOND KAPJE VERPLICHT!.</p>
				<p style="font-family: caption-light">2. ZIEK?, FAMILIE OF KENNIS(SEN) ZIEK IN JE OMGEVING? OF ONLANGS (BINNEN 14 DAGEN) ZIEK GEWEEST?. GA NAAR HUIS. </p>
				<p style="font-family: caption-light">3. ALS U ER BENT HOUD 1,5 METER AFSTAND. </p>



				<p style="font-family: caption-light">4. INSCHRIJVING IS VOOR 1 PERSOON. </p>


			</div>

			<div class="pricing-block-footer mt-50" style="height: 100px" >
				<button data-brackets-id="2918" type="submit" class="button button-orange">REGISTEREN</button>
			</div>

			<p style="font-family: caption-light; font-size: small">Met het invullen van dit formulier ga je akkoord met de gegevensverwerking onder artikel 6 GDPR, c) en het relevante Ministerieel Besluit. Op vraag van de overheid wordt er toegang gegeven tot de mailbox. De gegevens worden niet gebruikt voor commerciële doeleinden en zullen niet aan derden worden verkocht. Na 4 weken worden de gegevens definitief verwijderd. Samen sterk tegen COVID-19! </p>
		</div><!-- end pricing block -->
	</div>
	<div class="col-half  background-orange timeline-content">
	</div>
</div>
<script>
	$(document).ready(function(){
		if($(document).width() <= 768){
			var pricing_details_button = $('.pricing-details-button');
			$('.pricing-details-list').hide();
			$( document ).width();
			$(pricing_details_button).click(function(){
				$(this).parents('.pricing-component-body').find('.pricing-details-list').toggle('300');
			})
		}
	})
</script>
