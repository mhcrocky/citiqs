<div class="main-wrapper" style="text-align:center">
	<?php if($this->session->userdata('dropoffpoint')==1) { ?>
		<div class="col-half timeline-content mx-auto">
			<div class="timeline-content">
				<!-- <p>Add driver mobile number (starting with country code with zero) for sending sms.</p>
				<p>Set the number of minutes when the message will be sent to driver after the order status is changed in status "DONE"</p> -->
				<!-- <p>Add terms and conditions</p> -->

				<form method="post" action="<?php echo base_url() ?>profile/updateVendorData/<?php echo $vendor['id']; ?>">
					<input type="hidden" name="shopsettings" value="1" />
					<input type="number" name="vendorId" value="<?php echo $user->id ?>" readonly required hidden />
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
									style="width:24px; height: 24px"
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
						<label class="radio-inline" for="oldView">Old view</label>
						<input type="radio" id="oldView" name="vendor[preferredView]" value="<?php echo $oldView; ?>" <?php if ($vendor['preferredView'] === $oldView) echo 'checked'; ?> />
						<label class="radio-inline" for="newView">&nbsp;&nbsp;&nbsp;New view</label>
						<input type="radio" id="newView" name="vendor[preferredView]" value="<?php echo $newView; ?>" <?php if ($vendor['preferredView'] === $newView) echo 'checked'; ?> />
						<label class="radio-inline" for="view2021">&nbsp;&nbsp;&nbsp;2021 view</label>
						<input type="radio" id="view2021" name="vendor[preferredView]" value="<?php echo $view2021; ?>" <?php if ($vendor['preferredView'] === $view2021) echo 'checked'; ?> />
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
					<h4>SEND EMAIL WITH RECEIPT FROM ANONYMOUS BUYER</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="sendAnonymousReceiptYes">Yes</label>
						<input type="radio" id="sendAnonymousReceiptYes" name="vendor[sendAnonymousReceipt]" value="1" <?php if ($vendor['sendAnonymousReceipt'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="sendAnonymousReceiptNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="sendAnonymousReceiptNo" name="vendor[sendAnonymousReceipt]" value="0" <?php if ($vendor['sendAnonymousReceipt'] === '0') echo 'checked'; ?> />
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
					<h4>SHOW CATEGORIES</h4>
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
					<h4>RECEIPT ONLY FOR THE CUSTOMER</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="receiptOnlyToWaiterYes">Yes</label>
						<input type="radio" id="receiptOnlyToWaiterYes" name="vendor[receiptOnlyToWaiter]" value="1" <?php if ($vendor['receiptOnlyToWaiter'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="receiptOnlyToWaiterNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="receiptOnlyToWaiterNo" name="vendor[receiptOnlyToWaiter]" value="0" <?php if ($vendor['receiptOnlyToWaiter'] === '0') echo 'checked'; ?> />
					</div>
					<h4>PRINT ONLY CASH RECEIPT (WITHOUT ORDER PRINT)</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="printOnlyReceipttYes">Yes</label>
						<input type="radio" id="printOnlyReceipttYes" name="vendor[printOnlyReceipt]" value="1" <?php if ($vendor['printOnlyReceipt'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="printOnlyReceiptNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="printOnlyReceiptNo" name="vendor[printOnlyReceipt]" value="0" <?php if ($vendor['printOnlyReceipt'] === '0') echo 'checked'; ?> />
					</div>
					<h4>SET MAX DELIVERY DISTANCE</h4>
					<div class="form-group mb-35">
						<label for="deliveryAirDistance">Add kilometers&nbsp;
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
					<h4>SHOW VOUCHER CODE ON TOP OF PAYMENT METHODS</h4>
					<div class="form-group mb-35">
						<label class="radio-inline" for="voucherPaymentCodeYes">Yes</label>
						<input type="radio" id="voucherPaymentCodeYes" name="vendor[voucherPaymentCode]" value="1" <?php if ($vendor['voucherPaymentCode'] === '1') echo 'checked'; ?> />
						<label class="radio-inline" for="voucherPaymentCodeNo">&nbsp;&nbsp;&nbsp;No</label>
						<input type="radio" id="voucherPaymentCodeNo" name="vendor[voucherPaymentCode]" value="0" <?php if ($vendor['voucherPaymentCode'] === '0') echo 'checked'; ?> />
					</div>
					<br/>
					<br/>
					<input class="btn btn-primary" type="submit" value="Submit" />
				</form>
				<br/>
			</div>
		</div>
	<?php } ?>
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
