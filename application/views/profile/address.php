<style>
.footer-area p {
    color: #676666 !important;
    margin-bottom: 0 !important;
}
p,label{
	color: #000 !important;
}
</style>

<div class="main-wrapper-nh" style="text-align:center">
	<div class="col-half height-100">
		<div style="text-align:center;">
			<form action="<?php echo $this->baseUrl; ?>profileUpdate" method="post" id="editProfile" enctype="multipart/form-data">
				<!--					<input type="text" value="--><?php //echo $user->id; ?><!--" name="id" id="userId" readonly hidden required />-->
				<!-- <h2 class="heading mb-35"><?php echo $this->language->line("PROF-010A",'YOUR PROFILE PAGE.');?></h2> -->
				<div class="">
					<div class="flex-column align-space">
						<div class="form-group has-feedback">
							<p style="font-family: caption-light; padding: 10px">
								<?php echo $this->language->line("PROF-V1V020A",'BUSINESS NAME');?>
							</p>
							<div class="form-group has-feedback">
								<input
									value="<?php echo $user->username; ?>"
									name="username"
									required
									type="text"
									class="form-control ui-widget-content ui-corner-all ui-autocomplete-input ui-keyboard-preview"
									id="fname"
									style="border-radius: 50px; border:none"
									placeholder="<?php echo $name; ?>"
									maxlength="128"
									role="textbox"
									autocomplete="off"
									tabindex="-1"
								/>
							</div>
							<div class="virtual-keyboard-hook" data-target-id="fname" data-keyboard-mapping="qwerty"><i class="fa fa-keyboard-o" aria-hidden="true"></i></div>
						</div>
						<?php if ($user->IsDropOffPoint === '1') { ?>
							<div>
								<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  margin-bottom:10px; text-align: center">
									<?php echo $this->language->Line("registerbusiness-V1V1600A",'SHORTNAME');?>
								</p>
							</div>
							<div class="form-group has-feedback">
								<input value="<?php echo $user->usershorturl; ?>" type="text" class="form-control"  required id="usershorturl" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->Line("registerbusiness-1700A",'Your shortname');?>" name="usershorturl" pattern="[a-z]{1,15}" title="<?php echo $this->language->Line("registerbusiness-1800A",'Only [a-z] characters allowed (no capital), no spaces, points or special characters like @#$% and max 15 length');?>" />
								<div class="virtual-keyboard-hook" data-target-id="usershorturl" data-keyboard-mapping="qwerty"><i class="fa fa-keyboard-o" aria-hidden="true"></i></div>
							</div>
						<?php } ?>
						<div>
							<div>
								<p style="font-family: caption-light; padding: 10px">
									<?php echo $this->language->line("PROF-V030A31",'MOBILE NUMBER (Country code + number e.g. 0031(country) 0123456789 (number) => 00310123456789)');?>
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
									<select class="selectBox form-control ui-widget-content ui-corner-all ui-autocomplete-input ui-keyboard-preview" id="business_type" name="business_type_id" style="font-family:'caption-light';border-radius: 25px;" required>
										<option value=""><?php echo $this->language->Line("registerbusiness-V1V1600A1","SELECT BUSINESS TYPE");?></option>
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
									<?php echo $this->language->line("PROF-0303021","
								VAT number
								");?>
								</p>
							</div>
							<div class="form-group has-feedback">
								<input type="text" value="<?php echo $user->vat_number; ?>" name="vat_number" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->line("PROF-V03031","BUSINESS VAT NUMBER");?>" />
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
						<?php } ?>
						<div>
							<div>
								<p style="font-family: caption-light; padding: 10px">
									<?php echo $this->language->line("PROF-V031","YOUR E-MAIL ADDRESS");?>
								</p>

								<div class="form-group has-feedback">
									<input style="border-radius: 50px; border:none" type="text" class="form-control" id="email" name="email" placeholder="<?php echo $user->email; ?>" value="<?php echo $user->email; ?>" required />
								</div>
							</div>
						</div>
						<div>
							<div>
								<p style="font-family: caption-light; padding: 10px">
									<?php echo $this->language->line("RECEIPT-V03123","E-MAIL ADDRESS FOR RECEIPT AND X-Z REPORTES");?>
								</p>

								<div class="form-group has-feedback">
									<input style="border-radius: 50px; border:none" type="text" class="form-control" id="email" name="receiptEmail" placeholder="Email for receipt" value="<?php echo strval($vendor['receiptEmail']); ?>"  />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-half height-100">
				<div style="text-align:center;">

							<?php if ($user->IsDropOffPoint === '1') { ?>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-V10303021111","
									RESPONSIBLE PERSON FIRST NAME
									"); ?>
									</p>
								</div>
								<div class="form-group has-feedback">
									<input type="text" name="first_name" value="<?php echo $user->first_name; ?>" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="first name" />
									<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
								</div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-V103030211","
									RESPONSIBLE PERSON LAST NAME
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
										<?php echo $this->language->line("PROF-V032","ADDRESS");?>
									</p>
									<div class="form-group has-feedback">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="addres" name="address" placeholder="<?php echo $user->address; ?>" value="<?php echo $user->address; ?>" maxlength="128" />
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-V033","ADDITIONAL ADDRESS LINE");?>
									</p>
									<div class="form-group has-feedback">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="addressa" name="addressa" placeholder="<?php echo $user->addressa; ?>" value="<?php echo $user->addressa; ?>" maxlength="128" />
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-V034","ZIPCODE");?>
									</p>
									<div class="form-group">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="zipcode" name="zipcode" placeholder="<?php echo $user->zipcode; ?>" value="<?php echo $user->zipcode; ?>" maxlength="128" />
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-V035","CITY");?>
									</p>

									<div class="form-group has-feedback">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="city" name="city" placeholder="<?php echo $user->city; ?>" value="<?php echo $user->city; ?>" maxlength="128" />
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-V110303021","
										COUNTRY
										"); ?>
									</p>
									<div class="form-group has-feedback selectWrapper mb-35">
										<select class="selectBox form-control ui-widget-content ui-corner-all ui-autocomplete-input ui-keyboard-preview" name="country" id="country" style="font-family:'caption-light';border-radius: 25px;" required>
											<?php foreach ($countries as $code => $country) { ?>
												<option value="<?php echo $code; ?>" <?php if ($code === $user->country) echo 'selected'; ?> >
													<?php echo $this->language->line($country,$country); ?>
												</option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-V035REGNUMBER","REGISTER NUMBER");?>
									</p>
									<div class="form-group has-feedback">
										<input style="border-radius: 50px; border:none" type="text" class="form-control" id="inszNumber" name="inszNumber" placeholder="<?php echo $user->inszNumber; ?>" value="<?php echo $user->inszNumber; ?>" maxlength="255" />
									</div>
								</div>
							</div>
							<div>
								<div>
									<p style="font-family: caption-light; padding: 10px">
										<?php echo $this->language->line("PROF-BIZDIR","SHOW IN PLACES");?>
									</p>
									<div class="form-group has-feedback">
									<label class="radio-inline" for="bizdirYes">Yes</label>
									<input type="radio" id="bizdirYes" name="bizdir" value="1" <?php if ($user->bizdir === '1') echo 'checked'; ?> />
									<label class="radio-inline" for="bizdirNo">&nbsp;&nbsp;&nbsp;No</label>
									<input type="radio" id="bizdirNo" name="bizdir" value="0" <?php if ($user->bizdir === '0') echo 'checked'; ?> />
									</div>
								</div>
							</div>
							<?php if ($user->placeImage) { ?>
								<figure style="margin:auto">
									<img
										src="<?php echo base_url() . 'assets/images/placeImages/' . $user->placeImage; ?>"
										class="img-responsive img-thumbnail"
										alt="place image"
										width="300px" height="auto"
										/>
								</figure>
								<br>
							<?php } ?>
							<div class="form-group has-feedback" style="margin-top:10px">
								<input type="file" name="placeImage" class="form-control" accept="image/png" style="border-radius: 25px;" />
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<!--
							<div class="form-group has-feedback">
							    <p style="font-family: caption-light; padding: 10px">
								    <?php echo 'PASSWORD';?>
							    </p>
								<input
									type="hidden"
									value="<?php echo $user->password; ?>"
									name="oldpassword"
								/>
							    <div class="input-group">
							        <input 
									  style="height: 45px;border-top-left-radius: 25px;border-bottom-left-radius: 25px;"
									  type="password"
									  class="form-control pwd" 
									  name="password"
									  id="password"
									  maxlength="128"
									  role="textbox"
									  autocomplete="off"
									  tabindex="-1"
									  placeholder="New Password (Optional)"
									/>
							        <span class="input-group-btn">
							            <button class="btn btn-default reveal form-control" style="border-top-right-radius: 25px;border-bottom-right-radius: 25px;margin-left: -3px;height: 45px;width: 60px;" type="button">Show</button>
							        </span>          
							    </div>
							</div>
							-->
							
							<div class="form-group has-feedback" style="padding: 30px;">
								<div style="text-align: center; ">
									<input type="submit" class="button button-orange" onclick="saveSpotObject()" value="<?php echo $this->language->line("PROF-040 ",'SAVE');?>" style="border: none" />
								</div>
							</div>
						</div>
					</div>
				</form>
		</div>
	</div>
</div>

<script>
	function getUserAjax() {
		return "<?php echo base_url('index.php/ajax/users/'); ?>";
	}
	var baseURL = "<?php echo $this->baseUrl; ?>"

	function saveSpotObject() {
		let name = $("#fname").val();
		let city = $("#city").val();
		let objectType = $("#business_type option:selected").val();
		let country = $("#country option:selected").val();
		let zipcode = $("#zipcode").val();
		let address = $("#addres").val();
		let data = {
			name: name,
			city: city,
			country: country,
			objectType: objectType,
			zipcode: zipcode,
			address: address
		};
		$.post('<?php echo base_url(); ?>settingsmenu/savespotobject',data);
	}
		// date time picker
	$(document).ready(function(){
		$(".reveal").on('click',function() {
    var $pwd = $(".pwd");
    if ($pwd.attr('type') === 'password') {
        $pwd.attr('type', 'text');
		$(this).text('Hide');
    } else {
        $pwd.attr('type', 'password');
		$(this).text('Show');
    }
});
		// $('.timePickers').datetimepicker({
		// 	timepicker: false,
		// 	format: 'yy-m-d'
		// });
	});
</script>
