<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- Add Printer Modal -->
<div class="modal fade" id="addPrinterModal" tabindex="-1" role="dialog" aria-labelledby="addPrinterModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
				<h5 class="modal-title" id="addPrinterModalLabel">Add printer</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      		<div class="modal-body">
	        	<div class="item-editor" id='add-printer'>
					<div class="edit-single-user-container">
						<form class="form-inline" id="addPrinter" method="post" action="<?php echo $this->baseUrl . 'warehouse/addPrinter'; ?>">
							<input type="text" readonly name="userId" required value="<?php echo $userId ?>" hidden />
							<input type="text" readonly name="active" required value="1" hidden />
							<div>
								<label for="printer">Printer: </label>
								<input type="text" class="form-control" id="printer" name="printer" required />
							</div>
							<div>
								<label for="macNumber">MAC number: </label>
								<input type="text" class="form-control" id="macNumber" name="macNumber" required />
							</div>
							<div>
								<label for="contactPhone">Mobile phone for alerts (country code + number):</label>
								<input type="text" class="form-control" id="contactPhone" name="contactPhone" required />
							</div>
							<div>
								<label for="numberOfCopies">Number of copies: </label>
								<input type="integer" min="1" value="1" step="1" class="form-control" id="numberOfCopies" name="numberOfCopies" required />
							</div>
							<?php if ($printers) { ?>
								<div>
									<label for="masterMac">Select master printer (only for slave printer): </label>
									<select class="form-control" id="masterMac" name="masterMac">
										<option value="0">Select</option>
										<?php foreach ($printers as $printer) { ?>
											<?php if ($printer['masterMac'] === '0') { ?>
												<option value="<?php echo $printer['macNumber']; ?>">
													<?php echo $printer['printer']; ?>
												</option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							<?php } ?>
							<div style="margin-bottom:10px">
								<Label>Print reportes: </label>
								<label>
									<input
										type="radio"
										name="printReports"
										value="1"
									/>
									Yes
								</label>
								<label>
									<input
										type="radio"
										name="printReports"
										value="0"
										checked
									/>
									No
								</label>
							</div>
							<div style="margin-bottom:10px">
								<Label>Print receipts: </label>
								<label>
									<input
										type="radio"
										name="printReceipts"
										value="1"
									/>
									Yes
								</label>
								<label>
									<input
										type="radio"
										name="printReceipts"
										value="0"
										checked
									/>
									No
								</label>
							</div>
							<div style="margin-bottom:10px">
								<Label>Send SMS to buyer: </label>
								<label>
									<input
										type="radio"
										name="sendSmsToBuyer"
										value="1"
									/>
									Yes
								</label>
								<label>
									<input
										type="radio"
										name="sendSmsToBuyer"
										value="0"
										checked
									/>
									No
								</label>
							</div>
							<div style="margin-bottom:10px">
								<label for="messageToBuyer">Message to buyer: </label>
								<textarea
									class="form-control"
									id="messageToBuyer"
									name="messageToBuyer"
									maxlength="128"
									rows="3"
									style="border-radius:10px"
								><?php echo implode(' ', $messageToBuyerTags); ?></textarea>
							</div>
						</form>
					</div>
				</div>
      		</div>
      		<div class="modal-footer">
	    		<input style="width: 100px;" type="button" class="grid-button button theme-editor-header-button" onclick="submitForm('addPrinter')" value="Submit" />
				<button style="width: 100px;" class="grid-button-cancel button theme-editor-header-button"  data-dismiss="modal">Cancel</button>
      		</div>
    	</div>
  	</div>
</div>

<div style="margin-top: 0;" class="main-wrapper theme-editor-wrapper">
	<div style="background: none;" class="grid-wrapper">
		<div class="grid-list">
			<div class="grid-list-header row">
				<div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<!-- <div class="form-group">
						<label for="filterCategories">Filter printers:</label>						
					</div> -->
				</div>

				<div class="col-lg-4 col-md-4 col-sm-12 search-container">
					<button
                        class="btn button-security my-2 my-sm-0 button grid-button"
						data-toggle="modal" data-target="#addPrinterModal">Add printer</button>
				</div>
			</div><!-- end grid header -->
			<!-- SINGLE GIRD ITEM -->
            <?php if (is_null($printers)) { ?> 
				<p>No printers.</p>
            <?php } else { ?>
                <?php foreach ($printers as $printer) { ?>
					<div class="grid-item" style="background-color:<?php echo $printer['active'] === '1' ? '#72b19f' : '#ff0000'; ?>">
						<div class="item-header" style="width:100%">
							<p class="item-description" style="white-space: initial;">Name: <?php echo $printer['printer']; ?></p>
                            <p class="item-description" style="white-space: initial;">MAC number: <?php echo $printer['macNumber']; ?></p>
							<p class="item-category" style="white-space: initial;">Status:
								<?php echo $printer['active'] === '1' ? '<span>ACTIVE</span>' : '<span>BLOCKED</span>'; ?>
							</p>
							<?php if ($printer['contactPhone']) { ?>
								<p class="item-description" style="white-space: initial;">Alert phone number: <?php echo $printer['contactPhone']; ?></p>
							<?php } ?>
							<p class="item-description" style="white-space: initial;">Number of copies: <?php echo $printer['numberOfCopies']; ?></p>
							<?php if ($printer['isFod'] === '1') { ?>
							<p class="item-description" style="white-space: initial;">FOD PRINTER</p>
							<p class="item-description" style="white-space: initial;">Hard lock: <?php echo ($printer['isFodHardLock'] === '1') ? 'Yes' : 'No'; ?></p>
							<?php } ?>
							<?php if (!is_null($printer['master']) && $printer['masterMac'] !== '0') { ?>
							<p class="item-description" style="white-space: initial;">SLAVE PRINTER</p>
							<p class="item-description" style="white-space: initial;">Master is: <?php echo $printer['master']; ?></p>
							<?php } else { ?>
							<p class="item-description" style="white-space: initial;">Print reports: <?php echo ($printer['printReports'] === '1') ? 'Yes' : 'No'; ?></p>
							<?php } ?>
							<p class="item-description" style="white-space: initial;">Print receipts: <?php echo ($printer['printReceipts'] === '1') ? 'Yes' : 'No'; ?></p>
							<p class="item-description" style="white-space: initial;">Send SMS to buyer: <?php echo ($printer['sendSmsToBuyer'] === '1') ? 'Yes' : 'No'; ?></p>
							<p
								style="color:#ff3333; font-weight:900; font-size:16px; visibility:hidden"
								data-printer-id="<?php echo $printer['id']; ?>"
								data-active="<?php echo $printer['active']; ?>"
								class="printerErrMessage"
							>NOT CONNECTED</p>
						</div><!-- end item header -->
						<div class="grid-footer">
							<div class="iconWrapper">
								<span class="fa-stack fa-2x edit-icon btn-edit-item" onclick="editPrinter('<?php echo $printer['id']; ?>')">
									<i class="far fa-edit"></i>
								</span>
							</div>
							<?php if ($printer['active'] === '1') { ?>
								<div title="Click to block printer" class="iconWrapper delete-icon-wrapper">
									<a href="<?php echo $this->baseUrl . 'warehouse/editPrinter/' . $printer['id'] .'/0'; ?>" >
										<span class="fa-stack fa-2x delete-icon">
											<i class="fas fa-times"></i>
										</span>
									</a>
								</div>
							<?php } else { ?>
								<div title="Click to activate printer" class="iconWrapper delete-icon-wrapper">
									<a href="<?php echo $this->baseUrl . 'warehouse/editPrinter/' . $printer['id'] .'/1'; ?>" >
										<span class="fa-stack fa-2x" style="background-color:#0f0">
											<i class="fas fa-check"></i>
										</span>
									</a>
								</div>
							<?php } ?>
						</div>
						<button id="btn-<?php echo  $printer['id']; ?>" style="display: none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#editPrinterId<?php echo  $printer['id']; ?>">Edit</button>
						<!-- ITEM EDITOR -->
						<div class="modal fade" id="editPrinterId<?php echo  $printer['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editPrinterPrinterId<?php echo  $printer['id']; ?>ModalLabel" aria-hidden="true">
						    <div class="modal-dialog" role="document">
							    <div class="modal-content">
								    <div class="modal-header">
										<h5 id="editPrinterPrinterId<?php echo  $printer['id']; ?>ModalLabel" class="modal-title">Printer details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

									<div class="item-editor" id="editPrinterPrinterId<?php echo  $printer['id']; ?>">
										<div class="theme-editor-header d-flex justify-content-between">
									</div>
										<div class="edit-single-user-container">
											<form
												class="form-inline"
												id="editPrinter<?php echo $printer['id']; ?>"
												method="post"
												action="<?php echo $this->baseUrl . 'warehouse/editPrinter/' . $printer['id']; ?>"
											>
												<input type="text" name="userId" value="<?php echo $userId; ?>" readonly required hidden />
												<div>
													<label for="printer<?php echo $printer['id']; ?>">Name:</label>
													<input type="text" class="form-control" id="printer<?php echo $printer['id']; ?>" name="printer" required value="<?php echo $printer['printer']; ?>" />
												</div>
												<div>
													<label for="printerMac<?php echo $printer['id']; ?>">MAC number:</label>
													<input type="text" class="form-control" id="printerMac<?php echo $printer['id']; ?>" name="macNumber" required value="<?php echo $printer['macNumber']; ?>" />
												</div>
												<div>
													<label for="contactPhone<?php echo $printer['id']; ?>">Mobile phone for alerts (country code + number):</label>
													<input type="text" class="form-control" id="contactPhone<?php echo $printer['id']; ?>" name="contactPhone" required value="<?php echo $printer['contactPhone']; ?>" />
												</div>
												<div>
													<label for="numberOfCopies<?php echo $printer['numberOfCopies']; ?>">Number of copies:</label>
													<input type="number" min="1" step="1" class="form-control" id="numberOfCopies<?php echo $printer['numberOfCopies']; ?>" name="numberOfCopies" required value="<?php echo $printer['numberOfCopies']; ?>" />
												</div>
												<div>
													<label for="masterMac<?php echo $printer['id']; ?>">Select master printer (only for slave printer): </label>
													<select class="form-control" id="masterMac<?php echo $printer['id']; ?>" name="masterMac">
														<option value="0">None</option>
														<?php
															foreach ($printers as $master) {													
																if ($master['macNumber'] !== $printer['macNumber'] && $master['masterMac'] === '0') {
															?>
																<option
																	value="<?php echo $master['macNumber']; ?>"
																	<?php if ($master['macNumber'] === $printer['masterMac']) echo 'selected'; ?>
																	>
																	<?php echo $master['printer']; ?>
																</option>
															<?php
																}
															}
														?>
													</select>
												</div>
												<?php if ($printer['isFod'] === '1') { ?>
													<div>
														<label>Is hard lock:</label>
														<label>
															Yes:&nbsp;&nbsp;
															<input
																type="radio"
																value="1"
																name="isFodHardLock"
																<?php if ($printer['isFodHardLock'] === '1') echo 'checked'; ?>
															/>
														</label>
														<label>
															No:&nbsp;&nbsp;
															<input
																type="radio"
																value="0"
																name="isFodHardLock"
																<?php if ($printer['isFodHardLock'] === '0') echo 'checked'; ?>
															/>
														</label>
													</div>
												<?php } ?>
												<?php if (is_null($printer['master']) || $printer['masterMac'] === '0') { ?>
													<div style="margin-bottom:10px">
														<Label>Print reportes: </label>
														<label>
															<input
																type="radio"
																name="printReports"
																value="1"
																<?php if ($printer['printReports'] === '1') { echo 'checked'; } ?>
															/>
															Yes
														</label>
														<label>
															<input
																type="radio"
																name="printReports"
																value="0"
																<?php if ($printer['printReports'] === '0') { echo 'checked'; } ?>
															/>
															No
														</label>
													</div>
													<div style="margin-bottom:10px">
														<Label>Print receipts: </label>
														<label>
															<input
																type="radio"
																name="printReceipts"
																value="1"
																<?php if ($printer['printReceipts'] === '1') { echo 'checked'; } ?>
															/>
															Yes
														</label>
														<label>
															<input
																type="radio"
																name="printReceipts"
																value="0"
																<?php if ($printer['printReceipts'] === '0') { echo 'checked'; } ?>
															/>
															No
														</label>
													</div>
												<?php } ?>
												<div style="margin-bottom:10px">
													<Label>Send SMS to buyer: </label>
													<label>
														<input
															type="radio"
															name="sendSmsToBuyer"
															value="1"
															<?php if ($printer['sendSmsToBuyer'] === '1') { echo 'checked'; } ?>
														/>
														Yes
													</label>
													<label>
														<input
															type="radio"
															name="sendSmsToBuyer"
															value="0"
															<?php if ($printer['sendSmsToBuyer'] === '0') { echo 'checked'; } ?>
														/>
														No
													</label>
												</div>
												<div style="margin-bottom:10px">
													<label for="messageToBuyer<?php echo $printer['id']; ?>">Message to buyer: </label>
													<textarea
														class="form-control"
														id="messageToBuyer<?php echo $printer['id']; ?>"
														name="messageToBuyer"
														maxlength="128"
														rows="3"
														style="border-radius:10px"
													><?php
														echo is_null($printer['messageToBuyer']) ? implode(' ', $messageToBuyerTags) : $printer['messageToBuyer'];
													?></textarea>
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<input style="width: 100px;" type="button" onclick="submitForm('editPrinter<?php echo $printer['id']; ?>')" class="grid-button button theme-editor-header-button" value="Submit" />
									<button style="width: 100px;" class="grid-button-cancel button theme-editor-header-button" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>

						<!-- END EDIT FOR NEW USER -->
					</div>
                <?php } ?>
            <?php } ?>
			
		</div>
		<!-- end grid list -->
	</div>
</div>
<script>
	function editPrinter(id){
		$("#btn-"+id).click();
		return ;
	}
	var printerGlobals =(function(){
		let globals = {
			'errClass' : 'printerErrMessage'
		}
		Object.freeze(globals);
		return globals;
	}());
</script>