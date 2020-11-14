<style>
    .active {
        background-color: #E25F2A !important;
    }
</style>
<!-- end header -->
<div class="main-wrapper">
    <div class="col-half background-orange height-100 align-center">
        <div class="flex-column align-start width-650">

            <div class="flex-row align-space">
                <div class="flex-column align-space">


                    <?php include_once FCPATH . 'application/views/includes/sessionMessages.php'; ?>
					<form id="checkItem" action="<?php echo $this->baseUrl; ?>checkregister" method="post" enctype="multipart/form-data" style="width:100%">
                        <input type="text" value = "tiqs supplied label or sticker" name="label[descript]" readonly required hidden />
                        <input type="text" value = "0" name="label[lost]" readonly required hidden />
                        <?php if (isset($userId)) { ?>
                            <input type="text" name="userId" value="<?php echo $userId; ?>" readonly required hidden />
                        <?php } else { ?>
                        <input type="text" value = "<?php echo $createdBy; ?>" name="user[createdBy]" readonly required hidden />
                        <input type="text" value = "<?php echo $istype; ?>" name="user[istype]" readonly required hidden />
                        <input type="text" value = "<?php echo $isDropOffPoint; ?>" name="user[IsDropOffPoint]" readonly required hidden />
                        <?php } ?> 

                        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                             <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <?php if (!isset($userId)) { ?>

								<div class="item active">
									<div style="text-align:center">
										<h2 class="heading mb-35">
											<?php echo $this->language->line("CHECK-010",'WELCOME TO THE WORLD LARGEST SIMPLE, HONEST LOST AND FOUND SOLUTION.');?>
										</h2>
									</div>
									<div style=" font-size: x-large">
										<p style="text-align:center">LOST BY YOU, RETURNED BY US
										</p>
									</div>

									<div>
										<p style="text-align:left; font-family: caption-light">
											<?php echo $this->language->line("CHECK-020",'JUST PUT YOUR TIQS STICKER(S) ON ANY ITEM, YOU DO NOT WANT TO GET LOST. WHEN YOUR ITEM IS TAGGED AND REGISTERED AND UNFORTUNATELY GOES MISSING, THE PERSON WHO FINDS IT CAN IMMEDIATELY NOTIFY YOU. SIMPLE, HONEST AND EFFECTIVE, AND FINALLY WHEN FOUND YOU CAN ARRANGE SHIPMENT WITH DHL EXPRESS, TO PICK IT UP AND GET YOUR BELONGINGS BACK');?>
											<br/>
											<br/>
										</p>
									</div>
                                    <p style="text-align:center; font-family: caption-light"> <?php echo $this->language->line("CHECK-030",'YOUR E-MAIL ADDRESS, TO REGISTER THE ITEM ON. <br/>Your e-mail address is only used by TIQS we do not share your e-mail address with 3rd parties!, read more about this in our privacy, cookie policy and terms of use statement');?></p>
                                    <div class="form-group has-feedback">
                                        <input type = "email" id = "email"  onblur="checkEmail(this)"  name = "user[email]" requried class = "form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="<?php echo $this->language->line("CHECK-040",'Your e-mail');?>" />
                                    </div>
                                    <div>
                                        <p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  text-align: center">
                                            <?php echo $this->language->line("CHECK-130",'Validate Your e-mail address');?>
                                        </p>
                                    </div>


                                    <div class="form-group has-feedback">
                                        <input type="email" id="emailverify" name="user[emailverify]"  requried class="form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="<?php echo $this->language->line("CHECK-140",'Repeat email for verification');?>" />
                                    </div>
								</div>

								<div class="item">
                                    <div class="login-box">
                                        <p id="UnkownAddressText" style="font-family:'caption-light'; display:none; font-size:100%; color:#ffffff;  text-align: center">
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
                                        <input id="username" name="user[username]" type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-070",'Your full name');?>" />
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input id="address" name="user[address]" type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-080",'Your address');?>" />
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input id="addressa" name="user[addressa]" type="text" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-090",'Extra address line');?>" />
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input type="text" id="zipcode" name="user[zipcode]" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-100",'Your zipcode');?>" />
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input type="text" id="city" name="user[city]" class="form-control" style="display: none; font-family:'caption-light'; border-radius:50px; " placeholder="<?php echo $this->language->line("CHECK-110",'City');?>" />
                                    </div>
                                    <div class="selectWrapper" id="country1" style="background-color: #e25f2a;">
                                        <select class="selectBox" id="country" name="user[country]" style="display: none; font-family:'caption-light'; background-color: #eec5a7; border-radius: 50px; height: 32px;">
                                            <?php include_once FCPATH . 'application/views/includes/countrySelectOptions.php'; ?>
                                        </select>
                                    </div>
                                    <div>
                                        <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
                                            <?php echo $this->language->line("CHECK-150",'Your mobile phone number for SMS when someone finds this registered item. Number formatted as country code and phone number 0099123456789');?>
                                        </p>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input type="tel" name="user[mobile]" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->line("CHECK-160",'Your mobile number');?>" />
                                    </div>
                                    <div class="form-group has-feedback align-center">
                                        <div>
                                            <p style="font-family:'caption-light'; font-size:100%; color: #fff9df">
                                                <?php echo $this->language->line("CHECK-1170",'Check this box, when your code is attached to your mobile phone. (SMS will be send to your friends phone)');?>
                                            </p>
                                        </div>
                                        <div class="form-group has-feedback align-center">
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
                                        <input type="tel" name="user[lfbmobile]" class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->line("CHECK-190",'Your friends mobile number');?>" />
                                    </div>
                                </div>
                                <?php } ?>

                                <div class="item">
                                    <img src="<?php echo $this->baseUrl; ?>tiqsimg/StickerMockup.png" alt="tiqs" width="250" height="90" />
                                    <?php if ($code) { ?>
                                        <input type="text" name="label[code]" value="<?php echo $code; ?>" readonly requried hidden />
                                        <h2><?php echo $code; ?></h2>
                                    <?php } else { ?>							
                                    <div class="form-group has-feedback" style="padding: 10px">
                                        <h2 id="h2Code"></h2>
                                        <img id="labelImg" class="img-responsive center-block" />
                                        <input type="text" name="label[image]" id="imageResponseDatabaseName" readonly requried hidden />
                                        <input type="text" name="imageResponseFullName" id="imageResponseFullName" readonly requried hidden />
                                        <input id="inputManualCode" oninput="hideElement(this, 'imageDiv')" type="text" name="label[code]" class="form-control" placeholder="<?php echo $this->language->line("CHECK-200",'Unique code from sticker or tag');?>" style="font-family:'caption-light'; border-radius: 50px;" />
                                    </div>
                                    <div>
                                        <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
                                            <?php echo $this->language->line("CHECK-123210",'PLEASE ENTER THE UNIQUE CODE FROM THE STICKER/TAG. BY PRESSING THE "REGISTER YOUR ITEM" BUTTON IT IS ADDED TO YOUR ACCOUNT, NO TAGS OR STICKERS?, YOU CAN MAKE A PICTURE');?>
                                        </p>
                                    </div>
                                    <div style="text-align:center" class="mb-35" id="imageDiv">
                                        <label for="labelImage" onclick="triger('labelImage')" class="button button-orange"><?php echo $this->language->line("CHECK-C211032",'MAKE A PICTURE ');?></label>
                                        <input type="file" name="image" id="labelImage" style="display:none" />
                                    </div>
                                    <?php } ?>	
                                </div>
                                <div class="item">
                                
                                    <div class="form-group has-feedback" style="padding: 10px">
                                        <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
                                            <?php echo $this->language->line("CHECK-C122111032",'SELECT AN ITEM CATEGORY');?>
                                        </p>
                                        <div class="selectWrapper" id="caterory" style="background-color: #e25f2a;">

                                            <select class="selectBox" name="label[categoryid]" requried style="font-family:'caption-light'; background-color: #eec5a7; border-radius: 50px; height: 32px;" >
                                                <option value="">
                                                    <?php echo $this->language->line("CHECK-C22311032",'Select');?>
                                                </option>
                                                <?php
                                                foreach ($categories as $row) {
                                                    echo '<option value="' . $row->id . '">' . $row->description . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback" >
                                        <div style="text-align: center; ">
                                            <?php if (isset($userId)) { ?>
                                            <input  type="submit" class="button button-orange" value="<?php echo $this->language->line("CHECK-240",'REGISTER YOUR ITEM');?>" style="border: none" />
                                            <?php } else { ?>
                                            <input  type="button" onclick="checkValuesAndSubmit('checkItem', 'email', 'emailverify')" class="button button-orange" value="<?php echo $this->language->line("CHECK-240",'REGISTER YOUR ITEM');?>" style="border: none" />
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Left and right controls -->
							<div class="mt-50" align="center">
								<a class="left mt-50" type="button" href="#myCarousel" data-slide="prev">
									<input type="button" class="button button-orange" value="<?php echo 'Previous' ?>" style="border: none"  />
								</a>

								<a class="right mt-50" href="#myCarousel" data-slide="next">
									<input type="button" class="button button-orange" value="<?php echo 'Next' ?>" style="border: none"  />
								</a>
							</div>
                            <!-- Indicators -->
                            <!-- <ol class="carousel-indicators">
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                <li data-target="#myCarousel" data-slide-to="2"></li>
                            </ol> -->
                        </div>
                            
<!--                            <div class="form-group has-feedback" style="padding: 10px">-->
<!--                                <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">-->
<!--                                    Item description-->
<!--                                </p>-->
<!--                                <input type="text" name="label[descript]" requried class="form-control" style="font-family:'caption-light'; border-radius: 50px; " maxlength="254">-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">-->
<!--                                    Item width (in cm)-->
<!--                                </p>-->
<!--                            </div>-->
<!--                            <div class="form-group has-feedback" style="padding: 10px">-->
<!--                                <input type="number" name="label[dclw]" step="0.01" min="1" requried class="form-control" style="font-family:'caption-light'; border-radius: 50px;" />-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">-->
<!--                                    Item length (in cm)-->
<!--                                </p>-->
<!--                            </div>-->
<!--                            <div class="form-group has-feedback" style="padding: 10px">-->
<!--                                <input type="number" name="label[dcll]" step="0.01" min="1" requried class="form-control" style="font-family:'caption-light'; border-radius: 50px;" />-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">-->
<!--                                    Item height (in cm)-->
<!--                                </p>-->
<!--                            </div>-->
<!--                            <div class="form-group has-feedback" style="padding: 10px">-->
<!--                                <input type="number" name="label[dclh]" step="0.01" min="1" requried class="form-control" style="font-family:'caption-light'; border-radius: 50px;" />-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">-->
<!--                                    Item weight (in kg)-->
<!--                                </p>-->
<!--                            </div>-->
<!--                            <div class="form-group has-feedback" style="padding: 10px">-->
<!--                                <input type="number" name="label[dclwgt]" step="0.01" min='0' requried class="form-control" style="font-family:'caption-light'; border-radius: 50px;" />-->
<!--                            </div>-->
						
					</form>
                    <div class="row" style="text-align: center; padding:50px ">
                        <img src="<?php echo $this->baseUrl; ?>tiqsimg/tiqslogonew.png" alt="tiqs" width="125" height="45" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-half background-yellow">
        <div class="background-orange-light height">
            <div class="width-650">
                <h2 class="heading mb-35"><?php echo $this->language->line("CHECK-250",'<a href="https://tiqs.com/lostandfound/personaltagsinfo">GET YOUR FREE TIQS <br>PERSONAL LOST + FOUND<br>STICKERS</a>');?></h2>
                <p style="font-family: caption-light; font-size: larger"> WE ARE THE WORLD LARGEST LOST AND FOUND SOLUTION, TOGETHER WE CAN CREATE THE WORLD LARGEST LOST AND FOUND COMMUNITY! GET YOUR STICKERS AND TAGS HERE, USE THEM FOR YOUR OWN ITEMS, GIVE THEM TO YOUR FRIENDS, FAMILY AND OR OTHER RELATIVES AND ACQUAINTANCES. ORDER YOUR TIQS STICKER/TAG-PACK HERE FOR FREE! </p>
                <p style="font-family: caption-light; font-size: x-small"> (Only shipment will be charged) </p>
                <a style="color:#ffffff" class='how-we-works-link' href="<?php echo $this->baseUrl; ?>howitworksconsumer"><?php echo $this->language->line("CHECK-260",'MORE INFO, HOE IT WORKS');?></a>
                <p class="text-content mb-50"><?php echo $this->language->line("CHECK-70",'LOST BY YOU, <br> RETURNED BY US');?></p>
                <a href="<?php echo $this->baseUrl; ?>check" class="button button-orange mb-35"><?php echo $this->language->line("CHECK-280",'ORDER YOUR FREE STICKERS');?></a>
            </div>
            <div class="text-center mb-30 mobile-hide" style="text-align:center">
                <img src="<?php echo $this->baseUrl; ?>assets/home/images/TIQSKeys.png" alt="tiqs" width="220" height="175" />
            </div>
        </div>
        <div class="background-yellow height-50">
            <div class="width-650">
                <h2 class="heading mb-35"><?php echo $this->language->line("CHECK-A251",'TELL A FRIEND.');?></h2>
                <p style="font-family: caption-light; font-size: larger">TELL A FRIEND AND ENDORSE,
                    OUR PRODUCTS AND SERVICES. THESE EFFORTS ARE BORNE OUT OF GENUINE APPRECIATION FOR THE BRAND AND PRODUCTS.
                </p>
                <p style="font-family: caption-light; font-size: x-large">YOU CAN TELL A FRIEND THROUGH THE FORM BELOW.</p>
                <form action="<?php echo $this->baseUrl; ?>loginMe" method="post" class='homepage-form'>
                    <form action="<?php echo $this->baseUrl; ?>checkregister" method="post">
                        <div class="form-group has-feedback">
                            <input type="email" id="brandemail" class="form-control" style="font-family:'caption-light'; border-radius: 50px; " placeholder="<?php echo $this->language->line("CHECK-252",'Your e-mail');?>" id="brandemail" name="email" onfocusout="myFunctionBrand(this.value)"/>
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
                            <select class="selectBox" id="brandcountry" name="country" style="display: none; font-family:'caption-light';">
                                <?php include_once FCPATH . 'application/views/includes/countrySelectOptions.php'; ?>
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
