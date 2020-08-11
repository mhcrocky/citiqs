
<div class="main-wrapper">

    <div class="col-half background-orange height-100" style="text-align:center">
        <form id="registerVisitor" action="<?php echo base_url()?>Check424/registerVisitor" method="post">
            <input type="number" name="visitor[vendorId]" required readonly hidden value="<?php echo $vendor['vendorId']; ?>"/>
            <div class="card" style="text-align:center">
                <div style="visibility: hidden">
                    <div style="visibility: hidden" class="column-center" id="minutes">MM</div>
                    <div style="visibility: hidden" class="column-left" id="hours">H</div>
                    <div style="visibility: hidden" class="column-right" id="seconds">SS</div>
                </div>
                <h2 class="heading">
                    <h1>"<?php echo $vendor['vendorName']; ?>"</h1>
                    <div style="margin-bottom: 20px;">
                        COVID-19 GUEST QUESTIONNAIR
                        <div>
                            <a href="#info424"><i class="fa fa-info-circle" style="font-size:48px; color:dodgerblue"></i></a>
                        </div>
                    </div>
                </h2>
                <div class="products" style="text-align:center; background-color: rgb(255, 226, 148); height: 577px;">
                    <div class="product background-orange active" style="width:100%">
                        <div style="text-align:center">
                            <div style="margin-bottom: 20px; font-family: caption-light; font-size: medium">
                            </div>
                            <div style="text-align:center">
                                <img src="https://tiqs.com/alfred/assets/home/images/dooropenwhitegreenchecked.png" alt="tiqs" width="150" height="auto">
                            </div>
                            <ul style="list-style-type: none  ;font-family: caption-light; font-size:larger;  margin-left: -40px; margin-top: 20px; text-align:center">
                                <li>TOGETHER WE KEEP OURSELVES SAFE.</li>
                            </ul>
                            <ul style="list-style-type: none  ;font-family: caption-light; font-size:larger;  margin-left: -40px; text-align:center">
                            </ul>
                            <ul style="list-style-type: none  ;font-family: caption-light; font-size:smaller;  margin-left: -40px; text-align:center">
                                <li></li>
                                <li>(Available in more than 107 languages. GO TO the menu to change the language.)</li>
                                <li></li>
                            </ul>                            
                            <div style="text-align:center">
                                <div class="form-group">
                                    <label style="font-family: caption-bold" for="firstName">FIRST NAME</label>
                                    <input
                                        type="text"
                                        id="firstName"
                                        name="visitor[firstName]"
                                        required
                                        class="form-control"
                                        style="font-family:'caption-light'; border-radius: 50px;"
                                        value="<?php echo get_cookie('firstName'); ?>"
                                        />
                                </div>
                                <div class="form-group has-feedback">
                                    <label style="font-family: caption-bold" for="lastName">LAST NAME</label>
                                    <input
                                        type="text"
                                        id="lastName"
                                        name="visitor[lastName]"
                                        required
                                        class="form-control"
                                        style="font-family:'caption-light'; border-radius: 50px;"
                                        value="<?php echo get_cookie('lastName'); ?>"
                                        />
                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                </div>
                                <div style="margin:auto">
                                    <label style="font-family: caption-bold" for="email">E-MAIL</label>
                                    <input
                                        id="email"
                                        type="email"
                                        name="visitor[email]"
                                        required class="form-control"
                                        value="<?php echo get_cookie('email'); ?>"
                                        style="font-family:'caption-light'; border-radius: 50px;"
                                        />
                                </div>
                                <div>
                                    <label style="font-family: caption-bold" for="mobile">MOBILE</label>
                                    <input
                                        id="mobile"
                                        name="visitor[mobile]"
                                        type="tel"
                                        class="form-control"
                                        style="font-family:'caption-light'; border-radius: 50px;"
                                        value="<?php echo get_cookie('mobile'); ?>"
                                        required
                                        />
                                </div>
                                <div>
                                    <label style="font-family: caption-bold" for="tableDescription">TABLE</label>
                                    <input
                                        id="tableDescription"
                                        name="visitor[tableDescription]"
                                        type="text"
                                        class="form-control"
                                        style="font-family:'caption-light'; border-radius: 50px;"
                                        required
                                        />
                                </div>
                                <div>
                                    <input type="radio" id="timeIn" value="1" name="checkStatus" required>
                                    <label for="timeIn">
                                        <p style="margin-top: 20px; margin-left: 100px; font-size: large">
                                            Entering the location
                                        </p>
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" id="timeOut" value="0" name="checkStatus" required>
                                    <label style="margin-top: 30px" for="timeOut">
                                        <p style="margin-top: 20px; margin-left: 100px; font-size: large">
                                            Leaving the location
                                        </p>
                                    </label>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="footeronboarding" style="background-color: #ffe294; margin-top:5px;">
                        <div>
                            <a style="margin-right:5px; font-family: caption-bold; font-size: x-large; display: none" class="button button-orange" id="prev" href="#top" onclick="getfocus()" ripple="" ripple-color="#ffffff">
                                <i class="fa fa-arrow-left" style="font-size:48px;color:darkorange"></i>
                            </a>
                        </div>
                        <div>
                            <a
                                href="javascript:void(0)"
                                style="margin-left:5px; font-family: caption-bold; font-size: x-large"
                                class="button button-orange"
                                ripple-color="#ffffff"
                                onclick="submitForm('registerVisitor')"
                                >
                                <i class="fa fa-arrow-right" style="font-size:48px;color:darkorange"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php if (!is_null($makeOrderCookie)) { ?>
                <br/>
                <br/>
                <a href="<?php echo $makeOrderCookie . $vendor['vendorId']; ?>">Now you can make an order</a>
                <?php } ?>
                <div class="row mt-35" style="text-align: center; padding:50px ">


                    <img src="https://tiqs.com/alfred/assets/home/images/tiqslogowhite.png" alt="tiqs" width="150" height="auto">
                </div>
                <div>
                    <div style="text-align:center">
                        <h2 class="heading">TELL A FRIEND</h2>
                    </div>
                    <a
                        style="margin-right: 10px"
                        href="whatsapp://send?text=Check for 24Hours to avoid queuing, check-in check-out... https://check424.com"
                        data-action="share/whatsapp/share"
                        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                        target="_blank"
                        title="Share on whatsapp">
                        <i class="fa fa-whatsapp" style="font-size:48px;color:darkorange"></i>
                    </a>
                    <a
                        style="margin-right: 10px"
                        href="https://www.facebook.com/sharer/sharer.php?u=https://check424.com&amp;t=Very handy for restaurants, bars, Visitors Check for 24Hours to avoid queuing, check-in check-out... https://check424.com"
                        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                        target="_blank"
                        title="Share on Facebook">
                        <i class="fa fa-facebook" style="font-size:48px;color:darkorange"></i>
                    </a>
                    <a
                        style="margin-right: 10px"
                        href="https://twitter.com/share?url=https://check424.com&amp;text=Very handy for restaurants, bars, Visitors Check for 24Hours to avoid queuing, check-in check-out..."
                        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                        target="_blank"
                        title="Share on Twitter">
                        <i class="fa fa-twitter" style="font-size:48px;color:darkorange"></i>
                    </a>
                    <a
                        style="margin-right: 10px"
                        href="mailto:?subject=Very handy for restaurants, bars, Visitors Check for 24Hours to avoid queuing, check-in check-out.&amp;body=This is handy! please check this out, and tell your friends and bars, cafe's and restaurants. https://check424.com"
                        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                        target="_blank"
                        title="Share on Mail">
                        <i class="fa fa-envelope" style="font-size:48px;color:darkorange"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
    <div class="col-half background-yellow" id="info424">
        <div class="background-orange-light height">
            <div class="width-650"></div>
            <div class="text-center mb-50" style="text-align:center">
                <img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-19-list.png" alt="tiqs" width="150" height="auto" />
            </div>
            <p class="text-content mb-50"><?=$this->language->line("CHECK424-1270AB",'WHY THIS QUESTIONNAIRE?');?></p>
            <ul style="list-style-type: none  ;font-family: caption-light; font-size:larger;  margin-left: -40px " align="leftr">
                <li><?=$this->language->line("CHECK424-41212ABCDF",'RESTAURANTS, BARS, HOSPITALITY BUSINESSES ARE REQUIRED BY LAW TO QUESTION YOU ABOUT YOUR HEALTH TO DETERMINE THE RISK OF SPREADING COVID-19, THE VIRUS.<br>');?></li>
                <p><br></p>
                <li><?=$this->language->line("CHECK4241-41351232ABCDE",'YOU CAN HELP YOUR LOCAL BUSINESS BY PROVIDING THE ANSWERS IN A ELECTRICAL READABLE MANNER, ');?></li>
                <p><br></p>
            </ul>
            <div class="text-center mb-50 mt-50" style="text-align:center">
                <img src="<?php echo $this->baseUrl; ?>assets/home/images/keepdistance.png" alt="tiqs" width="150" height="auto" />
            </div>

          
        </div>

        <div class="text-center mb-30" style="text-align:center">
            <img src="<?php echo $this->baseUrl; ?>assets/home/images/TIQSKeys.png" alt="tiqs" width="220" height="175" />
        </div>

        <div class="background-yellow height-50">
            <div class="width-650">
                <p class="text-content mb-50"><?=$this->language->line("CHECK424-1370AB",'YOUR PRIVACY');?></p>
                <ul style="list-style-type: none  ;font-family: caption-light; font-size:larger;  margin-left: -40px " align="leftr">
                    <li><?=$this->language->line("CHECK424-91-ABCDEF",'WE ALL VALUE OUR PRIVACY YOUR ANSWERS PER QUESTION ARE NOT STORED ANYWHERE');?></li>
                    <p><br></p>
                    <li><?=$this->language->line("CHECK424-195A2BCDEFG",'4 WEEKS AFTER REGISTRATION WE COMPLETELY REMOVED YOU FROM OUR SYSTEM');?></li>
                    <p><br></p>
					Met het invullen van dit formulier ga je akkoord met de gegevensverwerking onder artikel 6 GDPR, c) en het relevante Ministerieel Besluit. Op vraag van de overheid wordt er toegang gegeven tot de data. De gegevens worden niet gebruikt voor commerciële doeleinden en zullen niet aan derden worden verkocht. Na 4 weken worden de gegevens definitief verwijderd. Samen sterk tegen COVID-19!

					<!-- <li><?php #echo $this->language->line("CHECK424-197A2BCDE",'WE MAY ASK YOU TO OPT-IN FOR A TIQS NEWS, YOU SUPPORT OUR BUSINESS  WITH THIS. <br/>THE SERVICE IS FREE, HOWEVER IT IS COSTING US SOME MONEY, YOU CAN ALWAYS SUPPORT IS BY BUYING US A COFFEE! SO WE CAN WORK WHILE YOU SLEEP AND KEEP YOU AND YOUR LOVED ONES SAVE!.');?></li> -->
                    <p><br></p>
                    <li><?=$this->language->line("CHECK424-98A2BCD",'');?></li>
                </ul>
            </div>
            <div class="form-group has-feedback mt-35" >
                <div style="text-align: right">
                    <a href="#top" ><i class="fa fa-arrow-circle-up" style="font-size:48px; color:white"></i></a>
                </div>
                <div style="text-align: center; ">
                    <!-- <a href="pay424" class="button button-orange mb-25"><?php #echo $this->language->line("CHECK424-BUYUS1234",'BUY US A COFFEE...');?></a> -->
                </div>
            </div>
        </div>
    </div>
</div>
