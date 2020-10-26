<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="main-wrapper theme-editor-wrapper">
	<div class="grid-wrapper">
		<div class="grid-list">
			<div class="item-editor theme-editor" id='add-type'>
				<div class="theme-editor-header d-flex justify-content-between" >
					<div>
						<img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
					</div>
					<div class="theme-editor-header-buttons">
						<input type="button" class="grid-button button theme-editor-header-button" onclick="submitForm('addType')" value="Submit" />
						<button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('add-type', 'display')">Cancel</button>
					</div>
				</div>
				<div class="edit-single-user-container">
					<form class="form-inline" id="addType" method="post" action="<?php echo $this->baseUrl . 'warehouse/addProductType'; ?>">
                        <legend>Add type</legend>
						<input type="text" readonly name="vendorId" required value="<?php echo $vendorId ?>" hidden />
						<div>
							<label for="type">Type: </label>
							<input type="text" class="form-control" id="type" name="type" required />
						</div>
                        <div class="checkbox">
							<label for="isMain">Is main: 
							    <input type="checkbox" id="isMain" name="isMain" required value="1" />
                            </label>
						</div>

						<div>
							<label for="additionalNumber">Maximum allowed choices:</label>
							<input type="number" min="0" step="1" class="form-control" id="additionalNumber; ?>" name="additionalNumber" required value="0" />
						</div>
					</form>
				</div>
			</div>
			<div class="grid-list-header row">
				<div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
					<h2>Product types</h2>
                    <?php if (!$main) { ?>
                    <p>No type with main flag. Please add or update one </š>
                    <?php } ?>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
				</div>

				<div class="col-lg-4 col-md-4 col-sm-12 search-container">
					<button
                        class="btn button-security my-2 my-sm-0 button grid-button"
                        onclick="toogleElementClass('add-type', 'display')">Add type</button>
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
							<p class="item-description">Maximum allowed choices: <?php echo $type['additionalNumber'] === '0' ? 'Unlimited' : $type['additionalNumber']; ?></p>
							
						</div><!-- end item header -->
                        <div class="grid-footer">
							<div class="iconWrapper">
								<span class="fa-stack fa-2x edit-icon btn-edit-item" onclick="toogleAllElementClasses('editProductTypeId<?php echo $type['id']; ?>', 'display')">
									<i class="far fa-edit"></i>
								</span>
							</div>
						</div>
						<!-- ITEM EDITOR -->
						<div class="item-editor theme-editor" id="editProductTypeId<?php echo  $type['id']; ?>">
							<div class="theme-editor-header d-flex justify-content-between">
								<div class="theme-editor-header-buttons">
									<input type="button" onclick="submitForm('editPrinter<?php echo $type['id']; ?>')" class="grid-button button theme-editor-header-button" value="Submit" />
									<button
                                        class="grid-button-cancel button theme-editor-header-button"
                                        onclick="toogleElementClass('editProductTypeId<?php echo  $type['id']; ?>', 'display')">Cancel</button>
								</div>
							</div>
							<div class="edit-single-user-container">
								<form
                                    class="form-inline"
                                    id="editPrinter<?php echo $type['id']; ?>"
                                    method="post"
                                    action="<?php echo $this->baseUrl . 'warehouse/editType/' . $type['id']; ?>"
                                    >
									<input type="text" name="vendorId" value="<?php echo $vendorId; ?>" readonly required hidden />
									<h3>Type details</h3>
									<div>
										<label for="type<?php echo $type['id']; ?>">Name:</label>
										<input type="text" class="form-control" id="type<?php echo $type['id']; ?>" name="type" required value="<?php echo $type['productType']; ?>" />
									</div>
                                    <div class="checkbox">
										<label for="isMain<?php echo $type['id']; ?>">Is main </label>
										<input type="checkbox" class="form-control" id="isMain<?php echo $type['id']; ?>" name="isMain" required value="1" <?php if ($type['isMain'] === '1') echo 'checked'; ?> />
									</div>
									<div>
										<label for="type<?php echo $type['id']; ?>">Maximum allowed choices:</label>
										<input type="number" min="0" step="1" class="form-control" id="additionalNumber<?php echo $type['id']; ?>" name="additionalNumber" required value="<?php echo $type['additionalNumber']; ?>" />
									</div>
								</form>
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
