<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="col-12 col-md-6">
   	<div class="single-product">
   		<div class="single-product__image">
   		    <!-- add url to single product image -->
   			<img src="" alt="">
   		</div>
   		<!-- end single product image -->
   		<div class="single-product-details">
   			<h3 class='single-product__title'>
   				<?php echo $productDetails['name']; ?>
   			</h3>
   			<p class='single-product__ingredients'>
   				 <?php if (trim($productDetails['name']) !== trim($productDetails['shortDescription'])) { ?>
                <?php echo $productDetails['shortDescription']; ?>
        		<?php } ?>
   			
				<?php if ($productDetails['longDescription'] && $productDetails['longDescription'] !== 'NA') { ?>
				<i style="width: 15px" class="fa fa-info-circle infoCircle" aria-hidden="true"
					data-toggle="popover" data-trigger="hover" data-placement="bottom"
					data-content="<?php echo $productDetails['longDescription']; ?>"></i>
				<?php } ?>
				
  			</p>
  			<div class="single-product-alergies">
  				<?php
					$baseUrl = base_url();
					if ($vendor['showAllergies'] === '1') {
						$productAllergies = unserialize($product['allergies']);
						if (!empty($productAllergies['productAllergies'])) {
							?>
								<!-- product allergies -->
								<div>
									<?php
										$productAllergies = $productAllergies['productAllergies'];
										foreach ($productAllergies as $allergy) {
											?>
												<img
													src="<?php echo $baseUrl . 'assets/images/allergies/' . str_replace(' ', '_', $allergy); ?>.png"
													class="ingredients"
													alt="<?php echo $allergy; ?>"
													style="display:inline; margin:5px 2px"
													width="20"
													height="20"
												/>
											<?php
										} ?>
								</div>
								<!-- product allergies -->
							<?php
						}
					}
				?>
  			</div>
  			<!-- end alergies -->
   		</div>
   		<!-- end single product details -->
   		<div class="single-product__footer">
   			<span class='single-product__price'><?php echo $productDetails['price']; ?>&euro; </span>
   			<div class="single-product__buttons">
   				<button href="" class="btn single-product__button single-product__button--minus">-</button>
   				<input name="" class="form-control" type="number" value="1" placeholder="0" data-price="0.53" disabled="" readonly="">
   				<button
                type="button"
                class='btn single-product__button single-product__button--plus'
                <?php if ($product['addRemark'] === '1' || !empty($product['addons'])) { ?>
                    data-toggle="modal"
                    data-target="#modal-additional-options_<?php echo $productDetails['productExtendedId']; ?>"
                <?php } else { ?>
                    onclick="mainProductQuantity(
                                                    this,
                                                    true,
                                                    '<?php echo $productDetails['name']; ?>',
                                                    '<?php echo $productDetails['price']; ?>'
                                                )"
                <?php } ?>
            	>
                +
            </button>
   			</div>
   		</div>
   		<!-- end single product footer -->
   		
   	</div>
   	<!-- end single product -->
    
</div>
<!-- end COL single product -->

