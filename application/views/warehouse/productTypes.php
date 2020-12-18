<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- Add Type Modal -->
<div class="modal fade" id="addTypeModal" tabindex="-1" role="dialog" aria-labelledby="addTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
	    <legend>Add type</legend>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <div class="item-editor" id='add-type'>
				<div class="edit-single-user-container">
					<form class="form-inline" id="addType" method="post" action="<?php echo $this->baseUrl . 'warehouse/addProductType'; ?>">
						<input type="text" readonly name="vendorId" required value="<?php echo $vendorId ?>" hidden />
						<div>
							<label for="type">Type: </label>
							<input type="text" class="form-control" id="type" name="type" required />
						</div>
                        <div class="checkbox mb-3">
							<label for="isMain">Is main: 
							    <input type="checkbox" id="isMain" name="isMain" required value="1" />
                            </label>
						</div>
						<div>
							<label for="additionalNumber">:</label>
<!--							Maximum allowed choices-->
							<input type="number" min="0" step="1" class="form-control" id="additionalNumber; ?>" name="additionalNumber" required value="0" />
						</div>
						<div>
							<label></label>
							<label for="isBoolYes">
								&nbsp;Value&nbsp;<input type="radio" id="isBoolYes" name="isBoolean" value="1" />
							</label>
							<label for="isBoolNo">
								&nbsp;Choice&nbsp;<input type="radio" id="isBoolNo" name="isBoolean" value="0" checked />
							</label>
						</div>
					</form>
				</div>
			</div>
      </div>
      <div class="modal-footer">
	  <button style="width: 100px;margin-right: 7px;" type="submit" class="grid-button button theme-editor-header-button" onclick="submitForm('addType')">Submit</button>
        <button style="width: 100px;" type="button" class="grid-button-cancel button theme-editor-header-button" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- End Add Type Modal -->

<div style="margin-top: 0 !important;" class="main-wrapper theme-editor-wrapper">
	<div style="background: #f3d0b1 !important;" class="grid-wrapper">
		<div class="grid-list">
			
			<div class="grid-list-header row">
				<div class="col-lg-5 col-md-5 col-sm-12 grid-header-heading">
					<h2><b>Product types</b></h2>
                    <?php if (!$main) { ?>
                    <p>No type with main flag. Please add or update one </p>
                    <?php } ?>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
				</div>

				<div class="col-lg-4 col-md-4 col-sm-12 search-container">
					<button
                        class="btn button-security my-2 my-sm-0 button grid-button"
                        data-toggle="modal" data-target="#addTypeModal">Add type </button>
				</div>
			</div><!-- end grid header -->
			<!-- SINGLE GIRD ITEM -->
            <?php if (is_null($productTypes)) { ?> 
				<p>No product types.</p>
            <?php } else { ?>
                <?php foreach ($productTypes as $type) { ?>
					<div class="grid-item">
						<div class="item-header">
							<p class="item-description">Type: <?php echo $type['productType']; ?></p>
                            <p class="item-description">Is main: <?php echo $type['isMain'] === '1' ? '<span>YES</span>' : '<span>NO</span>'; ?></p>
							<p class="item-description"> <?php echo $type['additionalNumber'] === '0' ? 'Unlimited' : $type['additionalNumber']; ?></p>
							<p class="item-description"> <?php echo ($type['isBoolean'] === '0') ? 'Choice' : 'Value'; ?></p>
<!--							Only yes or no values:-->
						</div><!-- end item header -->
                        <div class="grid-footer">
							<div class="iconWrapper">
								<span class="fa-stack fa-2x edit-icon btn-edit-item" onclick="editType('<?php echo $type['id']; ?>', 'display')">
									<i class="far fa-edit"></i>
								</span>
							</div>
						</div>
						<button id="btn-<?php echo  $type['id']; ?>" style="display:none;" type="button" class="btn button-security my-2 my-sm-0 button grid-button" data-toggle="modal" data-target="#editTypeModal<?php echo  $type['id']; ?>">Edit type</button>
						<!-- Edit Type Modal -->
						<div class="modal fade" id="editTypeModal<?php echo  $type['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editTypeModal<?php echo  $type['id']; ?>Label" aria-hidden="true">
						    <div class="modal-dialog modal-md" role="document">
							    <div class="modal-content">
								    <div class="modal-header">
									    <h5 class="modal-title">Type details</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										    <span aria-hidden="true">&times;</span>
										</button>
									</div>

									<div class="modal-body">
									    <div class="item-editor" id="editProductTypeId<?php echo  $type['id']; ?>">
											<div class="edit-single-user-container">
											<form
                                                class="form-inline"
                                                id="editPrinter<?php echo $type['id']; ?>"
                                                method="post"
                                                action="<?php echo $this->baseUrl . 'warehouse/editType/' . $type['id']; ?>"
                                                >
												<input type="text" name="vendorId" value="<?php echo $vendorId; ?>" readonly required hidden />
												
												<div>
										            <label for="type<?php echo $type['id']; ?>">Name:</label>
										            <input type="text" class="form-control" id="type<?php echo $type['id']; ?>" name="type" required value="<?php echo $type['productType']; ?>" />
									            </div>
                                                <div class="checkbox mb-3">
										            <label for="isMain<?php echo $type['id']; ?>">Is main: &nbsp
										                <input type="checkbox" id="isMain<?php echo $type['id']; ?>" name="isMain" required value="1" <?php if ($type['isMain'] === '1') echo 'checked'; ?> />
													</label>
												</div>
									            <div>
										            <label for="type<?php echo $type['id']; ?>">Maximum allowed choices:</label>
										            <input type="number" min="0" step="1" class="form-control" id="additionalNumber<?php echo $type['id']; ?>" name="additionalNumber" required value="<?php echo $type['additionalNumber']; ?>" />
									            </div>
									            <div>
										            <label></label>
<!--													Only yes or no values-->
										            <label for="isBoolYes<?php echo $type['id']; ?>">
											         Value
											        <input
												        type="radio"
												        id="isBoolYes<?php echo $type['id']; ?>"
												        name="isBoolean"
												        value="1"
												        <?php if ($type['isBoolean'] === '1') echo 'checked'; ?>
														/>
										            </label>
										            <label for="isBoolNo<?php echo $type['id']; ?>">
											        Choice
											        <input
												        type="radio"
												        id="isBoolNo<?php echo $type['id']; ?>"
												        name="isBoolean"
												        value="0"
												        <?php if ($type['isBoolean'] === '0') echo 'checked'; ?>
											            />
													</label>
												</div>
											</form>
										</div>
									</div>
									<!-- End Edit Type Modal -->
									</div>
									
									<div class="modal-footer">
									    <button style="width: 100px;margin-right: 7px;"  type="button" class="grid-button button theme-editor-header-button" onclick="submitForm('editPrinter<?php echo $type['id']; ?>')">Submit</button>
										<button style="width: 100px;" type="button" class="grid-button-cancel button theme-editor-header-button" data-dismiss="modal">Cancel</button>
									</div>
								</div>
							</div>
						</div>

					</div>
                <?php } ?>
            <?php } ?>
			
		</div>
		<!-- end grid list -->
	</div>
</div>
<script>
function editType(typeId){
	$('#btn-'+typeId).click();
}
</script>
