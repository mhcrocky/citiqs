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

		function myFunction(str) {
            $(document).ready(function() {
                $.get("<?php echo base_url('index.php/ajax/users/'); ?>" + encodeURIComponent(str), function(data) {
                    var result = JSON.parse(data);
                    // var result1 = JSON.parse(data);
                    // var myJSON = JSON.stringify(data);
                    // document.write(result);
                    // document.write(result1);
                    // document.write(myJSON);
                    // document.write(result.username);
                    //$.each(result, function (i, item) {
                    $('#myTable tbody').append('<tr><td>' + result.username + '</td><td>' + result.email + '</td></tr>');
                    if (result.username == true) {
                        document.getElementById("UnkownAddressText").style.display = "block";
                        document.getElementById("name").style.display = "block";
                        document.getElementById("address").style.display = "block";
                        document.getElementById("addressa").style.display = "block";
						document.getElementById("zipcode").style.display = "block";
						document.getElementById("city").style.display = "block";
                        document.getElementById("country").style.display = "block";
                        document.getElementById("country1").style.display = "block";
                    }
                });
            });
        }

		function myFunctionBrand(str) {
			$(document).ready(function() {
				$.get("<?php echo base_url('index.php/ajax/users/'); ?>" + encodeURIComponent(str), function(data) {
					var result = JSON.parse(data);
					// var result1 = JSON.parse(data);
					// var myJSON = JSON.stringify(data);
					// document.write(result);
					// document.write(result1);
					// document.write(myJSON);
					// document.write(result.username);
					//$.each(result, function (i, item) {
					$('#myTable tbody').append('<tr><td>' + result.username + '</td><td>' + result.email + '</td></tr>');
					if (result.username == true) {
						document.getElementById("brandUnkownAddressText").style.display = "block";
						document.getElementById("brandname").style.display = "block";
						document.getElementById("brandaddress").style.display = "block";
						document.getElementById("brandaddressa").style.display = "block";
						document.getElementById("brandzipcode").style.display = "block";
						document.getElementById("brandcity").style.display = "block";
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
    <div class="col-half background-orange height-100 align-center">
        <div class="flex-column align-start width-650">
            <div align="center">
                <h2 class="heading mb-35">
                    <?php echo $this->language->line("CHECK-010",'WELCOME TO THE WORLD LARGEST SIMPLE, HONEST LOST AND FOUND SOLUTION.');?>
                </h2>
            </div>
            <div class="flex-row align-space">
                <div class="flex-column align-space">
                    <div>
                        <p align="center" style="font-family: caption-light">
                            <?php echo $this->language->line("CHECK-020",'JUST PUT YOUR TIQS STICKER(S) ON ANY ITEM, YOU DO NOT WANT TO GET LOST. WHEN YOUR ITEM IS TAGGED AND REGISTERED AND UNFORTUNATELY GOES MISSING, THE PERSON WHO FINDS IT CAN IMMEDIATELY NOTIFY YOU. SIMPLE, HONEST AND EFFECTIVE, AND FINALLY WHEN FOUND YOU CAN ARRANGE SHIPMENT WITH DHL EXPRESS, TO PICK IT UP AND GET YOUR BELONGINGS BACK');?>
                            <br>
                            <br />
                        </p>
                    </div>
                    <div style=" font-size: x-large">
                        <p align="center">LOST BY YOU, RETURNED BY US
                        </p>
                    </div>
                    <?php
                    $this->load->helper('form');
                    echo $this->session->flashdata('fail'); ?>
                    <div class="row" >
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

					<form action="<?php echo base_url(); ?>checkregister" method="post">
	                    <p align="center" style="font-family: caption-light"> <?php echo $this->language->line("CHECK-030",'YOUR E-MAIL ADDRESS, TO REGISTER THE ITEM ON. <br/>Your e-mail address is only used by TIQS we do not share your e-mail address with 3rd parties!, read more about this in our privacy, cookie policy and terms of use statement');?></p>

                        <div class="form-group has-feedback">
                            <input type="email" id="email" value="<?php $email;?>" class="form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="<?php echo $this->language->line("CHECK-040",'Your e-mail');?>" id="email" name="email" onfocusout="myFunction(this.value)" required />
                        </div>

                        <div class="login-box">
                            <p id="UnkownAddressText" style="font-family:'caption-light'; display:none; font-size:100%; color:#ffffff;  margin:20px,20px,20px,200px; text-align: center">
                                <?php echo $this->language->line("CHECK-050",'HI!, WELCOME, AS A NEW MEMBER TO THE WORLD LARGEST HONEST LOST AND FOUND COMMUNITY!')?>
			                    <?php echo $this->language->line("CHECK-060",'
                                Please state your Name, home (or other physical address). 
                                Your personal data is encrypted stored for security reasons 
                                and we do not ask and show this information again, without login, to protect your personal data and secure your items. 
                                Please read our security by design page. 
                                Not a new member? Than we do not have an address linked to this e-mail from you. 
                                This is necessary to sent the item, to you, when found. 
                                Changes to your address can be made in your personal account profile page. 
                                Your credentials to login have been send to you, after your first registration, by separate mail, upon automatic creation of your account.
                                Please check you SPAM folder when not received.');?>
                                <br>
                                <br />
                            </p>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-070",'Your full name');?>" id="name" name="name" />
                        </div>

                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-080",'Your address');?>" id="address" name="address"  />
                        </div>

                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-090",'Extra address line');?>" id="addressa" name="addressa"  />

                        </div>

						<div class="form-group has-feedback">
							<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-100",'Your zipcode');?>" id="zipcode" name="zipcode"  />

						</div>

						<div class="form-group has-feedback">
                            <input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-110",'City');?>" id="city" name="city"  />

                        </div>

                        <div class="selectWrapper" style="display: none" id="country1">
                            <select class="selectBox" id="country" name="country" style="display: none; font-family:'caption-light';" required />
                            <option value="">
                                <?php echo $this->language->line("CHECK-120","Select your country");?>
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

                        <div>
                            <p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  text-align: center">
                                <?php echo $this->language->line("CHECK-130",'Validate Your e-mail address');?>
                             </p>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="email" value="<?php $email;?>" class="form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="<?php echo $this->language->line("CHECK-140",'Repeat email for verification');?>" name="emailverify" required />
                        </div>
                        <p <br /></p>
                        <div>
                            <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
                                <?php echo $this->language->line("CHECK-150",'Your mobile phone number for SMS when someone finds this registered item. Number formatted as country code and phone number 0099123456789');?>
                            </p>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="tel" value="<?php $mobile;?>" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->line("CHECK-160",'Your mobile number');?>" />
                        </div>

                        <div align="center">
                            <p style="font-family:'caption-light'; font-size:100%; color: #fff9df; text-align: center">
                                <?php echo $this->language->line("CHECK-1170",'Check this box, when your code is attached to your mobile phone. (SMS will be send to your friends phone)');?>
                            </p>

                            <div class="form-group has-feedback">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="ismyphone" class="onoffswitch-checkbox" id="myonoffswitch">
                                    <label class="onoffswitch-label" for="myonoffswitch">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
                                <?php echo $this->language->line("CHECK-180",'Your friends mobile number, when you lost your phone. Number formatted as country code and phone number 0099123456789');?>
                            </p>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="tel" value="<?php $lfbuddymobile;?>" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->line("CHECK-190",'Your friends mobile number');?>" name="lfbuddymobile" />
                        </div>



						<div class="row" align="center" style="padding:0px ">
							<img border="0" src="<?php echo base_url(); ?>tiqsimg/StickerMockup.png" alt="tiqs" width="250" height="90" />

							<?php if(empty($code)) { ?>
								<div class="form-group has-feedback" style="padding: 10px">
									<input type="code" class="form-control" placeholder="<?php echo $this->language->line("CHECK-200",'Unique code from sticker or tag');?>" name="code" style="font-family:'caption-light'; border-radius: 50px;" required/>
								</div>
								<div>
									<p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
										<?php echo $this->language->line("CHECK-210",'PLEASE ENTER THE UNIQUE CODE FROM THE STICKER/TAG. BY PRESSING THE "REGISTER YOUR ITEM" BUTTON IT IS ADDED TO YOUR ACCOUNT');?>
									</p>
								</div>
								<?php
							}
							else{
								?>
								<p style="font-family:'caption-bold'; font-size:300%; color: #6A2B34; text-align: center">
									<?php $code;?>
								</p>
								<div>
									<p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
										<?php echo $this->language->line("CHECK-230",'THIS IS YOUR UNIQUE CODE, BY PRESSING THE "REGISTER YOUR ITEM" BUTTON IT IS ADDED TO YOUR ACCOUNT');?>
									</p>
								</div>
							<?php
							}
							?>

						</div>
						<div class="form-group has-feedback" >
							<div style="text-align: center; ">
								<input type="submit" class="button button-orange" value="<?php echo $this->language->line("CHECK-240",'REGISTER YOUR ITEM');?>" style="border: none" />
							</div>
						</div>

					</form>
                    <div class="row" align="center" style="padding:50px ">
                        <img border="0" src="<?php echo base_url(); ?>tiqsimg/tiqslogonew.png" alt="tiqs" width="125" height="45" />
                    </div class="login-box">
            </div>
        </div>
    </div>
</div>

<div class="col-half">
    <div class="background-orange-light height">
        <div class="width-650">
            <h2 class="heading mb-35"><?php echo $this->language->line("CHECK-250",'<a href="https://tiqs.com/lostandfound/personaltagsinfo">GET YOUR FREE TIQS <br>PERSONAL LOST + FOUND<br>STICKERS</a>');?></h2>
			<p style="font-family: caption-light; font-size: larger"> WE ARE THE WORLD LARGEST LOST AND FOUND SOLUTION, TOGETHER WE CAN CREATE THE WORLD LARGEST LOST AND FOUND COMMUNITY! GET YOUR STICKERS AND TAGS HERE, USE THEM FOR YOUR OWN ITEMS, GIVE THEM TO YOUR FRIENDS, FAMILY AND OR OTHER RELATIVES AND ACQUAINTANCES. ORDER YOUR TIQS STICKER/TAG-PACK HERE FOR FREE! </p>
			<p style="font-family: caption-light; font-size: x-small"> (Only shipment will be charged) </p>
			<a style="color:#ffffff" class='how-we-works-link' href="<?php echo base_url(); ?>howitworksconsumer"><?php echo $this->language->line("CHECK-260",'MORE INFO, HOE IT WORKS');?></a>
            <p class="text-content mb-50"><?php echo $this->language->line("CHECK-70",'LOST BY YOU, <br> RETURNED BY US');?></p>
            <a href="<?php echo base_url(); ?>check" class="button button-orange mb-35"><?php echo $this->language->line("CHECK-280",'ORDER YOUR FREE STICKERS');?></a>
        </div>
		<div class="text-center mb-30 mobile-hide align="center">
		<img border="0" src="<?php echo base_url(); ?>assets/home/images/TIQSKeys.png" alt="tiqs" width="220" height="175" />
	</div class="login-box">

    </div>
        <div class="background-yellow height-50">
            <div class="width-650">
                <h2 class="heading mb-35"><?php echo $this->language->line("CHECK-251",'BECOME A TIQS AMBASSADOR.');?></h2>
				<p style="font-family: caption-light; font-size: larger">BRAND AMBASSADORS ARE ENDORSING OUR PRODUCTS AND SERVICES. THESE EFFORTS ARE BORNE OUT OF GENUINE APPRECIATION FOR THE BRAND.
					THERE ARE NO FIXED QUALIFICATIONS. OUR BRAND AMBASSADORS ARE STUDENTS, HOUSEWIVES, OFFICE WORKERS AND/OR PROFESSIONALS. AS LONG AS THEY HAVE GENUINE APPRECIATION FOR THE BRAND AND SOLUTIONS.
					THIS MEANS THAT OUR BRAND AMBASSADOR CAN BE. . . . . WELL, ANYONE, EVERY WHERE. </p>
				<p style="font-family: caption-light; font-size: x-large">YOU CAN APPLY AS BRAND AMBASSADOR THROUGH THE FORM BELOW.</p>

				<form action="<?php echo base_url(); ?>loginMe" method="post" class='homepage-form'>
					<form action="<?php echo base_url(); ?>checkregister" method="post">
						<div class="form-group has-feedback">
							<input type="email" id="email" value="<?php $email;?>" class="form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="<?php echo $this->language->line("CHECK-252",'Your e-mail');?>" id="brandemail" name="email" onfocusout="myFunctionBrand(this.value)" required />
						</div>

						<p id="brandUnkownAddressText" style="font-family:'caption-light'; margin-bottom: 10px; display:none; font-size:100%; color:#ffffff;  text-align: left" >
								<?php echo $this->language->line("CHECK-290",'THANKS, FOR YOUR APPLICATION AS BRAND AMBASSADOR FOR SUPPORTING TO THE WORLD LARGEST HONEST LOST AND FOUND COMMUNITY!')?>
								<?php echo $this->language->line("CHECK-300",'
                                Please state your Name, home (or other physical address). 
                                Your personal data is encrypted stored for security reasons 
                                and we do not ask and show this information again, without login, to protect your personal data. 
                                Please read our security by design page. 
                                Changes to your address can be made in your personal account profile page. 
                                Your credentials to login have been send to you, after your registration, by separate mail, upon automatic creation of your account.
                                Please check you SPAM folder when not received.');?>
							</p>

						<div class="form-group has-feedback">
							<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-310",'Your full name');?>" id="brandname" name="name"  />
						</div>

						<div class="form-group has-feedback">
							<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-320",'Your address');?>" id="brandaddress" name="address"  />
						</div>

						<div class="form-group has-feedback">
							<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-330",'Extra address line');?>" id="brandaddressa" name="addressa"  />
						</div>

						<div class="form-group has-feedback">
							<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-340",'Your zipcode');?>" id="brandzipcode" name="zipcode" />
						</div>

						<div class="form-group has-feedback">
							<input type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-350",'City');?>" id="city" name="brandcity"  />

						</div>

						<div class="selectWrapper" style="display: none" id="brandcountry1">
							<select class="selectBox" id="brandcountry" name="country" style="display: none; font-family:'caption-light';" required />
							<option value="">
								<?php echo $this->language->line("CHECK-360","Select your country");?>
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
								<input type="submit" class="button button-orange" value="<?php echo $this->language->line("CHECK-370",'APPLY');?>" style="border: none" />
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

<script>
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("modal-button");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // scroll to DHL section

</script>

<script>

    var transitionSpeed = 400;
    var sliderWidth = 520;
    var testimonialCount = 5;
    var testimonialImages = document.getElementById("images").children;
    var testimonials = document.getElementById("testimonials-wrapper");
    var testimonialsStyles = window.getComputedStyle(testimonials);
    var newleft;
    var testimonialBox = document.getElementsByClassName("testimonial-section__text");
    var singleTestimonial = document.getElementsByClassName("single-testimonial")[0];
    var testimonialHeight = 0;

    for (var i = 0; i < testimonialBox.length; i++) {
        console.log('++++', testimonialHeight)
        if (testimonialHeight < testimonialBox[i].offsetHeight) {
            testimonialHeight = testimonialBox[i].offsetHeight + 10;
        }
    }

    singleTestimonial.style.height = testimonialHeight + 10 + 'px';
    testimonials.style.height = testimonialHeight + 10 + 'px';
    console.log(testimonialHeight, 'ovo')

    if (window.innerWidth > 1024) {

    } else {
        sliderWidth = document.getElementsByClassName("testimonial")[0].offsetWidth;
        console.log(sliderWidth, 'else', document.getElementsByClassName("testimonial")[0].offsetWidth)
        testimonials.style.width = sliderWidth * 5 + 'px';
        testimonials.style.left = (sliderWidth * (-2) + 'px');
    }

    function disableEnable(elementId) {
        var element = document.getElementById(elementId);
        element.disabled = true;
        setTimeout(function() {
            element.disabled = false;
        }, transitionSpeed);
    }

    function moveRight() {
        var left = parseInt(testimonialsStyles.getPropertyValue('left'));
        if (left > -(testimonialCount - 1) * sliderWidth) {
            newleft = left - sliderWidth + 'px';
            testimonials.style.left = newleft;
            disableEnable("right");
            for (var counter = 0; counter < (testimonialImages.length - 1); counter += 1) {
                if (testimonialImages[counter].className.indexOf("active-image") !== -1) {
                    testimonialImages[counter].className = "image";
                    testimonialImages[counter].nextElementSibling.className += " active-image";
                    return;
                }
            }
        }
    }

    function moveLeft() {
        var left = parseInt(testimonialsStyles.getPropertyValue('left'));
        if (left < 0) {
            newleft = left + sliderWidth + 'px';
            testimonials.style.left = newleft;
            disableEnable("left");
            for (var counter = 1; counter < testimonialImages.length; counter += 1) {
                if (testimonialImages[counter].className.indexOf("active-image") !== -1) {
                    testimonialImages[counter].className = "image";
                    testimonialImages[counter].previousElementSibling.className += " active-image";
                    return;
                }
            }
        }
    }

    function showTestimonialByImage(imagePixelValue) {
        var allImages = event.target.parentElement.children;
        for (var counter = 0; counter < allImages.length; counter += 1) {
            allImages[counter].className = "image";
        }
        event.target.className += " active-image";
        var testimonials = document.getElementById("testimonials-wrapper");
        testimonials.style.left = imagePixelValue;
        disableEnable("left");
        disableEnable("right");
        console.log('click')
    }

    var left_first = '0px';
    var left_second = (-1 * sliderWidth).toString() + 'px';
    var left_third = (-2 * sliderWidth).toString() + 'px';
    var left_fourth = (-3 * sliderWidth).toString() + 'px';
    var left_fifth = (-4 * sliderWidth).toString() + 'px';

    document.getElementById('image-1').addEventListener('click', function() {
        showTestimonialByImage(left_first)
    });
    document.getElementById('image-2').addEventListener('click', function() {
        showTestimonialByImage(left_second)
    });
    document.getElementById('image-3').addEventListener('click', function() {
        showTestimonialByImage(left_third)
    });
    document.getElementById('image-4').addEventListener('click', function() {
        showTestimonialByImage(left_fourth)
    });
    document.getElementById('image-5').addEventListener('click', function() {
        showTestimonialByImage(left_fifth)
    });

    var slideIndex = 0;
    showSlides();

    function showSlides() {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1
        }
        slides[slideIndex - 1].style.display = "block";
        setTimeout(showSlides, 4000); // Change image every 2 seconds
    }
</script>

<!--<script src='--><?php //echo base_url(); ?><!--assets/js/main.js'></script>-->
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