<?php
    if ($product['addRemark'] === '1' || $product['onlyOne'] !== '1') {
        $modalId = 'modal-additional-options_' . $productDetails['productExtendedId'];
        ?>
            <!-- MODAL ADDITIONAL OPTIONS -->
            <div
                class="modal fade modal-additional"
                id="<?php echo $modalId; ?>"
                tabindex="-1"
                role="dialog"
                aria-labelledby="modal-additional-options_label_<?php echo $productDetails['productExtendedId']; ?>"
                aria-hidden="true"
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex flex-column">
                            <h3
                                class="single-product__title"
                                id="modal-additional-options_label_<?php echo $productDetails['productExtendedId']; ?>"
                            >
                                <?php echo $productDetails['name']; ?>
                            </h3>
                            <p class='single-product__ingredients mb-2'>
								<?php if (trim($productDetails['name']) !== trim($productDetails['shortDescription'])) { ?>
								<?php echo $productDetails['shortDescription']; ?>
								<?php } ?>
                            </p>
                            <p class='single-product__price mt-2 mb-0'><?php echo $productDetails['price']; ?>&euro;</p>
                            
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearModal('<?php echo $modalId; ?>')">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                        	<div class="modal-form">
                            <input
                                type="number"
                                value="1"
                                data-price="<?php echo $productDetails['price']; ?>"
                                name="order[<?php echo $productDetails['productExtendedId']; ?>][quantity]"
                                readonly
                                hidden
                            />

                            <?php if ($product['addons']) { ?>
                                <!-- product addons -->
                                <div>
                                    <?php
                                        // prepare product addons
                                        $productAddons = $product['addons'];
                                        $collectAddons = [];
                                        foreach ($productAddons as $productAddonData) {
                                            $addonId = $productAddonData[0][0];
                                            $allowedQuantity = $productAddonData[0][1];
                                            if (empty($addons[$addonId])) continue;
                                            $addon = $addons[$addonId][0];
                                            $addon['addonAllowedQuantity'] = $allowedQuantity;
                                            if (!isset($collectAddons[$addon['productType']])) {
                                                $collectAddons[$addon['productType']] = [];
                                            }
                                            array_push($collectAddons[$addon['productType']], $addon);
                                        }
                                    ?>

                                    <!-- show product addons -->
                                    <?php foreach ($collectAddons as $type => $typeAddons) { ?>
                                        <div class='modal-form'>
                                           	<div>
                                            <div class="modal-form__title">
                                                <h6><?php echo $type; ?></h6>
                                               <!-- <p class="mb-0">Choose one size <span>(*Required)</span></p>-->
                                            </div>
                                            <?php foreach ($typeAddons as $showAddon) { ?>
                                                <?php
                                                    // echo '<pre>';
                                                    // print_r($showAddon);
                                                    // echo '</pre>';
                                                    // prepare addon allergies
                                                    if ($vendor['showAllergies'] === '1') {
                                                        $addonAllergies = unserialize($showAddon['allergies']);
                                                        $addonAllergies = !empty($addonAllergies['productAllergies']) ? $addonAllergies['productAllergies'] : [];
                                                    }
                                                ?>

                                                <!-- addon name and buttons -->
                                                <div
                                                    class="form-group">
                                                   <label><?php echo $showAddon['name'] . ' <span>(+' . $showAddon['price'] . '&euro;)<span>'; ?></label>
                                                   <div class="d-flex align-items-center justify-content-center">
                                                   	<?php if ($showAddon['addonAllowedQuantity'] !== '1') { ?>
															<button
																type="button"
																class="btn single-product__button single-product__button--minus"
																onclick="changeSiblingValue(this, false)"
															>
																-
															</button>
														<?php } ?>
														<input
															name="order[<?php echo $productDetails['productExtendedId']; ?>][addons][<?php echo $showAddon['productExtendedId']; ?>][quantity]"
															class="form-control"
															type="number"
															value="0"
															placeholder="0"
															max="<?php echo $showAddon['addonAllowedQuantity']; ?>"
															min="0"
															step="1"
															data-price="<?php echo $showAddon['price']; ?>"
															disabled
															<?php if ($showAddon['addonAllowedQuantity'] !== '1') { ?>
																readonly
															<?php } else { ?>
																hidden
															<?php } ?>
														/>
														<?php if ($showAddon['addonAllowedQuantity'] !== '1') { ?>
															<button
																type="button"
																class="btn single-product__button single-product__button--plus"
																onclick="changeSiblingValue(this, true)"
															>
																+
															</button>
														<?php } ?>
                                                   </div>
                                                   <!-- end quantity input -->
                                                    <div class="menu-list__right-col" style="display:none">
                                                        <div class="quantity-section mt-0">
                                                            <?php if ($showAddon['addonAllowedQuantity'] !== '1') { ?>
                                                                <button
                                                                    type="button"
                                                                    class="quantity-button quantity-button--minus"
                                                                    onclick="changeSiblingValue(this, false)"
                                                                >
                                                                    -
                                                                </button>
                                                            <?php } ?>
                                                            <input
                                                                name="order[<?php echo $productDetails['productExtendedId']; ?>][addons][<?php echo $showAddon['productExtendedId']; ?>][quantity]"
                                                                class="quantity-input"
                                                                type="number"
                                                                value="1"
                                                                placeholder="0"
                                                                max="<?php echo $showAddon['addonAllowedQuantity']; ?>"
                                                                min="1"
                                                                step="1"
                                                                data-price="<?php echo $showAddon['price']; ?>"
                                                                disabled
                                                                <?php if ($showAddon['addonAllowedQuantity'] !== '1') { ?>
                                                                    readonly
                                                                <?php } else { ?>
                                                                    hidden
                                                                <?php } ?>
                                                            />
                                                            <?php if ($showAddon['addonAllowedQuantity'] !== '1') { ?>
                                                                <button
                                                                    type="button"
                                                                    class="quantity-button quantity-button--plus"
                                                                    onclick="changeSiblingValue(this, true)"
                                                                >
                                                                    +
                                                                </button>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end addon name and buttons -->
												
                                                <?php
                                                    if ($showAddon['addRemark'] === '1') {
                                                        $showAddonRemarkId = 'addon_remark_' . $showAddon['productExtendedId']; ?>
                                                            <!-- addon remark -->
                                                            <div
                                                                class=""
                                                                <?php if (isset($addonAllergies)) {echo 'style="border-bottom: 0px #fff;"';} ?>
                                                            >
                                                               	
                                                                <div class='modal-form__title' for="<?php echo $showAddonRemarkId; ?>">
                                                                	<h6>Add remark:</h6>
                                                                </div>
                                                                <input
                                                                    id="<?php echo $showAddonRemarkId; ?>"
                                                                    class="form form-control"
                                                                    type="text"
                                                                    maxlength="<?php echo $maxRemarkLength; ?>"
                                                                    placeholder="Allowed <?php echo $maxRemarkLength; ?> characters"
                                                                    name="order[<?php echo $productDetails['productExtendedId']; ?>][addons][<?php echo $showAddon['productExtendedId']; ?>][remark]"
                                                                    value=""
                                                                    oninput="setInputAttribte(this, 'value', this.value)"
                                                                />
                                                            </div>
                                                            <!-- end addon remark -->
                                                        <?php
                                                    }
                                                ?>
                                                
                                                <?php if (!empty($addonAllergies)) { ?>
                                                    <!-- addon allergies -->
                                                    <div style="border-bottom: 1px solid #cfcfcf">
                                                        <?php foreach ($addonAllergies as $allergy) { ?>
                                                            <img
                                                                src="<?php echo $baseUrl . 'assets/images/allergies/' . str_replace(' ', '_', $allergy); ?>.png"
                                                                alt="<?php echo $allergy; ?>"
                                                                class="ingredients imgAlergies"
                                                                width="20"
                                                                height="20"
                                                                style="display:inline; margin:0px 2px 3px 0px"
                                                            />
                                                        <?php } ?>
                                                    </div>
                                                    <!-- end addon allergies -->
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!-- end product addons -->
                            <?php } ?>
                            </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearModal('<?php echo $modalId; ?>')">
                                    Close
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary add-to-cart"
                                    onclick="addInCheckoutList(
                                        '<?php echo $modalId; ?>',
                                        '<?php echo $productDetails['productExtendedId'] . ''; ?>',
                                        '<?php echo $productDetails['name']; ?>',
                                        '<?php echo $productDetails['price']; ?>'
                                    )"
                                    data-disimiss="modal"
                                >
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
?>
