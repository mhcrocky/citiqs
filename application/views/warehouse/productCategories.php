<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
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
				<div class="edit-single-user-container">
					<form class="form-inline" id="addCategory" method="post" action="<?php echo $this->baseUrl . 'warehouse/addCategory'; ?>">
                        <legend>Add category</legend>
						<input type="text" readonly name="userId" required value="<?php echo $userId ?>" hidden />
                        <input type="text" readonly name="active" required value="1" hidden />
						<div>
							<label for="category">Category: </label>
							<input type="text" class="form-control" id="category" name="category" required />
						</div>
					</form>
				</div>
			</div>
			<div class="grid-list-header row">
				<div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
					<h2>Filter Options</h2>
				</div><!-- end col 4 -->
				<div class="col-lg-4 col-md-4 col-sm-12 date-picker-column">
					<div>
						<!-- From:-->
						<div class='date-picker-content'>
							<input type="text" placeholder="Select from.." data-input class="flatpickr" /> <!-- input is mandatory -->
						</div>
					</div>
					<div>
						<!-- To:-->
						<div class='date-picker-content'>
							<input type="text" placeholder="Select to.." data-input class="flatpickr-to" /> <!-- input is mandatory -->
						</div>
					</div>
				</div><!-- end date picker -->

				<div class="col-lg-4 col-md-4 col-sm-12 search-container">
					<form class="form-inline">
						<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0 button grid-button" type="submit">Search</button>
					</form>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-12 search-container">
					<button class="btn button-security my-2 my-sm-0 button grid-button" onclick="toogleElementClass('add-category', 'display')">Add category</button>
				</div>
			</div><!-- end grid header -->
			<!-- SINGLE GIRD ITEM -->
            <?php if (is_null($categories)) { ?> 
				<p>No categories added.</p>
            <?php } else { ?>
				<?php foreach ($categories as $category) { ?>
					<div class="grid-item">
						<div class="item-header">
							<p class="item-description"><?php echo $category['category']; ?></p>
							<p class="item-category">Status:
								<?php echo $category['active'] === '1' ? '<span style="color:#009933">Active</span>' : '<span style="color:#ff3333">Archived</span>'; ?>
							</p>
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
							<div class="edit-single-user-container">
								<form class="form-inline" id="editCategory<?php echo $category['categoryId']; ?>" method="post" action="<?php echo $this->baseUrl . 'warehouse/editCategory/' . $category['categoryId']; ?>" >
									<h3>Category details</h3>
									<div>
										<label for="category<?php echo$category['categoryId']; ?>">Name</label>
										<input type="text" class="form-control" id="category<?php echo $category['categoryId']; ?>" name="category" required value="<?php echo $category['category']; ?>" />
									</div>
									<div>
										<label for="active<?php echo $category['categoryId']; ?>">
											<input type="radio" id="active<?php echo $category['categoryId']; ?>" name="active" required value="1" <?php if ($category['active'] === '1') echo 'checked'; ?> />
											Active
										</label>
										<label for="inActive<?php echo $category['categoryId']; ?>">
											<input type="radio" id="inActive<?php echo $category['categoryId']; ?>" name="active" required value="0" <?php if ($category['active'] === '0') echo 'checked'; ?> />
											Arhive
										</label>
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
