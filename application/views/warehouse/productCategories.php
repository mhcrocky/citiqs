<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
	    		<div>
		    		<img class="img-fluid" style="max-width: 120px;" src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
				</div>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
				</button>
      		</div>
      		<div class="modal-body">
	  			<div class="item-editor" id='add-category'>
					<div class="d-flex justify-content-center" style="width:100%;">
						<form
							class="form-inline"
							id="addCategory"
							method="post"
							action="<?php echo $this->baseUrl . 'warehouse/addCategory'; ?>"
							enctype="multipart/form-data"
						>
							<fieldset>
								<legend>Add category</legend>
								<input type="text" readonly name="userId" required value="<?php echo $userId ?>" hidden />
								<input
									type="number"
									readonly
									name="sortNumber"
									required
									value="<?php echo (is_null($categories)) ? '1' :  (count($categories) + 1); ?>"
									hidden
								/>
								<input type="text" readonly name="active" required value="1" hidden />
								<div class="col-lg-4 col-sm-12 form-group">
									<label style="background-color:#fff" for="category">Category: </label>
									<input type="text" class="form-control" id="category" name="category" required />
								</div>
								<div class="col-lg-4 col-sm-12 form-group">
									<label style="background-color:#fff" for="driverNumber">Driver SMS number: </label>
									<input type="text" class="form-control" id="driverNumber" name="driverNumber" />
								</div>
								<div class="col-lg-4 col-sm-12 form-group">
									<label style="background-color:#fff" for="delayTime">Delay time in minutes: </label>
									<input type="number" min="0" step="1" class="form-control" id="delayTime" name="delayTime" />
								</div>
								<div class="col-lg-4 col-sm-12 form-group">
									<label style="background-color:#fff">Send SMS to driver:&nbsp;&nbsp;&nbsp;</label>
									<label style="background-color:#fff" class="radio-inline" for="sendSmsYes">Yes</label>
									<input type="radio" id="sendSmsYes" name="sendSms" value="1" >
									<label style="background-color:#fff" class="radio-inline" for="sendSmsNo">&nbsp;&nbsp;&nbsp;No</label>
									<input type="radio" id="sendSmsNo" name="sendSms" value="0" checked />
								</div>
								<div class="col-lg-4 col-sm-12 form-group">
									<label style="background-color:#fff" for="driverSmsMessage">SMS message for driver: </label>
									<input type="text" class="form-control" id="driverSmsMessage" name="driverSmsMessage" />
								</div>
								<div class="col-lg-4 col-sm-12 form-group">
									<label style="background-color:#fff">Private category:&nbsp;&nbsp;&nbsp;</label>
									<label style="background-color:#fff" class="radio-inline" for="privateYes">Yes</label>
									<input type="radio" id="privateYes" name="private" value="1" >
									<label style="background-color:#fff" class="radio-inline" for="privateNo">&nbsp;&nbsp;&nbsp;No</label>
									<input type="radio" id="privateNo" name="private" value="0" checked />
								</div>
								<div class="col-lg-4 col-sm-12 form-group">
									<label style="background-color:#fff" for="categoryImage">Upload category image: </label>
									<input type="file" class="form-control" id="categoryImage" name="image" />
								</div>
								<div class="col-lg-4 col-sm-12 form-group">
									<label style="background-color:#fff">Show image:&nbsp;&nbsp;&nbsp;</label>
									<label style="background-color:#fff" class="radio-inline" for="showImageYes">Yes</label>
									<input type="radio" id="showImageYes" name="showImage" value="1" >
									<label style="background-color:#fff" class="radio-inline" for="showImageNo">&nbsp;&nbsp;&nbsp;No</label>
									<input type="radio" id="showImageNo" name="showImage" value="0" checked />
								</div>
							</fieldset>
						</form>
					</div>
				</div>
      		</div>
      		<div class="modal-footer">
        		<button type="button" style="width: 100px;" class="grid-button-cancel button theme-editor-header-button" data-dismiss="modal">Cancel</button>
        		<input type="button" style="width: 100px;" class="grid-button button theme-editor-header-button" onclick="submitForm('addCategory')" value="Submit" />
      		</div>
    	</div>
  	</div>
