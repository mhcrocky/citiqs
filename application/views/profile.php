<div class="main-wrapper" style="text-align:center">
	<div class="col-half background-blue height-100">
		<div class="flex-column align-start width-650">
			<div style="text-align:center">
				<form action="<?php echo $this->baseUrl; ?>profileUpdate" method="post" id="editProfile">
					<!--					<input type="text" value="--><?php //echo $user->id; ?><!--" name="id" id="userId" readonly hidden required />-->
					<h2 class="heading mb-35"><?=$this->language->line("PROF-010A",'YOUR PROFILE PAGE.');?></h2>
					<div class="">
						<div class="flex-column align-space">
							<div class="form-group has-feedback">
								<p style="font-family: caption-light; padding: 10px">
									<?=$this->language->line("PROF-020A",'Full Name');?>
								</p>
								<div class="form-group has-feedback">
									<input  value="<?php echo $user->username; ?>" name="username" required type="text" class="form-control" id="fname" style="border-radius: 50px; border:none" placeholder="<?php echo $name; ?>" maxlength="128" />
								</div>
							</div>
							<?php if ($user->IsDropOffPoint === '1') { ?>
								<div>
									<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin-bottom:10px; text-align: center">
										<?=$this->language->Line("registerbusiness-1600A",'Your shortname');?>
									</p>
								</div>
								<div class="form-group has-feedback">
									<input value="<?php echo $user->usershorturl; ?>" name="usershorturl" required type="text" class="form-control"  required id="usershorturl" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?=$this->language->Line("registerbusiness-1700A",'Your shortname');?>" name="usershorturl" pattern="[a-z]{1,15}" title="<?=$this->language->Line("registerbusiness-1800A",'Only [a-z] characters allowed (no capital), no spaces, points or special characters like @#$% and max 15 length');?>" />
								</div>
							<?php } ?>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?=$this->language->line("PROF-030A31",'Mobile Number (Country code + number e.g. 0031(country) 0123456789 (number) => 00310123456789)');?>
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
											<option value=""><?=$this->language->Line("registerbusiness-1600A1","Select business type");?></option>
											<?php foreach ($businessTypes as $type) { ?>
												<option <?php if($type['id'] === $user->business_type_id) echo 'selected'; ?> value="<?php echo $type['id'] ?>">
													<?php echo $this->language->Line(ucfirst($type['busineess_type']),ucfirst($type['busineess_type'])) ?>
												</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?=$this->language->line("PROF-0303021","
									VAT number
									");?>
									</p>
								</div>
								<div class="form-group has-feedback">
									<input type="text" value="<?php echo $user->vat_number; ?>" name="vat_number" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?=$this->language->line("PROF-03031","Business VAT number");?>" />
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>
							<?php } ?>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?=$this->language->line("PROF-031","Your E-mail address");?>
									</p>

									<div class="form-group has-feedback">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="email" name="email" placeholder="<?php echo $user->email; ?>" value="<?php echo $user->email; ?>" required />
									</div>
								</div>
							</div>
							<?php if ($user->IsDropOffPoint === '1') { ?>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?=$this->language->line("PROF-10303021","
									Responsible person first name
									"); ?>
									</p>
								</div>
								<div class="form-group has-feedback">
									<input type="text" name="first_name" value="<?php echo $user->first_name; ?>" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="First name" />
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?=$this->language->line("PROF-103030211","
									Responsible person last name
									"); ?>
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
										<?=$this->language->line("PROF-032","Address");?>
									</p>
									<div class="form-group has-feedback">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="addres" name="address" placeholder="<?php echo $user->address; ?>" value="<?php echo $user->address; ?>" maxlength="128" />
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?=$this->language->line("PROF-033","Additional address line");?>
									</p>
									<div class="form-group has-feedback">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="addressa" name="addressa" placeholder="<?php echo $user->addressa; ?>" value="<?php echo $user->addressa; ?>" maxlength="128" />
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?=$this->language->line("PROF-034","Zipcode");?>
									</p>
									<div class="form-group">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="zipcode" name="zipcode" placeholder="<?php echo $user->zipcode; ?>" value="<?php echo $user->zipcode; ?>" maxlength="128" />
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?=$this->language->line("PROF-035","City");?>
									</p>

									<div class="form-group has-feedback">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="city" name="city" placeholder="<?php echo $user->city; ?>" value="<?php echo $user->city; ?>" maxlength="128" />
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?=$this->language->line("PROF-10303021","
										Country
										"); ?>
									</p>
									<div class="form-group has-feedback selectWrapper mb-35">
										<select class="selectBox" name="country" style="font-family:'caption-light';" required>
											<?php foreach ($countries as $code => $country) { ?>
												<option value="<?php echo $code; ?>" <?php if ($code === $user->country) echo 'selected'; ?> >
													<?php echo $this->language->line($country,$country); ?>
												</option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group has-feedback" style="padding: 30px;">

								<div style="text-align: center; ">
									<input type="submit" class="button button-orange" value="<?=$this->language->line("PROF-040 ",'SAVE');?>" style="border: none" />
								</div>

							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php if($this->session->userdata('dropoffpoint')==1) { ?>
		<div class="col-half background-purple-light timeline-content">
			<h2>Shop url</h2>
			<p>
				<?php echo base_url() . 'make_order?vendorid=' . $user->id; ?>
			</p>
			<div class="background-orange-light timeline-content">
				<!-- <p>Add driver mobile number (starting with country code with zero) for sending sms.</p>
				<p>Set the number of minutes when the message will be sent to driver after the order status is changed in status "DONE"</p> -->
				<!-- <p>Add terms and conditions</p> -->
			
				<form method="post" action="<?php echo base_url() ?>profile/updateVendorData/<?php echo $vendor['id']; ?>">
					<input type="number" name="vendorId" value="<?php echo $user->id ?>" readonly requried hidden />
					<div class="form group">
						<label for="termsAndConditions">Terms and conditions: </label>
						<textarea class="form-control" id="termsAndConditions" name="termsAndConditions"><?php echo strval($vendor['termsAndConditions']); ?></textarea>
					</div>
					<br/>
					<div class="form group">
						<label for="payNlServiceId">Pay service id: </label>
						<input
							type="text"
							id="payNlServiceId"
							name="payNlServiceId"
							class="form-control"
							value="<?php echo $vendor['payNlServiceId']; ?>"
							/>
					</div>
					<br/>
					<div class="form group">
						<label for="serviceFeePercent">Service fee percent: </label>
						<input
							type="number"
							id="serviceFeePercent"
							name="serviceFeePercent"
							min="0"
							step="0.01"
							class="form-control"
							value="<?php echo $vendor['serviceFeePercent']; ?>"
							/>
					</div>
					<br/>
					<div class="form group">
						<label for="serviceFeeAmount">Maximum service fee amount: </label>
						<input
							type="number"
							id="serviceFeeAmount"
							name="serviceFeeAmount"
							min="0"
							step="0.01"
							class="form-control"
							value="<?php echo $vendor['serviceFeeAmount']; ?>"
							/>
					</div>
					<br/>
					<div class="form group">
						<label for="minimumOrderFee">Minimum order fee amount: </label>
						<input
							type="number"
							id="minimumOrderFee"
							name="minimumOrderFee"
							min="0"
							step="0.01"
							class="form-control"
							value="<?php echo $vendor['minimumOrderFee']; ?>"
							/>
					</div>
					<br/>
					<div class="form group">
						<label for="printTimeConstraint">Print orders created before: 
						<input
							type="number"
							id="printTimeConstraint"
							name="printTimeConstraint"
							min="0"
							step="1"
							value="<?php echo $vendor['printTimeConstraint']; ?>"
							/>
							hours:
						</label>
					</div>
					<div class="form group">
						<label for="serviceFeeTax">Service fee tax: </label>
						<input
							type="number"
							min="0"
							step="1"
							id="serviceFeeTax"
							name="serviceFeeTax"
							class="form-control"
							value="<?php echo $vendor['serviceFeeTax']; ?>"
							/>
					</div>
					<div class="form group" style="margin-top:30px !important">
						<h3>Select payment method(s):</h3>
						<div class="col-lg-4">
							<h4>Bancontact</h4>
							<label class="radio-inline" for="bancontactYes">Yes</label>
							<input type="radio" id="bancontactYes" name="bancontact" value="1" <?php if ($vendor['bancontact'] === '1') echo 'checked'; ?> />
							<label class="radio-inline" for="bancontactNo">&nbsp;&nbsp;&nbsp;No</label>
							<input type="radio" id="bancontactNo" name="bancontact" value="0" <?php if ($vendor['bancontact'] === '0') echo 'checked'; ?> />
						</div>
						<div class="col-lg-4">
							<h4>Ideal</h4>
							<label class="radio-inline" for="idealYes">Yes</label>
							<input type="radio" id="idealYes" name="ideal" value="1" <?php if ($vendor['ideal'] === '1') echo 'checked'; ?> />
							<label class="radio-inline" for="idealNo">&nbsp;&nbsp;&nbsp;No</label>
							<input type="radio" id="idealNo" name="ideal" value="0" <?php if ($vendor['ideal'] === '0') echo 'checked'; ?> />
						</div>
						<div class="col-lg-4">
							<h4>Credit card</h4>
							<label class="radio-inline" for="creditCardYes">Yes</label>
							<input type="radio" id="creditCardYes" name="creditCard" value="1" <?php if ($vendor['creditCard'] === '1') echo 'checked'; ?> />
							<label class="radio-inline" for="creditCardNo">&nbsp;&nbsp;&nbsp;No</label>
							<input type="radio" id="creditCardNo" name="creditCard" value="0" <?php if ($vendor['creditCard'] === '0') echo 'checked'; ?> />
						</div>
					</div>
					<br/>
					<br/>
					<div class="form-group" style="margin-top:30px !important">
						<h3>Require user mobile phone on checkout form</h3>
						<br/>
						<label class="radio-inline" for="requireMobileYes">Yes</label>
						<input type="radio" id="requireMobileYes" name="requireMobile" value="1" <?php if ($vendor['requireMobile'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="requireMobileNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="requireMobileNo" name="requireMobile" value="0" <?php if ($vendor['requireMobile'] === '0') echo 'checked'; ?> />
					</div>
					<br/>
					<input class="btn btn-primary" type="submit" value="Submit" />
				</form>
				<br/>
				<form method="post" action="<?php echo base_url() ?>profile/updateVendorLogo/<?php echo $user->id; ?>" enctype="multipart/form-data">
					<div class="form-group" style="margin-top:30px !important">
						<label for="logo">
							<?php echo $this->language->line("LOGOPNG-1030302119"," Upload logo in png format "); ?>
						</label>
					</div>
					<?php if ($user->logo) { ?>
						<figure>
							<img
								src="<?php echo base_url() . 'assets/images/vendorLogos/' . $user->logo; ?>"
								class="img-responsive img-thumbnail"
								alt="logo"
								/>
						</figure>
						<br>
					<?php } ?>
					<div class="form-group has-feedback">
						<input type="file" name="logo" id="logo" class="form-control" accept="image/png" />
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<input class="btn btn-primary" type="submit" value="Upload" />
				</form>
			</div>
		</div>
	<?php } ?>
</div>
<?php if($this->session->userdata('dropoffpoint')==0) { ?>
	<div class="col-half background-orange-light height-100 align-center">
		<div class="flex-column align-start width-650">
			<div style="text-align:center">
				<h2 class="heading mb-35"><?=$this->language->line("PROF-A010",'YOUR BUDDY.');?></h2>
				<div class="flex-row align-space">
					<div class="flex-column align-space">
						<div class="form-group has-feedback">
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
										<input type="submit" class="button button-orange" value="<?=$this->language->line("PROF-05100 ",'SUBMIT');?>" style="border: none" />
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<div class="col-half background-green height-100 ">
	<div class="flex-column align-start width-650">
		<h2 class="heading mb-35"><?=$this->language->line("PROF-050",'PASSWORD CHANGE.');?></h2>
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
				<input type="submit" class="button button-orange" value="<?=$this->language->line("PROF-05100 ",'SUBMIT');?>" style="border: none" />
			</div>
		</form>
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
