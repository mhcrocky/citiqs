<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	if (!$fodIsActive) {
?>
	<p style="margin-left:10px">Food is not active. <a href="<?php echo base_url() . 'orders'; ?>">Back</a></p>
<?php
	} else {
?>
	<main style="margin: 0px 10px">
		<!-- <div class="container">
			<div class="row">
				<div class="col-lg-4 col-12 form-inline">
					<?php #if (!empty($spots) && count($spots) > 1) { ?>
						<label for='selectSpot'>Select POS spot:&nbsp;&nbsp;</label>
						<select onchange="redirectToNewLocation(this.value)" class="form-control">
							<option value="">Select</option>
							<?php #foreach ($spots as $spotOption) { ?>
								<?php #if ($spotOption['spotActive'] !== '1') continue; ?>
								<option
									value="pos?spotid=<?php #echo $spotOption['spotId']; ?>"
									<?php #if (intval($spotOption['spotId']) === $spotId) echo 'selected'; ?>
								>
									<?php #echo $spotOption['spotName']; ?>
								</option>
							<?php #} ?>
						</select>
					<?php #} ?>
					<?php #if (!isset($mainProducts)) { ?>
						<div class="pos-main__add-item">
							<a href="<?php #echo base_url() . 'orders'; ?>">
								<button class='pos-main__add-new-button' style="color:#000">
									<i class="fa fa-hand-o-left" aria-hidden="true"></i>
									BACK
								</button>
							</a>
						</div>
					<?php #} ?>
				</div>

			</div>
		</div> -->
		
		<?php if (isset($mainProducts)) { ?>			
			<div class="col-lg-8" style="height: 100vh;">
				<div class="pos_categories" style="margin-bottom: 10px">
					<div class="pos_categories__grid">
						<?php
							foreach ($categories as $index => $category) {
								$categoryId = str_replace(['\'', '"', ' ', '*', '/'], '', $category);
							?>
								<div
									class="pos_categories__single-item <?php if (array_key_first($categories) === $index) echo 'pos_categories__single-item--active'; ?>"
									onclick="showCategory(this, '<?php echo $categoryId; ?>', 'categories')"
									data-id="<?php echo $categoryId; ?>"
								>
									<p>
										<?php echo  $category; ?>
									</p>
								</div>
							<?php
							}
						?>
					</div>
				</div>
				<!-- end categories -->
				<div class="pos-main">
					<!-- <div class="pos-main__top-bar"> -->
						<!-- <div class="pos-main__add-item">
							<a href="<?php #echo base_url() . 'orders'; ?>">
								<button class='pos-main__add-new-button'>
									<i class="fa fa-hand-o-left" aria-hidden="true"></i>
									BACK
								</button>
							</a>
						</div> -->
						<!-- <div class="pos-main__search">
							<input type="text" class='form-control'>
							<button class="pos-main__search__button"><i class="fas fa-search"></i></button>
						</div> -->
					<!-- </div> -->
					<!-- end pos top bar -->

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
				<!-- end pos main-->
				<!-- 
				<div class="pos_categories__footer">
					<a
						href="javascript:void(0)"
						class='pos_categories__button pos_categories__button--primary'
						onclick="printReportes('<?php #echo $vendor['vendorId']; ?>', '<?php #echo $xReport; ?>')"
					>
						X reportes
					</a>
					<a
						href="javascript:void(0)"
						class='pos_categories__button pos_categories__button--third'
						onclick="printReportes('<?php #echo $vendor['vendorId']; ?>', '<?php #echo $zReport; ?>')"
					>
						Z reportes
					</a>
				</div>
				-->
			</div>
			<!-- start pos sidebar -->
			<?php include_once FCPATH . 'application/views/pos/includes/posMakeOrder.php'; ?>
			<!-- end pos sidebar -->
		<?php } ?>
	</main>
	<?php if (isset($mainProducts)) { ?>

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
		<script>
			var posGlobals = {};
		</script>
	<?php } ?>
<?php } ?>