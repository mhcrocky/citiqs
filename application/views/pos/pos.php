<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	if (!$fodIsActive) {
?>
	<p style="margin-left:10px">Food is not active</p>
<?php
	} elseif (isset($mainProducts)) {
?>
	<main class='row p-3 m-0 pos-black' id='main-pos-wrapper'>
		<div class="col-md-8" style="height: calc(100vh - 20px);">
			<div class="row mb-4">
				<div class="col-md-2 col-xl-1 p-3" style="background-color:#ff7f50">
					<span class='btn w-100 h-100 d-flex align-items-center justify-content-center'  data-toggle="modal" data-target="#floorplan">
						<img src="/assets/home/images/twoontable.png" alt="" class='w-100'>
					</span>
				</div>
				
				<div class="col-md-10 col-xl-11">
					<div class="splide"  id="splideCategories">
						<div class="splide__track">
							<ul class="splide__list">
								<?php
									$i = 0;
									foreach ($categories as $index => $category) {
										$categoryId = str_replace(['\'', '"', ' ', '*', '/'], '', $category); ?>
											<li
												class="splide__slide pos_categories__single-item <?php if (array_key_first($categories) === $index) {
											echo 'pos_categories__single-item--active';
										} ?>"
												onclick="showCategory(this, '<?php echo $categoryId; ?>', 'categories')"
												data-id="<?php echo $categoryId; ?>"
												data-splide-hash="slide0<?php echo($i + 1)?>"
											>
												<p><?php echo  $category; ?></p>
											</li>
										<?php
										$i++;
									}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- end categories -->
			<div class="row">
				<div class="col-md-2 col-xl-1 splideSpots-wrapper" style="padding-left:0px; padding-right:0px;">
					<div class="splide" id="splideSpots">
						<div class="splide__track">
							<ul class="splide__list">
								<?php
									foreach ($spots as $spot) {
										?>
											<li
												class="splide__slide pos_categories__single-item <?php if (intval($spot['spotId']) === $spotId) echo 'pos_categories__single-item--active'; ?>"
												onclick="redirectToSpot('pos?spotid=<?php echo $spot['spotId']; ?>')"
												style="text-align:center; padding:0px 0px 0px 0px; height:10% !important"
											>
												<p><?php echo $spot['spotName']; ?></p>
											</li>
										<?php
									}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-10 col-xl-11">
					<div class="pos-main">
						<div class="pos-main__grid-content">
							<?php
								foreach ($mainProducts as $category => $products) {
									$categoryId = str_replace(['\'', '"', ' ', '*', '/'], '', $category);
								?>
									<div
										class="pos-main__overflow categories"
										id="<?php echo $categoryId; ?>"
										<?php if (array_key_first($mainProducts) !== $category) echo 'style="display:none"'; ?>
									>
										<div class="pos-main__grid">
											<?php foreach ($products as $product) { ?>
												<?php $productDetails = reset($product['productDetails']); ?>
												<div
													class="pos-item"
													onclick="posTriggerModalClick('modal_buuton_<?php echo 'single-item-details-modal' . $product['productId']; ?>_<?php echo $productDetails['productExtendedId']?>')"													>
													<?php if ($vendor['showProductsImages'] === '1') { ?>
														<div class='pos-item__image'>
															<?php if ($product['productImage']) { ?>
																<img
																	src="<?php echo $productsImagesFolder . $product['productImage']; ?>"
																	alt=""
																/>
															<?php } else { ?>
																<img
																	src="<?php echo $defaultImagesFolder . $vendor['defaultProductsImage']; ?>"
																	alt=""
																/>
															<?php } ?>
														</div>
													<?php } ?>
													<!--
														http://localhost/upwork/alfred/assets/images/defaultProductsImages/22572_1618581122.png
														http://localhost/upwork/alfred/assets/images/productImages/22572_1618581122.png
													-->
													<div class="pos-item__content">
														<p class='pos-item__title'>
															<?php echo $productDetails['name']; ?>
														</p>
														<div class="pos-item__footer">
															<p class='pos-item__price'><?php echo $productDetails['price']; ?>&nbsp;&euro;</p>
															<span
															id="orderQuantityValue_<?php echo $product['productId']; ?>"
															class="countOrdered priceQuantity"
															style="font-size:14px;border-radius: 100%;text-align: center;background: coral;width: 20px;display: inline-block;"
														>0</span>
														</div>
													</div>
												</div>
												<!-- end single pos item-->
											<?php } ?>
										</div>
									</div>
								<?php
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- start pos sidebar -->
		<?php include_once FCPATH . 'application/views/pos/includes/posMakeOrder.php'; ?>
		<!-- end pos sidebar -->
	</main>

	<?php include_once FCPATH . 'application/views/publicorders/includes/modals/makeOrderPos/productModals.php'; ?>
	<?php include_once FCPATH . 'application/views/publicorders/includes/makeOrderGlobalsJs.php'; ?>
	<?php include_once FCPATH . 'application/views/pos/includes/posModals.php'; ?>

	<script>
		'use strict';

		var posGlobals = (function(){
			let globals = new Map();
			let serviceFeePercent = parseFloat('<?php echo $serviceFeePercent; ?>');
			let serviceFeeAmount = parseFloat('<?php echo $serviceFeeAmount; ?>');
			let minimumOrderFee = parseFloat('<?php echo $minimumOrderFee; ?>');
			globals = {
				'serviceFeePercent' : serviceFeePercent,
				'serviceFeeAmount' : serviceFeeAmount,
				'minimumOrderFee' : minimumOrderFee,
				'counter' : 0,
				'selectedOrderRandomKey' : '',
				'selectedOrderName' : '',
				'selectedOrderShortName' : '',
				'posOrderName' : document.getElementById('posOrderName'),
				'holdOrderElement' : document.getElementById('holdOrderId'),
				'selectSavedElement' : document.getElementById('selectSaved'),
				'postPaid' : '<?php echo $postPaid; ?>',
				'pinMachinePayment' : '<?php echo $pinMachinePayment; ?>',
				'voucherPayment' : '<?php echo $voucherPayment; ?>',
				'pinCodeELement' : document.getElementById('pinCode'),
				'posManager' : false,
				'managerButton' : document.getElementById('managerButton')
			}

			<?php if  ($lock) { ?>
				globals['unlock'] = true;
			<?php } else { ?>
				globals['unlock'] = false;
			<?php } ?>

			<?php if  ($spotPosOrders) { ?>
				globals['spotPosOrders'] = true;
			<?php } else { ?>
				globals['spotPosOrders'] = false;
			<?php } ?>

			<?php if  ($spotName) { ?>
				globals['spotName'] = '<?php echo $spotName; ?>';
			<?php } ?>

			return globals;
		}());

		var showFloorPlanGloabals = (function(){
			let globals = {
				floorplanID: '<?php echo $floorplan['id']; ?>',
				floor_name: '<?php echo $floorplan['floorplanName']; ?>',
				areas: $.parseJSON('<?php echo json_encode($areas); ?>'),
				canvasJSON: '<?php echo $floorplan['canvas']; ?>'
			}
        	Object.freeze(globals);
        	return globals;
    	})();

		$('#zoomIn').click(function () {
			floorplan.scaleAndPositionCanvas(1.25);
		})

		$('#zoomOut').click(function () {
			floorplan.scaleAndPositionCanvas(0.75);
		})


	</script>
<?php } else { ?>
	
	<div class="container">
		<p style="margin-left:10px">No product(s) for this spot</p>
		<label for='selectSpot'>Select POS spot:&nbsp;&nbsp;</label>
		<select onchange="redirectToNewLocation(this.value)" class="form-control">
			<option value="">Select</option>
			<?php foreach ($spots as $spotOption) { ?>
				<?php if ($spotOption['spotActive'] !== '1') continue; ?>
				<option
					value="pos?spotid=<?php echo $spotOption['spotId']; ?>"
					<?php if (intval($spotOption['spotId']) === $spotId) echo 'selected'; ?>
				>
					<?php echo $spotOption['spotName']; ?>
					<?php if (intval($spotOption['spotId']) === $spotId) echo ' (NO PRODUCTS) '; ?>
				</option>
			<?php } ?>
		</select>
	</div>
<?php } ?>