</div>
<!-- End Add Category Modal -->



<div style="margin-top: 0 !important;background: #f3d0b1 !important;" class="main-wrapper theme-editor-wrapper">
	<div style="background: #f3d0b1 !important;" class="grid-wrapper">
		<div class="grid-list">
			
			<div class="grid-list-header row">
				<div class="col-lg-3 col-md-3 col-sm-12 grid-header-heading text-center">
					<h3><b>Categories</b></h3>
				</div>
				<div class="col-lg-7 col-md-7 col-sm-12">
					<div class="form-group">
						<label>Filter categories:</label>
						<label class="radio-inline">
							<input
								type="radio"
								name="locationHref"
								value="<?php echo $this->baseUrl . 'product_categories'; ?>"
								<?php if (!isset($_GET['active'])) echo 'checked'; ?>
								onclick="redirect(this)"
								/>
							All categories
					    </label>
						<label class="radio-inline">
							<input
								type="radio"
								name="locationHref"
								value="<?php echo $this->baseUrl . 'product_categories?active=1'; ?>"
								<?php if (isset($_GET['active']) && $_GET['active'] === '1') echo 'checked'; ?>
								onclick="redirect(this)"
								/>
								Active categories
					    </label>
						<label class="radio-inline">
							<input
								type="radio"
								name="locationHref"
								value="<?php echo $this->baseUrl . 'product_categories?active=0'; ?>"
								<?php if (isset($_GET['active']) && $_GET['active'] === '0') echo 'checked'; ?>
								onclick="redirect(this)"
								/>
								Archived categories
					    </label>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-12 search-container">
				<button type="button" class="btn button-security my-2 my-sm-0 button grid-button" data-toggle="modal" data-target="#addCategoryModal">Add category</button>
				<br style="display:initial" />
				<button type="button" class="btn button-security my-2 my-sm-0 button grid-button" onclick="generateCategoryKey('<?php echo $userId; ?>', 'openKey')">New open key</button>
				<!--<button class="btn button-security my-2 my-sm-0 button grid-button" onclick="toogleElementClass('add-category', 'display')">Add category</button>-->
				</div>
			</div><!-- end grid header -->
			<!-- SINGLE GIRD ITEM -->
            <?php if (is_null($categories)) { ?> 
				<p>No categories.</p>
            <?php } else { ?>
				<div class="row list-categories" id="sortableCategories" style="width:100%">
					<?php foreach ($categories as $category) { ?>
						<div class="grid-item list-categories listCategories" data-category-id="<?php echo $category['categoryId']; ?>" style="background-color:<?php echo $category['active'] === '1' ? '#72b19f' : '#ff0000'; ?>">
							<div class="item-header" style="width:100%">
								<p class="item-description"><?php echo $category['category']; ?></p>
								<p class="item-category" style="white-space: initial;">Status: <?php echo $category['active'] === '1' ? '<span>ACTIVE</span>' : '<span>BLOCKED</span>'; ?> </p>
								<p class="item-category" style="white-space: initial;">Send SMS to driver: <?php echo $category['sendSms'] === '1' ? '<span>YES</span>' : '<span>NO</span>'; ?></p>
								<p class="item-category" style="white-space: initial;">Driver number: <?php echo $category['driverNumber']; ?></p>
								<p class="item-category" style="white-space: initial;">Minutes to delay: <?php echo $category['delayTime']; ?></p>
								<p class="item-category" style="white-space: initial;">Message to driver: <?php echo $category['driverSmsMessage']; ?></p>
								<p class="item-category" style="white-space: initial;">Private: <?php echo $category['private'] === '1' ? 'Yes' : 'No'; ?></p>
								<p class="item-category openKey" style="white-space: initial;">
									<?php if ($category['openKey']) { ?>
										Category key: <?php echo $category['openKey']; ?>
									<?php } ?>
								</p>
								<?php if ($category['image']) { ?>
									<figure>
										<img src='<?php echo $imgFolder . $category['image']; ?>' alt="<?php echo $category['category']; ?>" />
										<figcaption>
											Show image: <?php echo ($category['showImage'] === '1') ? 'Yes' : 'No'; ?>
										</figcaption>
									</figure>
								<?php } ?>
							</div><!-- end item header -->
							<div class="grid-footer">
								<div class="iconWrapper">
									<span class="fa-stack fa-2x edit-icon btn-edit-item" onclick="editCategory('<?php echo $category['categoryId']; ?>')">
										<i class="far fa-edit"></i>
									</span>
								</div>
								<div class="iconWrapper">
									<span class="fa-stack fa-2x edit-icon btn-edit-item" data-toggle="modal" data-target="#timeModal<?php echo $category['categoryId']; ?>"  title="Click to add time">
										<i class="far fa-clock-o"></i>
									</span>
								</div>
								<?php if ($category['active'] === '1') { ?>
									<div title="Click to archive category" class="iconWrapper delete-icon-wrapper">
										<a href="<?php echo $this->baseUrl . 'warehouse/editCategory/' . $category['categoryId'] .'/0'; ?>" >
											<span class="fa-stack fa-2x delete-icon">
												<i class="fas fa-times"></i>
											</span>
										</a>
									</div>
								<?php } else { ?>
									<div title="Click to activate category" class="iconWrapper delete-icon-wrapper">
										<a href="<?php echo $this->baseUrl . 'warehouse/editCategory/' . $category['categoryId'] .'/1'; ?>" >
											<span class="fa-stack fa-2x" style="background-color:#0f0">
												<i class="fas fa-check"></i>
											</span>
										</a>
									</div>
								<?php } ?>
							</div>
							<button id="btn-<?php echo $category['categoryId']; ?>" style="display:none;" type="button" class="btn button-security my-2 my-sm-0 button grid-button" data-toggle="modal" data-target="#editCategoryModal<?php echo $category['categoryId']; ?>">Edit category</button>
							<!-- Edit Category Modal -->
							<div class="modal" id="editCategoryModal<?php echo $category['categoryId']; ?>" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									<div class="modal-header">
										<h3 style="text-align:left">Category "<?php echo $category['category']; ?>" details</h3>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
											<div class="item-editor" id="editCategoryCategoryId<?php echo  $category['categoryId']; ?>">
												<div style="width:100%">
													<form
														class="form-inline"
														id="editCategory<?php echo $category['categoryId']; ?>"
														method="post"
														action="<?php echo $this->baseUrl . 'warehouse/editCategory/' . $category['categoryId']; ?>"
														enctype="multipart/form-data"
													>
														<input type="text" name="userId" value="<?php echo $userId; ?>" readonly required hidden />
														<input
															type="number"
															id="sortNumber<?php echo $category['categoryId']; ?>"
															readonly
															name="sortNumber"
															required
															value="<?php echo $category['sortNumber']; ?>"
															hidden
															/>
																	
														<div class="col-lg-4 col-sm-12 form-group">
															<label style="background-color:#fff" for="category<?php echo $category['categoryId']; ?>">Name</label>
															<input type="text" class="form-control" id="category<?php echo $category['categoryId']; ?>" name="category" required value="<?php echo $category['category']; ?>" />
														</div>
														<div class="col-lg-4 col-sm-12 form-group">
															<label style="background-color:#fff" for="driverNumber<?php echo $category['categoryId']; ?>">Driver SMS number: </label>
																<input
																	type="text"
																	class="form-control"
																	id="driverNumber<?php echo $category['categoryId']; ?>"
																	name="driverNumber"
																	value="<?php echo strval($category['driverNumber']); ?>"
																	/>
														</div>
														<div class="col-lg-4 col-sm-12 form-group">
															<label style="background-color:#fff" for="delayTime<?php echo $category['categoryId']; ?>">Delay time in minutes: </label>
															<input
																type="number"
																min="0"
																step="1"
																class="form-control"
																id="delayTime<?php echo $category['categoryId']; ?>"
																name="delayTime"
																value="<?php echo ($category['delayTime']) ? strval($category['delayTime']) : '0'; ?>"
																/>
														</div>
														<div class="col-lg-4 col-sm-12 form-group">
															<span style="background-color:#fff" >Send SMS to a driver:&nbsp;&nbsp;&nbsp;</span>
															<label class="radio-inline" style="background-color:#fff" for="sendSmsYes<?php echo $category['categoryId']; ?>">Yes</label>
															<input type="radio" id="sendSmsYes<?php echo $category['categoryId']; ?>" name="sendSms" value="1" <?php if ($category['sendSms'] === '1') echo 'checked'; ?>>
															<label class="radio-inline" style="background-color:#fff" for="sendSmsNo<?php echo $category['categoryId']; ?>">&nbsp;&nbsp;&nbsp;No</label>
															<input type="radio" id="sendSmsNo<?php echo $category['categoryId']; ?>" name="sendSms" value="0" <?php if ($category['sendSms'] === '0') echo 'checked'; ?>>
														</div>
														<div class="col-lg-4 col-sm-12 form-group">
															<label style="background-color:#fff" for="driverSmsMessage<?php echo $category['categoryId']; ?>">SMS message for driver: </label>
															<input
																type="text"
																class="form-control"
																id="driverSmsMessage<?php echo $category['categoryId']; ?>"
																value="<?php echo $category['driverSmsMessage']; ?>"
																name="driverSmsMessage"
																/>
														</div>
														<div class="col-lg-4 col-sm-12 form-group">
															<label style="background-color:#fff">Private category:&nbsp;&nbsp;&nbsp;</label>
															<label style="background-color:#fff" class="radio-inline" for="privateYes<?php echo $category['categoryId']; ?>">Yes</label>
															<input
																type="radio"
																id="privateYes<?php echo $category['categoryId']; ?>"
																name="private" value="1"
																<?php if ($category['private'] === '1') echo 'checked'; ?>
															/>
															<label style="background-color:#fff" class="radio-inline" for="privateNo<?php echo $category['categoryId']; ?>">&nbsp;&nbsp;&nbsp;No</label>
															<input
																type="radio"
																id="privateNo<?php echo $category['categoryId']; ?>"
																name="private"
																value="0"
																<?php if ($category['private'] === '0') echo 'checked'; ?>
															/>
														</div>
														<div class="col-lg-4 col-sm-12 form-group">
															<label style="background-color:#fff" for="categoryImage<?php echo $category['categoryId']; ?>">Upload category image: </label>
															<input type="file" class="form-control" id="categoryImage<?php echo $category['categoryId']; ?>" name="image" />
														</div>
														<div class="col-lg-4 col-sm-12 form-group">
															<label style="background-color:#fff">Show image:&nbsp;&nbsp;&nbsp;</label>
															<label style="background-color:#fff" class="radio-inline" for="showImageYes<?php echo $category['categoryId']; ?>">Yes</label>
															<input
																type="radio"
																id="showImageYes<?php echo $category['categoryId']; ?>"
																name="showImage"
																value="1"
																<?php if ($category['showImage'] === '1') echo 'checked'; ?>
															/>
															<label style="background-color:#fff" class="radio-inline" for="showImageNo<?php echo $category['categoryId']; ?>">&nbsp;&nbsp;&nbsp;No</label>
															<input
																type="radio"
																id="showImageNo<?php echo $category['categoryId']; ?>"
																name="showImage"
																value="0"
																<?php if ($category['showImage'] === '0') echo 'checked'; ?>
															/>
														</div>
													</form>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" style="width: 100px;margin-right: 7px;" class="grid-button-cancel button theme-editor-header-button" data-dismiss="modal">Cancel</button>
											<input type="button" style="width: 100px;" class="grid-button button theme-editor-header-button" onclick="submitForm('editCategory<?php echo $category['categoryId']; ?>')" value="Submit" />
									</div>
									</div>
								</div>
							</div>
							<!-- End Edit Category Modal -->

							<!-- Category times modal -->
							<div class="modal" id="timeModal<?php echo $category['categoryId']; ?>" tabindex="-1" role="dialog">
								<div class="modal-dialog">
									<!-- Modal content-->
									<form method="post" action="<?php echo $this->baseUrl . 'warehouse/addCategoryTimes/' . $category['categoryId']; ?>">
										<input type="text" value="<?php echo $category['category']; ?>" name = "category"  hidden readonly />;
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">
													Set availability days and time for category "<?php echo $category['category']; ?>"
												</h4>
											</div>
											<div class="modal-body">
												<?php foreach($dayOfWeeks as $day) { ?>
													<div class="from-group">
														<label
															class="checkbox-inline"
															for="<?php echo $day . $category['categoryId']; ?>"
														>
															<input
																type="checkbox"
																id="<?php echo $day . $category['categoryId']; ?>"
																value="<?php echo $day; ?>"
																onchange="showDay(this,'<?php echo $day . '_'.  $category['categoryId']; ?>')"
																name="categoryTime[<?php echo $day; ?>][day][]"
																<?php
																	if (isset($category['categoryTimes'][$day])) {
																		$first = array_shift($category['categoryTimes'][$day]);
																		echo 'checked';
																	}
																?>
															/>
															<?php echo ucfirst($day); ?>
														</label>
														<br/>
														<div
															id="<?php echo $day . '_'.  $category['categoryId']; ?>"
															<?php if (!isset($first)) echo 'style="display:none"'; ?>
														>
															<label for="from<?php echo $day . $category['categoryId']; ?>">
																From:
																<input
																	type="time"
																	id="from<?php echo $day . $category['categoryId']; ?>"
																	name="categoryTime[<?php echo $day; ?>][from][]"
																	<?php
																		if (isset($first[2])) {
																			echo 'value="' . date('H:i', strtotime($first[2])) . '"';
																		}
																	?>
																/>
															</label>
															<Label for="to<?php echo $day . $category['categoryId']; ?>">To:
																<input
																	type="time"
																	id="to<?php echo $day . $category['categoryId']; ?>"
																	name="categoryTime[<?php echo $day; ?>][to][]"
																	<?php
																		if (isset($first[3])) {
																			echo 'value="' . date('H:i', strtotime($first[3])) . '"';
																		}
																		unset($first);
																	?>
																	/>
															</label>
															<button
																type="button"
																class="btn btn-default"
																onclick="addTimePeriod('<?php echo $day . $category['categoryId']; ?>Times','<?php echo $day; ?>')"
															>
																Add time
															</button>
															<div id="<?php echo $day . $category['categoryId']; ?>Times">
																<?php
																	if (isset($category['categoryTimes'][$day]) && $category['categoryTimes'][$day]) {
																		foreach($category['categoryTimes'][$day] as $dayData) {
																			?>
																				<div>
																					<label>From
																						<input type="time" name="categoryTime[<?php echo $day; ?>][from][]" value="<?php echo date('H:i', strtotime($dayData[2])); ?>" />
																					</label>
																					<label>To:
																						<input type="time" name="categoryTime[<?php echo $day; ?>][to][]" value="<?php echo date('H:i', strtotime($dayData[3])); ?>"/>
																					</label>
																					<span class="fa-stack fa-2x" onclick="removeParent(this)">
																						<i class="fa fa-times"></i>
																					</span>
																				</div>
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
							<!-- End category times moadal -->
						</div>
					<?php } ?>
				</div>
            <?php } ?>
			
		</div>
		<!-- end grid list -->
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/home/js/utility.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/productCategories.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/ajax.js"></script>
<script>
function editCategory(categoryId){
	$('#btn-'+categoryId).click();
}
</script>
