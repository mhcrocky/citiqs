<div class="main-wrapper theme-editor-wrapper">
	<div class="grid-wrapper">
        <div class="grid-list">
            <div class="grid-list-header row">
				<form action="<?php $this->baseUrl . 'lostandfoundlist'; ?>" method="post" class="form-inline">
					<input type="text" name="userId" value="<?php echo $userId ?>" readonly hidden required />
					<div class="col-lg-3 col-md-3 col-sm-12 grid-header-heading">
						<h2>Filter Options</h2>
					</div><!-- end col 4 -->
					<div class="col-lg-3 col-md-3 col-sm-12 date-picker-column">
						<select class="form-control" name="isDeleted">
							<option value="">Select</option>
							<option <?php if (isset($isDeleted) && $isDeleted === '') echo 'selected'; ?> value="">All</option>
							<option <?php if (isset($isDeleted) && $isDeleted === '0') echo 'selected'; ?> value="0">Vissible</option>
							<option <?php if (isset($isDeleted) && $isDeleted === '1') echo 'selected'; ?> value="1">Hidden</option>
						</select>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12 date-picker-column">
						<div>
							<!--                        From:-->
							<div class='date-picker-content'>
								<input type="text" placeholder="Select from.." data-input class="flatpickr" /> <!-- input is mandatory -->
							</div>
						</div>
						<div>
							<!--                        To:-->
							<div class='date-picker-content'>
								<input type="text" placeholder="Select to.." data-input class="flatpickr-to" /> <!-- input is mandatory -->
							</div>
						</div>
					</div><!-- end date picker -->
					<div class="col-lg-3 col-md-3 col-sm-12 search-container">						
						<div class='date-picker-content'>
							<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
							<button class="btn btn-outline-success my-2 my-sm-0 button grid-button" type="submit">Search</button>                    
						</div>
					</div>
				</form>
            </div><!-- end grid header -->
            <?php
			//TIQS TO DO DO BETTER
            if(!empty($userRecords))
			{
				$codes = [];
				foreach ($userRecords as $record)
				{
					if (in_array($record->code, $codes)) continue;
					array_push($codes, $record->code);
				?>
				<div id="grid_<?php echo $record->id; ?>" class="grid-item" 
				
					<?php if (intval($record->dhlId)){ ?>
					style="background-color:rgb(255, 204, 0)"
					<?php } elseif (intval($record->userclaimId)) { ?>
					style="background-color:rgba(226, 95, 42)"
					<?php } elseif (floatval($record->lat) && floatval($record->lng)) { ?>
					style="background-color:#446087"
					<?php } ?>
					>
					<div class="item-header">
						<p class="item-date">
							<?php echo $record->createdDtm ?>
						</p>
						<p class="item-code">
							<?php echo $record->code ?>
						</p>
						<div class='grid-image'>
							<?php $sensitiveImage = File_helper::getSensitiveImage(intval($record->categoryid)); ?>
							<?php if (!$sensitiveImage && !($record->dhlId || $record->userclaimId)) { ?>
							<form
								class="file_form"
								enctype='multipart/form-data'>
								<input type="hidden" value="<?php echo $record->id; ?>" name="id" readonly required />								
							<?php } ?>
								<?php if ($sensitiveImage) { ?>
									<img src="<?php echo $sensitiveImage; ?>" alt="" />
								<?php } elseif (!empty($record->image)) { ?>
									<?php if (file_exists(FCPATH . 'uploads/LabelImagesBig/' . $record->userId . '-' . $record->code . '-' . $record->image)) { ?>
										<a class="image-link" href="<?php echo base_url() . 'uploads/LabelImagesBig/' . $record->userId . '-' . $record->code . '-' . $record->image; ?>" >
									<?php } ?>
									<img
										id="image_<?php echo $record->code; ?>" src="<?php echo $this->baseUrl . 'uploads/LabelImages/' . $record->userId . '-' . $record->code . '-' . $record->image; ?>" alt=""
									/>
									<?php if (file_exists(FCPATH . 'uploads/LabelImagesBig/' . $record->userId . '-' . $record->code . '-' . $record->image )) { ?>
										</a>
									<?php } ?>
								<?php } else { ?>
									<img src="<?php echo $this->baseUrl; ?>uploads/default.jpg" alt="">
								<?php } ?>
							<?php if (!$sensitiveImage && !($record->dhlId || $record->userclaimId)) { ?>
								<label 
									for="<?php echo $record->userId . '-' . $record->code; ?>"
									onclick="triger('<?php echo $record->userId . '-' . $record->code; ?>')"
									class="custom-file-upload btn btn-primary">
									Click Here to upload an image
								</label>
								<input
									type="file"
									name="<?php echo $record->userId . '-' . $record->code; ?>"
									data-image-id = "image_<?php echo $record->code; ?>"
									id="<?php echo $record->userId . '-' . $record->code; ?>"
									accept="image/jpg, image/jpeg, image/png" 
									class='upload-image'
								/>
							</form>
							<?php } ?>
						</div>
						<p class='item-description'>
							<span>Description: </span>
							<?php echo $this->language->line($record->descript, $record->descript); ?>
						</p>
						<p class='item-category'>
							<span>Category: </span>
							<?php echo $record->categoryname; ?>
						</p>
						<p class='item-o'>
							<span>Owner: </span>
							<?php echo $record->owner; ?>
						</p>
						<?php if ($record->employee) { ?>
						<p class='item-o'>
							<span>Employee: </span>
							<?php echo $record->employee; ?>
						</p>
						<?php } ?>
					</div>
					<div class="grid-footer">
						<div class='iconWrapper'>
							<?php if (intval($record->dhlId)) { ?>
								<?php if (intval($record->dhlErrorNumber) > 0 || $record->systemErrorMessage ) { ?>
									<span>We noticed a problem with this shippment. Please check your emali.<br/> Contact us for more information.</span>
								<?php } elseif (intval($record->paystatus) === $this->config->item('paystatusPayed') ) { ?>
									<?php if ($record->dhlordernr) { ?>
									<a href="https://www.dhl.com/nl-en/home/tracking/tracking-ecommerce.html?submit=1&tracking-id=<?php echo $record->dhlordernr; ?>"  target="_blank" >
									<?php } ?>
										<img src =" https://tiqs.com/lostandfound/assets/home/images/DHL_express.png" style="width:180px;height:30px;" 
										title = " <?php echo ($record->dhlordernr)  ? 'Click to track' :  'Waiting for DHL order number'; ?>" />
									<?php if ($record->dhlordernr) { ?> 
									</a>
									<?php } ?>
								<?php } elseif (intval($record->paystatus) === $this->config->item('paystatusError') || is_null($record->paystatus)) { ?>
									<input 
										type="button" data-fancybox data-touch="false"  data-type="ajax" 
										data-src="<?php echo  base_url() . 'getDHLPrice/' . $record->id . '/' . $record->dhlId; ?>" 
										onclick="parent.jQuery.fancybox.getInstance().close();" href="javascript:;" 
										class="button button-orange" style="border:none" value="PAY" />
								<?php }  elseif (intval($record->paystatus) === $this->config->item('paystatusPending')) { ?>
									<span>Paying is on pending</span>
								<?php } ?>						

							<?php } else { ?>
							<?php if (!$record->userclaimId) { ?>
							<span onclick="toogleElementClass('labelEditor<?php echo $record->id; ?>','display')" class="fa-stack fa-2x edit-icon btn-edit-item">
								<i class="far fa-edit"></i>
							</span>
							<?php }?>
							<?php } ?>
						</div>
						<?php if ($record->isDeleted === '0') { ?>
						<div
							class='iconWrapper delete-icon-wrapper'
							onclick="updateIsDeleted(
								this, 
								'1',
								'<?php echo $this->baseUrl .'user/updateLabelIsdeleted/'. $record->id; ?>'
							)"
						>
							<span class="fa-stack fa-2x delete-icon">
								<i class="fas fa-times"></i>
							</span>
						</div>
						<?php } ?>
						<?php if($dropoffpoint === '1') { ?>
						<div class='iconWrapper'>
							<span class="fa-stack fa-2x print-icon">
								<a href="<?php echo $this->baseUrl . 'PdfDesigner/print/' . $record->id; ?>" target="_blank">
									<i class="fas fa-print"></i>
								</a>
							</span>
						</div>
						<?php } else { ?>
							<?php if (!($record->dhlId || $record->userclaimId)) { ?>
							<div class='iconWrapper'>
								<span
									onclick="locateLostItem(<?php echo $record->id . ', ' . floatval($userLat) . ', ' . floatval($userLng) . ', ' . floatval($record->lat) . ', ' . floatval($record->lng);  ?>)" 
									class="fa-stack fa-2x print-icon" 
									data-toggle="modal" 
									data-target="#googleMapModal">
									<i class="fas fa-search"></i>
								</span>
							</div>
							<?php } ?>
						<?php } ?>
					</div>
					<?php if (!($record->dhlId || $record->userclaimId)) { ?>
					<div class="item-editor theme-editor" id="labelEditor<?php echo $record->id; ?>">
						<div class="theme-editor-header d-flex justify-content-between">
							<div>
								<img src="<?php echo base_url(); ?>assets/home/images/tiqslogonew.png" alt="">
							</div>
							<div class="theme-editor-header-buttons">
									<input 
										type="button"
										class="grid-button button theme-editor-header-button"
										onclick="submitForm('manageLabel<?php echo $record->id; ?>')"
										value="Submit"
									/>
								<button class="grid-button-cancel button theme-editor-header-button"  onclick="toogleElementClass('labelEditor<?php echo $record->id; ?>','display')">Cancel</button>
							</div>
						</div>
						<div class="edit-signle-item-container">
							<h3>Item Heading</h3>
							<form 
								id="manageLabel<?php echo $record->id; ?>" 
								class='form-inline' 
								method="post"
								action="<?php echo $this->baseUrl . 'user/editUserlabel'; ?>" >
								<input type="number" name="id" hidden value ="<?php echo $record->id; ?>" />
								<div>
									<label for="categoryid<?php echo $record->id; ?>">Category</label>
									<select name="categoryid" id="categoryid<?php echo $record->id; ?>" class='form-control'>
										<?php foreach ($categories as $category) { ?>
										<option 
											<?php if ($record->categoryid ===$category->id) echo 'selected'; ?>
											value="<?php echo $category->id; ?>"><?php echo $category->description; ?>
										</option>
										<?php } ?>
									</select>
								</div>
								<div>
									<label for="descript<?php echo $record->id; ?>">Description</label>			
									<input class='form-control' type="text" name="descript" id="descript<?php echo $record->id; ?>" value="<?php echo $record->descript; ?>"/>
								</div>
							</form>
						</div>
					</div>
					<?php } ?>
				</div>
				<!-- end grid item -->
					<?php
				}
				unset($codes);
			}
			?>
        </div>
        <!-- end grid list -->
    </div>
    <!-- end grid wrapper -->
