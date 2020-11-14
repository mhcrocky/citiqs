<html>
<head>

	<!-- Google Font -->
	<style type="text/css">
		input[type="checkbox"] {
			zoom: 3;
		}

		@media screen and (max-width: 680px) {
			.columns .column {
				flex-basis: 100%;
				margin: 0 0 5px 0;
			}
		}

		.selectWrapper {
			border-radius: 50px;
			overflow: hidden;
			background: #eec5a7;
			border: 0px solid #ffffff;
			padding: 5px;
			margin: 0px;
		}

		.selectBox {
			background: #eec5a7;
			width: 100%;
			height: 25px;
			border: 0px;
			outline: none;
			padding: 0px;
			margin: 0px;
		}
	</style>

	<script>

		function myFunctionBrand(str) {
			$(document).ready(function() {
				$.get("<?php echo base_url('index.php/ajax/users/'); ?>" + encodeURIComponent(str), function(data) {
					var result = JSON.parse(data);

					$('#myTable tbody').append('<tr><td>' + result.username + '</td><td>' + result.email + '</td></tr>');
					if (result.username == true) {
						document.getElementById("brandUnkownAddressText").style.display = "block";
						document.getElementById("brandname").style.display = "block";
						document.getElementById("brandaddress").style.display = "block";
						document.getElementById("brandaddressa").style.display = "block";
						document.getElementById("brandzipcode").style.display = "block";
						document.getElementById("brandcity").style.display = "block";
						document.getElementById("brandzip").style.display = "block";
						document.getElementById("brandcountry").style.display = "block";
						document.getElementById("brandcountry1").style.display = "block";
					}
				});
			});
		}

	</script>

</head>

