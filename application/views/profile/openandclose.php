<div class="main-wrapper" style="text-align:center">
	<?php if($this->session->userdata('dropoffpoint')==1) { ?>
		<div class="col-half timeline-content mx-auto">
			
			<div class="timeline-content mx-auto">
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#timeModal" style="margin-top:20px">Set working time</button>
				<br style="display:initial"/>
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#nonWorkingPeriod" style="margin-top:20px">Set non-working period</button>
				<!--TIME MODAL -->
				<div class="modal" id="timeModal" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<form method="post" action="<?php echo base_url() ?>profile/updateVendorTime/<?php echo $user->id; ?>">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title" style="color:#000; text-align:center">
										Set availability days and time
									</h4>
								</div>
								<div class="modal-body">
									<?php foreach($dayOfWeeks as $day) { ?>
									<div class="from-group">
										<div>
											<label for="<?php echo $day; ?>" style="color: #000">

												<?php echo ucfirst($day); ?>
											</label>
											<input
													type="checkbox"
													id="<?php echo $day; ?>"
													value="<?php echo $day; ?>"
													onchange="showDay(this,'<?php echo 'day_' . $day; ?>')"
													name="<?php echo $day; ?>[day][]"
													<?php
														if (isset($workingTime[$day])) {
															echo 'checked';
															$first = array_shift($workingTime[$day]);
														} else {
															$first = null;
														}
													?>
													style="zoom:2"
													/>
												<br/>
										</div>
										<div id="<?php echo 'day_' . $day; ?>" <?php if (empty($first)) echo 'style="display:none"'; ?>>
											<label for="from<?php echo $day; ?>" style="color: #000">From:
												<input
													type="time"
													id="from<?php echo $day; ?>"
													class="<?php echo 'day_' . $day; ?>"
													name="<?php echo $day; ?>[timeFrom][]"
													<?php if (!empty($first)) { ?>
														value="<?php echo $first['timeFrom']; ?>"
													<?php } else { ?>
														disabled
													<?php } ?>
													/>
											</label>
											<Label for="to<?php echo $day; ?>" style="color: #000">To:
												<input
													type="time"
													id="to<?php echo $day; ?>"
													class="<?php echo 'day_' . $day; ?>"
													name="<?php echo $day; ?>[timeTo][]"
													<?php if (!empty($first)) { ?>
														value="<?php echo $first['timeTo']; ?>"
													<?php } else { ?>
														disabled
													<?php } ?>
													/>
											</label>
											<button type="button" class="btn btn-default" onclick="addTimePeriod('<?php echo $day . 'Times'; ?>','<?php echo $day; ?>')">Add time</button>
											<div id="<?php echo $day; ?>Times">
												<?php
													if (!empty($workingTime[$day])) {
														foreach($workingTime[$day] as $day) {
															?>
															<label style="color: #000">From:
																<input
																	type="time"
																	class="<?php echo 'day_' . $day['day']; ?>"
																	name="<?php echo $day['day']; ?>[timeFrom][]"
																	value="<?php echo $day['timeFrom']; ?>"
																	/>
															</label>
															<Label style="color: #000">To:
																<input
																	type="time"
																	class="<?php echo 'day_' . $day['day']; ?>"
																	name="<?php echo $day['day']; ?>[timeTo][]"
																	value="<?php echo $day['timeTo']; ?>"
																	/>
															</label>
															<span style="color:#000" class="fa-stack fa-2x" onclick="removeParent(this)">
																<i class="fa fa-times"></i>
															</span>
															<?php
														}
													}
												?>
											</div>
										</div>
									</div>
									<?php } ?>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<input type="submit" class="btn btn-primary" value="Submit" />
								</div>
							</div>
						</form>
					</div>
				</div>
				<!--NON WORKING PERIOD -->
				<div class="modal" id="nonWorkingPeriod" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<form method="post" action="<?php echo base_url() ?>profile/setNonWorkingTime/<?php echo $vendor['id']; ?>">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title" style="color:#000; text-align:center">
										Set a non-working period
									</h4>
								</div>
								<div class="modal-body">								
									<div class="col-sm-12">
										<label for="nonWorkFrom" style="color:#000">From: 
											<input
												type="date"
												id="nonWorkFrom"
												name="nonWorkFrom"
												class="form-control"
												requried
												value="<?php if ($vendor['nonWorkFrom']) echo $vendor['nonWorkFrom']?>"
												min="<?php echo date('Y-m-d'); ?>"
											/>
										</label>
									</div>
									<div class="col-sm-12">
										<label for="nonWorkTo" style="color:#000">To: 
											<input
												type="date"
												id="nonWorkTo"
												name="nonWorkTo"
												class="form-control"
												requried
												value="<?php if ($vendor['nonWorkTo']) echo $vendor['nonWorkTo']?>"
												min="<?php echo date('Y-m-d'); ?>"
											/>
										</label>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<input type="submit" class="btn btn-primary" value="Submit" />
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>
<?php if($this->session->userdata('dropoffpoint')==0) { ?>
	<div class="col-half background-orange-light height-100 align-center">
		<div class="flex-column align-start width-650">
			<div style="text-align:center">
				<h2 class="heading mb-35"><?php echo $this->language->line("PROF-A010",'YOUR BUDDY.');?></h2>
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
										<input type="submit" class="button button-orange" value="<?php echo $this->language->line("PROF-05100 ",'SUBMIT');?>" style="border: none" />
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

<!--
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
-->

<script>
	function getUserAjax() {
		return "<?php echo base_url('index.php/ajax/users/'); ?>";
	}
	var baseURL = "<?php echo $this->baseUrl; ?>"
		// date time picker
	$(document).ready(function(){
		// $('.timePickers').datetimepicker({
		// 	timepicker: false,
		// 	format: 'yy-m-d'
		// });
	});
</script>
