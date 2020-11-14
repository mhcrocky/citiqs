<div class="main-wrapper">
	<div class="col-half background-blue height-100">
		<div class="flex-column align-start">
			<div class="flex-row align-space">
				<div class="flex-column align-space">
					<div style="text-align:center">
						<p style="font-family:'caption-bold'; font-size:300%; color:#ffffff;">
						<h2 class="heading"> <?php echo $this->language->Line("registerbusiness-A1100",'REGISTER BUSINESS ACCOUNT.');?></h2>
						<?php include_once APPPATH . 'views/includes/sessionMessages.php' ?>
						<form action="<?php echo $this->baseUrl; ?>login/registerbusinessAction" method="post">
							<input type="text" name="IsDropOffPoint" value ='<?php echo $isDropOffPoint; ?>' readonly hidden required />
							<input type="text" name="roleId" value ='<?php echo $roleId; ?>' readonly hidden required />
							<input type="text" name="istype" value ='<?php echo $istype; ?>' readonly hidden required />
							<input type="text" name="createdBy" value ='<?php echo $createdBy; ?>' readonly hidden required />							
							<div>
								<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">
									<?php echo $this->language->Line("registerbusiness-1200",'Your business name');?>
									<br>
									<br/>
								</p>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="username" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->Line("registerbusiness-1300",'Hotel/(air)BnB/Event/Club-name/Bar');?>" />
								<span class="glyphicon glyphicon-user form-control-feedback"></span>
							</div>
							<div>
								<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">
									<?php echo $this->language->Line("registerbusiness-1400ac",'With a short name of your business and or event, your visitors can browse and find the');?>
									<?php echo $this->language->Line("registerbusiness-1500ac",'website, to claim their lost Items. The link will represent, the url:');?>
									<?php echo $this->language->Line("registerbusiness-1600ac",'Your shortname');?>
									<br/>
									<br/>
								</p>
							</div>
							<div class="form-group has-feedback">
								<input type="text" class="form-control" name="usershorturl"  required id="usershorturl" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->Line("registerbusiness-1700",'Your shortname');?>" name="usershorturl" pattern="[A-Za-z0-9]{1,20}" title="<?php echo $this->language->Line("registerbusiness-1800",'Only characters allowed, no spaces, points or special characters like @#$% and max 20 length');?>" />
								<span class="glyphicon glyphicon-user form-control-feedback"></span>
							</div>
							<div>
								<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin-bottom:10px; text-align: center">
									<?php echo $this->language->Line("registerbusiness-S20120A","Your business type");?>
								</p>
							</div>

							<div class="selectWrapper mb-35">
								<select class="selectBox" name="business_type_id" style="font-family:'caption-light';" required>
								<option value=""><?php echo $this->language->Line("registerbusiness-A200101A","Select business type");?></option>
								<?php foreach ($businessTypes as $type) { ?>
								<option value="<?php echo $type['id'] ?>"><?php echo ucfirst($type['busineess_type']); ?></option>
								<?php } ?>
								</select>
							</div>
							<div>
								<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin-bottom:10px; text-align: center">
									<?php echo $this->language->Line("registerbusiness-20120","Business VAT number");?>
								</p>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="vat_number" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->Line("registerbusiness-20120","Business VAT number");?>" />
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div>
								<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">
									<?php echo $this->language->Line("registerbusiness-1900",'Company e-mail');?>
									<br/>
									<br/>
								</p>
							</div>
							<div class="form-group has-feedback">
								<input type="email" name="email" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->Line("registerbusiness-2000","email");?>" />
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div>
								<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center"><?php echo $this->language->Line("registerbusiness-A2001A","
									Responsible person first name
									");?>
									<br/>
									<br/>
								</p>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="first_name" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder=<?php echo $this->language->Line("registerbusiness-A20011A","First name");?> />
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div>
								<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center"><?php echo $this->language->Line("registerbusiness-A20012A","
									Responsible person last name
									");?>
									<br/>
									<br/>
								</p>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="second_name" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder=<?php echo $this->language->Line("registerbusiness-A2001A","Last name");?> />
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div>
								<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">
									<?php echo $this->language->Line("registerbusiness-2100",'Company phone number');?>
									<br/>
									<br/>
								</p>
							</div>
							<div class="form-group has-feedback">
								<input name="mobile" type="tel" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->Line("registerbusiness-2200","Phone number");?>" required />
								<span class="glyphicon glyphicon-phone form-control-feedback"></span>
							</div>
							<div>
								<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">
									<?php echo $this->language->Line("registerbusiness-2300",'Choose a good unique password');?>
									<br/>
									<br/>
								</p>
							</div>
							<div class="form-group has-feedback">
								<input type="password" name="password"  required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->Line("registerbusiness-2400","Password");?>" />
							</div>
							<div class="form-group has-feedback">
								<input type="password" name="cpassword" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->Line("registerbusiness-2500"," Confirm Password ");?>" />
							</div>
							<div>
								<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">
									<?php echo $this->language->Line("registerbusiness-2600",'Your business address, this is the address where the');?> lost + found
									<?php echo $this->language->Line("registerbusiness-2700",'will be picked-up by DHL and/or customers, to repatriate the lost Items.');?>
									<br/>
									<br/>
								</p>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="address" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder=<?php echo $this->language->Line("registerbusiness-2800","Address");?> />
								<span class="glyphicon glyphicon-home form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input name="addressa"  type="text" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->Line("registerbusiness-2900"," Additional address line ");?>" />
								<span class="glyphicon glyphicon-home form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="text" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder=<?php echo $this->language->Line("registerbusiness-3000","Zipcode");?> name="zipcode" required />
								<span class="glyphicon glyphicon-home form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="text" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder=<?php echo $this->language->Line("registerbusiness-3100","City");?> name="city" required />
								<span class="glyphicon glyphicon-home form-control-feedback"></span>
							</div>
							<div class="selectWrapper mb-35">
								<select class="selectBox" name="country" style="font-family:'caption-light';" required>
									<?php include_once FCPATH . 'application/views/includes/countrySelectOptions.php'; ?>
								</select>
							</div>
							<?php if ($this->baseUrl !== "http://127.0.0.1/lostandfound/") {?>
							<div class="flex-column align-space">
								<div style="text-align:center">
									<div class="g-recaptcha" data-sitekey="6LfxY8oUAAAAANlllpeFQhGDE-SVgssfFNonhl7F"  data-callback="capenable" data-expired-callback="capenable" ></div>
								</div>
							</div>
							<?php } ?>

							<?php if ($this->baseUrl === "http://127.0.0.1/lostandfound/")  {?>
							<div class="form-group align-center mb-35 mt-50" >
								<p>
									<input type="submit" id="capsubmit" class="button button-orange" value="<?php echo $this->language->Line("registerbusiness-3300",'REGISTER ACCOUNT');?>" style="border: none" />
								</p>
							</div>
							<?php }?>

							<?php if ($this->baseUrl !== "http://127.0.0.1/lostandfound/")  {?>
							<div class="form-group align-center mb-35 mt-50" >
							<p>
								<input type="submit" id="capsubmit" style="display:none;" class="button button-orange" value="<?php echo $this->language->Line("registerbusiness-3300",'REGISTER ACCOUNT');?>" style="border: none" />
							</p>
							</div>
							<?php }?>
							
						</form>
						<div class="row" style="text-align:center; padding:0px ">
							<img src="<?php echo $this->baseUrl; ?>tiqsimg/tiqslogonew.png" alt="tiqs" width="125" height="45" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-half background-apricot timeline-content">
		<div class="timeline-block background-yankee">
			<span class='timeline-number text-orange hide-mobile'>1</span>
			<div class="timeline-text">
				<div class='timeline-heading'>
					<span class='timeline-number text-orange show-mobile'>1</span>
					<h2 style="font-weight:bold; font-family: caption-bold"><?php echo $this->language->Line("registerbusiness-A200133A","REGISTER");?></h2>
				</div>
				<p class="text-content-light" style="font-size: larger"><?php echo $this->language->Line("registerbusiness-A200134A","REGISTER AND RECEIVE AN E-MAIL WITH YOUR CREDENTIALS AND AN ACTIVATION LINK.");?></p>
				<!-- <p class="text-content-light">NO CREDENTIALS RECEIVED YET, WAIT A MINUTE AND PLEASE CHECK YOUR SPAM MAIL  </p>-->
				<div class="flex-column align-space">
				<!-- <p class="text-content-light" style="">LOST BY YOUR CUSTOMER, <br>RETURNED BY US.</p>-->
					<div class="videos" id="timeline-video-2">
						<div style="padding:56.25% 0 0 0;position:relative;">
							<iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" allow="autoplay; fullscreen" allowfullscreen=""></iframe>
						</div>
					</div>
					<div style="text-align:center">
						<span class="button button-orange mb-25" id="show-timeline-video-2" onclick="playThisVideo(this)"><?php echo $this->language->Line("registerbusiness-A200135A","LEARN MORE VIDEO");?></span>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="timeline-block background-blue-light">
			<span class='timeline-number text-orange hide-mobile'>2</span>
			<div class="timeline-text">
				<div class="timeline-heading">
					<span class='timeline-number text-blue show-mobile'>2</span>
					<h2 style="font-weight:bold; font-family: caption-bold"><?php echo $this->language->Line("registerbusiness-A200136A","ACTIVATE");?></h2>
				</div>
				<p class="text-content-light" style="font-size: larger"><?php echo $this->language->Line("registerbusiness-A200137A","ACTIVATE YOUR ACCOUNT WITH THE E-MAIL OR BY LOGIN-IN AND MANUALLY ACTIVATE YOUR ACCOUNT.");?> </p>
				<div class="flex-column align-space">
				<!-- <p class="text-content-light" >LOST BY YOUR CUSTOMER, <br>RETURNED BY US.</p>-->
					<div class="videos" id="timeline-video-3">
						<div style="padding:56.25% 0 0 0;position:relative;">
							<iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" allow="autoplay; fullscreen" allowfullscreen=""></iframe>
						</div>
					</div>
					<div style="text-align:center">
						<span  onclick="playThisVideo(this)" class="button button-orange mb-25" id="show-timeline-video-3"><?php echo $this->language->Line("registerbusiness-A200138A","LEARN MORE VIDEO");?></span>
					</div>
				</div>
			</div>
		</div><!-- end timeline block -->
		<div class="mobile-hide" style="text-align:center; margin-top: 50px; margin-bottom: 50px; margin-left: 50px">
			<img src="<?php echo $this->baseUrl; ?>assets/home/images/lostandfounditemswhite.png" alt="tiqs" width="500" height="auto" />
			<div class="mobile-hide" style="margin-left: 150px; margin-top: -20px; margin-bottom: 0px">
				<img src="<?php echo $this->baseUrl; ?>assets/home/images/StickerNew.png" alt="tiqs" width="125" height="auto" />
			</div>
		</div>
		<div class="text-left mt-50 mobile-hide" style="margin-left: 100px; margin-bottom: 100px;  margin-top: -30px">
			<div class="text-left mobile-hide" style="margin-left: 100px; margin-bottom: -40px; ">
				<img src="<?php echo $this->baseUrl; ?>assets/home/images/Keychain.png" alt="tiqs" width="110" height="50" />
			</div>
			<img src="<?php echo $this->baseUrl; ?>assets/home/images/TIQSKeys.png" alt="tiqs" width="250" height="200" />
			<div class="text-center mt-50 mobile-hide"  style="text-align:center">
				<img src="<?php echo $this->baseUrl; ?>assets/home/images/DHL_express.png" alt="tiqs" width="300" height="auto" />
			</div>
		</div>
	</div>
</div>