<body>
<!-- end header -->
<div class="main-wrapper">


	<div class="col-half background-blue-light height-100">
		<div class="flex-column align-start">
			<div align="center">
				<h2 class="heading">
					<?php echo $this->language->line("CODE-010",'VERIFICATION CODE');?>
				</h2>
			</div>
			<div style="font-family: caption-light; font-size: larger">
				<p align="center">FOR BUSINESS AND PERSONAL
				</p>
			</div>
			<div class="flex-row align-space">
				<div class="flex-column align-space">
					<div>
						<?php $this->load->helper('form'); ?>
						<?php echo $this->session->flashdata('fail'); ?>
						<div class="row">
							<div class="col-md-12" id="mydivs">
								<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
							</div>
						</div>

						<?php
						$this->load->helper('form');
						$error = $this->session->flashdata('error');
						if($error)
						{
							?>
							<div id="mydivs1">
								<div class="alert alert-danger alert-dismissable" id="mydivs">
									<button id="mydevs" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<?php echo $this->language->Line($this->session->flashdata('error'), $this->session->flashdata('error')); ?>
								</div>
							</div>
						<?php }

						$success = $this->session->flashdata('success');
						if($success)
						{
							?>
							<div class="alert alert-success alert-dismissable" id="mydivs2">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<?php echo $this->language->Line($this->session->flashdata('success'), $this->session->flashdata('success')); ?>
							</div>
						<?php }
						$success = $this->session->flashdata('code');
						if($success)
						{
							?>
							<div class="alert alert-success alert-dismissable" id="mydivs2">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<?php echo $this->language->Line($this->session->flashdata('code'), $this->session->flashdata('code')); ?>
							</div>
						<?php } ?>


						<form action="<?php echo base_url(); ?>loginMe" method="post">

							<div class="form-group has-feedback" align="center">
								<input style="border-radius: 50px" type="password" class="form-control" placeholder="Code" name="code" required />
							</div>

							<div class="row">
								<div class="form-group has-feedback" >
									<div style="text-align: center; ">
										<input type="submit" class="button button-orange" value="<?php echo $this->language->line("CODE-A240",'VERIFY THAT IT IS YOU');?>" style="border: none" />
									</div>
								</div>
							</div>

						</form>

					</div><!-- /.login-box-body -->

					<div style=" font-size: x-large">
						<p align="center">LOST BY YOU, RETURNED BY US
						</p>
					</div>

					<div class="row" align="center" style="padding:50px ">
						<img border="0" src="<?php echo base_url(); ?>tiqsimg/tiqslogonew.png" alt="tiqs" width="125" height="45" />
					</div class="login-box">

					<div class="mobile-hide" align="center" style="margin-top: 70px; margin-bottom: 30px; margin-left: 100px">
						<img border="0" src="<?php echo base_url(); ?>assets/home/images/TIQSLaptop.png" alt="tiqs" width="300" height="300" />
					</div>
					<div class="text-Left mt-50 mobile-hide" style="margin-top: -20px; margin-left: 100px">
						<img border="0" src="<?php echo base_url(); ?>assets/home/images/TIQSWallet.png" alt="tiqs" width="150" height="125" />
					</div>
					<div class="mobile-hide" align="center" style="margin-top: 0x; margin-bottom: 50px; margin-left: 100px">
						<img border="0" src="<?php echo base_url(); ?>assets/home/images/Mobilephone.png" alt="tiqs" width="125" height="250" />
						<div class="mobile-hide" style="margin-left: 150px; margin-top: -30px; margin-bottom: 0px">
							<img border="0" src="<?php echo base_url(); ?>assets/home/images/StickerNew.png" alt="tiqs" width="125" height="50" />
						</div>
					</div>
					<div class="text-left mt-50 mobile-hide" style="margin-left: 100px; margin-bottom: 100px;  margin-top: -30px">
						<div class="text-left mobile-hide" style="margin-left: 100px; margin-bottom: -40px; ">
							<img border="0" src="<?php echo base_url(); ?>assets/home/images/Keychain.png" alt="tiqs" width="110" height="50" />
						</div>
						<img border="0" src="<?php echo base_url(); ?>assets/home/images/TIQSKeys.png" alt="tiqs" width="250" height="200" />
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-half background-yellow">
		<div class="background-orange-light height">
			<div class="width-650">
				<h2 class="heading mb-35"><?php echo $this->language->line("CODE-250",'<a href="https://tiqs.com/lostandfound/personaltagsinfo">GET YOUR FREE TIQS <br>PERSONAL LOST + FOUND<br>STICKERS</a>');?></h2>
				<p style="font-family: caption-light; font-size: larger"> WE ARE THE WORLD LARGEST LOST AND FOUND SOLUTION, TOGETHER WE CAN CREATE THE WORLD LARGEST LOST AND FOUND COMMUNITY! GET YOUR STICKERS AND TAGS HERE, USE THEM FOR YOUR OWN ITEMS, GIVE THEM TO YOUR FRIENDS, FAMILY AND OR OTHER RELATIVES AND ACQUAINTANCES. ORDER YOUR TIQS STICKER/TAG-PACK HERE FOR FREE! </p>
				<p style="font-family: caption-light; font-size: x-small"> (Only shipment will be charged) </p>
				<a style="color:#ffffff" class='how-we-works-link' href="<?php echo base_url(); ?>howitworksconsumer"><?php echo $this->language->line("CODE-260",'MORE INFO, HOE IT WORKS');?></a>
				<p class="text-content mb-50"><?php echo $this->language->line("CODE-70",'LOST BY YOU, <br> RETURNED BY US');?></p>
				<a href="<?php echo base_url(); ?>check" class="button button-orange mb-35"><?php echo $this->language->line("CODE-280",'ORDER YOUR FREE STICKERS');?></a>
			</div>
			<div class="text-center mb-30 mobile-hide align="center">
			<img border="0" src="<?php echo base_url(); ?>assets/home/images/TIQSKeys.png" alt="tiqs" width="220" height="175" />
		</div class="login-box">

	</div>
	<div class="background-yellow height-50">
		<div class="width-650">
			<h2 class="heading mb-35"><?php echo $this->language->line("CODE-251",'BECOME A TIQS AMBASSADOR.');?></h2>
			<p style="font-family: caption-light; font-size: larger">BRAND AMBASSADORS ARE ENDORSING OUR PRODUCTS AND SERVICES. THESE EFFORTS ARE BORNE OUT OF GENUINE APPRECIATION FOR THE BRAND.
				THERE ARE NO FIXED QUALIFICATIONS. OUR BRAND AMBASSADORS ARE STUDENTS, HOUSEWIVES, OFFICE WORKERS AND/OR PROFESSIONALS. AS LONG AS THEY HAVE GENUINE APPRECIATION FOR THE BRAND AND SOLUTIONS.
				THIS MEANS THAT OUR BRAND AMBASSADOR CAN BE. . . . . WELL, ANYONE, EVERY WHERE. </p>
			<p style="font-family: caption-light; font-size: x-large">YOU CAN APPLY AS BRAND AMBASSADOR THROUGH THE FORM BELOW.</p>

			<form action="<?php echo base_url(); ?>loginMe" method="post" class='homepage-form'>
				<form action="<?php echo base_url(); ?>checkregister" method="post">
					<div class="form-group has-feedback">
						<input type="email" id="email" class="form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="<?php echo $this->language->line("CODE-252",'Your e-mail');?>" id="brandemail" name="email" onfocusout="myFunctionBrand(this.value)" required />
					</div>

					<p id="brandUnkownAddressText" style="font-family:'caption-light'; margin-bottom: 10px; display:none; font-size:100%; color:#ffffff;  text-align: left" >
						<?php echo $this->language->line("CODE-290",'THANKS, FOR YOUR APPLICATION AS BRAND AMBASSADOR FOR SUPPORTING TO THE WORLD LARGEST HONEST LOST AND FOUND COMMUNITY!')?>
						<?php echo $this->language->line("CODE-300",'
                                Please state your Name, home (or other physical address). 
                                Your personal data is encrypted stored for security reasons 
                                and we do not ask and show this information again, without login, to protect your personal data. 
                                Please read our security by design page. 
                                Changes to your address can be made in your personal account profile page. 
                                Your credentials to login have been send to you, after your registration, by separate mail, upon automatic creation of your account.
                                Please check you SPAM folder when not received.');?>
					</p>

					<div class="form-group has-feedback">
						<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CODE-310",'Your full name');?>" id="brandname" name="name"  />
					</div>

					<div class="form-group has-feedback">
						<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CODE-320",'Your address');?>" id="brandaddress" name="address"  />
					</div>

					<div class="form-group has-feedback">
						<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CODE-330",'Extra address line');?>" id="brandaddressa" name="addressa"  />
					</div>

					<div class="form-group has-feedback">
						<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CODE-340",'Your zipcode');?>" id="brandzipcode" name="zipcode" />
					</div>

					<div class="form-group has-feedback">
						<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CODE-350",'City');?>" id="city" name="brandcity"  />

					</div>

					<div class="selectWrapper" style="display: none" id="brandcountry1">
						<select class="selectBox" id="brandcountry" name="country" style="display: none; font-family:'caption-light';" required />
						<option value="">
							<?php echo $this->language->line("CODE-360","Select your country");?>
						</option>
						<option value="AF">Afghanistan</option>
						<option value="AX">Åland Islands</option>
						<option value="AL">Albania</option>
						<option value="DZ">Algeria</option>
						<option value="AS">American Samoa</option>
						<option value="AD">Andorra</option>
						<option value="AO">Angola</option>
						<option value="AI">Anguilla</option>
						<option value="AQ">Antarctica</option>
						<option value="AG">Antigua and Barbuda</option>
						<option value="AR">Argentina</option>
						<option value="AM">Armenia</option>
						<option value="AW">Aruba</option>
						<option value="AU">Australia</option>
						<option value="AT">Austria</option>
						<option value="AZ">Azerbaijan</option>
						<option value="BS">Bahamas</option>
						<option value="BH">Bahrain</option>
						<option value="BD">Bangladesh</option>
						<option value="BB">Barbados</option>
						<option value="BY">Belarus</option>
						<option value="BE">Belgium</option>
						<option value="BZ">Belize</option>
						<option value="BJ">Benin</option>
						<option value="BM">Bermuda</option>
						<option value="BT">Bhutan</option>
						<option value="BO">Bolivia, Plurinational State of</option>
						<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
						<option value="BA">Bosnia and Herzegovina</option>
						<option value="BW">Botswana</option>
						<option value="BV">Bouvet Island</option>
						<option value="BR">Brazil</option>
						<option value="IO">British Indian Ocean Territory</option>
						<option value="BN">Brunei Darussalam</option>
						<option value="BG">Bulgaria</option>
						<option value="BF">Burkina Faso</option>
						<option value="BI">Burundi</option>
						<option value="KH">Cambodia</option>
						<option value="CM">Cameroon</option>
						<option value="CA">Canada</option>
						<option value="CV">Cape Verde</option>
						<option value="KY">Cayman Islands</option>
						<option value="CF">Central African Republic</option>
						<option value="TD">Chad</option>
						<option value="CL">Chile</option>
						<option value="CN">China</option>
						<option value="CX">Christmas Island</option>
						<option value="CC">Cocos (Keeling) Islands</option>
						<option value="CO">Colombia</option>
						<option value="KM">Comoros</option>
						<option value="CG">Congo</option>
						<option value="CD">Congo, the Democratic Republic of the</option>
						<option value="CK">Cook Islands</option>
						<option value="CR">Costa Rica</option>
						<option value="CI">Côte d'Ivoire</option>
						<option value="HR">Croatia</option>
						<option value="CU">Cuba</option>
						<option value="CW">Curaçao</option>
						<option value="CY">Cyprus</option>
						<option value="CZ">Czech Republic</option>
						<option value="DK">Denmark</option>
						<option value="DJ">Djibouti</option>
						<option value="DM">Dominica</option>
						<option value="DO">Dominican Republic</option>
						<option value="EC">Ecuador</option>
						<option value="EG">Egypt</option>
						<option value="SV">El Salvador</option>
						<option value="GQ">Equatorial Guinea</option>
						<option value="ER">Eritrea</option>
						<option value="EE">Estonia</option>
						<option value="ET">Ethiopia</option>
						<option value="FK">Falkland Islands (Malvinas)</option>
						<option value="FO">Faroe Islands</option>
						<option value="FJ">Fiji</option>
						<option value="FI">Finland</option>
						<option value="FR">France</option>
						<option value="GF">French Guiana</option>
						<option value="PF">French Polynesia</option>
						<option value="TF">French Southern Territories</option>
						<option value="GA">Gabon</option>
						<option value="GM">Gambia</option>
						<option value="GE">Georgia</option>
						<option value="DE">Germany</option>
						<option value="GH">Ghana</option>
						<option value="GI">Gibraltar</option>
						<option value="GR">Greece</option>
						<option value="GL">Greenland</option>
						<option value="GD">Grenada</option>
						<option value="GP">Guadeloupe</option>
						<option value="GU">Guam</option>
						<option value="GT">Guatemala</option>
						<option value="GG">Guernsey</option>
						<option value="GN">Guinea</option>
						<option value="GW">Guinea-Bissau</option>
						<option value="GY">Guyana</option>
						<option value="HT">Haiti</option>
						<option value="HM">Heard Island and McDonald Islands</option>
						<option value="VA">Holy See (Vatican City State)</option>
						<option value="HN">Honduras</option>
						<option value="HK">Hong Kong</option>
						<option value="HU">Hungary</option>
						<option value="IS">Iceland</option>
						<option value="IN">India</option>
						<option value="ID">Indonesia</option>
						<option value="IR">Iran, Islamic Republic of</option>
						<option value="IQ">Iraq</option>
						<option value="IE">Ireland</option>
						<option value="IM">Isle of Man</option>
						<option value="IL">Israel</option>
						<option value="IT">Italy</option>
						<option value="JM">Jamaica</option>
						<option value="JP">Japan</option>
						<option value="JE">Jersey</option>
						<option value="JO">Jordan</option>
						<option value="KZ">Kazakhstan</option>
						<option value="KE">Kenya</option>
						<option value="KI">Kiribati</option>
						<option value="KP">Korea, Democratic People's Republic of</option>
						<option value="KR">Korea, Republic of</option>
						<option value="KW">Kuwait</option>
						<option value="KG">Kyrgyzstan</option>
						<option value="LA">Lao People's Democratic Republic</option>
						<option value="LV">Latvia</option>
						<option value="LB">Lebanon</option>
						<option value="LS">Lesotho</option>
						<option value="LR">Liberia</option>
						<option value="LY">Libya</option>
						<option value="LI">Liechtenstein</option>
						<option value="LT">Lithuania</option>
						<option value="LU">Luxembourg</option>
						<option value="MO">Macao</option>
						<option value="MK">Macedonia, the former Yugoslav Republic of</option>
						<option value="MG">Madagascar</option>
						<option value="MW">Malawi</option>
						<option value="MY">Malaysia</option>
						<option value="MV">Maldives</option>
						<option value="ML">Mali</option>
						<option value="MT">Malta</option>
						<option value="MH">Marshall Islands</option>
						<option value="MQ">Martinique</option>
						<option value="MR">Mauritania</option>
						<option value="MU">Mauritius</option>
						<option value="YT">Mayotte</option>
						<option value="MX">Mexico</option>
						<option value="FM">Micronesia, Federated States of</option>
						<option value="MD">Moldova, Republic of</option>
						<option value="MC">Monaco</option>
						<option value="MN">Mongolia</option>
						<option value="ME">Montenegro</option>
						<option value="MS">Montserrat</option>
						<option value="MA">Morocco</option>
						<option value="MZ">Mozambique</option>
						<option value="MM">Myanmar</option>
						<option value="NA">Namibia</option>
						<option value="NR">Nauru</option>
						<option value="NP">Nepal</option>
						<option value="NL">Netherlands</option>
						<option value="NC">New Caledonia</option>
						<option value="NZ">New Zealand</option>
						<option value="NI">Nicaragua</option>
						<option value="NE">Niger</option>
						<option value="NG">Nigeria</option>
						<option value="NU">Niue</option>
						<option value="NF">Norfolk Island</option>
						<option value="MP">Northern Mariana Islands</option>
						<option value="NO">Norway</option>
						<option value="OM">Oman</option>
						<option value="PK">Pakistan</option>
						<option value="PW">Palau</option>
						<option value="PS">Palestinian Territory, Occupied</option>
						<option value="PA">Panama</option>
						<option value="PG">Papua New Guinea</option>
						<option value="PY">Paraguay</option>
						<option value="PE">Peru</option>
						<option value="PH">Philippines</option>
						<option value="PN">Pitcairn</option>
						<option value="PL">Poland</option>
						<option value="PT">Portugal</option>
						<option value="PR">Puerto Rico</option>
						<option value="QA">Qatar</option>
						<option value="RE">Réunion</option>
						<option value="RO">Romania</option>
						<option value="RU">Russian Federation</option>
						<option value="RW">Rwanda</option>
						<option value="BL">Saint Barthélemy</option>
						<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
						<option value="KN">Saint Kitts and Nevis</option>
						<option value="LC">Saint Lucia</option>
						<option value="MF">Saint Martin (French part)</option>
						<option value="PM">Saint Pierre and Miquelon</option>
						<option value="VC">Saint Vincent and the Grenadines</option>
						<option value="WS">Samoa</option>
						<option value="SM">San Marino</option>
						<option value="ST">Sao Tome and Principe</option>
						<option value="SA">Saudi Arabia</option>
						<option value="SN">Senegal</option>
						<option value="RS">Serbia</option>
						<option value="SC">Seychelles</option>
						<option value="SL">Sierra Leone</option>
						<option value="SG">Singapore</option>
						<option value="SX">Sint Maarten (Dutch part)</option>
						<option value="SK">Slovakia</option>
						<option value="SI">Slovenia</option>
						<option value="SB">Solomon Islands</option>
						<option value="SO">Somalia</option>
						<option value="ZA">South Africa</option>
						<option value="GS">South Georgia and the South Sandwich Islands</option>
						<option value="SS">South Sudan</option>
						<option value="ES">Spain</option>
						<option value="LK">Sri Lanka</option>
						<option value="SD">Sudan</option>
						<option value="SR">Suriname</option>
						<option value="SJ">Svalbard and Jan Mayen</option>
						<option value="SZ">Swaziland</option>
						<option value="SE">Sweden</option>
						<option value="CH">Switzerland</option>
						<option value="SY">Syrian Arab Republic</option>
						<option value="TW">Taiwan, Province of China</option>
						<option value="TJ">Tajikistan</option>
						<option value="TZ">Tanzania, United Republic of</option>
						<option value="TH">Thailand</option>
						<option value="TL">Timor-Leste</option>
						<option value="TG">Togo</option>
						<option value="TK">Tokelau</option>
						<option value="TO">Tonga</option>
						<option value="TT">Trinidad and Tobago</option>
						<option value="TN">Tunisia</option>
						<option value="TR">Turkey</option>
						<option value="TM">Turkmenistan</option>
						<option value="TC">Turks and Caicos Islands</option>
						<option value="TV">Tuvalu</option>
						<option value="UG">Uganda</option>
						<option value="UA">Ukraine</option>
						<option value="AE">United Arab Emirates</option>
						<option value="GB">United Kingdom</option>
						<option value="US">United States</option>
						<option value="UM">United States Minor Outlying Islands</option>
						<option value="UY">Uruguay</option>
						<option value="UZ">Uzbekistan</option>
						<option value="VU">Vanuatu</option>
						<option value="VE">Venezuela, Bolivarian Republic of</option>
						<option value="VN">Viet Nam</option>
						<option value="VG">Virgin Islands, British</option>
						<option value="VI">Virgin Islands, U.S.</option>
						<option value="WF">Wallis and Futuna</option>
						<option value="EH">Western Sahara</option>
						<option value="YE">Yemen</option>
						<option value="ZM">Zambia</option>
						<option value="ZW">Zimbabwe</option>
						</select>
					</div>

					<div class="form-group has-feedback" >
						<div style="text-align: center; margin-bottom: 30px ">
							<input type="submit" class="button button-orange" value="<?php echo $this->language->line("CODE-370",'APPLY');?>" style="border: none" />
						</div>
					</div>

				</form>
		</div>
	</div>
</div>
</div>
</body>

</html>

<!-- end col half -->

<?php
if(isset($_SESSION['error'])){
	unset($_SESSION['error']);
}
if(isset($_SESSION['success'])){
	unset($_SESSION['success']);
}
if(isset($_SESSION['message'])){
	unset($_SESSION['message']);
}
?>
