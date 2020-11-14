<div class="main-wrapper">
	<div class="col-half background-orange timeline-content">
		<div class="timeline-block background-yellow-DHL">
			<span class='timeline-number text-orange hide-mobile'>1</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-green show-mobile'>1</span>
					<h2 style="font-weight:bold; font-family: caption-bold">RETURN BY DHL EXPRESS WORLDWIDE</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">YOU CAN SELECT THE RETURN OF THE ITEM BY DHL.</p>
				<div class="flex-column align-space">
					<!-- <p class="text-content-light" style="font-weight: bold">LOST BY YOUR CUSTOMER, <br>RETURNED BY US. </p>-->
					<div style="text-align:center">
						<!-- href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->
						<input type="button" data-fancybox  style="border:none" class="button button-orange" <?php if ($record->payreturnfeestatus == 1) echo('class="active"'); ?> data-touch="false"  data-type="ajax" data-src="<?php echo base_url() . 'getDHLPrice/' . $record->labelId; ?>" href="javascript:;" type="button" class="button button-orange" onclick="parent.jQuery.fancybox.getInstance().close();" value="SELECT AND PAY"/>
					</div>
					<div class="mt-50" style="text-align:center">
						<img src="<?php echo base_url(); ?>assets/home/images/DHL_express.png" alt="tiqs" width="250" height="auto" />
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-grey">
			<span class='timeline-number text-orange hide-mobile'>2</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-green show-mobile'>2</span>
					<h2 style="font-weight:bold; font-family: caption-bold">SELECT TO COLLECT</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">COLLECT YOUR ITEM  AT THE VENUE WHERE IT WAS FOUND ONLY IF THE VENUE SUPPORT THIS. YOUR COLLECTION FEE (SHIPMENT OR APPOINTMENT FEE) NEEDS TO BE PAID IN ADVANCE.</p>
				<div class="flex-column align-space">
					<!-- <p class="text-content-light" style="font-weight: bold">LOST BY YOUR CUSTOMER, <br>RETURNED BY US. </p>-->
					<div style="text-align:center">
						<!-- href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->						
						<input type="button" data-fancybox  style="border:none" class="button button-orange" <?php if ($record->payreturnfeestatus == 1) echo('class="active"'); ?> data-touch="false"  data-type="ajax" data-src="<?php echo base_url() . 'appointment/' . $record->userId . '/'. $code; ?>" href="javascript:;" type="button" class="button button-orange" onclick="parent.jQuery.fancybox.getInstance().close();" value="COLLECT ITEM"/>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-yankee ">
			<span class='timeline-number text-orange hide-mobile'>3</span>
			<div class="timeline-text">
				<div class='timeline-heading'>
					<span class='timeline-number text-blue show-mobile'>3</span>
					<h2 style="font-weight:bold; font-family: caption-bold">UPLOAD YOUR ID</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">OUR RETURN-ITEM PROCESS IF FULLY AUTOMATED. NO MANUAL HUMAN PROCESS IS INVOLVED. THIS ENSURES COMPLETE PRIVACY.<br>PLEASE, UPLOAD YOUR IDENTIFICATION DOCUMENT. (DRIVERS LICENSE OR PASSPORT). </p>
				<div class="flex-column align-space">
					<!-- <p class="text-content-light" style="font-weight: bold">LOST BY YOUR CUSTOMER, <br>RETURNED BY US.</p>-->
					<div style="text-align:center">
						<!-- href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->
						<button style="border:none" class="button button-orange" <?php if (!empty($record->identification)) echo('class="active"'); ?> data-fancybox data-touch="false" href="#uploadidentification">UPLOAD IDENTIFICATION</button>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-grey">
			<span class='timeline-number text-orange hide-mobile'>4</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-apricot show-mobile'>4</span>
					<h2 style="font-weight:bold; font-family: caption-bold">UPLOAD YOUR PROOF OF ADRESS</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">		OUR RETURN-ITEM PROCESS IF FULLY AUTOMATED. NO MANUAL HUMAN PROCESS IS INVOLVED. THIS ENSURES COMPLETE PRIVACY.<BR>THE UTILITY BILL NEEDS TO HAVE YOUR NAME AND COMPLETE ADDRESS, AND IT NEEDS TO BE FROM A VIABLE SOURCE (ELECTRA-, GAS-, WATER-COMPANY AND/OR TAX-DEPARTMENT.)</p>
				<!--<span class="cd-date">Feb 18</span>-->
				<div class="flex-column align-space">
					<div style="text-align:center">
						<button style="border:none" class="button button-orange" id="ibd<?php echo $id; ?>" <?php if (!empty($record->utilitybill)) echo('class="active"'); ?> data-fancybox data-touch="false" href="#uploadUtilityBill">UPLOAD UTILITY BILL</button>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="background-orange">
			<div class="timeline-text">
				<div class="timeline-heading">
					<h2 style="font-weight:bold; font-family: caption-bold">THE PROCESS OF RETURNING THE ITEM BACK TO YOU, IS ONLY INITIATED AFTER COMPLETION OF STEP 1,2 AND 3.
						AFTER A CLAIM YOU HAVE 48 HOURS TO COMPLETE THIS AUTOMATED PROCESS.  </h2>
					<p class="text-content-light" style="font-size: larger">ADVANCED PAYMENT IS MANDATORY AFTER PAYMENT THE ITEM IS BLOCKED AND YOU HAVE 4 DAYS TO COMPLETE THE IDENTIFICATION AND PROOF OF ADDRESS UPLOAD.
						WE DO NOT COMMUNICATE BY PHONE ABOUT LOST AND FOUND. PLEASE SEND US AN E-MAIL IF YOU HAVE ANY QUESTION. AFTER 48 HOURS THE ITEM MUST BE CLAIMED AGAIN IF PAYMENT HAS NOT BEEN PROCESSED.</p>
				</div>
				<p class="text-content-light" style="font-size: larger"></p>
			</div>
		</div><!-- end timeline block -->
	</div>
	<!-- time-line -->
	<!-- end col half -->
	<div class="col-half background-blue height-100" style="color: white">
		<div class="flex-column align-start">
			<div  style="text-align:center">
				<h2 class="heading mb-35">
					<?php echo $this->language->line('CHECKOUT-A10001','GET YOUR ITEM BACK PROCESS</a>');?>
				</h2>
				<h3 class="heading mb-35 text-blue-dark">
					<?php echo $this->language->line('CHECKOUT-C100010','FOLLOW THE 3 STEPS ON THIS SCREEN.');?>
				</h3>
				<p style="font-family: caption-light" class="text-content mb-35"><?php echo $this->language->line("CLAIMCHECKOUT-A003111",'LOST BY YOU,<br> RETURNED BY US.');?></p>

				<p style="font-family: caption-bold" class="text-content mb-35"><?php echo $this->language->line("CLAIMCHECKOUT-A00301",'YOU HAVE CLAIMED AN ITEM ON TIQS LOST AND FOUND. TO REPATRIATE THE ITEM BACK TO YOU, WE NEED TO PROCESS YOUR PAYMENT, ID AND UTILITY BILL (PROOF OF ADDRESS).
					');?></p>

				<p style="font-family: caption-light" class="text-content mb-35"><?php echo $this->language->line("CLAIMCHECKOUT-A00305",'
					TIQS LOST AND FOUND USES A STATE OF THE ART ARTIFICIAL INTELLIGENCE, MACHINE LEARNING MECHANISM TO DETERMINE, THAT THIS IS AN APPROPRIATE CLAIM OF OWNERSHIP.
					UNDER GDPR RULING WE WILL STORE YOUR PAYMENT DETAILS, DETERMINE IF YOUR ID IS VALID (BY A VALIDATED CHECK OF YOUR ID, THROUGH A THIRD PARTY, ID IS NOT STORED AT THIRD PARTY SITE JUST TO CHECK IF THIS IS A VALID ID) AND BY CHECKING THE DETAILS OF YOUR UTILITY BILL (GAS, WATER COMPANY, TAX LETTER) SO WE CAN VALIDATE YOUR ADDRESS');?></p>

				<p style="font-family: caption-light" class="text-content mb-35"><?php echo $this->language->line("CLAIMCHECKOUT-A00310",'FOR THE DURATION OF THE PROCESS OF THE REPATRIATING PROCESS AND 3 MONTHS AFTER RECEIVING THE GOODS, THIS INFORMATION WILL BE STORED ENCRYPTED IN OUR SYSTEM. WHEN YOU HAVE CLAIMED AN ITEM NOT YOURS AND THE RIGHTFUL OWNER PROCESSED A CLAIM
				BY LAW, JUSTICE, OR ANY LEGAL PROCESS WE WILL PROVIDE LEGAL SERVICES WITH INFORMATION ABOUT THE CLAIM ALLEGEDLY MADE BY YOU. WE WILL ONLY SUPPLY INFROMATION REGARDING THE CLAIM FORCED BY LAW. ');?></p>


			</div>
			<div class="text-Left mt-50 mobile-hide" style="text-align:center">
				<img  src="<?php echo base_url(); ?>assets/home/images/lostandfounditemswhite.png" alt="tiqs" width="500" height="auto" />
			</div>
			<div class="mt-50" style="text-align:center">
				<img src="<?php echo base_url(); ?>assets/home/images/tiqsiconlogonew.png" alt="tiqs" width="40" height="auto" />
			</div>
			<div class="mt-50" style="text-align:center">
				<img src="<?php echo base_url(); ?>assets/home/images/DHL_expresswhite.png" alt="tiqs" width="250" height="auto" />
			</div>
		</div>
	</div><!-- end col half -->
</div>


<!-- <form id="getItem" action="" method="post" style="font-family:caption-bold; background-color: #FFCC00; display: none;width:100%;max-width:500px; border-radius: 10px; border: 3px solid #E25F2A;" >
	<div style="text-align:center"class="mb-35">
		<img src="https://tiqs.com/lostandfound/assets/home/images/tiqsiconlogonew.png" style="width:40px;height:40px;" />
	</div>
	<p style="font-family: caption-bold">
	</p>
	<div class="radio" style="margin-bottom: 10px">
		<input id="radio-1" type="radio" name="collectWay" value="dhl" checked>
		<label for="radio-1" class="radio-label">Send item by DHL to your registered address.</label>
	</div>
	<div class="radio" style="margin-top: 10px">
		<input id="radio-2" type="radio" name="collectWay" value="appointment" >
		<label for="radio-2" class="radio-label">Make an appointment to collect your item.</label>
	</div>
	
	<p></p>
	<p class="mt-10 text-right">
		<input id="collectDHL" data-fancybox data-type="ajax" data-src="<?php #echo base_url() . 'getDHLPrice/' . $record->userclaimId . '/' . $record->userfoundId; ?>" href="javascript:;" type="button" class="button button-orange" value="Submit" onclick="parent.jQuery.fancybox.getInstance().close();"/>
		<input id="collectAppointment" data-fancybox data-type="ajax" data-src="<?php #echo base_url() . 'appointment/' . $record->userId . '/'. $code; ?>" href="javascript:;" type="button" class="button button-orange hide" value="Submit" onclick="parent.jQuery.fancybox.getInstance().close();"/>
	</p>
</form> -->

<form id="uploadidentification" method="POST" enctype="multipart/form-data" style="font-family:caption-bold; background-color:#FFCC00; display: none;width:100%;max-width:500px; border-radius: 10px; border: 3px solid #E25F2A;" >
	<input type="text" value="<?php echo $code; ?>" name="labelCode" hidden readonly required />
	<input type="text" value="<?php echo $id; ?>" name="labelId" hidden readonly required />
	<div style="text-align:center" class="mb-35">
		<img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png" style="width:40px;height:40px;" />
	</div>
	<h2 class="mb-3" style="text-align:center; font-family: caption-bold">
		UPLOAD IDENTIFICATION
	</h2>
	<p style="font-family: caption-bold">
		Our return-item process if fully automated. No manual human process is involved. This ensures complete privacy.<br>Please, upload your identification document. (Drivers license or passport).
	</p>
	<p>
		<div style="text-align:center; padding:10px; font-family: caption-bold">
			<label class="fileContainer mb-10">
				UPLOAD DOCUMENT
				<input type="file" name="idfile" id="idfile" accept="image/jpg, image/jpeg, image/png, image/tiff, application/pdf" capture="user" required />
			</label>
		</div>
	</p>
	<p>
		YOUR DOCUMENT IS ENCRYPTED PROCESSED AND WE DO NOT STORE THIS DOCUMENT.<br><br>MORE INFORMATION ABOUT OUR SECURITY AND GDPR IS AVAILABLE IN OUR LEGAL SECTION.
	</p>
	<p class="mb-0 text-right">
		<input type="button" onclick="uploadIdentification('uploadidentification')" class="button button-orange" value="SEND" data-fancybox-close />
	</p>
</form>

<form id="uploadUtilityBill" method="POST" enctype="multipart/form-data" style="font-family:caption-bold; background-color:#FFCC00; display: none;width:100%;max-width:500px; border-radius: 10px; border: 3px solid #E25F2A;" >
	<input type="text" name="labelCode" value="<?php echo $code; ?>" hidden readonly required />
	<input type="text" name="labelId" value="<?php echo $id; ?>" hidden readonly required />
	<div style="text-align:center" class="mb-35">
		<img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqsiconlogonew.png" style="width:40px;height:40px;" />
	</div>
	<h2 class="mb-3" style="text-align:center; font-family: caption-bold">
		UPLOAD UTILITY BILL
	</h2>
	<p>
		OUR RETURN-ITEM PROCESS IF FULLY AUTOMATED. NO MANUAL HUMAN PROCESS IS INVOLVED. THIS ENSURES COMPLETE PRIVACY.<BR>THE UTILITY BILL NEEDS TO HAVE YOUR NAME AND COMPLETE ADDRESS, AND IT NEEDS TO BE FROM A VIABLE SOURCE (ELECTRA-, GAS-, WATER-COMPANY AND/OR TAX-DEPARTMENT.)
	</p>
	<div style="text-align:center; padding:10px; font-family: caption-bold">
		<label class="fileContainer mb-10">
			UPLOAD DOCUMENT
			<input type="file" name="ubfile" required accept="image/jpg, image/jpeg, image/png, image/tiff, application/pdf" capture="user" />
		</label>
	</div>
	<p>
		Your document is encrypted processed and we do not store this document.<br><br>More information about our security and GDPR is available in our legal section.
	</p>
	<p class="mb-0 text-right">
		<input type="button" onclick="uploadUtilityBill('uploadUtilityBill')" class="button button-orange" value="SEND"  data-fancybox-close />
	</p>
</form>
