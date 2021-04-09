<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	if (!$fodIsActive) {
?>
	<p style="margin-left:10px">Food is not active</p>
<?php
	} elseif (isset($mainProducts)) {
?>
	<main style="margin: 0px 10px">
		<div class="col-md-8" style="height: 100vh;">
			<div class="row">
				<div class="col-md-1" style="background-color:#ff7f50"></div>
				
				<div class="col-md-11">
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
												<?php echo  $category; ?>
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
				<div class="col-md-1" style="padding-left:0px; padding-right:0px;">
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
												<?php echo $spot['spotName']; ?>
											</li>
										<?php
									}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-11">
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
															<img
																<?php if ($product['productImage'] && file_exists($uploadProductImageFolder . $product['productImage'])) { ?>
																	src="<?php echo base_url() . 'assets/images/productImages/' . $product['productImage']; ?>"
																<?php } else { ?>
																	src="<?php echo base_url() . 'assets/images/defaultProductsImages/' . $vendor['defaultProductsImage']; ?>"
																<?php } ?>
																alt="<?php echo $productDetails['name']; ?>"
															/>
														</div>
													<?php } ?>
													<p class='pos-item__title'>
														<?php echo $productDetails['name']; ?>
													</p>
													<p class='pos-item__price'><?php echo $productDetails['price']; ?>&nbsp;&euro;</p>
													<p>
														<span
															id="orderQuantityValue_<?php echo $product['productId']; ?>"
															class="countOrdered priceQuantity"
															style="font-size:14px;border-radius: 100%;text-align: center;background: coral;width: 20px;display: inline-block;"
														>0</span>
													</p>
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
