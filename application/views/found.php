<div class="main-wrapper">
	<div class="col-half background-yankee height-100">
		<div class="flex-column align-start">
			<div style="text-align:center;">
				<h2 class="heading mb-35">
					YOU FOUND SOMETHING?,
					<?php echo $this->language->line("FOUND-010","LET'S GET THIS ITEM BACK TO THE RIGHTFUL OWNER. ");?>
				</h2>
			</div>
			<div style="text-align:center; margin-bottom: 30px">
				<?php echo $this->language->line("FOUND-020",'TO GET THE ITEM YOU FOUND BACK TO TH RIGHTFUL OWNER WE NEED SOME INFORMATION TO MAKE THIS HAPPEN.');?>
				<p class="text-content-light" style="font-size: 24px; padding-top: 10px" >
					LOST AND FOUND, RETURNED WITH YOUR HELP.
				</p>
			</div>
			<?php include_once FCPATH . 'application/views/includes/sessionMessages.php'; ?>
			<form id="foundItem" action="<?php echo $this->baseUrl . $action; ?>" method="post" style="text-align:center;">
				<?php if ($code) { ?>					
					<input type="text" readonly value="<?php echo $code; ?>" name="code" hidden />
				<?php } ?>
				<?php if (isset($userId)) { ?>					
					<input type="text" readonly value="<?php echo $userId; ?>" name="userId" hidden />
				<?php } ?>
				<?php if (isset($userfoundId)) { ?>					
					<input type="text" readonly value="<?php echo $userfoundId; ?>" name="userfoundId" hidden />
				<?php } ?>
				<div style="text-align:center;">
					<img src="<?php echo $this->baseUrl; ?>tiqsimg/StickerMockup.png" alt="tiqs" width="250" height="90" />
					<?php if (!$code) { ?>
						<div style="text-align:center; font-family:caption-light; padding: 10px">
							<input type="text"  required name="code" class="form-control" placeholder="<?php echo $this->language->line("FOUND-01030",'Unique code from sticker or tag');?>" style="border-radius: 50px" />
						</div>
						<div style="text-align: center;">
							<a href=" <?php echo $this->baseUrl . 'itemfound'; ?>" class="button button-orange">
								<?php echo $this->language->line("FOUND-01032",'NO TAG? PLEASE MAKE A PICTURE');?>
							</a>
						</div>
					<?php } else { ?>
					<h2><?php echo $code; ?></h2>
					<?php } ?>
				</div>
				<?php if(!isset($_SESSION['userId'])) { ?>
				<div style="text-align:center; font-family:caption-light; padding: 10px">
					<p style="font-family: caption-light">
						<?php echo $this->language->line("FOUND-050",'PLEASE STATE YOUR MOBILE NUMBER AND/OR E-MAIL. (WE WILL NOT SHARE THIS INFO WITH THE OWNER UNLESS YOU CONSENT TO THIS BY CHECKING THE GDPR AND SHARE CHECKBOX BELOW. )');?>
						<br>
					</p>
				</div>
				<div style="font-family:caption-light; padding: 10px">
					<input type="tel" class="form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="Mobile" name="mobile" required />
				</div>
				<div style="font-family:caption-light; padding: 10px">
					<input type="email" id="email" name="email" required onblur="checkEmail(this)" class="form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="<?php echo $this->language->line("FOUND-070",'Your e-mail');?>" />
				</div>
				<div style="font-family:caption-light; padding: 10px">
					<input type="email" id="emailverify" name="emailverify" required class="form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="Repeat email for verification" />
				</div>
				<div style="font-family:caption-light; padding: 10px">
					<p id="UnkownAddressText" style="font-family:'caption-light'; display:none; text-align: center">
						<?php echo $this->language->line("FOUND-080",'WHERE CAN WE LET DHL EXPRESS COLLECT THE FOUND ITEM?<br/> YOU CAN HAVE DHL EXPRESS COLLECT THE FOUND ITEM AT A GIVEN TIME AT YOUR ADDRESS,PLEASE STATE YOUR NAME, HOME OR OTHER PHYSICAL ADDRESS. WHEN YOUR NAME AND ADDRESS HAS BEEN FILED, WE DO NOT ASK (SHOW) THIS AGAIN, FOR SECURITY REASONS. CHANGE OF ADDRESS CAN BE DONE IN YOUR PERSONAL PROFILE, WHEN SECURELY LOGGED IN, YOUR CREDENTIALS HAVE BEEN SEND BY SEPARATE MAIL, TO THE GIVEN E-MAIL ACCOUNT IN THIS SCREEN.');?>
					</p>
				</div>
				<div style="font-family:caption-light; padding: 10px;" id="label1">
					<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUND-090",'Name');?>" id="username" name="username" disabled />
				</div>
				<div style="font-family:caption-light; padding: 10px;" id="label2">
					<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUND-100",'Address');?>" id="address" name="address"  disabled />
				</div>
				<div style="font-family:caption-light; padding: 10px;" id="label3">
					<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUND-110",'Extra address line');?>" id="addressa" name="addressa"  disabled />
				</div>
				<div style="font-family:caption-light; padding: 10px;" id="label4" >
					<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUND-120",'Zipcode');?>" id="zipcode" name="zipcode" disabled />
				</div>
				<div style="font-family:caption-light; padding: 10px;" id="label5">
					<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUND-130",'City');?>" id="city" name="city" disabled />
				</div>
				<div style="font-family:caption-light; padding: 10px;" id="label6">
					<div class="selectWrapper" style="display: none; padding: 10px" id="country1">
						<select class="selectBox" id="country" name="country" style="font-family: caption-light';" disabled>
							<?php include_once FCPATH . 'application/views/includes/countrySelectOptions.php'; ?>
						</select>
					</div>
				</div>
				<div class="login-box" style="text-align:center;">
					<p style="font-family:'caption-light'; font-size:100%; color: #fff9df; text-align: center">
						<?php echo $this->language->line("FOUND-160",'I GIVE MY CONSENT (GDPR PRIVACY) THAT THE OWNER CAN DIRECTLY CONTACT ME. ');?>
					</p>
					<div class="form-group has-feedback" style="text-align:center;">
						<div class="onoffswitch" style="text-align:center;">
							<input type="checkbox" name="consentdirectcontact" class="onoffswitch-checkbox" id="consentdirectcontact">
							<label class="onoffswitch-label" for="consentdirectcontact">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</div>
				<?php } ?>
 				<p>
					<br>
					<?php echo $this->language->line("FOUND-170",'THE OWNER MAY HAVE SET A FINDERS FEE. AFTER THE ITEM HAS RETURNED TO THE RIGHTFUL OWNER, THE FINDERS FEE WILL BE TRANSFERRED TO YOUR BANK ACCOUNT. YOUR BANK DETAILS CAN BE SECURELY SUBMITTED IN YOUR PROFILE CREDENTIALS ARE SEND BY E-MAIL (PLEASE CHECK YOUR SPAM)');?>
					<br>
				</p>
				<div class="form-group has-feedback" style="padding: 30px;">
					<div style="text-align: center; ">
						<input type="button" onclick="checkValuesAndSubmit('foundItem', 'email', 'emailverify')"  class="button button-orange" value="<?php echo $this->language->line("FOUND-180",'SUBMIT FOUND ITEM');?>" style="border: none" />
					</div>
					<br>
				</div>
				<div class="clearfix"></div>
				<div class="row login-box" style="text-align:center; padding:0px ">
					<img src="<?php echo $this->baseUrl; ?>tiqsimg/tiqslogonew.png" alt="tiqs" width="125" height="45" />
				</div>
				<div class="text-center mt-50 mobile-hide login-box">
					<img src="<?php echo $this->baseUrl; ?>assets/home/images/TIQSWallet.png" alt="tiqs" width="250" height="200" />
				</div>
			</form>
		</div>
	</div>
	<div class="col-half background-apricot timeline-content">
		<div class="timeline-block background-orange">
			<span class='timeline-number text-orange hide-mobile'>1</span>
			<div class="timeline-text">
				<div class='timeline-heading'>
					<h2 style="font-weight:bold; font-family: caption-bold">REGISTER THE FOUND ITEM</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">THANK YOU FOR USING THE TIQS LOST AND FOUND SERVICE. PLEASE REGISTER THE FOUND ITEM ON THIS PAGE. WHEN THE FOUND ITEM HAS A TIQS-TAG-STICKER JUST TYPE IN THE CODE (CASE_SENSITIVE APPLIES).</p>
				<p class="text-content-light">NO TIQS-CODE ON THE FOUND ITEM, YOU CAN MAKE A PICTURE AND WE ASSIGN A TIQS-CODE TO IT.</p>
				<div class="flex-column align-space">
					<p class="text-content-light" style="font-weight: bold">FOUND BY YOU, <br>RETURNED WITH A LITTLE HELP. </p>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-blue">
			<span class='timeline-number text-blue hide-mobile'>2</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<h2 style="font-weight:bold; font-family: caption-bold">WE NEED YOUR CONTACT DETAILS</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">IN ORDER TO COLLECT THE FOUND ITEM WE NEED SOME INFORMATION WHERE TO COLLECT THE ITEM. </p>
				<div class="flex-column align-space">
					<div id="timeline-video-2" class="">
						<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" allow="autoplay; fullscreen" allowfullscreen=""></iframe></div>
					</div>
					<div style="text-align:center;">
						<a class="button button-orange mb-25" id="show-timeline-video-2">SHOW ME THE INTRODUCTION</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-green">
			<span class='timeline-number text-green hide-mobile'>3</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<h2 style="font-weight:bold; font-family: caption-bold">YOU WANT THE OWNER TO CONTACT YOU DIRECTLY</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">WHEN THE OWNER IS A MEMBER OF THE LOST AND FOUND COMMUNITY (TIQS-TAGS AND STICKER REGISTRATION) YOU CAN DIRECTLY CONTACT THE OWNER IF YOU WISH TO. THAT COULD BE HELPFUL BUT WE ALSO WANT TO BE SURE THAT IT IS SAVE TO DO SO. </p>
				<div class="flex-column align-space">
					<div id="timeline-video-3">
						<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" allow="autoplay; fullscreen" allowfullscreen=""></iframe></div>
					</div><!-- time line video for third block -->
					<div style="text-align:center;">
						<!--                                href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->
						<a href="#" class="button button-orange mb-25" id="show-timeline-video-3">SAFETY RULES FIRST</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-yankee">
			<span class='timeline-number text-blue hide-mobile'>4</span>
			<div class="timeline-text">
				<div class='timeline-heading'>
					<h2 style="font-weight:bold; font-family: caption-bold">GET YOUR REWARD</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">AS A TRUE HELPFUL PERSON WE WOULD LIKE TO REWARD YOU. OPTIONAL A FINDERS FEE COULD BE SET. THE FINDERS FEE IS NEVER PAID IN PERSON OR CASH. SAFETY FIRST! WE WOUOLD NOT LIKE TO HAVE OUR USERS GOING WITH CASH ON THE STREET. THEREFORE WE TRANSFER THE MONEY IF APPLICABLE INTO YOUR ACCOUNT AFTER THE OWNER HAS CONFIRMED THE RECEIPT OF THE ITEM.   </p>
				<div class="flex-column align-space">
					<p class="text-content-light" style="font-weight: bold">LOST BY YOUR CUSTOMER, <br>RETURNED BY US.</p>
					<div id="timeline-video-4">
						<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" allow="autoplay; fullscreen" allowfullscreen=""></iframe></div>
					</div><!-- time line video for fourth block -->
					<div style="text-align:center;">
						<!-- href="https://tiqs.com/lostandfound/menuapp target="_blank"" -->
						<a class="button button-orange mb-25" id="show-timeline-video-4">HOW TO REGISTER FOUND ITEMS</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-apricot">
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-apricot show-mobile'>5</span>
					<h2 style="font-weight:bold; font-family: caption-bold">NEED SOME HELP?</h2>
				</div>
				<div>
					<iframe src="https://tiqs.com/backoffice/forms/ticket" style="text-align:center; width: 100%; height: 100%; min-height: 900px" frameborder="0"></iframe>
				</div>
			</div>
		</div><!-- end timeline block -->
	</div><!-- time-line -->
</div>
