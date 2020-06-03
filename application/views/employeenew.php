<div class="main-wrapper theme-editor-wrapper">
	<div class="grid-wrapper">
		<div class="grid-list">
			<!-- ITEM EDITOR FOR NEW USER -->
			<div class="item-editor theme-editor" id='add-new-user'>

				<div class="theme-editor-header d-flex justify-content-between" >
					<div>
						<img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
					</div>
					<div class="theme-editor-header-buttons">
						<input type="button" class="grid-button button theme-editor-header-button" onclick="submitForm('addEmployee')" value="Submit" />
						<button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('add-new-user', 'display')">Cancel</button>
					</div>
				</div>

				<div class="edit-single-user-container">
					<form class="form-inline" id="addEmployee" method="post" action="<?php echo $this->baseUrl . 'index.php/addNewEmployeeSetup'; ?>">
						<input type="text" readonly name="ownerId" required value="<?php echo $ownerId ?>" hidden />
						<h3>Employee Details</h3>
						<div>
							<label for="username">Name</label>
							<input type="text" class="form-control" id="username" name="username" required />
						</div>
						<div>
							<label for="email">Email</label>
							<input type="text" class="form-control" id="email" name="email" required />
						</div>
						<div>
							<label for="expiration_time_value">Expiration time value</label>
							<input type="number" step="1" min="1" class="form-control" id="expiration_time_value" name="expiration_time_value" required />
						</div>
						<div>
							<label for="expiration_time_type">Expiration time type</label>
							<select class="form-control" id="expiration_time_type" name="expiration_time_type" required>
								<option value="">Select</option>
								<option value="minutes">Minutes</option>
								<option value="hours">Hours</option>
								<option value="days">Days</option>
								<option value="months">Months</option>
							</select>
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
					<!--                    Search by name:-->
					<form class="form-inline">
						<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0 button grid-button" type="submit">Search</button>
					</form>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-12 search-container">
					<button class="btn button-security my-2 my-sm-0 button grid-button" onclick="toogleElementClass('add-new-user', 'display')">Add new</button>
				</div>
			</div><!-- end grid header -->
			<!-- SINGLE GIRD ITEM -->
			<?php
			if(!empty($employees))
			{
			foreach ($employees as $employee)
			{
			?>
			<div class="grid-item" <?php if (intval($employee->expiration_time) < $time){ ?>style="background-color:rgba(226, 95, 42)" <?php } ?>>
				<div class="item-header">
					<p class="item-description"><?= $employee->username; ?></p>
					<p class="item-category"><?= $employee->email; ?></p>
					<p class="item-category"><?= $employee->uniquenumber; ?></p>
					<p class="item-category"><?php echo date('Y-m-d H:i:s', $employee->expiration_time); ?></p>
					<!-- <p class="item-category"><? #echo date('Y-m-d H:i:s', $employee->validitytime); ?></p>
							<p class="item-category"><? #echo date('Y-m-d H:i:s', $employee->expiration_time); ?></p>
							<p class="item-category"><? #echo $employee->expiration_time_value; ?></p>
							<p class="item-category"><? #echo $employee->expiration_time_type; ?></p> -->
				</div><!-- end item header -->
				<div class="grid-footer">
					<div class="iconWrapper">
						<span class="fa-stack fa-2x edit-icon btn-edit-item" onclick="toogleElementClass('editEmployeeId<?php echo $employee->id; ?>', 'display')">
							<i class="far fa-edit"></i>
						</span>
					</div>
					<div 
						title="Click to delete employee" class="iconWrapper delete-icon-wrapper"
						onclick="deleteObject(
							this,
							'<?php echo $this->baseUrl . 'index.php/employee/deleteEmployee/' . $employee->id; ?>'
						)">
								<span class="fa-stack fa-2x delete-icon">
									<i class="fas fa-times"></i>
								</span>
					</div>
					<div class="iconWrapper"  onclick="emailEmployee(
						<?php echo $employee->id ?>,
						'<?php echo $this->baseUrl . 'index.php/employee/emailEmployee'; ?>'
					)">
                        <span class="fa-stack fa-2x print-icon">
                            <i class="fas fa-envelope"></i>
                        </span>
					</div>
				</div>

				<!-- ITEM EDITOR -->
				<div class="item-editor theme-editor" id="editEmployeeId<?php echo $employee->id; ?>">
					<div class="theme-editor-header d-flex justify-content-between">
						<div>
							<img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
						</div>
						<div class="theme-editor-header-buttons">
							<input type="button" onclick="submitForm('editEmployee<?php echo $employee->id; ?>')" class="grid-button button theme-editor-header-button" value="Submit" />
							<button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('editEmployeeId<?php echo $employee->id; ?>', 'display')">Cancel</button>
						</div>
					</div>
					<div class="edit-single-user-container">
						<form class="form-inline" id="editEmployee<?php echo $employee->id; ?>" method="post" action="<?php echo $this->baseUrl . 'index.php/employeeEdit/' . $employee->id; ?>" >
							<h3>Employee Details</h3>
							<div>
								<label for="username<?php echo $employee->id; ?>">Name</label>
								<input type="text" class="form-control" id="username<?php echo $employee->id; ?>" name="username" required value="<?php echo $employee->username; ?>" />
							</div>
							<div>
								<label for="email<?php echo $employee->id; ?>">Email</label>
								<input type="text" class="form-control" id="email<?php echo $employee->id; ?>" name="email" required value="<?php echo $employee->email; ?>"  />
							</div>
							<div>
								<label for="validitytime<?php echo $employee->id; ?>">Validity time</label>
								<input type="text" data-input class="form-control flatpickr-to" id="validitytime<?php echo $employee->id; ?>" value="<?php echo date("Y-m-d H:i:s", intval($employee->validitytime)); ?>" name="validitytime" readonly disabled />
							</div>
							<div>
								<label for="expiration_time<?php echo $employee->id; ?>">Expiration time</label>
								<input type="text" data-input class="form-control flatpickr-to" id="expiration_time<?php echo $employee->id; ?>" value="<?php echo date("Y-m-d H:i:s", intval($employee->expiration_time)); ?>" name="expiration_time"  readonly disabled />
							</div>
							<div>
								<label for="expiration_time_value<?php echo $employee->id; ?>">Expiration time value</label>
								<input type="number" step="1" min="1" class="form-control" id="expiration_time_value<?php echo $employee->id; ?>" name="expiration_time_value" value="<?php echo $employee->expiration_time_value; ?>" required />
							</div>
							<div>
								<label for="expiration_time_type<?php echo $employee->id; ?>">Expiration time type</label>
								<select class="form-control" id="expiration_time_type<?php echo $employee->id; ?>" name="expiration_time_type" required>
									<option value="">Select</option>
									<option <?php if ($employee->expiration_time_type === 'minutes') echo 'selected'; ?> value="minutes">Minutes</option>
									<option <?php if ($employee->expiration_time_type === 'hours') echo 'selected'; ?> value="hours">Hours</option>
									<option <?php if ($employee->expiration_time_type === 'days') echo 'selected'; ?> value="days">Days</option>
									<option <?php if ($employee->expiration_time_type === 'months') echo 'selected'; ?> value="months">Months</option>
								</select>
							</div>
						</form>
					</div>
				</div>
				<!-- END EDIT FOR NEW USER -->
			</div>
			<!-- END SINGLE GRID ITEM -->
			<?php
			}
			}
			?>
		</div>
		<!-- end grid list -->
	</div>
</div>
