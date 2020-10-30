<head>



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
		$(function() {
			$('[data-toggle="tooltip"]').tooltip({
				'delay': {
					show: 3000,
					hide: 1
				}
			});
		})

		function myFunction(str) {
			$(document).ready(function() {
				$.get("<?php echo base_url('index.php/ajax/users/'); ?>" + encodeURIComponent(str), function(data) {
					var result = JSON.parse(data);
					$('#myTable tbody').append('<tr><td>' + result.username + '</td><td>' + result.email + '</td></tr>');
					if (result.username == true) {
						document.getElementById("UnkownAddressText").style.display = "block";
						document.getElementById("name").style.display = "block";
						document.getElementById("address").style.display = "block";
						document.getElementById("addressa").style.display = "block";
						document.getElementById("zipcode").style.display = "block";
						document.getElementById("city").style.display = "block";
						// document.getElementById("country").style.display = "block";
						document.getElementById("country1").style.display = "block";
						document.getElementById("label1").style.display = "block";
						document.getElementById("label2").style.display = "block";
						document.getElementById("label3").style.display = "block";
						document.getElementById("label4").style.display = "block";
						document.getElementById("label5").style.display = "block";
						document.getElementById("label6").style.display = "block";
					}
				});
			});
		}
	</script>

	<script>
		function FileImageFunction() {
		$('#file-upload').change(function () {
			$.get("<?php echo base_url('index.php/ajax/imageupload'); ?>")
			$('#file-upload').val('');// set the value to empty of myfile control.
			});
		};
	</script>
</head>
<body>

