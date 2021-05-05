<div class="main-wrapper" style="text-align:center">
	<?php if($this->session->userdata('dropoffpoint')==1) { ?>
		<div class="col-half timeline-content mx-auto">
			
			<div class="timeline-content">
				<!-- <p>Add driver mobile number (starting with country code with zero) for sending sms.</p>
				<p>Set the number of minutes when the message will be sent to driver after the order status is changed in status "DONE"</p> -->
				<!-- <p>Add terms and conditions</p> -->
				<form method="post" action="<?php echo base_url() ?>profile/updateVendorData/<?php echo $vendor['id']; ?>">
				    <input type="hidden" name="paymentsettings" value="1" />
					<input type="number" name="vendorId" value="<?php echo $user->id ?>" readonly required hidden />
					<div class="form-group mb-35">
						<label for="serviceFeePercent">LOCAL SERVICE FEE PERCENTAGE</label>
						<input
							type="number"
							id="serviceFeePercent"
							name="vendor[serviceFeePercent]"
							min="0"
							step="0.01"
							class="form-control"
							style="border-radius: 50px"
							value="<?php echo $vendor['serviceFeePercent']; ?>"
						/>
					</div>
					<div class="form-group mb-35">
						<label>POS LOCAL SERVICE FEE PERCENTAGE SAME</label>
						<br style="display:initial"/>
						<label class="radio-inline" for="serviceFeePercentPosYes">Yes</label>
						<input type="radio" id="serviceFeePercentPosYes" name="vendor[serviceFeePercentPos]" value="1" <?php if ($vendor['serviceFeePercentPos'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="serviceFeePercentPosNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="serviceFeePercentPosNo" name="vendor[serviceFeePercentPos]" value="0" <?php if ($vendor['serviceFeePercentPos'] === '0') echo 'checked'; ?> />
					</div>
					<div class="form-group mb-35">
						<label for="minimumOrderFee">LOCAL SERVICE FEE AMOUNT</label>
						<input
							type="number"
							id="minimumOrderFee"
							name="vendor[minimumOrderFee]"
							min="0"
							step="0.01"
							class="form-control"
							style="border-radius: 50px"
							value="<?php echo $vendor['minimumOrderFee']; ?>"
							/>
					</div>
					<div class="form-group mb-35">
						<label>POS LOCAL SERVICE FEE AMOUNT SAME</label>
						<br style="display:initial"/>
						<label class="radio-inline" for="minimumOrderFeePosYes">Yes</label>
						<input type="radio" id="minimumOrderFeePosYes" name="vendor[minimumOrderFeePos]" value="1" <?php if ($vendor['minimumOrderFeePos'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="minimumOrderFeePosNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="minimumOrderFeePosNo" name="vendor[minimumOrderFeePos]" value="0" <?php if ($vendor['minimumOrderFeePos'] === '0') echo 'checked'; ?> />
					</div>
					<div class="form-group mb-35">
						<label for="serviceFeeAmount">LOCAL MAXIMUM SERVICE FEE AMOUNT</label>
						<input
							type="number"
							id="serviceFeeAmount"
							name="vendor[serviceFeeAmount]"
							min="0"
							step="0.01"
							class="form-control"
							style="border-radius: 50px"
							value="<?php echo $vendor['serviceFeeAmount']; ?>"
							/>
					</div>
					<div class="form-group mb-35">
						<label>POS LOCAL MAXIMUM SERVICE FEE AMOUNT SAME</label>
						<br style="display:initial"/>
						<label class="radio-inline" for="serviceFeeAmountPosYes">Yes</label>
						<input type="radio" id="serviceFeeAmountPosYes" name="vendor[serviceFeeAmountPos]" value="1" <?php if ($vendor['serviceFeeAmountPos'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="serviceFeeAmountPosNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="serviceFeeAmountPosNo" name="vendor[serviceFeeAmountPos]" value="0" <?php if ($vendor['serviceFeeAmountPos'] === '0') echo 'checked'; ?> />
					</div>
					<div class="form-group mb-35">
						<label for="deliveryServiceFeePercent">DELIVERY SERVICE FEE PERCENTAGE</label>
						<input
							type="number"
							id="deliveryServiceFeePercent"
							name="vendor[deliveryServiceFeePercent]"
							min="0"
							step="0.01"
							class="form-control"
							style="border-radius: 50px"
							value="<?php echo $vendor['deliveryServiceFeePercent']; ?>"
							/>
					</div>
					<div class="form-group mb-35">
						<label>POS DELIVERY SERVICE FEE PERCENTAGE SAME</label>
						<br style="display:initial"/>
						<label class="radio-inline" for="deliveryServiceFeePercentPosYes">Yes</label>
						<input type="radio" id="deliveryServiceFeePercentPosYes" name="vendor[deliveryServiceFeePercentPos]" value="1" <?php if ($vendor['deliveryServiceFeePercentPos'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="deliveryServiceFeePercentPosNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="deliveryServiceFeePercentPosNo" name="vendor[deliveryServiceFeePercentPos]" value="0" <?php if ($vendor['deliveryServiceFeePercentPos'] === '0') echo 'checked'; ?> />
					</div>
					<div class="form-group mb-35">
						<label for="deliveryMinimumOrderFee">DELIVERY SERVICE FEE AMOUNT</label>
						<input
							type="number"
							id="deliveryMinimumOrderFee"
							name="vendor[deliveryMinimumOrderFee]"
							min="0"
							step="0.01"
							class="form-control"
							style="border-radius: 50px"
							value="<?php echo $vendor['deliveryMinimumOrderFee']; ?>"
							/>
					</div>
					<div class="form-group mb-35">
						<label>POS DELIVERY SERVICE FEE AMOUNT SAME</label>
						<br style="display:initial"/>
						<label class="radio-inline" for="deliveryMinimumOrderFeePosYes">Yes</label>
						<input type="radio" id="deliveryMinimumOrderFeePosYes" name="vendor[deliveryMinimumOrderFeePos]" value="1" <?php if ($vendor['deliveryMinimumOrderFeePos'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="deliveryMinimumOrderFeePosNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="deliveryMinimumOrderFeePosNo" name="vendor[deliveryMinimumOrderFeePos]" value="0" <?php if ($vendor['deliveryMinimumOrderFeePos'] === '0') echo 'checked'; ?> />
					</div>
					<div class="form-group mb-35">
						<label for="deliveryServiceFeeAmount">DELIVERY MAXIMUM SERVICE FEE AMOUNT</label>
						<input
							type="number"
							id="deliveryServiceFeeAmount"
							name="vendor[deliveryServiceFeeAmount]"
							min="0"
							step="0.01"
							class="form-control"
							style="border-radius: 50px"
							value="<?php echo $vendor['deliveryServiceFeeAmount']; ?>"
							/>
					</div>
					<div class="form-group mb-35">
						<label>POS DELIVERY MAXIMUM SERVICE FEE AMOUNT SAME</label>
						<br style="display:initial"/>
						<label class="radio-inline" for="deliveryServiceFeeAmountPosYes">Yes</label>
						<input type="radio" id="deliveryServiceFeeAmountPosYes" name="vendor[deliveryServiceFeeAmountPos]" value="1" <?php if ($vendor['deliveryServiceFeeAmountPos'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="deliveryServiceFeeAmountPosNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="deliveryServiceFeeAmountPosNo" name="vendor[deliveryServiceFeeAmountPos]" value="0" <?php if ($vendor['deliveryServiceFeeAmountPos'] === '0') echo 'checked'; ?> />
					</div>
					<div class="form-group mb-35">
						<label for="pickupServiceFeePercent">PICKUP SERVICE FEE PERCENTAGE</label>
						<input
							type="number"
							id="pickupServiceFeePercent"
							name="vendor[pickupServiceFeePercent]"
							min="0"
							step="0.01"
							class="form-control"
							style="border-radius: 50px"
							value="<?php echo $vendor['pickupServiceFeePercent']; ?>"
							/>
					</div>
					<div class="form-group mb-35">
						<label>POS PICKUP SERVICE FEE PERCENTAGE SAME</label>
						<br style="display:initial"/>
						<label class="radio-inline" for="pickupServiceFeePercentPosYes">Yes</label>
						<input type="radio" id="pickupServiceFeePercentPosYes" name="vendor[pickupServiceFeePercentPos]" value="1" <?php if ($vendor['pickupServiceFeePercentPos'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="pickupServiceFeePercentPosNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="pickupServiceFeePercentPosNo" name="vendor[pickupServiceFeePercentPos]" value="0" <?php if ($vendor['pickupServiceFeePercentPos'] === '0') echo 'checked'; ?> />
					</div>
					<div class="form-group mb-35">
						<label for="pickupMinimumOrderFee">PICKUP SERVICE FEE AMOUNT</label>
						<input
							type="number"
							id="pickupMinimumOrderFee"
							name="vendor[pickupMinimumOrderFee]"
							min="0"
							step="0.01"
							class="form-control"
							style="border-radius: 50px"
							value="<?php echo $vendor['pickupMinimumOrderFee']; ?>"
							/>
					</div>
					<div class="form-group mb-35">
						<label>POS PICKUP SERVICE FEE AMOUNT SAME</label>
						<br style="display:initial"/>
						<label class="radio-inline" for="pickupMinimumOrderFeePosYes">Yes</label>
						<input type="radio" id="pickupMinimumOrderFeePosYes" name="vendor[pickupMinimumOrderFeePos]" value="1" <?php if ($vendor['pickupMinimumOrderFeePos'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="pickupMinimumOrderFeePosNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="pickupMinimumOrderFeePosNo" name="vendor[pickupMinimumOrderFeePos]" value="0" <?php if ($vendor['pickupMinimumOrderFeePos'] === '0') echo 'checked'; ?> />
					</div>
					<div class="form-group mb-35">
						<label for="pickupServiceFeeAmount">PICKUP MAXIMUM SERVICE FEE AMOUNT</label>
						<input
							type="number"
							id="pickupServiceFeeAmount"
							name="vendor[pickupServiceFeeAmount]"
							min="0"
							step="0.01"
							class="form-control"
							style="border-radius: 50px"
							value="<?php echo $vendor['pickupServiceFeeAmount']; ?>"
							/>
					</div>
					<div class="form-group mb-35">
						<label>POS PICKUP MAXIMUM SERVICE FEE AMOUNT SAME</label>
						<br style="display:initial"/>
						<label class="radio-inline" for="pickupServiceFeeAmountPosYes">Yes</label>
						<input type="radio" id="pickupServiceFeeAmountPosYes" name="vendor[pickupServiceFeeAmountPos]" value="1" <?php if ($vendor['pickupServiceFeeAmountPos'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="pickupServiceFeeAmountPosNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="pickupServiceFeeAmountPosNo" name="vendor[pickupServiceFeeAmountPos]" value="0" <?php if ($vendor['pickupServiceFeeAmountPos'] === '0') echo 'checked'; ?> />
					</div>
					<div class="form-group mb-35">
						<label for="printTimeConstraint">PRINT ORDERS CREATED BEFORE
						<input
							type="number"
							id="printTimeConstraint"
							name="vendor[printTimeConstraint]"
							min="0"
							step="1"
							style="border-radius: 50px; text-align: center"
							value="<?php echo $vendor['printTimeConstraint']; ?>"
							/>
							HOURS
						</label>
					</div>
					<div class="form-group mb-35">
						<label for="serviceFeeTax">SERVICE FEE (VAT PERCENTAGE) </label>
						<select
							class="form-control"
							name="vendor[serviceFeeTax]"
							id="serviceFeeTax"
							class="form-control"
						>
							<option value="">Select</option>
							<?php foreach ($taxRates as $tax) { ?>
								<option
									value="<?php echo $tax; ?>"
									<?php if ($tax === intval($vendor['serviceFeeTax'])) { echo 'selected'; } ?>
								>
									<?php echo $tax; ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group mb-35">
						<label>EMAIL X AND Z REPORTES</label>
						<br style="display:initial"/>
						<label class="radio-inline" for="emailFinanceReporetsYes">Yes</label>
						<input type="radio" id="emailFinanceReporetsYes" name="vendor[emailFinanceReporets]" value="1" <?php if ($vendor['emailFinanceReporets'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="emailFinanceReporetsNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="emailFinanceReporetsNo" name="vendor[emailFinanceReporets]" value="0" <?php if ($vendor['emailFinanceReporets'] === '0') echo 'checked'; ?> />
					</div>
					<!--
					<h4>SELECT PAYMENT METHOD(S)</h4>
					<div class="form-check-inline mb-35">
						<div class="col-lg-6">
							<div class="form-group">
								<h4>BANCONTACT</h4>
								<label class="radio-inline" for="bancontactYes">Yes</label>
								<input type="radio" id="bancontactYes" name="vendor[bancontact]" value="1" <?php #if ($vendor['bancontact'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="bancontactNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="bancontactNo" name="vendor[bancontact]" value="0" <?php #if ($vendor['bancontact'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group">
								<h4>PAYCONIQ</h4>
								<label class="radio-inline" for="payconiqYes">Yes</label>
								<input type="radio" id="payconiqYes" name="vendor[payconiq]" value="1" <?php #if ($vendor['payconiq'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="bancontactNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="payconiqNo" name="vendor[payconiq]" value="0" <?php #if ($vendor['payconiq'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group mb-35">
								<h4>IDEAL</h4>
								<label class="radio-inline" for="idealYes">Yes</label>
								<input type="radio" id="idealYes" name="vendor[ideal]" value="1" <?php #if ($vendor['ideal'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="idealNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="idealNo" name="vendor[ideal]" value="0" <?php #if ($vendor['ideal'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group mb-35">
								<h4>My Bank</h4>
								<label class="radio-inline" for="myBankYes">Yes</label>
								<input type="radio" id="myBankYes" name="vendor[myBank]" value="1" <?php #if ($vendor['myBank'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="myBankNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="myBankNo" name="vendor[myBank]" value="0" <?php #if ($vendor['myBank'] === '0') echo 'checked'; ?> />
							</div>							
							<div class="form-group mb-35">
								<h4>VISA / MASTERCARD</h4>
								<label class="radio-inline" for="creditCardYes">Yes</label>
								<input type="radio" id="creditCardYes" name="vendor[creditCard]" value="1" <?php #if ($vendor['creditCard'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="creditCardNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="creditCardNo" name="vendor[creditCard]" value="0" <?php #if ($vendor['creditCard'] === '0') echo 'checked'; ?> />
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group mb-35">
								<h4>GIRO</h4>
								<label class="radio-inline" for="giroYes">Yes</label>
								<input type="radio" id="giroYes" name="vendor[giro]" value="1" <?php #if ($vendor['giro'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="giroNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="giroNo" name="vendor[giro]" value="0" <?php #if ($vendor['giro'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group mb-35">
								<h4>PREPAID</h4>
								<label class="radio-inline" for="prePaidYes">Yes</label>
								<input type="radio" id="prePaidYes" name="vendor[prePaid]" value="1" <?php #if ($vendor['prePaid'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="prePaidNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="prePaidNo" name="vendor[prePaid]" value="0" <?php #if ($vendor['prePaid'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group mb-35">
								<h4>POST PAID</h4>
								<label class="radio-inline" for="postPaidYes">Yes</label>
								<input type="radio" id="postPaidYes" name="vendor[postPaid]" value="1" <?php #if ($vendor['postPaid'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="postPaidNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="postPaidNo" name="vendor[postPaid]" value="0" <?php #if ($vendor['postPaid'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group mb-35">
								<h4>VOUCHER</h4>
								<label class="radio-inline" for="vaucherYes">Yes</label>
								<input type="radio" id="vaucherYes" name="vendor[vaucher]" value="1" <?php #if ($vendor['vaucher'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="vaucherNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="vaucherNo" name="vendor[vaucher]" value="0" <?php #if ($vendor['vaucher'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group mb-35">
								<h4>PIN MACHINE</h4>
								<label class="radio-inline" for="pinMachineYes">Yes</label>
								<input type="radio" id="pinMachineYes" name="vendor[pinMachine]" value="1" <?php #if ($vendor['pinMachine'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="pinMachineNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="pinMachineNo" name="vendor[pinMachine]" value="0" <?php #if ($vendor['pinMachine'] === '0') echo 'checked'; ?> />
							</div>
						</div>
					</div>
					-->
					
					<br/>
					<br/>
					<input class="btn btn-primary" type="submit" value="Submit" />
				</form>
				<br/>

			</div>
		</div>
	<?php } ?>
</div>

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
