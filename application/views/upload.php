<div class="main-wrapper">
	<div class="col-half background-blue height align-left">
		<div class="flex-column align-start ">
			<div style="text-align:left">
				<h2 class="heading mb-35" style="color: white">
					<?php echo $this->language->line("ITEMFOUND-1000",'MAKE A PICTURE OF THE FOUND ITEM');?>
				</h2>
				<div >
					<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  text-align: left">
						<?php echo $this->language->line("PHOTO-45550",'NO TAG, NO TIQS IDENTIFICATION, LETS MAKE ONE!')?>
						<?php echo $this->language->line("PHOTO-45560",'
                                <br/><br/>When an item is uploaded or a picture is made, the image gets automatically a unique TIQS identification code. With this code the item can be claimed by the rightful owner. Lets make one.    
                                ');?>
					</p>
				</div>
				<?php
					include_once APPPATH . 'views/includes/sessionMessages.php';
				?>
				<form action="<?php base_url(); ?>home/insertLabel" method="post" enctype="multipart/form-data">
					<input type="text" name="userId" hidden readonly value="<?php echo $userId; ?>" />
					
					<input type="text" name="createdDtm" hidden readonly value="<?php echo date('Y-m-d H:i:s'); ?>" />
					<input type="text" name="lost" hidden readonly value="0" />
					<?php if (isset($employeeId)) { ?>
						<input type="text" name="employeeId" hidden readonly value="<?php echo $employeeId; ?>" />
					<?php } ?>
					<?php if (isset($token)) { ?>
						<input type="text" name="token" hidden readonly value="<?php echo $token; ?>" />
					<?php } ?>
					<div class="row">
						<div class="col-md-12">
							<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
						</div>
					</div>
					<div style="text-align:center; padding:10px">
						<label class="fileContainer mb-10">
							TAKE PICTURE
							<input type="file" name="file" accept="image/*" required>
						</label>
					</div>
					<div >
						<p style="font-family:'caption-light'; font-size:100%; color:#ffffff;  text-align: left">
							<?php echo $this->language->line("PHOTO-35550",'PLEASE DESCRIBE THE ITEM FOUND')?>
							<?php echo $this->language->line("PHOTO-35560",'
                                <br/><br/>An item is best found when we know what it is. Please state the color, what the item is and some caracteristics, more info how to describe an item kan be found in the FAQ.  
                                ');?>
						</p>
					</div>
					<div  style="text-align:center">
						<div class="form-group has-feedback">
							<input name="descript"  type="text" class="form-control" style="border: none; border-radius: 50px; font-family: caption-light;"  placeholder="Describe the item" />
						</div>
					</div>
					<p></p>
					<div style="text-align:center">
						<div class="selectWrapper mb-50">
							<select class="selectBox" name="categoryId" style="font-family:'caption-light';" required onchange="toggleItemData(this)">
							<option value="" selected="selected"><?php echo $this->language->line("PHOTO-10120","Choose a category");?></option>
							<?php foreach ($categories as $category) { ?>
								<option value="<?php $category->id; ?>"><?php $category->description; ?></option>
							<?php } ?>
						</select>
						</div>
					</div>
					<div class="labelData" style = "visibility: hidden; height: 0px">
						<p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
							Item width (in cm)
						</p>
					</div>
					<div class="form-group has-feedback">
						<input type="number" id="dclw" name="dclw" step="0.01" min="1" hidden style="font-family:'caption-light'; border-radius: 50px;" />
					</div>
					<div class="labelData" style = "visibility: hidden; height: 0px">
						<p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
							Item length (in cm)
						</p>
					</div>
					<div class="form-group has-feedback">
						<input type="number" id="dcll" name="dcll" step="0.01" min="1" hidden style="font-family:'caption-light'; border-radius: 50px;" />
					</div>
					<div class="labelData" style = "visibility: hidden; height: 0px">
						<p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
							Item height (in cm)
						</p>
					</div>
					<div class="form-group has-feedback">
						<input type="number" id="dclh" name="dclh" step="0.01" min="1" hidden style="font-family:'caption-light'; border-radius: 50px;" />
					</div>
					<div class="labelData" style = "visibility: hidden; height: 0px">
						<p style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
							Item weight (in kg)
						</p>
					</div>
					<div class="form-group has-feedback">
						<input type="number" id="dclwgt" name="dclwgt" hidden step="0.01" min='0' style="font-family:'caption-light'; border-radius: 50px;" />
					</div>
					<div  style="text-align:center">
						<input type="submit" class="button button-orange" id="submit" name="submit" value="<?php echo $this->language->line("IITEMFOUND-1300",'UPLOAD THE ITEM');?>" style="border: none; border-radius: 50px"/>
					</div>
				</form>
			</div>

		</div>
		<div style="text-align:center">
			<p id="UnkownAddressText1" style="font-family:'caption-light'; font-size:100%; color:#ffffff; text-align: center">
				<?php echo $this->language->line("PHOTO-10050",'THANKS! FOR REGISTERING THIS FOUND ITEM')?>
				<?php echo $this->language->line("PHOTO-A11060",'
                                <br/><br/>.<br/><br/> 
                                ');?>
				<br/>
				<br/>
			</p>
		</div>
	</div>
	<div class="col-half"  style="text-align:left">
		<div class="background-yellow height-75">
			<div class="width-650">
				<!--        HERE THE UPLOAD ID SCREEN-->
				<h2 style="color:#ffffff; margin-bottom: 30px"  class="heading"><?php echo $this->language->line("PHOTO-101010",'GET YOUR REWARD');?></h2>
				<div >
					<p id="UnkownAddressText2" style="font-family:'caption-light'; font-size:100%; color:#ffffff;  text-align: left">
						<?php echo $this->language->line("PHOTO-15550",'WE APPRECIATE YOUR EFFORT!')?>
						<?php echo $this->language->line("PHOTO-15560",'
                                <br/><br/>AS YOU HAVE REGISTERED THE ITEM AT TIQS LOST + FOUND, WE WOULD LIKE TO REWARD YOUR EFFORTS.
                                <br/> YOU RECIEVE FROM US A FREE PACKAGE OF TIQS-TAGS STICKERS TO USE FOR YOURSELF OR AS A GIVE AWAY TO YOUR FRIENDS OR RELATIVES.
                                BESIDES THE RECEIPT OF THIS FREE PACKAGE ON THE GIVEN PERSONAL ADDRESS, YOU ALSO GET 3 MONTHS OF FREE SMS NOTIFICATIONS!   
                                WE REALLY APPRECIATE YOUR EFFORT AND LOVE TO BRING THE LOST ITEM BACK TO THE RIGHTFUL OWNER. 
                                ');?>
						<br/><br/>
						<?php echo $this->language->line("PHOTO-25560",'
                                <br/><br/>READ IN THE FREQUENTLY ASKED QUESTIONS MORE ABOUT THE LOST + FOUND PROCEDURE
                                ');?>
					</p>
				</div>
				<div>
					<a style="color:#ffffff" class='how-we-works-link' href="<?php echo base_url(); ?>howitworksbusiness"><?php echo $this->language->line('Home-002','MORE INFO HOW IT WORKS');?></a>
				</div>
				<div style="text-align:center">
					<a href="<?php echo base_url(); ?>check" class="button button-orange mb-35"><?php echo $this->language->line("PHOTO-10280",'GET YOUR REWARD');?></a>

				</div>
				<p style="color:#ffffff" class="text-content mb-50"><?php echo $this->language->line("ITEMFOUND-1110",'lost by you, <br> returned by us');?></p>
			</div>
		</div>
		<div class="background-apricot height-50">
			<div class="width-650">
				<!--        HERE THE UTILITY BILL PROOF OF CONCEPT SCREEN-->
				<h2 class="heading mb-35"><?php echo $this->language->line("ITEMFOUND-A1111",'MORE INFO');?></h2>
			</div>
		</div>
	</div><!-- end col half -->
</div>
<script>
	var uploadGlobals = (function(){
		return {
			categories: JSON.parse('<?php echo json_encode($categories); ?>'),
			otherCategoryId : '<?php echo $otherCategoryId; ?>',
		}
	})();
	
	function toggleItemData(element) {
		let otherCategoryId = uploadGlobals.otherCategoryId;
		let categories = uploadGlobals.categories;
		let categoriesLength = categories.length;
		let i;
		let category;
		let dclw = document.getElementById('dclw');
		let dclh = document.getElementById('dclh');
		let dcll = document.getElementById('dcll');
		let dclwgt = document.getElementById('dclwgt');

		if (element.value === otherCategoryId) {
			$('.labelData').css({'visibility':'visible', 'height':'30px'});
			dclw.hidden = false;
			dclw.classList.add('form-control');
			dclh.hidden = false;
			dclh.classList.add('form-control');
			dcll.hidden = false;
			dcll.classList.add('form-control');
			dclwgt.hidden = false;
			dclwgt.classList.add('form-control');
		} else {
			$('.labelData').css({'visibility':'hidden', 'height':'0px'});
			dclw.hidden = true;
			dclw.classList.remove('form-control');
			dclh.hidden = true;
			dclh.classList.remove('form-control');
			dcll.hidden = true;
			dcll.classList.remove('form-control');
			dclwgt.hidden = true;
			dclwgt.classList.remove('form-control');
		}

		for (i = 0; i < categoriesLength; i++) {
			category = categories[i];
			if (category.id === element.value) {
				dclw.value = category.dclw;
				dclh.value = category.dclh;
				dcll.value = category.dcll;
				dclwgt.value = category.dclwgt;
			}
		}
	}
</script>
