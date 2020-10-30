<!DOCTYPE html>
<html >
<body>
<div class="main-wrapper">
	<?php if($code =='0') { ?>
<div class="col-half background-orange height-100">
	<?php } elseif($code =='-2') { ?>
<div class="col-half background-red height-100">
	<?php } elseif($code =='-1') { ?>
<div class="col-half background-red height-100">
	<?php } elseif($code !='0') { ?>
<div class="col-half background-green-environment height-100">
	<?php } ?>
	<?php if ($code =='0') { ?>
	<?php include_once FCPATH . 'application/views/includes/sessionMessages.php'; ?>
	<form id="checkItem" action="<?php echo $this->baseUrl; ?>cqrcode" method="post" enctype="multipart/form-data"  >
<div class="card">
	<div class="products">
		<div class="product active background-orange" product-id="1" value="peter">
			<div style="text-align:center">
				<div style="text-align:center">
					<h2 class="heading mb-35">
						<?php echo $this->language->line("CHECK424-010AB",'COVID-19 GUEST QUESTIONNAIRE');?>
					</h2>
				</div>
				<p style="hidden" id="onboardingslide" value="1"></p>

				<ul style="list-style-type: none  ;font-family: caption-light; font-size:larger;  margin-left: -40px " align="center">
					<li><?php echo $this->language->line("CHECK424-0200011ABCD",'MAKE A QRCode VALID FOR 24 HOURS, SO THAT YOU CAN QUICKLY, PRIVATELY ENTER A VENUE.');?></li>

				</ul>
				<ul style="list-style-type: none  ;font-family: caption-light; font-size:larger;  margin-left: -40px " align="center">
					<li><?php echo $this->language->line("CHECK424-0200012ABCD",'');?></li>
					<li><?php echo $this->language->line("CHECK424-0200032ABCD",'PLEASE UNDERSTAND THAT YOUR ANSWERS NEED TO BE HONEST TO KEEP YOU AND YOUR LOVED ONES SAVE.');?></li>
					<li><?php echo $this->language->line("CHECK424-0200012ABCD",'');?></li>

				</ul>

				<ul style="list-style-type: none  ;font-family: caption-light; font-size:smaller;  margin-left: -40px " align="center">
					<li><?php echo $this->language->line("CHECK424-10200012ABCD",'');?></li>
					<li><?php echo $this->language->line("CHECK424-10200032ABCD",'(Available in more than 100 languages.)');?></li>
					<li><?php echo $this->language->line("CHECK424-10200012ABCD",'');?></li>
				</ul>

			</div>
		</div>

		<div class="product background-orange" product-id="2" value="peter">
			<div style="text-align:center">
				<h2 class="heading mb-35">
					<?php echo $this->language->line("CHECK424-010AB",'COVID-19 GUEST QUESTIONNAIRE');?>
				</h2>
			</div>

			<div>

				<div>
					<p style="font-size: larger; font-family: caption-light">
						<?php echo $this->language->line("CHECK424-Q0001ABCD",'Check this box, when you do NOT sneeze and/or cough and/or are short of breath and/or have a fever and/or temperature higher than 38 degrees');?>
					</p>
				</div>
				<div class="form-group has-feedback" align="center">
					<div class="onoffswitchblue ">
						<input type="checkbox" name="question1" class="onoffswitchblue-checkbox" id="question1">
						<label class="onoffswitchblue-label" for="question1">
							<span class="onoffswitchblue-inner"></span>
							<span class="onoffswitchblue-switch"></span>
						</label>
					</div>
				</div>

				<div>
					<p style="font-size: larger; font-family: caption-light">
						<?php echo $this->language->line("CHECK424-Q0005ABC",'Check this box, when you where NOT tested for COVID-19 in the last 7 days and or DID NOT had COVID-19 in the last 7 days');?>
					</p>
				</div>
				<div class="form-group has-feedback" align="center">
					<div class="onoffswitchblue">
						<input type="checkbox" name="question4" class="onoffswitchblue-checkbox" id="question5">
						<label class="onoffswitchblue-label" for="question5">
							<span class="onoffswitchblue-inner"></span>
							<span class="onoffswitchblue-switch"></span>
						</label>
					</div>
				</div>

				<div>
					<p style="font-size: larger; font-family: caption-light">
						<?php echo $this->language->line("CHECK424-Q00015A",'Check this box, when you where NOT in contact with someone who was tested within 14 days for COVID-19 and showed symptoms.');?>
					</p>
				</div>
				<div class="form-group has-feedback" align="center">
					<div class="onoffswitchblue">
						<input type="checkbox" name="question4" class="onoffswitchblue-checkbox" id="question11">
						<label class="onoffswitchblue-label" for="question11">
							<span class="onoffswitchblue-inner"></span>
							<span class="onoffswitchblue-switch"></span>
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="product background-orange setpn" product-id="3" >
			<div style="text-align:center">
				<h2 class="heading mb-35">
					<?php echo $this->language->line("CHECK424-010AB",'COVID-19 GUEST QUESTIONNAIRE');?>
				</h2>
			</div>

			<div>
				<p style="font-size: larger; font-family: caption-light">
					<?php echo $this->language->line("CHECK424-02000112AB",'ADDITIONALY WE HAVE TO ASK ABOUT THE HEALTH OF CLOSE RELATIVES ');?>
					<br/>

				</p>
				<div>
					<p style="font-size: larger; font-family: caption-light">
						<?php echo $this->language->line("CHECK424-Q00011A",'Check this box, when roommates, household members are NOT sneezing and/or coughing and/or short of breath and/or having a fever and/or temperature higher dan 38 degrees');?>
					</p>
				</div>
				<div class="form-group has-feedback" align="center">
					<div class="onoffswitchblue">
						<input type="checkbox" name="question1" class="onoffswitchblue-checkbox" id="question7">
						<label class="onoffswitchblue-label" for="question7">
							<span class="onoffswitchblue-inner"></span>
							<span class="onoffswitchblue-switch"></span>
						</label>
					</div>
				</div>

				<div>
					<p style="font-size: larger; font-family: caption-light">
						<?php echo $this->language->line("CHECK424-Q00016AB",'Check this box, when roommates, household members where NOT in contact with someone who was tested within 14 days for COVID-19 and showed symptoms.');?>
					</p>
				</div>
				<div class="form-group has-feedback" align="center">
					<div class="onoffswitchblue">
						<input type="checkbox" name="question4" class="onoffswitchblue-checkbox" id="question12">
						<label class="onoffswitchblue-label" for="question12">
							<span class="onoffswitchblue-inner"></span>
							<span class="onoffswitchblue-switch"></span>
						</label>
					</div>
				</div>

			</div>

			<div>
				<p style="font-size: larger; font-family: caption-light">
					<?php echo $this->language->line("CHECK424-Q00017ABCD",'Check this box, when you are NOT in quarantine or any of your roommates, household members.');?>
				</p>
			</div>
			<div class="form-group has-feedback" align="center">
				<div class="onoffswitchblue">
					<input type="checkbox" name="question4" class="onoffswitchblue-checkbox" id="question13">
					<label class="onoffswitchblue-label" for="question13">
						<span class="onoffswitchblue-inner"></span>
						<span class="onoffswitchblue-switch"></span>
					</label>
				</div>
			</div>


		</div>
		<div class="product background-orange setp" product-id="4" >

			<div style="text-align:center">
				<h2 class="heading mb-35">
					<?php echo $this->language->line("CHECK424-010AB",'COVID-19 GUEST QUESTIONNAIRE');?>
				</h2>
			</div>

			<div class="form-group has-feedback mb-50" >
				<div style="text-align: center; ">
					<input  type="submit" class="button button-orange" value="<?php echo $this->language->line("CHECK424-1240A",'GET YOUR QRCODE');?>" style="border: none" />
				</div>
			</div>

			<div>
				<p style="font-size: larger; font-family: caption-light">
					<?php echo $this->language->line("CHECK424-Q000189BCD",'AFTER 24 HOURS THE QRCode WILL BE INVALID AND YOU CAN MAKE A NEW ONE.');?>
				</p>
			</div>

		</div>
	</div>
	<div class="mt-50">
		<div class="footer">
			<div>
				<a style="margin-right:5px; font-family: caption-bold; display:none; font-size: x-large" class="button button-orange" id="prev" href="#top" onclick="getfocus()" ripple="" ripple-color="#ffffff"><<</a>
			</div>
			<div>
				<a style="margin-left:5px; font-family: caption-bold; font-size: x-large" class="button button-orange" id="next" href="#top"  onclick="getfocus()" ripple="" ripple-color="#ffffff">>></a>
			</div>
		</div>
	</div>
	</form>
	<div class="row mt-50" style="text-align: center; padding:50px ">
		<img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-19-list.png" alt="tiqs" width="auto" height="150" />
	</div>
</div>
	<div class="row mt-50" style="text-align: center; padding:50px ">
		<img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="auto" height="100" />
	</div>


	<?php } elseif($code =='-2') { ?>
	<div class="container">
		<h1 style="font-family: caption-bold; font-size: x-large">QRCODE INDICATES A QUESTION WAS ANSWERED WITH YES.</h1>
		<img src="<?php echo $this->baseUrl; ?>assets/home/images/venueclosed.png" alt="tiqs" width="200" height="200" />
	</div>


	<?php } elseif($code =='-1') { ?>
	<div class="container">
		<h2 class="heading mb-35">
			<?php echo $this->language->line("CHECK424-010AB",'COVID-19 GUEST QUESTIONNAIRE');?>
		</h2>
		<h1 class="mb-50" style="font-family: caption-bold; font-size: x-large">QRCODE HAS EXPIRED</h1>
		<img src="<?php echo $this->baseUrl; ?>assets/home/images/scanagain.png" alt="tiqs" width="200" height="225" />
		<h1 style="font-family: caption-bold; font-size: x-large">A NEW QRCODE NEEDS TO BE MADE</h1>
	</div>

	<?php } elseif($code !='0') { ?>
	<div class="container">
		<h1 style="font-family: caption-bold; font-size: x-large">QRCODE IS STILL VALID FOR THE NEXT</h1>
		<ul>
			<li><span id="hours"></span>Hours</li>
			<li><span id="minutes"></span>Minutes</li>
			<li><span id="seconds"></span>Seconds</li>
		</ul>
	</div>
	<?php } ?>