<div class="main-wrapper">
	<div class="col-half background-blue-light height-100 align-center">
		<div class="flex-column align-start width-650">
			<div align="center">
				<h2 class="heading mb-35">
					<?php echo $this->language->line("FOUND-010","LET'S GET THIS ITEM BACK TO THE RIGHTFUL OWNER. ");?>
				</h2>
			</div>
			<div align="center" style="margin-bottom: 30px">
				<?php echo $this->language->line("FOUND-020",'TO GET THE ITEM YOU FOUND BACK TO TH RIGHTFUL OWNER WE NEED SOME INFORMATION TO MAKE THIS HAPPEN.');?>
				<p class="text-content-light" style="font-size: 24px; padding-top: 10px" >
					LOST AND FOUND, RETURNED WITH YOUR HELP.
				</p>
			</div>
			<?php
			$this->load->helper('form');
			echo $this->session->flashdata('fail'); ?>
			<div class="row">
				<div class="col-md-12" id="mydivs">
					<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
				</div>
			</div>
			<?php
			$this->load->helper('form');
			$error = $this->session->flashdata('error');
			if($error){
				?>
				<div id="mydivs1">
					<div class="alert alert-danger alert-dismissable" id="mydivs">
						<button id="mydevs" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $error; ?>
					</div>
				</div>
			<?php }
			$success = $this->session->flashdata('success');
			if($success){
				?>
				<div class="alert alert-success alert-dismissable" id="mydivs2">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $success; ?>
				</div>
			<?php } ?>

			<form action="<?php echo base_url(); ?>foundregister" method="post" align="center">
				<div align="center">
					<img border="0" src="<?php echo base_url(); ?>tiqsimg/StickerMockup.png" alt="tiqs" width="250" height="90" />
					<?php if (empty($code)) { ?>
						<div align="center" style="font-family:caption-light; padding: 10px">
							<input type="code" class="form-control" placeholder="<?php echo $this->language->line("FOUND-01030",'Unique code from sticker or tag');?>" name="code" style="border-radius: 50px" required/>
						</div>
						<div style="text-align: center; ">
							<a href="<?php echo base_url(); ?>itemfound" class="button button-orange"><?php echo $this->language->line("FOUND-01032",'NO TAG? PLEASE MAKE A PICTURE');?></a>
						</div>
					<?php
					}
					?>
					<h2><?php $code;?></h2>
				</div>



				<div style="font-family:caption-light; padding: 10px; margin-bottom: 30px" align="center">
					<h2 style="font-family: caption-bold"><?php echo $this->language->line("FOUND-040",'HOW IT WORKS');?></h2>
				</div>

				<div style="font-family:caption-light; padding: 10px" align="center">
					<p style="font-family: caption-light">
						<?php echo $this->language->line("FOUND-050",'PLEASE STATE YOUR MOBILE NUMBER AND/OR E-MAIL. (WE WILL NOT SHARE THIS INFO WITH THE OWNER UNLESS YOU CONSENT TO THIS BY CHECKING THE GDPR AND SHARE CHECKBOX BELOW. )');?>
						<br>
					</p>
				</div>
				<div style="font-family:caption-light; padding: 10px">
					<input type="tel" class="form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="Mobile" name="mobile" />
				</div>

				<div style="font-family:caption-light; padding: 10px">
					<input type="email" id="email" value="<?php $email;?>" class="form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="<?php echo $this->language->line("FOUND-070",'Your e-mail');?>" id="email" name="email"  required />
				</div>

				<div style="font-family:caption-light; padding: 10px">
					<input type="email" value="<?php $email;?>" class="form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="Repeat email for verification" name="emailverify" onfocusout="myFunction(this.value)" required />
				</div>

				<div style="font-family:caption-light; padding: 10px">
					<p id="UnkownAddressText" style="font-family:'caption-light'; display:none; text-align: center">
						<?php echo $this->language->line("FOUND-080",'WHERE CAN WE LET DHL EXPRESS COLLECT THE FOUND ITEM?<br/> YOU CAN HAVE DHL EXPRESS COLLECT THE FOUND ITEM AT A GIVEN TIME AT YOUR ADDRESS,PLEASE STATE YOUR NAME, HOME OR OTHER PHYSICAL ADDRESS. WHEN YOUR NAME AND ADDRESS HAS BEEN FILED, WE DO NOT ASK (SHOW) THIS AGAIN, FOR SECURITY REASONS. CHANGE OF ADDRESS CAN BE DONE IN YOUR PERSONAL PROFILE, WHEN SECURELY LOGGED IN, YOUR CREDENTIALS HAVE BEEN SEND BY SEPARATE MAIL, TO THE GIVEN E-MAIL ACCOUNT IN THIS SCREEN.');?>
					</p>
				</div>

				<div style="font-family:caption-light; padding: 10px; display:none" id="label1">
					<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUND-090",'Name');?>" id="name" name="name"  />
				</div>

				<div style="font-family:caption-light; padding: 10px; display:none" id="label2">
					<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUND-100",'Address');?>" id="address" name="address"  />
				</div>

				<div style="font-family:caption-light; padding: 10px; display:none" id="label3">
					<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUND-110",'Extra address line');?>" id="addressa" name="addressa"  />
				</div>

				<div style="font-family:caption-light; padding: 10px; display:none" id="label4" >
					<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUND-120",'Zipcode');?>" id="zipcode" name="zipcode"  />
				</div>

				<div style="font-family:caption-light; padding: 10px; display:none" id="label5">
					<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("FOUND-130",'City');?>" id="city" name="city"  />
				</div>
				<div style="font-family:caption-light; padding: 10px; display:none" id="label6">
					<div class="selectWrapper" style="display: none; padding: 10px" id="country1">
						<select class="selectBox" id="country" name="country" font-family:'caption-light';" required />
						<option value="">
							<?php echo $this->language->line("FOUND-140","Select your country");?>
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
				</div>

				<div class="login-box" align="center">
					<p style="font-family:'caption-light'; font-size:100%; color: #fff9df; margin:20px,20px,20px,200px; text-align: center">
						<?php echo $this->language->line("FOUND-160",'I GIVE MY CONSENT (GDPR PRIVACY) THAT THE OWNER CAN DIRECTLY CONTACT ME. ');?>
					</p>

					<div class="form-group has-feedback">
						<div class="onoffswitch">
							<input type="checkbox" name="consentdirectcontact" class="onoffswitch-checkbox" id="consentdirectcontact">
							<label class="onoffswitch-label" for="consentdirectcontact">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>

				</div>

 				<p>
					<br>
					<?php echo $this->language->line("FOUND-170",'THE OWNER MAY HAVE SET A FINDERS FEE. AFTER THE ITEM HAS RETURNED TO THE RIGHTFUL OWNER, THE FINDERS FEE WILL BE TRANSFERRED TO YOUR BANK ACCOUNT. YOUR BANK DETAILS CAN BE SECURELY SUBMITTED IN YOUR PROFILE CREDENTIALS ARE SEND BY E-MAIL (PLEASE CHECK YOUR SPAM)');?>
					<br>

				<div class="form-group has-feedback" style="padding: 30px;">

					<div style="text-align: center; ">
						<input type="submit" class="button button-orange" value="<?php echo $this->language->line("FOUND-180",'SUBMIT FOUND ITEM');?>" style="border: none" />
					</div>
					<br>

				</div>
				<div class="clearfix"></div>
				<div class="row" align="center" style="padding:0px ">
					<img border="0" src="<?php echo base_url(); ?>tiqsimg/tiqslogonew.png" alt="tiqs" width="125" height="45" />
				</div class="login-box">
				<div class="text-center mt-50 mobile-hide">
					<img border="0" src="<?php echo base_url(); ?>assets/home/images/TIQSWallet.png" alt="tiqs" width="250" height="200" />
				</div class="login-box">
			</form>

		</div>
	</div>

	<div class="col-half background-apricot">
		<div class="flex-column background-orange height">
			<div align="left">
				<div class="flex-column align-start width-650">
					<p style="font-family:'caption-bold'; font-size:300%; color:#ffffff; text-align: center">
						<?php echo $this->language->line("HOWITORKSBUSINESS-1000",'HOW IT WORKS. ');?>
					</p>
					<section id="cd-timeline" >
						<div class="cd-timeline-block">
							<div class="cd-timeline-img cd-picture">
								<span>1</span>
							</div>

							<div class="cd-timeline-content">
								<h2>REGISTER YOUR BUSINESS</h2>
								<!--                        <div class="timeline-content-info">-->
								<!--                        <span class="timeline-content-info-title">-->
								<!--                        <i aria-hidden="true"></i>-->
								<!--                        HOW IT WORKS-->
								<!--                        </span>-->
								<!--                                        <span class="timeline-content-info-date">-->
								<!--                        <i aria-hidden="true"></i>-->
								<!--                      </span>-->
								<!--                        </div>-->
								<p class="text-content-light">Working alongside requires registration of your business. This is the first step of using the lost & found TIQS solution </p>
								<div class="flex-column align-space">
									<p class="text-content-light"><?php echo $this->language->line("HOWITORKSBUSINESS-1200",'LOST BY YOUR CUSTOMER, <br>RETURNED BY US.');?>
									</p>
									<div align="center">
										<a href="<?php echo base_url(); ?>registerbusiness" target="_blank" class="button button-orange mb-25"><?php echo $this->language->line("HOWITORKSBUSINESS-1300",'GET YOUR ACCOUNT');?></a>
									</div>
								</div>
							</div> <!-- cd-timeline-content -->

							<div id="timeline-video-2">
								<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/357256299" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div>
							</div><!-- time line video for second block -->

						</div> <!-- cd-timeline-block -->

						<div class="cd-timeline-block">
							<div class="cd-timeline-img cd-movie">
								<span>2</span>
							</div> <!-- cd-timeline-img -->

							<div class="cd-timeline-content">
								<h2>DOWNLOAD THE APP</h2>
								<p class="text-content-light">After registering your account, you have a business login (send by e-mail to you, please check your spam). When you login for the first time you need to activate your account with a code. This code is also send to your e-mail address. Now you are able to register lost and found items with a mobile phone (ANDROID and/or IOS). </p>
								<div class="flex-column align-space">
									<p class="text-content-light"><?php echo $this->language->line("HOWITORKSBUSINESS-1400",'LOST BY YOUR CUSTOMER, <br>RETURNED BY US.');?>
									</p>
									<div align="center">
										<!--                                href="<?php echo base_url(); ?>menuapp target="_blank"" -->
										<a  class="button button-orange mb-25" id='show-timeline-video-2'><?php echo $this->language->line("HOWITORKSBUSINESS-1500",'DOWNLOAD APP');?></a>
									</div>
								</div>
								<!--<span class="cd-date">Jan 18</span>-->
							</div> <!-- cd-timeline-content -->
						</div> <!-- cd-timeline-block -->

						<div class="cd-timeline-block">
							<div class="cd-timeline-img cd-picture">
								<span>3</span>
							</div>
							<div class="cd-timeline-content">
								<h2>MAKE THE ITEMS VISIBLE ON YOUR WEBSITE</h2>
								<p class="text-content-light">After registration of lost and found items in your account, you can make an overview available on your website, or use the TIQS lost and found web-page. </p>
								<div class="flex-column align-space">
									<p class="text-content-light"><?php echo $this->language->line("HOWITORKSBUSINESS-1600",'LOST BY YOUR CUSTOMER, <br>RETURNED BY US.');?>
									</p>
									<div align="center">
										<a href="<?php echo base_url(); ?>menuapp" target="_blank" class="button button-orange mb-25"><?php echo $this->language->line("HOWITORKSBUSINESS-1700",'HOW TO SHOW ITEMS');?></a>
									</div>
								</div>
								<!--<span class="cd-date">Jan 18</span>-->
							</div> <!-- cd-timeline-content -->
						</div> <!-- cd-timeline-block -->

						<div class="cd-timeline-block">
							<div class="cd-timeline-img cd-location">
								<span>4</span>
							</div> <!-- cd-timeline-img -->

							<div class="cd-timeline-content">
								<h2>YOUR ALL SETUP NOW!</h2>
								<p class="text-content-light">You are all setup now! You are now able to have guest claim lost and found items, without any cumbersome procedures and handling costs.</p>
								<!-- <span class="cd-date">Feb 14</span>-->
							</div> <!-- cd-timeline-content -->
						</div> <!-- cd-timeline-block -->

						<div class="cd-timeline-block">
							<div class="cd-timeline-img cd-location">
								<span>5</span>
							</div>

							<div class="cd-timeline-content">
								<h2>ADDITIONAL OPTIONS</h2>
								<p class="text-content-light">Learn more about all the posibilities TIQS lost and found offers. Set your lost and found collect times, give limited access to you housekeeping for lost and found item registration, connect TIQS lost and found to your hospitality system. Change standard forms and e-mails in line with your corporate house style.  </p>
								<!--<span class="cd-date">Feb 18</span>-->
								<div class="flex-column align-space">
									<div align="center">
										<a href="" target="_blank" class="button button-orange mb-25"><?php echo $this->language->line("HOWITORKSBUSINESS-1800",'LEARN MORE VIDEO');?></a>
									</div>
								</div>
							</div> <!-- cd-timeline-content -->

						</div> <!-- cd-timeline-block -->

						<div class="cd-timeline-block">
							<div class="cd-timeline-img cd-movie">
								<span>6</span>
							</div> <!-- cd-timeline-img -->

							<div class="cd-timeline-content">
								<h2>FINALLY</h2>
								<p class="text-content-light">Any questions or suggestions contact us with the button below. </p>
								<!-- <span class="cd-date">Feb 26</span>-->
								<div class="flex-column align-space">
									<div align="center">
										<a href="" target="_blank" class="button button-orange mb-25"><?php echo $this->language->line("HOWITORKSBUSINESS-1900",'CONTACT');?></a>
									</div>
								</div>
							</div> <!-- cd-timeline-content -->

						</div> <!-- cd-timeline-block -->
					</section> <!-- cd-timeline -->
					<div class="row" align="center" style="padding:50px ">
						<img border="0" src="<?php echo base_url(); ?>tiqsimg/tiqslogonew.png" alt="tiqs" width="125" height="45" />
					</div class="login-box">
				</div>
			</div>
		</div>
	</div>


