<div class="main-wrapper background-yankee"  style="text-align:center">
	<div class="col-half background-yankee align-center height-75">
		<div class="flex-column align-center">
			<h2 class="heading mb-35"><?php echo $this->language->line("FOUNDCLAIM-010",'GET YOUR ITEM BACK.');?></h2>
			<div class="grid-image">
				<label class="thumbnail-file">
					<?php if (!empty($image)){ ?>
						<img src="<?php echo $this->baseUrl; ?>uploads/LabelImages/<?php $userId?>-<?php $code;?>-<?php $image;?>">
					<?php } else { ?>
						<img src="<?php echo $this->baseUrl; ?>uploads/default.jpg">
					<?php }?>
				</label>
			</div>
			<p>
				<?php echo $this->language->line("FOUNDCLAIM-030",'WITH THE ITEM TAG-CODE');?>
			</p>
			<?php include_once APPPATH . 'views/includes/sessionMessages.php' ?>
			<div class="flex-row align-space">
				<div class="flex-column align-space">
					<form action="<?php echo $this->baseUrl; ?>foundregisterclaim" method="post" id="foundRegister">
						<!-- HIDDEN FILEDS -->
						<input type="text" value="2" name="user[roleId]" readonly required hidden />
						<?php if (empty($code)) { ?>
							<div>
								<p><?php echo $this->language->line("FOUNDCLAIM-040",'PLEASE ENTER THE UNIQUE CODE IDENTIFYING  THE ITEM ');?></p>
							</div>
							<div class="form-group has-feedback" style="font-family: caption" >
								<input style="border-radius:50px" type="text" class="form-control" placeholder="Code" name="code" required/>
							</div>
						<?php } else { ?>
							<h1 style="font-family: caption-bold"> <?php $code; ?><br></h1>
							<input type="text" name="code" value="<?php echo $code ?>" readonly required hidden />
						<?php } ?>
						<p>
							<?php echo $this->language->line("FOUNDCLAIM-060",'THE PROCESS TO START RETURNING THE ITEM TO YOU, REQUIRES ADDITIONAL INFO');?>
						</p>

						<a href="<?php echo $this->baseUrl; ?>whatislostisfound" class="button button-orange"><?php echo $this->language->line('CLAIMFOUND-CC101012','NOT YOUR ITEM GO BACK');?></a>
						<h2 style="font-family: caption-bold"> <?php echo $this->language->line("FOUNDCLAIM-070",'HOW IT WORKS');?></h2>
						<p>
							<?php echo $this->language->line("FOUNDCLAIM-080",'WE NEED YOUR MOBILE PHONE NUMBER, TO CONTACT YOU');?>
						</p>
						<div class="form-group has-feedback" style="font-family: caption" >
							<input type="tel" class="form-control" style="font-family:caption-light; border-radius: 50px" placeholder="<?php echo $this->language->line("FOUNDCLAIM-090"," Mobile ");?>" name="user[mobile]"  />
						</div>
						<p>
							<?php echo $this->language->line("FOUNDCLAIM-100",'WE NEED YOUR E-MAIL, TO KEEP YOU INFORMED');?>
						</p>
						<div class="form-group has-feedback" style="font-family: caption" >
							<input type="email" id="email" name="user[email]" required onblur="checkEmail(this)"  class="form-control" placeholder="<?php echo $this->language->line("FOUNDCLAIM-110"," Email ");?>" style="font-family:caption-light; border-radius: 50px" />
						</div>
						<p>
							<?php echo $this->language->line("FOUNDCLAIM-180",'VERIFY YOUR E-MAIL ADDRESS');?>
						</p>
						<div class="form-group has-feedback" style="font-family: caption" >
							<input type="email" id="emailverify" name="emailverify" required class="form-control" placeholder="<?php echo $this->language->line("FOUNDCLAIM-190"," Repeat email for verification ");?>"  style="font-family:caption-light; border-radius: 50px"  />
							<br/>
						</div>
						<div class="login-box">
							<p id="UnkownAddressText" style="font-family:'caption-light'; display:none; font-size:100%; color:#ffffff;  text-align: center">
								<?php echo $this->language->line("FOUNDCLAIM-120",'WHERE DO WE SENT THE ITEM TO? PLEASE STATE YOUR NAME AND ADDRESS. YOUR NAME AND ADDRESS IS ENCRYPTED AND SECURED STORED. WE DO NOT ASK (SHOW) THIS AGAIN, FOR SECURITY REASONS. CHANGE OF ADDRESS CAN ONLY BE DONE IN YOUR PERSONAL PROFILE. YOUR CREDENTIALS HAVE BEEN SEND BY SEPARATE MAIL (PLEASE CHECK YOUR SPAM FOLDER). ');?>
								<br/>
								<br/>
							</p>
						</div>
						<div class="form-group has-feedback">
							<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUNDCLAIM-121",'Name');?>" id="username" name="user[username]" disabled/>
						</div>
						<div class="form-group has-feedback">
							<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUNDCLAIM-122",'Address');?>" id="address" name="user[address]" disabled />
						</div>
						<div class="form-group has-feedback">
							<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUNDCLAIM-123",'Extra address line');?>" id="addressa" name="user[addressa]" disabled />
						</div>
						<div class="form-group has-feedback">
							<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUNDCLAIM-1249",'zipcode');?>" id="zipcode" name="user[zipcode]" disabled />
						</div>
						<div class="form-group has-feedback">
							<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUNDCLAIM-124",'City');?>" id="city" name="user[city]" disabled />
						</div>
						<div class="selectWrapper mb-35" style="display: none" id="country1">
							<select class="selectBox" id="country" name="user[country]" style="display: none; font-family:'caption-light';" disabled >
								<?php include_once FCPATH . 'application/views/includes/countrySelectOptions.php'; ?>
							</select>
						</div>
						<div class="clearfix"></div>
						<input type="button" onclick="checkValuesAndSubmit('foundRegister', 'email', 'emailverify')" class="button button-orange" value="<?php echo $this->language->line("FOUNDCLAIM-200",'CLAIM YOUR ITEM');?>" />
					</form>
					<div class="mobile-hide" style="text-align:center; margin-top: 30px; margin-bottom: 50px; margin-left: 100px">
						<img src="<?php echo $this->baseUrl; ?>assets/home/images/Mobilephone.png" alt="tiqs" width="125" height="250" />
						<div class="mobile-hide" style="margin-left: 150px; margin-top: -30px; margin-bottom: 0px">
							<img src="<?php echo $this->baseUrl; ?>assets/home/images/StickerNew.png" alt="tiqs" width="125" height="50" />
						</div>
					</div>
					<div class="text-left mt-35 mobile-hide" style="margin-left: 100px; margin-bottom: 0px;  margin-top: -30px">
						<div class="text-left">
							<img style="margin-left: 70px; margin-bottom: -10px" src="<?php echo $this->baseUrl; ?>assets/home/images/Keychain.png" alt="tiqs" width="90" height="40" />
							<div>
								<img style="margin-left: -10px; margin-bottom: 30px;  margin-top: 0px" src="<?php echo $this->baseUrl; ?>assets/home/images/TIQSKeys.png" alt="tiqs" width="200" height="150" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-half background-yellow timeline-content">
		<div class="timeline-block background-yellow">
			<span class='timeline-number text-orange hide-mobile'>1</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-green show-mobile'>1</span>
					<h2 style="font-weight:bold; font-family: caption-bold">YOU ARE CLAIMING THIS ITEM BACK (IMAGE)</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">THIS IS THE FIRST STEP IN THE LOST AND FOUND PROCESS, PLEASE CHECK THAT THIS IS A RIGHTFUL CLAIM AND THE ITEM IS YOURS!.</p>
				<div class="flex-column align-space">
					<!--					<p class="text-content-light" style="font-weight: bold">LOST BY YOUR CUSTOMER, <br>RETURNED BY US.							</p>-->
					<div class="videos" id="timeline-video-3">
						<div style="padding:56.25% 0 0 0;position:relative;">
							<iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" allow="autoplay; fullscreen" allowfullscreen=""></iframe>
						</div>
					</div><!-- time line video for third block -->
					<div style="text-align:center">
						<span class="button button-orange mb-25" onclick="playThisVideo(this)">LEARN MORE VIDEO</span>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-orange-light">
			<span class='timeline-number text-orange hide-mobile'>2</span>
			<div class="timeline-text">
				<div class='timeline-heading'>
					<span class='timeline-number text-blue show-mobile'>2</span>
					<h2 style="font-weight:bold; font-family: caption-bold">YOUR E-MAIL ADDRESS IS MANDATORY</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">WHEN YOU ARE NOT REGISTERED IN TIQS LOST AND FOUND BY THIS E-MAIL ADDRESS WE WILL ASK YOUR FYSICAL ADDRESS. THIS IS THE ADDRESS WHERE THE ITEM WILL BE SEND TO.</p>
				<div class="flex-column align-space">
					<!--					<p class="text-content-light" style="font-weight: bold">LOST BY YOUR CUSTOMER, <br>RETURNED BY US.</p>-->
					<div class="videos" id="timeline-video-4">
						<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" allow="autoplay; fullscreen" allowfullscreen=""></iframe></div>
					</div><!-- time line video for fourth block -->
					<div style="text-align:center">
						<span class="button button-orange mb-25" onclick="playThisVideo(this)">LEARN MORE VIDEO</span>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-green-environment">
			<span class='timeline-number text-orange hide-mobile'>3</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-apricot show-mobile'>3</span>
					<h2 style="font-weight:bold; font-family: caption-bold">PLEASE READ CAREFULLY THE TERMS AND CONDITIONS THAT APPLY TO THE CLAIM YOU ARE MAKING</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">WE CARE ABOUT YOUR PRIVACY AND SECURITY. IN ORDER TO AVOID ANY FRAUD WE THEREFORE NEED TO CHECK YOUR CLAIM. </p>
				<div class="flex-column align-space">
					<div style="text-align:center">
						<a href="#" class="button button-orange mb-25">LEARN MORE VIDEO</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-yellow timeblock-last">
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-blue show-mobile'>4</span>
					<h2 style="font-weight:bold; font-family: caption-bold">FREQUENTLY ASKED QUESTIONS</h2>
				</div>
				<p class="text-content-light" style="font-size: larger">MOST QUESTIONS AND ANSWERS IN ONE PAGE.</p>
				<!--<span class="cd-date">Feb 18</span>-->
				<div class="flex-column align-space">
					<div style="text-align:center">
						<a href="#" target="_blank" class="button button-orange mb-25">LEARN MORE VIDEO</a>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
	</div>
</div>
