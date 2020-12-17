<div class="main-wrapper" style="text-align:center">
	<?php if($this->session->userdata('dropoffpoint')==1) { ?>
		<div class="col-half timeline-content mx-auto">
		    <div class="timeline-content">
			    <form method="post" action="<?php echo base_url() ?>profile/updateVendorData/<?php echo $vendor['id']; ?>">
					<input type="number" name="vendorId" value="<?php echo $user->id ?>" readonly required hidden />
					<div class="form-group mb-35">
						<label for="termsAndConditions">TERMS AND CONDITIONS</label>
						<textarea class="form-control" id="termsAndConditions" name="vendor[termsAndConditions]"><?php echo strval($vendor['termsAndConditions']); ?></textarea>
					</div>
					<input class="btn btn-primary" type="submit" value="Submit" />
				</form>
			</div>
		</div>
	<?php } ?>
</div>


<script>
	function getUserAjax() {
		return "<?php echo base_url('index.php/ajax/users/'); ?>";
	}
	var baseURL = "<?php echo $this->baseUrl; ?>";
</script>
