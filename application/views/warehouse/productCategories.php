<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
	.listCategories:hover {
		cursor: -webkit-grab;
		cursor: grab;
	}
</style>
<div class="main-wrapper theme-editor-wrapper">
	<div class="grid-wrapper">
		<div class="grid-list">
			<div class="item-editor theme-editor" id='add-category'>
				<div class="theme-editor-header d-flex justify-content-between" >
					<div>
						<img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
					</div>
					<div class="theme-editor-header-buttons">
						<input type="button" class="grid-button button theme-editor-header-button" onclick="submitForm('addCategory')" value="Submit" />
						<button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('add-category', 'display')">Cancel</button>
					</div>
				</div>
				<div style="width:100%;">
					<form class="form-inline" id="addCategory" method="post" action="<?php echo $this->baseUrl . 'warehouse/addCategory'; ?>">
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
							<label style="background-color:#fff" for="sendSms">Send SMS to driver:&nbsp;&nbsp;&nbsp;</label>
							<label style="background-color:#fff" class="radio-inline" for="sendSmsYes">Yes</label>
							<input type="radio" id="sendSmsYes" name="sendSms" value="1" >
							<label style="background-color:#fff" class="radio-inline" for="sendSmsNo">&nbsp;&nbsp;&nbsp;No</label>
							<input type="radio" id="sendSmsNo" name="sendSms" value="0" checked />
						</div>
						<div class="col-lg-4 col-sm-12 form-group">
							<label style="background-color:#fff" for="driverSmsMessage">SMS message for driver: </label>
							<input type="text" class="form-control" id="driverSmsMessage" name="driverSmsMessage" />
						</div>
					</form>
				</div>
			</div>
			<div class="grid-list-header row">
				<div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
					<h2>Categories</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="form-group">
						<label for="filterCategories">Filter categories:</label>
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
					<button class="btn button-security my-2 my-sm-0 button grid-button" onclick="toogleElementClass('add-category', 'display')">Add category</button>
				</div>
			</div><!-- end grid header -->
			<!-- SINGLE GIRD ITEM -->
            <?php if (is_null($categories)) { ?> 
				<p>No categories.</p>
            <?php } else { ?>
				<div class="row" id="sortableCategories" class="list-categories" style="width:100%">
				<?php foreach ($categories as $category) { ?>
					<div class="grid-item list-categories listCategories" data-category-id="<?php echo $category['categoryId']; ?>" style="background-color:<?php echo $category['active'] === '1' ? '#72b19f' : '#f2622f'; ?>">
						<div class="item-header" style="width:100%">
							<p class="item-description"><?php echo $category['category']; ?></p>
							<p class="item-category" style="white-space: initial;">Status: <?php echo $category['active'] === '1' ? '<span>ACTIVE</span>' : '<span>BLOCKED</span>'; ?> </p>
							<p class="item-category" style="white-space: initial;">Send SMS to driver: <?php echo $category['sendSms'] === '1' ? '<span>YES</span>' : '<span>NO</span>'; ?></p>
							<p class="item-category" style="white-space: initial;">Driver number: <?php echo $category['driverNumber']; ?></p>
							<p class="item-category" style="white-space: initial;">Minutes to delay: <?php echo $category['delayTime']; ?></p>
							<p class="item-category" style="white-space: initial;">Message to driver: <?php echo $category['driverSmsMessage']; ?></p>
						</div><!-- end item header -->
						<div class="grid-footer">
							<div class="iconWrapper">
								<span class="fa-stack fa-2x edit-icon btn-edit-item" onclick="toogleAllElementClasses('editCategoryCategoryId<?php echo $category['categoryId']; ?>', 'display')">
									<i class="far fa-edit"></i>
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
						<!-- ITEM EDITOR -->
						<div class="item-editor theme-editor" id="editCategoryCategoryId<?php echo  $category['categoryId']; ?>">
							<div class="theme-editor-header d-flex justify-content-between">
								<div class="theme-editor-header-buttons">
									<input type="button" onclick="submitForm('editCategory<?php echo $category['categoryId']; ?>')" class="grid-button button theme-editor-header-button" value="Submit" />
									<button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('editCategoryCategoryId<?php echo  $category['categoryId']; ?>', 'display')">Cancel</button>
								</div>
							</div>
							<div style="width:100%">
								<form class="form-inline" id="editCategory<?php echo $category['categoryId']; ?>" method="post" action="<?php echo $this->baseUrl . 'warehouse/editCategory/' . $category['categoryId']; ?>">
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
									<legend style="text-align:left">Category "<?php echo $category['category']; ?>" details</legend>
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
								</form>
							</div>
						</div>
						<!-- END EDIT FOR NEW USER -->
					</div>
				<?php } ?>
				</div>
            <?php } ?>
			
		</div>
		<!-- end grid list -->
	</div>
</div>
