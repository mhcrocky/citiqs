<div class="main-wrapper" style="text-align:center">
	<div class="col-half background-blue height-100 align-center">
		<div class="flex-column align-start width-650">
			<div style="text-align:center">
				<form action="<?php echo $this->baseUrl; ?>profileUpdate" method="post" id="editProfile">
<!--					<input type="text" value="--><?php //echo $user->id; ?><!--" name="id" id="userId" readonly hidden required />-->
					<h2 class="heading mb-35"><?php echo $this->language->line("PROF-010",'YOUR PROFILE PAGE.');?></h2>
					<div class="flex-row align-space">
						<div class="flex-column align-space">
							<div class="form-group has-feedback">
								<p style="font-family: caption-light; padding: 10px">
									<?php echo $this->language->line("PROF-020",'Full Name');?>
								</p>
								<div class="form-group has-feedback">
									<input  value="<?php echo $user->username; ?>" name="username" required type="text" class="form-control" id="fname" style="border-radius: 50px; border:none" placeholder="<?php echo $name; ?>" maxlength="128" />
								</div>
							</div>
							<?php if ($user->IsDropOffPoint === '1') { ?>
							<div>
								<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin:0px; text-align: center">
									<?php echo $this->language->Line("registerbusiness-1600",'Your shortname');?>]
								</p>
							</div>
							<div class="form-group has-feedback">
								<input value="<?php echo $user->usershorturl; ?>" name="usershorturl" required type="text" class="form-control"  required id="usershorturl" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->Line("registerbusiness-1700",'Your shortname');?>" name="usershorturl" pattern="[a-z]{1,15}" title="<?php echo $this->language->Line("registerbusiness-1800",'Only [a-z] characters allowed (no capital), no spaces, points or special characters like @#$% and max 15 length');?>" />
							</div>
							<?php } ?>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-030",'Mobile Number (Country code + number e.g. 0031(country) 0123456789 (number) => 00310123456789)');?>
									</p>
									<div class="form-group has-feedback">
										<input name="mobile" value="<?php echo $user->mobile; ?>" required style="border-radius: 50px; border:none" type="text" class="form-control" id="mobile" placeholder="<?php echo $user->mobile; ?>" maxlength="20">
									</div>
								</div>
							</div>
							<?php if ($user->IsDropOffPoint === '1') { ?>
							<div>
								<p style="font-family: caption-light; padding: 10px">Business type</p>
								<div class="selectWrapper mb-35">
									<select class="selectBox" name="business_type_id" style="font-family:'caption-light';" required>
									<option value="">Select business type</option>
									<?php foreach ($businessTypes as $type) { ?>
									<option <?php if($type['id'] === $user->business_type_id) echo 'selected'; ?> value="<?php echo $type['id'] ?>">
									<?php echo ucfirst($type['busineess_type']); ?>
									</option>
									<?php } ?>
									</select>
								</div>
							</div>
							<div>
								<p style="font-family: caption-light; padding: 10px">
									VAT number
								</p>
							</div>
							<div class="form-group has-feedback">
								<input type="text" value="<?php echo $user->vat_number; ?>" name="vat_number" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="Business VAT number" />
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<?php } ?>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-031","Your E-mail address");?>
									</p>

									<div class="form-group has-feedback">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="email" name="email" placeholder="<?php echo $user->email; ?>" value="<?php echo $user->email; ?>" required />
									</div>
								</div>
							</div>
							<?php if ($user->IsDropOffPoint === '1') { ?>
							<div>
								<p style="font-family: caption-light; padding: 10px">
									Responsible person first name
								</p>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="first_name" value="<?php echo $user->first_name; ?>" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="First name" />
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div>
								<p style="font-family: caption-light; padding: 10px">
									Responsible person last name
								</p>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="second_name" value="<?php echo $user->second_name; ?>" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="Last name" />
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<?php } ?>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-032","Address");?>
									</p>
									<div class="form-group has-feedback">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="addres" name="address" placeholder="<?php echo $user->address; ?>" value="<?php echo $user->address; ?>" maxlength="128" />
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-033","Additional address line");?>
									</p>
									<div class="form-group has-feedback">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="addressa" name="addressa" placeholder="<?php echo $user->addressa; ?>" value="<?php echo $user->addressa; ?>" maxlength="128" />
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-034","Zipcode");?>
									</p>
									<div class="form-group">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="zipcode" name="zipcode" placeholder="<?php echo $user->zipcode; ?>" value="<?php echo $user->zipcode; ?>" maxlength="128" />
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-035","City");?>
									</p>

									<div class="form-group has-feedback">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="city" name="city" placeholder="<?php echo $user->city; ?>" value="<?php echo $user->city; ?>" maxlength="128" />
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">Country</p>
									<div class="form-group has-feedback selectWrapper mb-35">
										<select class="selectBox" name="country" style="font-family:'caption-light';" required>
											<?php foreach ($countries as $code => $country) { ?>
											<option value="<?php echo $code; ?>" <?php if ($code === $user->country) echo 'selected'; ?> >
												<?php echo $country; ?>
											</option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group has-feedback" style="padding: 30px;">

								<div style="text-align: center; ">
									<input type="submit" class="button button-orange" value="<?php echo $this->language->line("PROF-040 ",'SAVE');?>" style="border: none" />
								</div>

							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="col-half background-blue timeline-content">
		<div class="pricing-block background-orange-light" id="starterSection">
			<div class="pricing-block-body">
				<div class="pricing-first" style="font-family: caption-bold">
					<h2 style="font-family: caption-bold">STARTER</h2>
					<h6 style="font-family: caption-light">PRICE PER YEAR</h6>
					<h1 style="font-family: caption-light">€ 89,95</h1>
					<p style="font-family: caption-light">STRAIGHT FORWARD ONE FEE PER YEAR, NO EXTRA COST</p>
				</div>
				<div class="pricing-second">
						<p>
							< 200 ITEMS TO REGISTER
						</p>
						<p>
							FULL WEBSITE INTEGRATION
						</p>
						<p>
							100 TIQS LOST AND FOUND BAGS (INCLUDED)
						</p>
						<p>
							SET RETURN FEE, FOR EARNINGS/COMPENSATION
						</p>

				</div>
			</div><!-- end pricing block body -->
			<div class="pricing-block-footer mt-50" >
				<a data-brackets-id="2918" href="#starterSection"
					<?php if ($_SESSION['dropoffpoint'] !== '0') { ?>
					onclick="sendInvoice('<?php echo $user->id; ?>', '<?php echo $starter; ?>')"
					<?php } ?>
					class="button button-orange">
					<img src="pay.png" alt="">
					SEND ME AN INVOICE
				</a>
			</div>
		</div><!-- end pricing block -->
		<div class="pricing-block background-orange" id="basicSection">
			<div class="pricing-block-body">
				<div class="pricing-first" style="font-family: caption-bold">
					<h2 style="font-family: caption-bold">BASIC</h2>
					<h6 style="font-family: caption-light">PRICE PER MONTH</h6>
					<h1 style="font-family: caption-bold">€ 9,95</h1>
					<p style="font-family: caption-light">STRAIGHT FORWARD FEE PER MONTH EASY REGISTRATION OF UNLIMTED ITEMS</p>
				</div>
				<div class="pricing-second">
					<ul >
						<li>
							MOST CHOSEN OPTION
						</li>
						<li>
							PER E-MAIL ACCOUNT
						</li>
						<li>
							UNLIMITED ITEMS
						</li>
						<li>
							NOTIFICATION BY E-MAIL, SMS AND IM
						</li>
						<li>
							RETURN FEE DISCOUNT 10%
						</li>
					</ul>
				</div>
			</div><!-- end pricing block body -->
			<div class="pricing-block-footer">
				<a data-brackets-id="2918" href="#basicSection"
					<?php if ($_SESSION['dropoffpoint'] !== '0') { ?>
					onclick="sendInvoice('<?php echo $user->id; ?>', '<?php echo $basic; ?>')"
					<?php } ?>
					class="button button-orange">
					<img src="pay.png" alt="">
					SEND ME AN INVOICE
				</a>
			</div>
		</div><!-- end pricing block -->

		<div class="pricing-block background-purple-light" id="extremeSection">
			<div class="pricing-block-body">
				<div class="pricing-first" style="font-family: caption-bold">
					<h2 style="font-family: caption-bold">EXTREME</h2>
					<h6 id="pricePeriod" style="font-family: caption-light; text-transform: capitalize;"></h6>
					<h1 id="periodPrice" style="font-family: caption-light"></h1>
					<p style="font-family: caption-light">STRAIGHT FORWARD ONE FEE PER YEAR EASY REGISTRATION</p>
				</div>
				<div class="pricing-second">
					<ul >
						<li>
							PER E-MAIL ACCOUNT
						</li>
						<li>
							UNLIMITED ITEMS
						</li>
						<li>
							NOTIFICATION ONLY BY E-MAIL
						</li>
						<li>
							RETURN FEE DISCOUNT 5%
						</li>
					</ul>
				</div>
			</div><!-- end pricing block body -->
			<div class="pricing-block-footer">
				<!-- onclick="sendInvoice(this)" -->
				<a
					id="sendExtremeInvoice"
					data-itemid = '';
					<?php if ($_SESSION['dropoffpoint'] !== '0') { ?>
					onclick="sendExtremeInvoice(this,'<?php echo $user->id; ?>')"
					<?php } ?>
					data-brackets-id="2918" 
					href="#extremeSection"
					class="button button-orange"><img src="pay.png" alt="">SEND ME AN INVOICE</a>
					
			</div>
			<br/>
			<br/>
			<div
				class="form-group has-feedback selectWrapper"
				style="background-color: #fff; width: 60%; margin-left:20%; margin-top:20px;">
				<select
					id="period" 
					<?php if ($_SESSION['dropoffpoint'] !== '0') { ?>
					onchange="setIdForCrm('period', 'quantity')"
					<?php } ?>
					style="font-family:'caption-light'; color: #E25F2A; font-weight:900; border: #fff; background-color: #fff; width:100%" >
					<option value="">SELECT SUBSCRIPTION PERIOD</option>
					<option value="monthly">MONTHLY</option>
					<option value="yearly">YEARLY</option>					
				</select>
			</div>
			<br/>
			<br/>
			<div
				class="form-group has-feedback selectWrapper"
				style="background-color: #fff; width: 40%; width: 60%; margin-left:20%; margin-top:20px;">
				<select id="quantity" onchange="setIdForCrm('period', 'quantity')" style="font-family:'caption-light'; color: #E25F2A; font-weight:900; border: #fff; background-color: #fff; width:100%" >
					<option value="">SELECT QUANTITY</option>
					<option value="200_500">200 - 500</option>
					<option value="500_999">500 - 999</option>
					<option value="1000_1999">1000 - 1999</option>
					<option value="2000_2999">2000 - 2999</option>
					<option value="3000_3999">3000 - 3999</option>
					<option value="4000_4999">4000 - 4999</option>
				</select>
			</div>
		</div><!-- end pricing block -->
	<!-- end pricing -->
	<!--	<div class="col-half" style="text-align:left">-->
	<!---->
	<!---->
		<div class=" background-green height-35">
			<div class="width-650">
				<h2 class="heading mb-35"><?php echo $this->language->line("PROF-050",'PASSWORD CHANGE.');?></h2>
				<form action="<?php echo $this->baseUrl; ?>changePassword" method="post">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="inputOldPassword">Old Password</label>
									<input style="border-radius: 50px" type="password" class="form-control" id="inputOldPassword" placeholder="Old password" name="oldPassword" maxlength="20" required>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="inputPassword1">New Password</label>
									<input style="border-radius: 50px" type="password" class="form-control" id="inputPassword1" placeholder="New password" name="newPassword" maxlength="20" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="inputPassword2">Confirm New Password</label>
									<input style="border-radius: 50px" type="password" class="form-control" id="inputPassword2" placeholder="Confirm new password" name="cNewPassword" maxlength="20" required>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<input type="submit" class="button button-orange" value="<?php echo $this->language->line("PROF-05100 ",'SUBMIT');?>" style="border: none" />
					</div>
				</form>
			</div>
		</div>

		<?php if($this->session->userdata('dropoffpoint')==1){ ?>



		<div class="background-orange-light height-65">
			<div class="width-650">
				<h2 class="heading mb-35"><?php echo $this->language->line("PROF-A060",'PRICING FEE.');?></h2>
				<form action="<?php echo $this->baseUrl; ?>profileDropOffPointSettings" method="post">
					<div >
						<p>COLLECT ITEM FEE / HANDLING LOST AND FOUND</p>
						<br/>State your fee...</p>
						<div class="form-group has-feedback">
							<input type="text" class="form-control" id="itemfee" name="itemfee" style="border-radius: 50px; border:none" value="<?php echo $user->itemfee; ?>" maxlength="128" />
						</div>
					</div>
					<div class="clearfix"></div>
					<div style="text-align:center">
						<p style="font-family:'caption-light'; font-size:100%; color: #fff9df; text-align: center">
							<?php echo $this->language->line("PROFILE-61000",'CHECK FOR PUBLIC LISTING');?>
						</p>
						<div class="form-group has-feedback">
							<div class="onoffswitch">
								<input type="checkbox" name="publiclisting" class="onoffswitch-checkbox" id="publicoffswitch" <?php if($user->publiclisting == 0) {echo "checked";}?> />
								<label class="onoffswitch-label" for="publicoffswitch">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>
					<div >
						<input type="submit" class="button button-orange" value="SAVE" />
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php } ?>

	<?php if($this->session->userdata('dropoffpoint')==0) { ?>
	<div class="background-orange-light height-65">
		<form action="<?php echo base_url() ?>buddyUpdate" method="post" id="editBuddy">
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="lfbuddy">Lost +Found Buddy Name</label>
							<input style="border-radius: 50px; border:none" type="text" class="form-control" id="lfbuddy" name="lfbuddy" placeholder="<?php if (isset($lfbuddy)) echo $lfbuddy; ?>" value="<?php if (isset($lfbuddy)) echo $lfbuddy; ?>" maxlength="128">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="lfbmobile">Buddy Mobile Number (Country code + number e.g. 0031(country) 0123456789 (number) => 00310123456789)
							</label>
							<input style="border-radius: 50px; border:none" type="text" class="form-control" id="lfbmobile" name="lfbmobile" placeholder="<?php if (isset($lfbmobiley)) echo $lfbmobile; ?>" value="<?php if (isset($lfbmobiley)) echo $lfbmobile; ?>" maxlength="20">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="lfbemail">Buddy Email</label>
							<input style="border-radius: 50px; border:none" type="text" class="form-control" id="lfbemail" name="lfbemail" placeholder="<?php if (isset($lfbemail)) echo $lfbemail; ?>" value="<?php if (isset($lfbemail)) echo $lfbemail; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="lfaddress">Buddy Address</label>
							<input style="border-radius: 50px; border:none" type="text" class="form-control" id="lfaddres" name="lfaddress" placeholder="<?php if (isset($lfaddress)) echo $lfaddress; ?>" value="<?php if (isset($lfbemail)) echo $lfaddress; ?>" maxlength="128" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="lfaddressa">Buddy Address aditional</label>
							<input style="border-radius: 50px; border:none" type="text" class="form-control" id="lfaddressa" name="lfaddressa" placeholder="<?php if (isset($lfaddressa)) echo $lfaddressa; ?>" value="<?php if (isset($lfaddressa)) echo $lfaddressa; ?>" maxlength="128" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="lfzipcode">Buddy zipcode</label>
							<input style="border-radius: 50px; border:none" type="text" class="form-control" id="lfzipcode" name="lfzipcode" placeholder="<?php if (isset($lfzipcode)) echo $lfzipcode; ?>" value="<?php if (isset($lfzipcode)) echo $lfzipcode; ?>" maxlength="128" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="lfcity">Buddy City</label>
							<input style="border-radius: 50px; border:none" type="text" class="form-control" id="lfcity" name="lfcity" placeholder="<?php if (isset($lfcity)) echo $lfcity; ?>" value="<?php if (isset($lfcity)) echo $lfcity; ?>" maxlength="128" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="lfcountry">Buddy Country</label>
							<input style="border-radius: 50px; border:none" type="text" class="form-control" id="lfcountry" name="lfcountry" placeholder="<?php if (isset($lfcountry)) echo $lfcountry; ?>" value="<?php if (isset($lfcountry)) echo $lfcountry; ?>" maxlength="128" />
						</div>
					</div>
				</div>
			</div>

			<div class="box-footer">
				<input type="submit" class="button button-orange" value="<?php echo $this->language->line("PROF-05100 ",'SUBMIT');?>" style="border: none" />
			</div>
<!--			-->
<!--			<div class="box-footer">-->
<!--				<input type="submit" class="btn btn-primary" value="Submit" />-->
<!--				<input type="reset" class="btn btn-default" value="Reset" />-->
<!--			</div>-->

		</form>

	</div>
	<?php } ?>
</div>
</div>
<div class="col-md-4">
	<?php
	$this->load->helper('form');
	$error = $this->session->flashdata('error');
	if($error)
	{
		?>
		<div id="error" class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php echo $this->session->flashdata('error'); ?>
		</div>
	<?php } ?>
	<?php
	$success = $this->session->flashdata('success');
	if($success) {
	?>
		<div id="success" class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php echo $this->session->flashdata('success'); ?>
		</div>
	<?php
	}
	?>

	<?php
	$noMatch = $this->session->flashdata('nomatch');
	if($noMatch)
	{
		?>
		<div id="nomatch" class="alert alert-warning alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php echo $this->session->flashdata('nomatch'); ?>
		</div>
	<?php
	}
	?>
	<div class="row">
		<div id="validationerrors" class="col-md-12">
			<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
		</div>
	</div>
</div>
<script>
	function getUserAjax() {
		return "<?php echo base_url('index.php/ajax/users/'); ?>";
	}
	var baseURL = "<?php echo $this->baseUrl; ?>"
</script>
<?php if ($_SESSION['dropoffpoint'] !== '0') { ?>
<script>
	var profileGloabls = (function(){
		let globals = {
			'monthly' : {
				'200_500' : {
					'id': '<?php echo $MONTHLY_200_500; ?>',
					'price' : '<?php echo $MONTHLY_200_500_PRICE; ?>',
				},
				'500_999' : {
					'id': '<?php echo $MONTHLY_500_999; ?>',
					'price': '<?php echo $MONTHLY_500_999_PRICE; ?>',
				},
				'1000_1999' : {
					'id': '<?php echo $MONTHLY_1000_1999; ?>',
					'price': '<?php echo $MONTHLY_1000_1999_PRICE; ?>',
				},
				'2000_2999' : {
					'id': '<?php echo $MONTHLY_2000_2999; ?>',
					'price': '<?php echo $MONTHLY_2000_2999_PRICE; ?>',
				},					
				'3000_3999' : {
					'id': '<?php echo $MONTHLY_3000_3999; ?>',
					'price': '<?php echo $MONTHLY_3000_3999_PRICE; ?>',
				},
				'4000_4999' : {
					'id': '<?php echo $MONTHLY_4000_4999; ?>',
					'price': '<?php echo $MONTHLY_4000_4999_PRICE; ?>',
				}
			},
			'yearly' : {
				'200_500' : {
					'id': '<?php echo $YEARLY_200_500; ?>',
					'price' : '<?php echo $YEARLY_200_500_PRICE; ?>',
				},
				'500_999' : {
					'id': '<?php echo $YEARLY_500_999; ?>',
					'price': '<?php echo $YEARLY_500_999_PRICE; ?>',
				},
				'1000_1999' : {
					'id': '<?php echo $YEARLY_1000_1999; ?>',
					'price': '<?php echo $YEARLY_1000_1999_PRICE; ?>',
				},
				'2000_2999' : {
					'id': '<?php echo $YEARLY_2000_2999; ?>',
					'price': '<?php echo $YEARLY_2000_2999_PRICE; ?>',
				},
				
				'3000_3999' : {
					'id': '<?php echo $YEARLY_3000_3999; ?>',
					'price': '<?php echo $YEARLY_3000_3999_PRICE; ?>',
				},
				'4000_4999' : {
					'id': '<?php echo $YEARLY_4000_4999; ?>',
					'price': '<?php echo $YEARLY_4000_4999_PRICE; ?>',
				}
			}
		}
		Object.freeze(globals);
		return globals;
	}())
</script>
<?php } ?>