</div>

<div class="modal fade" id="googleMapModal" role="dialog">
	<div class="modal-dialog" style="width:90vw; height:90vh;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Drag marker to location where you think that you lost your item or fill up form</h3>
			</div>
			<div class="row" >
				<div id="labelsModalForm" class="col-xs-12 col-sm-10 col-md-3" style="height:70vh;">
					<form method="post" onsubmit="return updateLostItem()">
						<input type="text" id="labelId" requried hidden />
						<legend>Tell us where you lost your item. All fields are required</legend>
						<div class="form-group">
							<label for="country">Country:</label>
							<select class="form-control" id="country" requried >
								<?php include_once FCPATH . 'application/views/includes/countrySelectOptions.php'; ?>
							</select>
						</div> 
						<div class="form-group">
							<label for="city">City:</label>
							<input type="text" class="form-control" id="city" requried />
						</div>
						<div class="form-group">
							<label for="city_code">City code:</label>
							<input type="text" class="form-control" id="city_code" requried />
						</div>
						<div class="form-group">
							<label for="address">Address:</label>
							<input type="text" class="form-control" id="address" requried />
						</div>
						<div class="form-group">
							<label for="reward">Reward:</label>
							<input type="number" min="0" step="1" class="form-control" id="reward" requried />
						</div>
						<div class="checkbox">
							<label><input type="checkbox" id="lost" />Public</label>
						</div>
						<input type="submit" class="btn btn-default" value="Submit" />
					</form>
				</div>
				<div class="col-xs-12 col-sm-10 col-md-9" id="lostItem" style="height:70vh;">
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function locateLostItem(labelId, userLat, userLng, labelLostlLat, labelLostLng) {
		document.getElementById('labelId').setAttribute('value', labelId);
		let itemLat = (labelLostlLat) ? parseFloat(labelLostlLat) : parseFloat(userLat);
		let itemLng = (labelLostLng) ? parseFloat(labelLostLng) : parseFloat(userLng);
		let mapProp= {
			center:new google.maps.LatLng(itemLat, itemLng),
			zoom: 20,
		};
		let map = new google.maps.Map(document.getElementById("lostItem"), mapProp);

		// Place a draggable marker on the map
		var marker = new google.maps.Marker({
			position: {lat: itemLat, lng: itemLng},
			map: map,
			draggable: true,
			title:"Drag me on the item location!"
		});
		
		if (labelLostlLat && labelLostLng) {
			let content = '<p>Click <span id="saveLocation" ';
			content += 'onclick="itemFindUpdate('+ labelId + ',\'#fff\')" ';
			content += 'style="font-weight:900">yes</span> if you found item</p>';

			let itemFind = new google.maps.InfoWindow({content: content});
			itemFind.open(map, marker);
		}
		
		marker.addListener('dragend', function(event) {
			let lat = event.latLng.lat().toFixed(10);
			let lng = event.latLng.lng().toFixed(10);
			let content = '';

			content += '<p>Click <span id="saveLocation" ';
			content += 'onclick="saveItemLocation('+ labelId + ',' + lat + ',' + lng +', \'#446087\')" ';
			content += 'style="font-weight:900">yes</span> to confirm location</p>'

			let saveLocation = new google.maps.InfoWindow({
				content: content
			});

			saveLocation.open(map, marker);
        });
	}

	function saveItemLocation(labelId, lat, lng, color) {
		let reward = prompt('Add your reward amount for finder. Amount must be positive integer number');
		reward = parseInt(reward);

		if (reward > 0 && Number.isInteger(reward) ) {
			let post = {
				'lat': lat,
				'lng': lng,
				'lost': 1,
				'finder_fee': reward,
				'id': labelId,
			}
			let url = globalVariables.ajax + 'updateLabel'
			let callBack = 'saveItemLocation';
			let gridId = 'grid_' + labelId;
			sendAjaxPostRequest(post, url, callBack, updateLostItemCallBack, [gridId, color]);
		} else {
			alert('Reward amount must be positive number and integer!');
		}
	}

	function itemFindUpdate(labelId, color) {
		let post = {
			'lat': 0,
			'lng': 0,
			'lost': 0,
			'finder_fee': 0,
			'id': labelId,
		}
		let url = globalVariables.ajax + 'updateLabel'
		let callBack = 'saveItemLocation';
		let gridId = 'grid_' + labelId;
		sendAjaxPostRequest(post, url, callBack, changeGridBackground, [gridId, color]);
		locateLostItem(labelId, labelGlobals.userLat, labelGlobals.userLng, 0, 0);
	}

	function changeGridBackground(id, color) {
		document.getElementById(id).style.backgroundColor = color;
	}

	function updateLostItemCallBack(gridId, color, labelId, labelLat, labelLng) {
		changeGridBackground(gridId, color);
		locateLostItem(labelId, 0, 0, labelLat, labelLng);
	}		

	function updateLostItem(formId) {
		let address = document.getElementById('address').value;
		let cityCode = document.getElementById('city_code').value;
		let city = document.getElementById('city').value;
		let country = document.getElementById('country').value;
		let reward = parseInt(document.getElementById('reward').value);
		let lost =  document.getElementById('lost').checked ? 1 : 0;
		let id = document.getElementById('labelId').value;
		if (address && cityCode && city && country && reward) {
			let lost_item_address = address + ', ' + cityCode + ', ' + city + ', ' + country;
			let post = {
				'id' : document.getElementById('labelId').value,
				'lost_item_address' : lost_item_address,
				'lost' : lost,
				'finder_fee' : reward,
			};
			let gridId = 'grid_' + id;
			let color = '#446087';
			let url = globalVariables.ajax + 'updateLabel'
			sendAjaxPostRequest(post, url, 'updateLostItem', updateLostItemCallBack, [gridId, color])
		} else {
			alert('Fill up required fields');
		}
		
		return false;
	}

	$(document).ready(function() {
		if ($('.image-link').length > 0) {
			$('.image-link').magnificPopup({type:'image'});
		}
	});

	var labelGlobals = (function(){
		let data = {
			'userLat': parseFloat(<?php echo $userLat; ?>),
			'userLng': parseFloat(<?php echo $userLng; ?>),
		}
		Object.freeze(data);
		return data;
	}());
</script>
