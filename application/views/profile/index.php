<div class="main-wrapper" style="text-align:center">
	<?php if($this->session->userdata('dropoffpoint')==1) { ?>
		<div class="col-half background-apricot-blue timeline-content">
			<h2>Shop url</h2>
			<a href="<?php echo base_url() . 'make_order?vendorid=' . $user->id; ?>" target='_blank' >
				<?php echo base_url() . 'make_order?vendorid=' . $user->id; ?>
			</a>
			<h2>Booking url</h2>
			<a href="<?php echo base_url() . 'check424/' . $user->id; ?>" target='_blank' >
				<?php echo base_url() . 'check424/' . $user->id; ?>
			</a>
			<h2>Agenda Booking url</h2>
			<a href="<?php echo base_url() . 'agenda_booking/' . $user->username; ?>" target='_blank' >
				<?php echo base_url() . 'agenda_booking/' . $user->username; ?>
			</a>
			<h2>Booking Agenda url</h2>
			<a href="<?php echo base_url() . 'booking_agenda/' . $user->username; ?>" target='_blank' >
				<?php echo base_url() . 'booking_agenda/' . $user->username; ?>
			</a>
			<h2>Set public design</h2>
			<a href="<?php echo base_url() . 'viewdesign'; ?>">
				Design
			</a>
			<h2>Visma Accounting</h2>
			<a href="<?php echo base_url() . 'visma/config'; ?>">
				Visma
			</a>
			<div class="background-blue timeline-content">
				<!-- <p>Add driver mobile number (starting with country code with zero) for sending sms.</p>
				<p>Set the number of minutes when the message will be sent to driver after the order status is changed in status "DONE"</p> -->
				<!-- <p>Add terms and conditions</p> -->

				<form method="post" action="<?php echo base_url() ?>profile/updateVendorData/<?php echo $vendor['id']; ?>">
					<input type="number" name="vendorId" value="<?php echo $user->id ?>" readonly required hidden />
					<div class="form-group mb-35">
						<label for="termsAndConditions">TERMS AND CONDITIONS</label>
						<textarea class="form-control" id="termsAndConditions" name="vendor[termsAndConditions]"><?php echo strval($vendor['termsAndConditions']); ?></textarea>
					</div>
					<br/>
					<div class="form-group mb-35">
						<label for="payNlServiceId">PAY SERVICE ID</label>
						<input
							type="text"
							id="payNlServiceId"
							name="vendor[payNlServiceId]"
							class="form-control"
							style="border-radius: 50px"
							value="<?php echo $vendor['payNlServiceId']; ?>"
						/>
					</div>
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
						<input
							type="number"
							min="0"
							step="1"
							id="serviceFeeTax"
							name="vendor[serviceFeeTax]"
							class="form-control"
							style="border-radius: 50px"
							value="<?php echo $vendor['serviceFeeTax']; ?>"
							/>
					</div>
					<h4>SELECT PAYMENT METHOD(S)</h4>
					<div class="form-check-inline mb-35">
						<div class="col-lg-6">
							<div class="form-group">
								<h4>BANCONTACT</h4>
								<label class="radio-inline" for="bancontactYes">Yes</label>
								<input type="radio" id="bancontactYes" name="vendor[bancontact]" value="1" <?php if ($vendor['bancontact'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="bancontactNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="bancontactNo" name="vendor[bancontact]" value="0" <?php if ($vendor['bancontact'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group">
								<h4>PAYCONIQ</h4>
								<label class="radio-inline" for="payconiqYes">Yes</label>
								<input type="radio" id="payconiqYes" name="vendor[payconiq]" value="1" <?php if ($vendor['payconiq'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="bancontactNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="payconiqNo" name="vendor[payconiq]" value="0" <?php if ($vendor['payconiq'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group mb-35">
								<h4>IDEAL</h4>
								<label class="radio-inline" for="idealYes">Yes</label>
								<input type="radio" id="idealYes" name="vendor[ideal]" value="1" <?php if ($vendor['ideal'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="idealNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="idealNo" name="vendor[ideal]" value="0" <?php if ($vendor['ideal'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group mb-35">
								<h4>VISA / MASTERCARD</h4>
								<label class="radio-inline" for="creditCardYes">Yes</label>
								<input type="radio" id="creditCardYes" name="vendor[creditCard]" value="1" <?php if ($vendor['creditCard'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="creditCardNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="creditCardNo" name="vendor[creditCard]" value="0" <?php if ($vendor['creditCard'] === '0') echo 'checked'; ?> />
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group mb-35">
								<h4>GIRO</h4>
								<label class="radio-inline" for="giroYes">Yes</label>
								<input type="radio" id="giroYes" name="vendor[giro]" value="1" <?php if ($vendor['giro'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="giroNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="giroNo" name="vendor[giro]" value="0" <?php if ($vendor['giro'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group mb-35">
								<h4>PREPAID</h4>
								<label class="radio-inline" for="prePaidYes">Yes</label>
								<input type="radio" id="prePaidYes" name="vendor[prePaid]" value="1" <?php if ($vendor['prePaid'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="prePaidNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="prePaidNo" name="vendor[prePaid]" value="0" <?php if ($vendor['prePaid'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group mb-35">
								<h4>POST PAID</h4>
								<label class="radio-inline" for="postPaidYes">Yes</label>
								<input type="radio" id="postPaidYes" name="vendor[postPaid]" value="1" <?php if ($vendor['postPaid'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="postPaidNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="postPaidNo" name="vendor[postPaid]" value="0" <?php if ($vendor['postPaid'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group mb-35">
								<h4>VOUCHER</h4>
								<label class="radio-inline" for="vaucherYes">Yes</label>
								<input type="radio" id="vaucherYes" name="vendor[vaucher]" value="1" <?php if ($vendor['vaucher'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="vaucherNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="vaucherNo" name="vendor[vaucher]" value="0" <?php if ($vendor['vaucher'] === '0') echo 'checked'; ?> />
							</div>
							<div class="form-group mb-35">
								<h4>PIN MACHINE</h4>
								<label class="radio-inline" for="pinMachineYes">Yes</label>
								<input type="radio" id="pinMachineYes" name="vendor[pinMachine]" value="1" <?php if ($vendor['pinMachine'] === '1') echo 'checked'; ?> />
								<label class="radio-inline" for="pinMachineNo">&nbsp;&nbsp;&nbsp;No</label>
								<input type="radio" id="pinMachineNo" name="vendor[pinMachine]" value="0" <?php if ($vendor['pinMachine'] === '0') echo 'checked'; ?> />
							</div>
						</div>
					</div>
					<h4>REQUIRE USER MOBILE PHONE ON CHECKOUT FORM</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="requireMobileYes">Yes</label>
						<input type="radio" id="requireMobileYes" name="vendor[requireMobile]" value="1" <?php if ($vendor['requireMobile'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="requireMobileNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="requireMobileNo" name="vendor[requireMobile]" value="0" <?php if ($vendor['requireMobile'] === '0') echo 'checked'; ?> />
					</div>
					<h4>REQUIRE USER EMAIL ON CHECKOUT FORM</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="requireEmailYes">Yes</label>
						<input type="radio" id="requireEmailYes" name="vendor[requireEmail]" value="1" <?php if ($vendor['requireEmail'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="requireEmailNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="requireEmailNo" name="vendor[requireEmail]" value="0" <?php if ($vendor['requireEmail'] === '0') echo 'checked'; ?> />
					</div>
					<h4>REQUIRE USER NAME ON CHECKOUT FORM</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="requireNameYes">Yes</label>
						<input type="radio" id="requireNameYes" name="vendor[requireName]" value="1" <?php if ($vendor['requireName'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="requireNameNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="requireNameNo" name="vendor[requireName]" value="0" <?php if ($vendor['requireName'] === '0') echo 'checked'; ?> />
					</div>
					<h4>REQUIRE REGISTRATION FROM VISITOR</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="requireReservationkYes">Yes</label>
						<input type="radio" id="requireReservationkYes" name="vendor[requireReservation]" value="1" <?php if ($vendor['requireReservation'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="requireReservationNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="requireReservationNo" name="vendor[requireReservation]" value="0" <?php if ($vendor['requireReservation'] === '0') echo 'checked'; ?> />
					</div>
					<h4>REQUIRE HEALTH INFORMATION FROM VISITOR</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="healthCheckYes">Yes</label>
						<input type="radio" id="healthCheckYes" name="vendor[healthCheck]" value="1" <?php if ($vendor['healthCheck'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="healthCheckNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="healthCheckNo" name="vendor[healthCheck]" value="0" <?php if ($vendor['healthCheck'] === '0') echo 'checked'; ?> />
					</div>
					<h4>SELECT SALES LOCATION TYPES</h4>
					<div class="form-check-inline mb-35">
						<?php foreach ($vendor['typeData'] as $type) { ?>
							<label class="form-check-label">
								<?php echo $type['type']; ?>:
								<input
									type="checkbox"
									class="form-check-input"
									value="<?php echo $type['id']; ?>"
									name="vendorTypes[<?php echo $type['id']; ?>]"
									style="width:8px; height: 8px"
									<?php
										if ($type['active'] === '1') {
											echo 'checked';
										}
									?>
									/>

							</label>
						<?php } ?>
					</div>
					<h4>SELECT PREFERRED MAKE ORDER VIEW</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="preferredViewCheckYes">Old view</label>
						<input type="radio" id="preferredViewCheckYes" name="vendor[preferredView]" value="1" <?php if ($vendor['preferredView'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="preferredViewCheckNo">&nbsp;&nbsp;&nbsp;New view</label>
						<input type="radio" id="preferredViewCheckNo" name="vendor[preferredView]" value="2" <?php if ($vendor['preferredView'] === '2') echo 'checked'; ?> />
					</div>
					<h4>SHOW REMARKS IN CHECKOUT FORM</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="requireRemarksYes">Yes</label>
						<input type="radio" id="requireRemarksYes" name="vendor[requireRemarks]" value="1" <?php if ($vendor['requireRemarks'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="requireRemarksNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="requireRemarksNo" name="vendor[requireRemarks]" value="0" <?php if ($vendor['requireRemarks'] === '0') echo 'checked'; ?> />
					</div>
					<h4>SHOW SEND NEWSLETTER CHECKBOX IN FORM</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="requireNewsletterYes">Yes</label>
						<input type="radio" id="requireNewsletterYes" name="vendor[requireNewsletter]" value="1" <?php if ($vendor['requireNewsletter'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="requireNewsletterNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="requireNewsletterNo" name="vendor[requireNewsletter]" value="0" <?php if ($vendor['requireNewsletter'] === '0') echo 'checked'; ?> />
					</div>
					<h4>SEND EMAIL WITH RECEIPT TO BUYER</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="sendEmailReceiptYes">Yes</label>
						<input type="radio" id="sendEmailReceiptYes" name="vendor[sendEmailReceipt]" value="1" <?php if ($vendor['sendEmailReceipt'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="sendEmailReceiptNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="sendEmailReceiptNo" name="vendor[sendEmailReceipt]" value="0" <?php if ($vendor['sendEmailReceipt'] === '0') echo 'checked'; ?> />
					</div>
					<h4>SHOW PRODUCTS IMAGES IN MAKE ORDER FORM</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="showProductsImagesYes">Yes</label>
						<input type="radio" id="showProductsImagesYes" name="vendor[showProductsImages]" value="1" <?php if ($vendor['showProductsImages'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="showProductsImagesNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="showProductsImagesNo" name="vendor[showProductsImages]" value="0" <?php if ($vendor['showProductsImages'] === '0') echo 'checked'; ?> />
					</div>
					<h4>SHOW PRODUCT ALLERGIES</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="showAllergiesYes">Yes</label>
						<input type="radio" id="showAllergiesYes" name="vendor[showAllergies]" value="1" <?php if ($vendor['showAllergies'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="showAllergiesNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="showAllergiesNo" name="vendor[showAllergies]" value="0" <?php if ($vendor['showAllergies'] === '0') echo 'checked'; ?> />
					</div>
					<h4>SHOW MENU ON MAKE ORDER</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="showMenuYes">Yes</label>
						<input type="radio" id="showMenuYes" name="vendor[showMenu]" value="1" <?php if ($vendor['showMenu'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="showMenuNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="showMenuNo" name="vendor[showMenu]" value="0" <?php if ($vendor['showMenu'] === '0') echo 'checked'; ?> />
					</div>
					<h4>REQUIRE 'TERMS AND CONDITIONS' AND 'PRIVACY POLICE' CHECKOUT</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="showTermsAndPrivacyYes">Yes</label>
						<input type="radio" id="showTermsAndPrivacyYes" name="vendor[showTermsAndPrivacy]" value="1" <?php if ($vendor['showTermsAndPrivacy'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="showTermsAndPrivacyNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="showTermsAndPrivacyNo" name="vendor[showTermsAndPrivacy]" value="0" <?php if ($vendor['showTermsAndPrivacy'] === '0') echo 'checked'; ?> />
					</div>
					<h4>TIP TO A WAITER</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="tipWaiterYes">Yes</label>
						<input type="radio" id="tipWaiterYes" name="vendor[tipWaiter]" value="1" <?php if ($vendor['tipWaiter'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="tipWaiterNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="tipWaiterNo" name="vendor[tipWaiter]" value="0" <?php if ($vendor['tipWaiter'] === '0') echo 'checked'; ?> />
					</div>
					<h4>SET BUSY AND SLOW TIME</h4>
					<div class="form-group mb-35">
						<label for="minBusyTime">Minutes for slow&nbsp;
						<input
							type="number"
							id="minBusyTime"
							name="vendor[minBusyTime]"
							min="0"
							step="1"
							style="border-radius: 50px; text-align: center"
							value="<?php echo $vendor['minBusyTime']; ?>"
							/>
						</label>
						<label for="maxBusyTime">&nbsp;add minutes for busy&nbsp;
						<input
							type="number"
							id="maxBusyTime"
							name="vendor[maxBusyTime]"
							min="0"
							step="1"
							style="border-radius: 50px; text-align: center"
							value="<?php echo $vendor['maxBusyTime']; ?>"
							/>
							&nbsp; time.
						</label>
					</div>
					<h4>RECEIPT ONLY TO A WAITER</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="receiptOnlyToWaiterYes">Yes</label>
						<input type="radio" id="receiptOnlyToWaiterYes" name="vendor[receiptOnlyToWaiter]" value="1" <?php if ($vendor['receiptOnlyToWaiter'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="receiptOnlyToWaiterNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="receiptOnlyToWaiterNo" name="vendor[receiptOnlyToWaiter]" value="0" <?php if ($vendor['receiptOnlyToWaiter'] === '0') echo 'checked'; ?> />
					</div>
					<h4>SET MAX DELIVERY DISTANCE</h4>
					<div class="form-group mb-35">
						<label for="deliveryAirDistance">Add kilometars&nbsp;
						<input
							type="number"
							id="deliveryAirDistance"
							name="vendor[deliveryAirDistance]"
							min="0"
							step="1"
							style="border-radius: 50px; text-align: center"
							value="<?php echo $vendor['deliveryAirDistance']; ?>"
							/>
						</label>
					</div>
					<!-- <h4>
						SKIP CALENDAR DATE IF CUT TIME HAS PASSED
						(application will skipp working day if value is set to 'no')
					</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="skipDateYes">Yes</label>
						<input type="radio" id="skipDateYes" name="vendor[skipDate]" value="1" <?php #if ($vendor['skipDate'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="skipDateNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="skipDateNo" name="vendor[skipDate]" value="0" <?php #if ($vendor['skipDate'] === '0') echo 'checked'; ?> />
					</div> -->
					<h4>SET CUT TIME</h4>
					<div class="form-group mb-35">
						<label for="cutTime">CUT TIME&nbsp;
						<input
							type="time"
							id="cutTime"
							name="vendor[cutTime]"
							style="border-radius: 50px; text-align: center"
							value="<?php echo ($vendor['cutTime']) ? $vendor['cutTime'] : ''; ?>"
							step="60"
							/>
						</label>
					</div>
					<h4>ACTIVATE POS</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="activatePosYes">Yes</label>
						<input type="radio" id="activatePosYes" name="vendor[activatePos]" value="1" <?php if ($vendor['activatePos'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="activatePosNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="activatePosNo" name="vendor[activatePos]" value="0" <?php if ($vendor['activatePos'] === '0') echo 'checked'; ?> />
					</div>

					<h4>SET NUMBER OF WEEKS AHEAD FOR PICKUP/DELIVERY PERIOD AND TIME INTERVAL</h4>
					<div class="form-group mb-35">
						<label for="minBusyTime">Show pickup/delivery date for next&nbsp;
							<input
								type="number"
								id="pickupDeliveryWeeks"
								name="vendor[pickupDeliveryWeeks]"
								min="1"
								step="1"
								style="border-radius: 50px; text-align: center"
								value="<?php echo $vendor['pickupDeliveryWeeks']; ?>"
							/>
							weeks
						</label>
						<label for="maxBusyTime">&nbsp;Period time every&nbsp;
						<input
							type="number"
							id="pickupDeliveryMinutes"
							name="vendor[pickupDeliveryMinutes]"
							min="1"
							step="1"
							style="border-radius: 50px; text-align: center"
							value="<?php echo $vendor['pickupDeliveryMinutes']; ?>"
							/>
							&nbsp; minutes.
						</label>
					</div>
					<br/>
					<br/>
					<input class="btn btn-primary" type="submit" value="Submit" />
				</form>
				<br/>
				<form method="post" action="<?php echo base_url() ?>profile/updateVendorLogo/<?php echo $user->id; ?>" enctype="multipart/form-data">
					<div class="form-group" style="margin-top:30px !important">
						<label for="logo">
							<?php echo $this->language->line("LOGOPNG-103030211912"," Upload logo in png format 550 * 150 pxl"); ?>
						</label>
					</div>
					<?php if ($user->logo) { ?>
						<figure style="margin:auto;">
							<img
								src="<?php echo base_url() . 'assets/images/vendorLogos/' . $user->logo; ?>"
								class="img-responsive img-thumbnail"
								alt="logo"
								width="300px" height="auto"
								/>
						</figure>
						<br>
					<?php } ?>
					<div class="form-group has-feedback" style="margin-top: 10px">
						<input type="file" name="logo" id="logo" class="form-control" accept="image/png" />
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<input class="btn btn-primary" type="submit" value="Upload logo" />
				</form>
				<?php if ($vendor['showProductsImages'] === '1') { ?>
					<form method="post" action="<?php echo base_url() ?>profile/uploadDefaultProductsImage/<?php echo $vendor['id']; ?>" enctype="multipart/form-data">
						<div class="form-group" style="margin-top:30px !important">
							<label for="defaultProductsImage">
								<?php echo $this->language->line("DEFAULTPRODUCTIMAGE-1103030211dd9"," Upload default products image in PNG format "); ?>
							</label>
						</div>
						<?php if ($vendor['defaultProductsImage']) { ?>
							<figure style="margin:auto">
								<img
									src="<?php echo base_url() . 'assets/images/defaultProductsImages/' . $vendor['defaultProductsImage']; ?>"
									class="img-responsive img-thumbnail"
									alt="default product image"
									width="300px" height="auto"
									/>
							</figure>
							<br>
						<?php } ?>
						<div class="form-group has-feedback"  style="margin-top:10px;">
							<input type="file" name="defaultProductsImage" id="defaultProductsImage" class="form-control" accept="image/png" />
							<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
						</div>
						<input class="btn btn-primary" type="submit" value="Upload default products image" />
					</form>
				<?php } ?>
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

<div class="col-half background-green height-100 ">
	<div class="flex-column align-start width-650">
		<h2 class="heading mb-35"><?php echo $this->language->line("PROF-050",'PASSWORD CHANGE.');?></h2>
		<form action="<?php echo $this->baseUrl; ?>changePassword" method="post">
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="inputOldPassword">Old Password</label>
							<input style="border-radius: 50px" type="password" class="form-control" id="inputOldPassword" placeholder="Old password" name="oldPassword" maxlength="20" required>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="inputPassword1">New Password</label>
							<input style="border-radius: 50px" type="password" class="form-control" id="inputPassword1" placeholder="New password" name="newPassword" maxlength="20" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="inputPassword2">Confirm New Password</label>
							<input style="border-radius: 50px" type="password" class="form-control" id="inputPassword2" placeholder="Confirm new password" name="cNewPassword" maxlength="20" required>
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