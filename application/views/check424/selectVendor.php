<div class="main-wrapper-nh" style="text-align:center">
	<div class="col-half background-apricot-blue height">
		<div class="width-650"></div>
            <div class="form-group has-feedback">
                <img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="350" height="" />
            </div>
    		<h1 style="text-align:center">Select vendor</h1>
		    <div class="selectWrapper mb-35">
                    <select class="selectBox selecVendor" id="vendorId" onchange="redirectToSelectedVendor(this.value)" class="form-control" style="color :black">
                        <option value="">Select vendor</option>
                        <?php foreach ($vendors as $vendor) { ?>
                            <option value="<?php echo 'check424/' . $vendor['vendorId']; ?>">
                                <?php echo $vendor['vendorName']; ?>
                            </option>
                        <?php } ?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-half background-blue height-100">
		<div class="flex-column align-start">
			</div>
				<div style="text-align:center;">
						<img src="<?php echo base_url(); ?>assets/home/images/alfredmenu.png" alt="tiqs" width="auto" height="110" />
				</div>
				<h1 style="text-align:center">MENU</h1>
				<div style="text-align:center; margin-top: 30px">
					<p style="font-size: larger; margin-top: 50px; margin-left: 0px"><?php echo $this->language->line("HOMESTART-SPOT-X001111ABC",'BUILD BY TIQS');?></p>
				</div>
			</div>
		</div>
	</div>
</div>
