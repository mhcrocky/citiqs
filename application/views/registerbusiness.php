<div class="background-blue">
<div class="main-wrapper-nh background-blue">
	<div class="col-half width-650 background-blue height-100" style="margin-top: 30px">
		<div class="flex-column align-start">
			<div style="text-align:center">
				<p style="font-family:'caption-bold'; font-size:300%; color:#ffffff;">
				<h2 class="heading"> <?php echo $this->language->tline('REGISTER YOUR BUSINESS.');?></h2>
				<?php include_once APPPATH . 'views/includes/sessionMessages.php' ?>
				<form
					id="registerBusinessForm"
					action="<?php echo $this->baseUrl; ?>login/registerbusinessAction"
					method="post"
					onsubmit="return registerNewBusiness('registerBusinessForm', 'password', 'repeatPassword')"
				>
					<input type="text" name="IsDropOffPoint" value ='<?php echo $isDropOffPoint; ?>' readonly hidden required />
					<input type="text" name="roleid" value ='<?php echo $roleId; ?>' readonly hidden required />
					<input type="text" name="istype" value ='<?php echo $istype; ?>' readonly hidden required />
					<input type="text" name="createdBy" value ='<?php echo $createdBy; ?>' readonly hidden required />
					<?php if (!empty($ambasadorId)) { ?>
						<input type="text" name="ambasadorId" value ='<?php echo $ambasadorId; ?>' readonly hidden required />
					<?php } ?>
					<div>
						<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">
							<?php echo $this->language->tline('Your business name');?>
							<br>
							<br/>
						</p>
					</div>
					<div class="form-group has-feedback">
						<input
							type="text"
							name="username"
							value="<?php echo get_cookie('username'); ?>"
							class="form-control"
							style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->tline('Hotel/(air)BnB/Event/Club-name/Bar');?>"
							data-form-check="1"
							data-error-message='Username is required'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
						/>
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<!--					<div>-->
					<!--						<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">-->
					<!--							--><?php //echo $this->language->Line("spot-registerbusiness-A1400ac",'With a short name of your business and or event, your visitors can browse and find the');?>
					<!--							--><?php //echo $this->language->Line("spot-registerbusiness-A1500ac",'website. The link will represent, the url:tiqs.com/presence/[yourshortname]');?>
					<!--							--><?php //echo $this->language->Line("spot-registerbusiness-A1600ac",'Your shortname');?>
					<!--							<br/>-->
					<!--							<br/>-->
					<!--						</p>-->
					<!--					</div>-->
					<!--					<div class="form-group has-feedback">-->
					<!--						<input-->
					<!--							type="text"-->
					<!--							class="form-control"-->
					<!--							name="usershorturl"-->
					<!--							value="--><?php //echo get_cookie('usershorturl'); ?><!--"-->
					<!--							id="usershorturl"-->
					<!--							style="font-family:'caption-light'; border-radius: 50px;"-->
					<!--							placeholder="--><?php //echo $this->language->Line("spot-registerbusiness-1700",'Your shortname');?><!--"-->
					<!--							pattern="[A-Za-z0-9]{1,20}" title="--><?php //echo $this->language->Line("spot-registerbusiness-1800",'Only characters allowed, no spaces, points or special characters like @#$% and max 20 length');?><!--"-->
					<!--							data-form-check="1"-->
					<!--							data-error-message='Shortname is required and can contain only alphabetic characters and digits'-->
					<!--							data-min-length="1"-->
					<!--							onblur='alertifyErrMessage(this)'-->
					<!--						/>-->
					<!--						<span class="glyphicon glyphicon-user form-control-feedback"></span>-->
					<!--					</div>-->
					<div>
						<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin-bottom:10px; text-align: center">
							<?php echo $this->language->Line("spot-registerbusiness-S20120A","Your business type");?>
						</p>
					</div>

					<div class="selectWrapper mb-35">
						<select
							class="selectBox"
							name="business_type_id"
							style="font-family:'caption-light';"
							data-form-check="1"
							data-error-message='Please select business type'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
						>
						<option value=""><?php echo $this->language->Line("spot-registerbusiness-A200101A","Select business type");?></option>
						<?php foreach ($businessTypes as $type) { ?>
						<option
							value="<?php echo $type['id'] ?>"
							<?php
								if (
									($type['id'] === get_cookie('business_type_id') && empty($businessTypeId))
									|| (!empty($businessTypeId) && $type['id'] === $businessTypeId)
								) {
									echo 'selected';
								}
							?>
						>
								<?php echo ucfirst($type['busineess_type']); ?>
						</option>
						<?php } ?>
						</select>
					</div>
					<div>
						<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">
							<?php echo $this->language->Line("spot-registerbusiness-1900",'Company e-mail');?>
						</p>
					</div>
					<div class="form-group has-feedback">
						<input
							type="email"
							name="email"
							value="<?php echo get_cookie('email'); ?>"
							class="form-control"
							style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->Line("spot-registerbusiness-2000","email");?>"
							data-form-check="1"
							data-error-message='Email is required'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
							oninput='checkIfsUserExists(this)'
						/>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div>
						<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center"><?php echo $this->language->Line("spot-registerbusiness-A2001A123","
							Responsible person first name
							");?>
						</p>
					</div>
					<div class="form-group has-feedback">
						<input
							type="text"
							name="first_name"
							value="<?php echo get_cookie('first_name'); ?>"
							class="form-control"
							style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->Line("spot-registerbusiness-A20011A","First name");?>"
							data-form-check="1"
							data-error-message='First name is required'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
						/>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div>
						<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center"><?php echo $this->language->Line("spot-registerbusiness-A20012A","
							Responsible person last name
							");?>
						</p>
					</div>
					<div class="form-group has-feedback">
						<input
							type="text"
							name="second_name"
							value="<?php echo get_cookie('second_name'); ?>"
							class="form-control"
							style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->Line("spot-registerbusiness-A2001A","Last name");?>"
							data-form-check="1"
							data-error-message='Last name is required'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
						/>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div>
						<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">
							<?php echo $this->language->Line("spot-registerbusiness-2100",'Company phone number');?>
						</p>
					</div>
					<div class="form-group has-feedback">
						<input
							name="mobile"
							value="<?php echo get_cookie('mobile'); ?>"
							type="tel"
							class="form-control"
							style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->Line("spot-registerbusiness-2200","Phone number");?>"
							data-form-check="1"
							data-error-message='Mobile phone is required and must have at least 6 digits'
							data-min-length="6"
							onblur='alertifyErrMessage(this)'
						/>
						<span class="glyphicon glyphicon-phone form-control-feedback"></span>
					</div>
					<div>
						<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">
							<?php echo $this->language->Line("spot-registerbusiness-2300",'Choose a good unique password');?>
						</p>
					</div>
					<div class="form-group has-feedback">
						<input
							type="password"
							name="password"
							id="password"
							class="form-control"
							style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->Line("spot-registerbusiness-2400","Password");?>"
							data-form-check="1"
							data-error-message='Password is required'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
						/>
					</div>
					<div class="form-group has-feedback">
						<input
							type="password"
							name="cpassword"
							id="repeatPassword"
							class="form-control"
							style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->Line("spot-registerbusiness-2500"," Confirm Password ");?>"
							data-form-check="1"
							data-error-message='Repeat password is required'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
						/>
					</div>
					<div>
					<!-- <p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">-->
					<!-- --><?php //echo $this->language->Line("spot-registerbusiness-2600",'Your business address, this is the address where the');?><!-- lost + found-->
					<!-- --><?php //echo $this->language->Line("spot-registerbusiness-2700",'will be picked-up by DHL and/or customers, to repatriate the lost Items.');?>
					<!-- <br/>-->
					<!-- <br/>-->
					<!-- </p>-->
					</div>
					<div class="form-group has-feedback">
						<input
							type="text"
							name="address"
							value="<?php echo get_cookie('address'); ?>"
							class="form-control" style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->Line("spot-registerbusiness-2800","Address");?>"
							data-form-check="1"
							data-error-message='Address is required'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
						/>
						<span class="glyphicon glyphicon-home form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input
							name="addressa"
							type="text"
							value="<?php echo get_cookie('addressa'); ?>"
							class="form-control"
							style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->Line("spot-registerbusiness-2900"," Additional address line ");?>"
						/>
						<span class="glyphicon glyphicon-home form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input
							type="text"
							class="form-control"
							style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->Line("spot-registerbusiness-3000","Zipcode");?>"
							name="zipcode"
							value="<?php echo get_cookie('zipcode'); ?>"
							data-form-check="1"
							data-error-message='Zipcode is required'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
						/>
						<span class="glyphicon glyphicon-home form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input
							type="text"
							class="form-control"
							style="font-family:'caption-light'; border-radius: 50px;"
							placeholder="<?php echo $this->language->Line("spot-registerbusiness-3100","City");?>"
							name="city"
							value="<?php echo get_cookie('city'); ?>"
							data-form-check="1"
							data-error-message='City is required'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
						/>
						<span class="glyphicon glyphicon-home form-control-feedback"></span>
					</div>
					<div class="selectWrapper mb-35">
						<select
							class="selectBox"
							name="country"
							style="font-family:'caption-light';"
							data-form-check="1"
							data-error-message='Please select country'
							data-min-length="1"
							onblur='alertifyErrMessage(this)'
						>
							<option value="">
								<?php echo $this->language->Line("CountrySelect-A2001A","Select country");?>
							</option>
							<?php foreach ($countries as $countryCode => $country) { ?>
								<option
									value="<?php echo $countryCode; ?>"
									<?php
										$selected = get_cookie('country');
										if ($selected && $selected === $countryCode) echo 'selected';
									?>
								>
									<?php echo $country; ?>
								</option>
							<?php } ?>
							<?php include_once FCPATH . 'application/views/includes/countrySelectOptions.php'; ?>
						</select>
					</div>
					<?php if (ENVIRONMENT !== 'development' ) { ?>
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
								<input
									onclick="registerNewBusiness('registerBusinessForm', 'password', 'repeatPassword')"
									id="capsubmit"
									class="button button-orange"
									value="<?php echo $this->language->Line("spot-registerbusiness-3300",'REGISTER ACCOUNT');?>"
									style="border: none"
								/>
							</p>
						</div>
						<?php } ?>

						<?php if ($this->baseUrl !== "http://127.0.0.1/lostandfound/")  {?>
						<div class="form-group align-center mb-35 mt-50" >
						<p>
							<input
								onclick="registerNewBusiness('registerBusinessForm', 'password', 'repeatPassword')"
								id="capsubmit"
								class="button button-orange"
								value="<?php echo $this->language->Line("spot-registerbusiness-3300",'REGISTER ACCOUNT');?>"
								style="border: none"
							/>
						</p>
						</div>
						<?php }?>
					<?php } else { ?>
						<div class="form-group align-center mb-35 mt-50" >
							<p>
								<input
									onclick="registerNewBusiness('registerBusinessForm', 'password', 'repeatPassword')"
									id="capsubmit"
									class="button button-orange"
									value="<?php echo $this->language->Line("spot-registerbusiness-3300",'REGISTER ACCOUNT');?>"
									style="border: none"
								/>
							</p>
						</div>
					<?php }?>
				</form>
				<div class="row" style="text-align:center; padding:0px ">
					<img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="125" height="45" />
				</div>
			</div>
		</div>
	</div>
<!--	<div class="col background-blue" style="margin-left: 0px ;margin-right: 0px; padding: 0px; width: 100%; margin-top: 50px">-->
<!--		<ul class="nav nav-tabs" style="border-bottom: none;background-color: #131e3a; margin-top: 10px;margin-bottom: 10px " role="tablist">-->
<!--			<li class="nav-item">-->
<!--				<a style="color: #efd1ba; border-radius: 50px; margin-left:10px" class="nav-link active" data-toggle="tab" href="#manual"> <i class="ti-pencil-alt"> </i> HOW TO REGISTER</a>-->
<!--			</li>-->
<!--		</ul>-->
<!---->
<!--		<div class="tab-content no-border" style="height: 90%; width: 100%">-->
<!--			<div id="manual" class="tab-pane active" style="background: none; height: 100%;margin-left: 0px ;margin-right: 0px; width:100%">-->
<!--				<embed src="--><?php //echo base_url(); ?><!--/assets/home/documents/NL-manual.pdf" height=100% width="100%">-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
</div>
</div>
