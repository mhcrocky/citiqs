<!DOCTYPE html>
<html >
<body>

<style>

	input[type="radio"]{
		display:none;
	}

	input[type="radio"] + label
	{
		background-image:url(https://tiqs.com/alfred/assets/home/images/unchecked.png);
		background-size: 100px 100px;
		height: 100px;
		width: 100px;
		display:inline-block;
		padding: 0 0 0 0px;
		cursor:pointer;
	}

	input[type="radio"]:checked + label
	{
		background-image:url(https://tiqs.com/alfred/assets/home/images/checked.png);
	}

	.container {
		position: relative;
		width: 100%;
		max-width: 400px;
	}

	.container img {
		width: 100%;
		height: auto;
	}

	.container .btn {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		-ms-transform: translate(-50%, -50%);
		background-color: #555;
		color: white;
		font-size: 16px;
		padding: 12px 24px;
		border: none;
		cursor: pointer;
		border-radius: 5px;
		text-align: center;
	}

	.container .btn:hover {
		background-color: black;
	}

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

<div class="main-wrapper">
	<?php if($code =='0') { ?>
	<div class="col-half background-orange height-100" align="center">
		<?php } elseif($code =='-2') { ?>
		<div class="col-half background-red height-100">
			<?php } elseif($code =='-1') { ?>
			<div class="col-half background-red height-100">
				<?php } elseif($code !='0') { ?>
				<div class="col-half background-green-environment height-100" align="center">
					<?php } ?>
					<?php if ($code =='0') { ?>
					<?php include_once FCPATH . 'application/views/includes/sessionMessages.php'; ?>
					<form id="checkItem" action="<?php echo $this->baseUrl; ?>cqrcode" method="post" enctype="multipart/form-data"  >
						<div class="card" align="center">
							<div style="visibility: hidden">
								<div style="visibility: hidden" class="column-center" id="minutes">MM</div>
								<div style="visibility: hidden" class="column-left" id="hours" >H</div>
								<div style="visibility: hidden" class="column-right" id="seconds">SS</div>
							</div>
							<h2 class="heading">
								<div style="margin-bottom: 20px;" >
									<?php echo $this->language->line("CHECK424-010ABCD",'COVID-19 GUEST QUESTIONNAIRE');?>
									<div>
										<a href="#info424" ><i class="fa fa-info-circle" style="font-size:48px; color:dodgerblue"></i></a>
									</div>
								</div>
							</h2>

							<div class="products" align="center" style="background-color: #ffe294" >

								<div class="product background-orange" product-id="0">
									<div align="center">
										<div style="margin-bottom: 20px; font-family: caption-light; font-size: medium" >

										</div>
										<div style="text-align:center">
											<img src="<?php echo $this->baseUrl; ?>assets/home/images/dooropenwhitegreenchecked.png" alt="tiqs" width="150" height="auto" />
										</div>

										<ul style="list-style-type: none  ;font-family: caption-light; font-size:larger;  margin-left: -40px; margin-top: 20px " align="center">
											<li><?php echo $this->language->line("CHECK424-029111ABCDEF",'HELP, YOUR LOCAL SHOP, BAR, RESTAURANT, TO BE SAFE.  ');?></li>
										</ul>

										<ul style="list-style-type: none  ;font-family: caption-light; font-size:larger;  margin-left: -40px " align="center">

										</ul>


										<ul style="list-style-type: none  ;font-family: caption-light; font-size:smaller;  margin-left: -40px " align="center">
											<li><?php echo $this->language->line("CHECK424-10200012ABCD",'');?></li>
											<li><?php echo $this->language->line("CHECK424-10200032ABCDFG",'(AVAILABLE IN MORE THAN 107 LANGUAGES. GO TO THE MENU TO CHANGE YOUR LANGUAGE.)');?></li>
											<li><?php echo $this->language->line("CHECK424-10200012ABCD",'');?></li>
										</ul>

										<div style="margin-bottom: 50px; margin-left: 0px" align="center">

											<div>
												<input type="radio" id="shipadd1" value=1 name="address" />
												<label for="shipadd1">
													<p style="margin-top: 20px; margin-left: 100px; font-size: large" >
														<?php echo $this->language->line("CHECK424-11231231ABC",'Entering the location');?>
													</p>
												</label>

											</div>

											<div>
												<input type="radio" id="shipadd2" value=2 name="address" />

												<label style="margin-top: 30px" for="shipadd2">
													<p style="margin-top: 20px; margin-left: 100px; font-size: large" >
														<?php echo $this->language->line("CHECK424-112311234A",'Leaving the location');?>
													</p>
												</label>

											</div>
										</div>
										<br>
									</div>
								</div>

								<div class="product background-orange" product-id="2" value="peter">
									<div style="text-align:center">
										<div style="text-align:center">
											<h2 class="heading mb-35">
												<?php echo $this->language->line("CHECK424-3Q010AB",'3 QUESTIONS ABOUT YOU');?>
<!--												<P><i class="fa fa-user" style="font-size:48px;color:darkorange"></i></P>-->
											</h2>
										</div>


										<div>

											<div class="mb-50">
												<div class="text-center mb-30" style="text-align:center; display: block" id="covid-cst-white">
													<img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-cst-white.png" alt="tiqs" width="160" height="auto" />
												</div>
												<div class="text-center mb-30" style="text-align:center; display: none" id="covid-cst-green">
													<img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-cst-green.png" alt="tiqs" width="200" height="auto" />
												</div>
											</div>

											<div>
												<p style="font-size: larger; font-family: caption-light">
													<?php echo $this->language->line("CHECK424-Q1-00001A",'CHECK THIS BOX, WHEN YOU DO NOT SNEEZE AND/OR COUGH AND/OR ARE SHORT OF BREATH AND/OR HAVE A FEVER AND/OR TEMPERATURE HIGHER THAN 38 DEGREES');?>
												</p>
											</div>
											<div class="form-group has-feedback" align="center">
												<div class="onoffswitchblue ">
													<input type="checkbox" name="question1" class="onoffswitchblue-checkbox" onchange="answer1image()" id="question1" value="1">
													<label class="onoffswitchblue-label" for="question1">
														<span class="onoffswitchblue-inner"></span>
														<span class="onoffswitchblue-switch"></span>
													</label>
												</div>
											</div>

											<div>
												<div class="mb-50 mt-50">

													<div class="text-center mb-30" style="text-align:center; display: block" id="covid-test-white">
														<img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-test-white.png" alt="tiqs" width="180" height="auto" />
													</div>


													<div class="text-center mb-30" style="text-align:center; display: none" id="covid-test-green">
														<img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-test-green.png" alt="tiqs" width="180" height="auto" style="margin-left: 15px" />
													</div>

												</div>
											</div>
											<div>
												<p style="font-size: larger; font-family: caption-light">
													<?php echo $this->language->line("CHECK424-Q2-00001A",'CHECK THIS BOX, WHEN YOU WHERE NOT TESTED FOR COVID-19 AND DID NOT HAD COVID-19 IN THE LAST 7 DAYS');?>
												</p>
											</div>
											<div class="form-group has-feedback mb-35" align="center">
												<div class="onoffswitchblue">
													<input type="checkbox" name="question2" class="onoffswitchblue-checkbox"  onchange="answer2image()"  id="question2" value="1">
													<label class="onoffswitchblue-label" for="question2">
														<span class="onoffswitchblue-inner"></span>
														<span class="onoffswitchblue-switch"></span>
													</label>
												</div>
											</div>
											<div class="mt-50">
												<div class="mb-50 mt-50">

													<div class="text-center mb-30" style="text-align:center; display: block" id="covid-test-14days-white">
														<img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-test-14days-white.png" alt="tiqs" width="220" height="auto" />
													</div>


													<div class="text-center mb-30" style="text-align:center; display: none" id="covid-test-14days-green">
														<img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-test-14days-green.png" alt="tiqs" width="200" height="auto" />
													</div>

												</div>
											</div>
											<div>
												<p style="font-size: larger; font-family: caption-light">
													<?php echo $this->language->line("CHECK424-Q3-00001A",'CHECK THIS BOX, WHEN YOU WHERE NOT IN CONTACT WITH SOMEONE WHO WAS TESTED WITHIN 14 DAYS FOR COVID-19 AND SHOWED SYMPTOMS.');?>
												</p>
											</div>
											<div class="form-group has-feedback" align="center">
												<div class="onoffswitchblue">
													<input type="checkbox" name="question3" class="onoffswitchblue-checkbox" onchange="answer3image()" id="question3" value="1">
													<label class="onoffswitchblue-label" for="question3">
														<span class="onoffswitchblue-inner"></span>
														<span class="onoffswitchblue-switch"></span>
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="product background-orange" product-id="3" >

											<div style="text-align:center">
												<div style="text-align:center">
													<h2 class="heading mb-35">
														<?php echo $this->language->line("CHECK424-3Q3010AB",'3 QUESTIONS ABOUT YOUR ENVIRONMENT');?>
													</h2>
												</div>
											<div>

											<div class="mb-50">
												<div class="text-center mb-30" style="text-align:center; display: block" id="covid-cst-white-2">
													<img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-cst-white.png" alt="tiqs" width="160" height="auto" />
												</div>
												<div class="text-center mb-30" style="text-align:center; display: none" id="covid-cst-green-2">
													<img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-cst-green.png" alt="tiqs" width="200" height="auto" />
												</div>
											</div>

											<div>
												<p style="font-size: larger; font-family: caption-light">
													<?php echo $this->language->line("CHECK424-Q00011A",'Check this box, when roommates, household members are NOT sneezing and/or coughing and/or short of breath and/or having a fever and/or temperature higher dan 38 degrees');?>
												</p>
											</div>

											<div class="form-group has-feedback" align="center">
												<div class="onoffswitchblue">
													<input type="checkbox" name="question4" class="onoffswitchblue-checkbox" onchange="answer4image()" id="question4" value="1">
													<label class="onoffswitchblue-label" for="question4">
														<span class="onoffswitchblue-inner"></span>
														<span class="onoffswitchblue-switch"></span>
													</label>
												</div>
											</div>

												<div class="mt-50">
													<div class="mb-50 mt-50">

														<div class="text-center mb-30" style="text-align:center; display: block" id="covid-test-14days-white-2">
															<img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-test-14days-white.png" alt="tiqs" width="220" height="auto" />
														</div>


														<div class="text-center mb-30" style="text-align:center; display: none" id="covid-test-14days-green-2">
															<img src="<?php echo $this->baseUrl; ?>assets/home/images/covid-test-14days-green.png" alt="tiqs" width="200" height="auto" />
														</div>

													</div>
												</div>


											<div>
												<p style="font-size: larger; font-family: caption-light">
													<?php echo $this->language->line("CHECK424-Q00016AB",'Check this box, when roommates, household members where NOT in contact with someone who was tested within 14 days for COVID-19 and showed symptoms.');?>
												</p>
											</div>

											<div class="form-group has-feedback" align="center">
												<div class="onoffswitchblue">
													<input type="checkbox" name="question5" class="onoffswitchblue-checkbox" onchange="answer5image()" id="question5" value="1">
													<label class="onoffswitchblue-label" for="question5">
														<span class="onoffswitchblue-inner"></span>
														<span class="onoffswitchblue-switch"></span>
													</label>
												</div>
											</div>

										</div>


										<div class="mt-50">
											<div class="mb-50 mt-50">

												<div class="text-center mb-30" style="text-align:center; display: block" id="quarantine-white">
													<img src="<?php echo $this->baseUrl; ?>assets/home/images/quarantine-white.png" alt="tiqs" width="220" height="auto" />
												</div>


												<div class="text-center mb-30" style="text-align:center; display: none" id="quarantine-green">
													<img src="<?php echo $this->baseUrl; ?>assets/home/images/quarantine-green.png" alt="tiqs" width="200" height="auto" />
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
												<input type="checkbox" name="question6" class="onoffswitchblue-checkbox" onchange="answer6image()" id="question6" value="1">
												<label class="onoffswitchblue-label" for="question6">
													<span class="onoffswitchblue-inner"></span>
													<span class="onoffswitchblue-switch"></span>
												</label>
											</div>
										</div>
									</div>
								</div>

								<div class="product background-orange" product-id="4" >
									<div style="text-align:center">

										<div style="text-align:center">
											<h2 class="heading mb-35">
												<?php echo $this->language->line("CHECK424-QR010ABC",'YOU ARE READY!');?>
											</h2>
										</div>

										<div class="container mb-35" align="center">
											<img src="assets/home/images/getyourqrcode.png" alt="tiqs" style="width:100%">
											<button type="submit" class="btn" style="background-color: darkorange; color: white; "><?php echo $this->language->line("CHECK424-1240A",'GET YOUR QRCODE');?></button>
										</div>


										<div >
											<p style="font-size: larger; font-family: caption-light">
												<?php echo $this->language->line("CHECK424-Q000189BCDE",'AFTER 24 HOURS THE QRCODE WILL BE INVALID AND YOU CAN MAKE A NEW ONE.');?>
											</p>
										</div>
									</div>
								</div>

							</div>


							<div class="mt-50">

								<div class="footeronboarding" style="background-color: #ffe294">

									<div>
										<a style="margin-right:5px; font-family: caption-bold; font-size: x-large; display: none" class="button button-orange" id="prev" href="#top" onclick="getfocus()" ripple="" ripple-color="#ffffff">
											<i class="fa fa-arrow-left" style="font-size:48px;color:darkorange"></i>
										</a>
									</div>

									<div>
										<a style="margin-left:5px; font-family: caption-bold; font-size: x-large" class="button button-orange" id="next" href="#top"  onclick="getfocus()" ripple="" ripple-color="#ffffff">
											<i class="fa fa-arrow-right" style="font-size:48px;color:darkorange"></i>
										</a>
									</div>
								</div>
							</div>
						</form>

						<div class="row mt-35" style="text-align: center; padding:50px ">
							<ul style="list-style-type: none  ;font-family: caption-light; font-size:larger;  margin-left: -40px " align="center">
								<li><?php echo $this->language->line("CHECK424-020921ED",'THIS SERVICE IS FREE TO HELP AVOIDING A QUEUE... HOPE YOU ALL ENJOY');?></li>
							</ul>
							<img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="150" height="auto" />
						</div>

						<div>

							<div style="text-align:center">
								<h2 class="heading">
									<?php echo $this->language->line("CHECK424-TELL001",'TELL A FRIEND');?>							</h2>
							</div>

							<a style="margin-right: 10px" href="whatsapp://send?text=Check for 24Hours to avoid queuing, check-in check-out... https://check424.com" data-action="share/whatsapp/share" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on whatsapp">
								<i class="fa fa-whatsapp" style="font-size:48px;color:darkorange"></i>
							</a>

							<a style="margin-right: 10px" href="https://www.facebook.com/sharer/sharer.php?u=https://tiqs.com/alfred/loggedin&t=Very handy for restaurants, bars, Visitors Check for 24Hours to avoid queuing, check-in check-out... https://check424.com" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Facebook">
								<i class="fa fa-facebook" style="font-size:48px;color:darkorange"></i>
							</a>

							<a style="margin-right: 10px" href="https://twitter.com/share?url=https://check424.com&text=Very handy for restaurants, bars, Visitors Check for 24Hours to avoid queuing, check-in check-out..." onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Twitter">
								<i class="fa fa-twitter" style="font-size:48px;color:darkorange"></i>
							</a>

							<a style="margin-right: 10px" href="mailto:?subject=Very handy for restaurants, bars, Visitors Check for 24Hours to avoid queuing, check-in check-out.&body=This is handy! please check this out, and tell your friends and bars, cafe's and restaurants. https://check424.com" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Mail">
								<i class="fa fa-envelope" style="font-size:48px;color:darkorange"></i>
							</a>

						</div>

						<?php } elseif($code =='-2') { ?>

					<div class="flex-column align-top" align="center">

						<div class="" align="center">
							<h1 style="font-family: caption-bold; font-size: x-large">QRCODE INDICATES A HEALTH RISK.</h1>
							<img src="<?php echo $this->baseUrl; ?>assets/home/images/venueclosed.png" alt="tiqs" width="200" height="200" />
							<div class="mb-50" align="center">
								<h1 style="font-family: caption-bold; font-size: x-large">STAY HOME, STAY SAVE.</h1>
							</div>
						</div>

						<h2 class="heading mb-35">
							<?php echo $this->language->line("CHECK424-HR0101234ABC",'YOU DO NOT AGREE? PLEASE TRY AGAIN AND READ ALL QUESTIONS CAREFULLY. ');?>
						</h2>

						<div class="form-group has-feedback mt-35" >
							<div style="text-align: center; ">
								<a href="https://check424.com" class="button button-orange mb-25"><?php echo $this->language->line("CHECK424-CHECK1234",'CHECK AGAIN');?></a>
							</div>
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

					<div class="flex-column align-top">
						<div align="center">
							<h1 style="font-family: caption-bold; color:white; font-size: x-large">QRCODE IS VALID FOR THE NEXT.</h1>
						</div>

								<div>
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
							</div>

							<div class="mb-35" align="center">
								<img src="<?php echo $this->baseUrl; ?>assets/home/images/covidlistwhitechecked.png" alt="tiqs" width=150" height="auto" />
							</div>

						<div class="" align="center">
							<div style="text-align:center">
								<h2 class="heading mb-35" Style="color:white">
									<?php echo $this->language->line("CHECK424-TELL001",'TELL A FRIEND');?>							</h2>
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

					<div class="form-group has-feedback mt-50" >
						<div style="text-align: center; ">
							<a href="pay424" class="button button-orange mb-25"><?php echo $this->language->line("CHECK424-BUYUS1234",'BUY US A COFFEE...');?></a>
					</div>
					</div>

							<?php } ?>
					</div>
				</div>

				<div class="col-half background-yellow" id="info424">
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
						<div class="text-center mb-50 mt-50" style="text-align:center">
							<img src="<?php echo $this->baseUrl; ?>assets/home/images/keepdistance.png" alt="tiqs" width="150" height="auto" />
						</div>

						<div class="form-group has-feedback mt-35" >
							<div style="text-align: right">
								<a href="#top" ><i class="fa fa-arrow-circle-up" style="font-size:48px; color:white"></i></a>
							</div>
							<div style="text-align: center; ">
								<a href="pay424" class="button button-orange mb-25"><?php echo $this->language->line("CHECK424-BUYUS1234",'BUY US A COFFEE...');?></a>
							</div>
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
						<div class="form-group has-feedback mt-35" >
							<div style="text-align: right">
								<a href="#top" ><i class="fa fa-arrow-circle-up" style="font-size:48px; color:white"></i></a>
							</div>
							<div style="text-align: center; ">
								<a href="pay424" class="button button-orange mb-25"><?php echo $this->language->line("CHECK424-BUYUS1234",'BUY US A COFFEE...');?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

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

<script>
	function getfocus() {
		window.location.href = "#top";
	}
</script>

<script>
	function answer1image() {
		var x = document.getElementById("covid-cst-white");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}

		var x = document.getElementById("covid-cst-green");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}
	}
</script>

<script>
	function answer2image() {
		var x = document.getElementById("covid-test-white");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}

		var x = document.getElementById("covid-test-green");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}
	}
</script>

<script>
	function answer3image() {
		var x = document.getElementById("covid-test-14days-white");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}

		var x = document.getElementById("covid-test-14days-green");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}
	}
</script>

<script>
	function answer4image() {
		var x = document.getElementById("covid-cst-white-2");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}

		var x = document.getElementById("covid-cst-green-2");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}
	}
</script>

<script>
	function answer5image() {
		var x = document.getElementById("covid-test-14days-white-2");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}

		var x = document.getElementById("covid-test-14days-green-2");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}
	}
</script>


<script>
	function answer6image() {
		var x = document.getElementById("quarantine-white");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}

		var x = document.getElementById("quarantine-green");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}
	}
</script>
