<div class="main-wrapper-nh" style="text-align:center">
	<div class="col-half background-apricot-blue height">
		<div class="width-650"></div>
				<div class="form-group has-feedback">
					<img border="0" src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="350" height="" />
				</div><!-- /.login-logo -->
		<h1 align="center"><?php echo $vendor['vendorName'] ?></h1>
		<div class="selectWrapper mb-35">
			<?php if (!empty($spots)) { ?>
				<label for="spot">Service Point Or Table:</label>
				<select class="selectBox" id="spot" onchange="redirectToMakeOrder(this)" class="form-control" style="color :black">
					<option value="">Select spot</option>
					<?php foreach ($spots as $spot) { ?>
					<option value="<?php echo base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spot['spotId'] ?>">
						<?php echo $spot['spotName']; ?>
					</option>
					<?php } ?>
				</select>
			<?php } else { ?>
				<p>No available spots</p>
			<?php } ?>
			</div>
		</div>
</div>
	<div class="col-half background-blue height-100">
		<div class="flex-column align-start">
			</div>
				<div style="text-align:center;">
						<img border="0" src="<?php echo base_url(); ?>assets/home/images/alfredmenu.png" alt="tiqs" width="auto" height="110" />
				</div>
				<h1 align="center">MENU</h1>
				<div style="text-align:center; margin-top: 30px">
					<p style="font-size: larger; margin-top: 50px; margin-left: 0px"><?=$this->language->line("HOMESTART-SPOT-X001111ABC",'BUILD BY TIQS');?></p>
				</div>
			</div>
		</div>
	</div><!-- end col half -->
</div>
<script>
    function redirectToMakeOrder(element) {
        let link = element.value;
        if (link) {
            window.location.replace(link);
        }
    }

</script>
