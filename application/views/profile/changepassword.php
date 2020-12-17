<div class="col-half height-100 mx-auto">
	<div class="flex-column align-start">
		<h2 class="heading mb-35 text-dark"><?php echo $this->language->line("PROF-050",'PASSWORD CHANGE');?></h2>
		<form class="w-100" action="<?php echo $this->baseUrl; ?>changePassword" method="post">
		        <div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="inputOldPassword">Old Password</label>
							<input style="border-radius: 50px" type="password" class="form-control w-100" id="inputOldPassword" placeholder="Old password" name="oldPassword" maxlength="20" required>
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
			<div class="box-footer text-right">
				<input type="submit" class="button button-orange" value="<?php echo $this->language->line("PROF-05100 ",'SUBMIT');?>" style="border: none;width:150px;" />
			</div>
		</form>
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
