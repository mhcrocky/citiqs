

<script>

	var doc = new jsPDF();

</script>

<style>

	ul {
	font-size: smaller;
	list-style-type: none;
	font-family: caption-light;
	}

	h2 {
		font-family: caption-bold;
		font-size: 20px;
	}

	.active {
		background-color: #E25F2A !important;
	}

	.slide {
		min-height: 450px
	}

	.container {
		color: #333;
		margin: 0 auto;
		padding: 0.5rem;
		text-align: center;
		color: white;
	}

	* {
		box-sizing: border-box;
		margin: 0;
		padding: 0;
	}

	h1 {
		font-weight: normal;
	}

	li {
		display: inline-block;
		font-size: 1.5em;
		list-style-type: none;
		padding: 1em;
		text-transform: uppercase;
	}

	li span {
		display: block;
		font-size: 4.5rem;
	}

</style>

<style>

	.column-left {
		float: left;
		width: 33.333%;
	}

	.column-right {
		float: right;
		width: 33.333%;
	}

	.column-center {
		display: inline-block;
		width: 33.333%;
	}

</style>
<!-- end header -->


<div class="main-wrapper">
	<div class="col-half background-green height-100" align="center">
		<div class="flex-column align-start width-650 align-top" align="center">

			<div align="center">
				<h1 style="font-family: caption-bold; color:white; font-size: x-large">QRCODE IS VALID FOR THE NEXT.</h1>
			</div>

			<div align="center">
				<p style="text-align: center; display: none">to: <?php echo $countdown ?></p>
			</div>

			<div align="center">
				<p style="text-align: center; display:none">now: <?php echo $datetimenow ?></p>
			</div>

			<div style="font-size: large; color:white" align="center">
				<div class="column-center"><p>Minutes</p></div>
				<div class="column-left"><p>Hours</p></div>
				<div class="column-right"><p>Seconds</p></div>
			</div>

			<div style="font-size: 350%; color:white" align="center">
				<div class="column-center"><p id="minutes">MM</p></div>
				<div class="column-left"><p id="hours" >H</p></div>
				<div class="column-right"><p id="seconds">SS</p></div>
			</div>
			<div class="mb-50" align="center">
				<img src="<?php echo $SERVERFILEPATH.$file_name1 ?>" width="275" height="auto" >
			</div>



			<div style="text-align:center">
				<h2 class="mb-35">
					<?php echo $this->language->line("CHECK424-1213010AB",'CONGRATULATIONS YOUR 24 HOURS QRCode IS READY.');?>
					<div id="countdown"></div>
				</h2>
				<div id="countdown"></div>
			</div>

			<form id="check424email" action="<?php echo $this->baseUrl; ?>check424email" method="post" enctype="multipart/form-data"  >

				<div>
					<p style="font-size: larger; font-family: caption-light">
						<?php echo $this->language->line("CHECK424QRCODE-Q10001A",'YOU CAN MAKE A SCREEN COPY OR SAVE YOUR QRCode as PDF AND SEND TO YOUR E-MAIL.');?>
					</p>
				</div>

				<div>
					<a href="whatsapp://send?text=<URL>" data-action="share/whatsapp/share" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on whatsapp"></a>
				</div>

				<div class="form-group has-feedback">
					<input type="email" name="email" required class="form-control" style="font-family:'caption-light'; border-radius: 50px;" placeholder="<?php echo $this->language->Line("check4242email-2000","email");?>" />
					<input style="visibility: hidden" type="code" name="code" value="<?php echo $code ?>" />
					<input style="visibility: hidden" type="qrlink" name="qrlink" value="<?php echo $qrlink ?>" />
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>

  				<div>
					<p style="font-size: larger; font-family: caption-light">
						<?php echo $this->language->line("CHECK424-Q000189BCD",'AFTER 24 HOURS THE QRCode WILL BE INVALID AND YOU CAN MAKE A NEW ONE.');?>
					</p>
				</div>

				<div class="form-group has-feedback mb-50" >
					<div style="text-align: center; ">
						<input  type="submit" class="button button-orange" value="<?php echo $this->language->line("CHECK424-122340A",'SAVE QRCode AND SEND E-MAIL');?>" style="border: none" />
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="col-half background-yellow">
		<div class="background-orange-light height">
			<div class="width-650"></div>

			<div class="text-center mb-35" style="text-align:center">
				<img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-19-list.png" alt="tiqs" width="150" height="auto" />
			</div>
				<p class="text-content mb-35" align="center"><?php echo $this->language->line("CHECK424-1270AB",'WHY THIS QUESTIONNAIRE?');?></p>
			<ul  align="left">
				<li><?php echo $this->language->line("CHECK424-41212ABCDF",'RESTAURANTS, BARS, HOSPITALITY BUSINESSES ARE REQUIRED BY LAW TO QUESTION YOU ABOUT YOUR HEALTH TO DETERMINE THE RISK OF SPREADING COVID-19, THE VIRUS.<br>');?></li>
				<p><br></p>
				<li><?php echo $this->language->line("CHECK424-113243232ABCD",'ADHOC PROCESSING THESE QUESTIONS, TAKES TIME (5 MINUTES PER PERSON) AND DUE TO THE MANUAL LABOUR THERE IS A HIGH COST AND IMPACT ON ANY ORGANISATION .');?></li>
				<p><br></p>
				<li><?php echo $this->language->line("CHECK424-12415232ABCD",'TIQS SUPPORTS FOR FREE A SOLUTION TO HAVE THE QUESTIONS PROCESSED BEFORE AND VALID FOR 24 HOURS. DOES YOUR STATE OF HEALTH CHANGE WITHIN THESE 24 HOURS PLEASE STAY HOME!');?></li>
				<p><br></p>
				<li><?php echo $this->language->line("CHECK4241-41351232ABCD",'YOU CAN HELP YOUR LOCAL BUSINESS BY PROVIDING THE ANSWERS IN A ELECTRICAL READABLE MANNER, HAVE YOUR QRCode READY AND SHOW YOUR QRCode ON ENTRANCE ');?></li>
				<p><br></p>
			</ul>

			<div align="center" style="text-align:center; margin-bottom: 20px">
				<div style="text-align:center; margin-bottom: 10px">
					<h2 class="heading">
						<?php echo $this->language->line("CHECK424-TELL001",'TELL A FRIEND');?>
					</h2>
				</div>

				<a style="margin-right: 10px" href="whatsapp://send?text=Check for 24Hours to avoid queuing, check-in check-out... https://check424.com" data-action="share/whatsapp/share" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on whatsapp">
					<i class="fa fa-whatsapp" style="font-size:48px;color:white"></i>
				</a>

				<a style="margin-right: 10px" href="https://www.facebook.com/sharer/sharer.php?u=https://check424.com&t=Very handy for restaurants, bars, Visitors Check for 24Hours to avoid queuing, check-in check-out... https://check424.com" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Facebook">
					<i class="fa fa-facebook" style="font-size:48px;color:white"></i>
				</a>

				<a style="margin-right: 10px" href="https://twitter.com/share?url=https://check424.com&text=Very handy for restaurants, bars, Visitors Check for 24Hours to avoid queuing, check-in check-out..." onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Twitter">
					<i class="fa fa-twitter" style="font-size:48px;color:white"></i>
				</a>

				<a style="margin-right: 10px" href="mailto:?subject=Very handy for restaurants, bars, Visitors Check for 24Hours to avoid queuing, check-in check-out.&body=This is handy! please check this out, and tell your friends and bars, cafe's and restaurants. https://check424.com" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Mail">
					<i class="fa fa-envelope" style="font-size:48px;color:white"></i>
				</a>
			</div>

			<div class="text-center mb-50" style="text-align:center">
				<img src="<?php echo $this->baseUrl; ?>assets/home/images/keepdistance.png" alt="tiqs" width="150" height="auto" />
			</div>

			<div class="form-group has-feedback mt-50" >
				<div style="text-align: center; ">
					<a href="pay424" class="button button-orange mb-25"><?php echo $this->language->line("CHECK424-BUYUS1234",'BUY US A COFFEE...');?></a>
				</div>
			</div>

		</div>

		<div class="text-center mb-30" style="text-align:center">
			<img src="<?php echo $this->baseUrl; ?>assets/home/images/TIQSKeys.png" alt="tiqs" width="220" height="175" />
		</div>

		<div class="background-yellow">
			<div class="width-650">
				<p class="text-content mb-35"><?php echo $this->language->line("CHECK424-1370AB",'YOUR PRIVACY');?></p>
				<ul align="leftr">
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

<script>

	const second = 1000,
		minute = second * 60,
		hour = minute * 60,
		day = hour * 24;

	let countDown = new luxon.DateTime('<?php echo $countdown ?>'),
		x = setInterval(function() {

			let now = luxon.DateTime.local();
			const d = luxon.DateTime.fromISO(now, {zone: 'Europe/Amsterdam'});
			const e = luxon.DateTime.fromISO(countDown, {zone: 'Europe/Amsterdam'});
			timeleft =  e.plus({days:1}) - d;


				console.log("now");
				console.log(d.toISO());
				console.log(d.toUTC().toISO());


				console.log("countdown");
				console.log(e.toISO());
				console.log(e.toUTC().toISO());

				timelefttime = timeleft;

				var minuteschecked = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60)) ;
				if (minuteschecked >59) {minuteschecked = 59;}


				document.getElementById('hours').innerText =  Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60) ) ;
				document.getElementById('minutes').innerText = minuteschecked;
				document.getElementById('seconds').innerText = Math.floor((timeleft % (1000 * 60)) / 1000) ;

		}, second)

</script>

