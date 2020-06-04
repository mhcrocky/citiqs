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
            <?php } else { var_dump($categories); ?>

            <?php } ?>
			
		</div>
		<!-- end grid list -->
	</div>
</div>