</div>

<div class="col-half background-yellow">
	<div class="background-orange-light height">
		<div class="width-650"></div>
		<div class="text-center mb-50" style="text-align:center">
			<img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-19-list.png" alt="tiqs" width="150" height="auto" />
		</div>
			<p class="text-content mb-50"><?php echo $this->language->line("CHECK424-1270AB",'WHY THIS QUESTIONNAIRE?');?></p>
			<ul style="list-style-type: none  ;font-family: caption-light; font-size:larger;  margin-left: -40px " align="leftr">
				<li><?php echo $this->language->line("CHECK424-41212ABCDF",'RESTAURANTS, BARS, HOSPITALITY BUSINESSES ARE REQUIRED BY LAW TO QUESTION YOU ABOUT YOUR HEALTH TO DETERMINE THE RISK OF SPREADING COVID-19, THE VIRUS.<br>');?></li>
				<p><br></p>
				<li><?php echo $this->language->line("CHECK424-113243232ABCD",'ADHOC PROCESSING THESE QUESTIONS, TAKES TIME (5 MINUTES PER PERSON) AND DUE TO THE MANUAL LABOUR THERE IS A HIGH COST AND IMPACT ON ANY ORGANISATION .');?></li>
				<p><br></p>
				<li><?php echo $this->language->line("CHECK424-12415232ABCD",'TIQS SUPPORTS FOR FREE A SOLUTION TO HAVE THE QUESTIONS PROCESSED BEFORE AND VALID FOR 24 HOURS. DOES YOUR STATE OF HEALTH CHANGE WITHIN THESE 24 HOURS PLEASE STAY HOME!');?></li>
				<p><br></p>
				<li><?php echo $this->language->line("CHECK4241-41351232ABCD",'YOU CAN HELP YOUR LOCAL BUSINESS BY PROVIDING THE ANSWERS IN A ELECTRICAL READABLE MANNER, HAVE YOUR QRCode READY AND SHOW YOUR QRCode ON ENTRANCE ');?></li>
				<p><br></p>
			</ul>
			<div class="form-group has-feedback mt-50" >
				<div style="text-align: center; ">
					<input  type="submit" class="button button-orange" value="<?php echo $this->language->line("CHECK424-100240AB",'BUY US A COFFEE');?>" style="border: none" />
				</div>
			</div>
			<div class="text-center mb-50" style="text-align:center">
				<img src="<?php echo $this->baseUrl; ?>assets/home/images/keepdistance.png" alt="tiqs" width="150" height="auto" />
			</div>
			</div>

		<div class="text-center mb-30" style="text-align:center">
			<img src="<?php echo $this->baseUrl; ?>assets/home/images/TIQSKeys.png" alt="tiqs" width="220" height="175" />
		</div>

	<div class="background-yellow height-50">
		<div class="width-650">
			<p class="text-content mb-50"><?php echo $this->language->line("CHECK424-1370AB",'YOUR PRIVACY');?></p>
				<ul style="list-style-type: none  ;font-family: caption-light; font-size:larger;  margin-left: -40px " align="leftr">
			 		<li><?php echo $this->language->line("CHECK424-91-ABCDEF",'WE ALL VALUE OUR PRIVACY YOUR ANSWERS PER QUESTION ARE NOT STORED ANYWHERE');?></li>
					<p><br></p>
					<li><?php echo $this->language->line("CHECK424-92A2BCD",'WE DO NOT ASK YOU TO REGISTER, A SCREEN PRINT OF THE QRCode WORKS JUST AS FINE');?></li>
					<p><br></p>
					<li><?php echo $this->language->line("CHECK424-94A2BCD",'IF YOU WANT TO RETRIEVE YOUR QRCode WITH A LINK AND WANT TO BE REMEMBERED ABOUT THE EXPIRATION OF YOUR QRCode YOU CAN SIGN-UP FOR OUR RETRIEVAL AND REMINDER E-MAIL');?></li>
					<p><br></p>
					<li><?php echo $this->language->line("CHECK424-95A2BCDEF",'YOU CAN USE THE PROVIDE LINK IN YOUR E-MAIL FROM US TO RETRIEVE YOUR QRCode AND YOU WILL RECEIVE A REMINDER E-MAIL AFTER 22 HOURS THAT YOUR QRCode WILL EXPIRE.');?></li>
					<p><br></p>
					<li><?php echo $this->language->line("CHECK424-195A2BCDE",'2 HOURS AFTER SENDING YOU THE REMINDER OR IN ANY CASE AFTER 24 HOURS YOUR E-MAIL AND YOUR QRCode is COMPLETELY REMOVED FROM OUR SYSTEM');?></li>
					<p><br></p>
					<li><?php echo $this->language->line("CHECK424-197A2BCDE",'WE MAY ASK YOU TO OPT-IN FOR A TIQS NEWS, YOU SUPPORT OUR BUSINESS  WITH THIS. <br/>THE SERVICE IS FREE, HOWEVER IT IS COSTING US SOME MONEY, YOU CAN ALWAYS SUPPORT IS BY BUYING US A COFFEE! SO WE CAN WORK WHILE YOU SLEEP AND KEEP YOU AND YOUR LOVED ONES SAVE!.');?></li>
					<p><br></p>
					<li><?php echo $this->language->line("CHECK424-1197A2BCDE",'THE SERVICE IS FREE, HOWEVER IT IS COSTING US SOME MONEY AND TIME.');?></li>
					<p><br></p>
					<li><?php echo $this->language->line("CHECK424-111197A21BCDE",'YOU CAN ALWAYS SUPPORT US BY BUYING US A COFFEE! SO WE CAN WORK WHILE YOU SLEEP AND KEEP YOU AND YOUR LOVED ONES SAVE!.');?></li>
					<li><?php echo $this->language->line("CHECK424-98A2BCD",'');?></li>
				</ul>
		</div>
		<div class="form-group has-feedback mt-50" >
			<div style="text-align: center; ">
				<input  type="submit" class="button button-orange" value="<?php echo $this->language->line("CHECK424-100240BA",'BUY US A COFFEE');?>" style="border: none" />
			</div>
		</div>
	</div>
	</div>
</div>
</div>
</body>

<script>
	function getfocus() {
			window.location.href = "#top";
			document.getElementById("prev").style.display = "block";
			document.getElementById("next").style.display = "block";
	}

</script>