<!--	<div class="col-half background-apricot">-->
<!--		<div class="flex-column background-orange height">-->
<!--			<div align="left">-->
<!--				<h2 class="heading mb-35">-->
<!--					--><?//=$this->language->line("FOUND-190",'THE PROCESS OF RETURNING A FOUND ITEM, FINDERS FEE AND PRIVACY');?>
<!--				</h2>-->
<!--				<ol Style="font-family: caption-light; font-size: larger" align="left">-->
<!--					<li>REGISTER THE FOUND ITEM WITH THE UNIQUE CODE, BY SUBMITTING THE FOUND ITEM, WITH THE BUTTON BELOW THE FORM.</li>-->
<!--					<li>STATE PHONE NUMBER AND/OR E-MAIL ADDRESS. SO WE OR THE OWNER CAN CONTACT YOU. PLEASE READ OUR GUIDELINES ON DIRECT CONTACT.</li>-->
<!--					<li>WHEN YOU WANT TO CONTACT DIRECTLY THE OWNER, YOUR CAN CHECK THE SWITCH TO GIVE CONSENT IN SHARING YOUR PHONE NUMBER / E-MAIL ADDRESS WE WILL NOT SHARE YOUR GIVEN ADDRESS IN ANY CASE, EVEN WHEN YOU HAVE CONSENTED WITH THE GDPR SHARE INFO CHECKBOX. THIS ADDRESS IS ONLY USED FOR COLLECTING THE ITEM BY DHL EXPRESS, IF APPLICABLE.-->
<!--					WE WILL KEEP YOU UPDATED ABOUT THE RETURN PROCESS BY E-MAIL</li>-->
<!--					<li>WHEN WE DO NOT KNOW YOUR PHONE NUMBER AND/OR E-MAIL ADDRESS WE WILL ASK YOUR PHYSICAL YOUR ADDRESS TO COLLECT THE ITEM FROM.</li>-->
<!--					<li>WHEN THE OWNER HAS SET, OPTIONALLY, A "FINDERS FEE" WE WILL ASK YOU FOR YOUR BANK ACCOUNT.</li>-->
<!--					<li>THE FINDERS FEE IS PROCESSED BY US THROUGH AN ESCROW ACCOUNT. THE OWNER FIRST HAS TO PAY THE FINDERS FEE BEFORE WE PROCESS THE ITEM AND SHIP IT BACK TO THE OWNER. YOUR PHONE NUMBER AND/OR E-MAIL IS THEREFORE PROCESSED ONLY AFTER WE HAVE RECEIVED THE FINDERS FEE IN THE ESCROW ACCOUNT. THIS IS TO SECURE YOUR FINDERS FEE! </li>-->
<!--					<li>ONLY A FOUND ITEM DELIVERED AFTER THE RECEIPT OF THE FINDERS FEE AND/OR BY DHL EXPRESS AND PROCESSED BY US, GUARANTEES YOUR FINDERS FEE!</li>-->
<!--					<li>THE SET FINDERS FEE BY THE OWNER IS NOT NEGOTIABLE.</li>-->
<!--					<li>IN YOUR PERSONAL ACCOUNT YOU CAN FIND THE PROCESS OF THE ITEM AND YOUR FINDERS FEE PAYMENT.</li>-->
<!--					<li>YOUR PERSONAL ACCOUNT CREDENTIALS ARE SEND TO YOU BY THE GIVEN E-MAIL WHILE REGISTERING.</li>-->
<!--					<li>PLEASE CHECK YOU SPAM FOLDER! AS E-MAILS CAN BE RECEIVED AS SPAM, WE APOLOGIZE FOR THE INCONVENIENCE.</li>-->
<!--				</ol>-->
<!--				<div style="text-align: center; margin-top: 30px">-->
<!--					<a href="--><?php //echo base_url(); ?><!--howitworksconsumer" class="button button-orange">--><?//=$this->language->line("FOUND-200",'HOW IT WORKS');?><!--</a>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="background-apricot height">-->
<!--			<div class="flex-column align-start width-650">-->
<!---->
<!--				<div class="flex-row align-space">-->
<!--					<div class="flex-column align-space">-->
<!--						<p style="font-family:'caption-bold'; word-wrap:break-word; font-size:300%; color:#ffffff; ">-->
<!--							--><?//=$this->language->line("FOUND-210",'PRIVACY, COOKIE POLICY AND OTHER LEGAL COMPLIANCE.');?>
<!--						</p>-->
<!--						<div>-->
<!--							<p style="font-family:'caption-light'; font-size:100%; color:#ffffff; margin:20px,20px,20px,200px; text-align: left">-->
<!--								--><?//=$this->language->line("FOUND-220","BY CLICKING THE REGISTER BUTTON, YOU AGREE TO OUR TERMS OF USE, E-MAIL OPT-IN, PRIVACY POLICY AND DISCLAIMER.");?>
<!--								<br />-->
<!--							</p>-->
<!--						</div>-->
<!--						<p style="font-family:'caption-light'; color: #ffffff; font-size:100%; text-align: left; ">-->
<!--							--><?//=$this->language->line("FOUND-230",'READ MORE ABOUT OUR, PRIVACY, COOKIE POLICY AND DISCLAIMER.');?>
<!--						</p>-->
<!--						<p>-->
<!--							<br>-->
<!--						</p>-->
<!--						<a href="--><?php //echo base_url(); ?><!--legal" class="button button-orange">--><?//=$this->language->line("FOUND-240",'MORE INFO');?><!--</a><p>-->
<!--							<br>-->
<!--						</p>-->
<!--						<p>-->
<!--							<br>-->
<!--						</p>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
	</div>
</div>
<!-- end col half -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

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
