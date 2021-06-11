<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row d-flex justify-content-center">
    <div class='col-sm-12 col-lg-10 col-lg-offset-1'>
        <div class="checkout-table">
            <div id="headlineYourOrder" class="checkout-table__header">
                <h3 class='mb-0' style="text-align:center">
                    <?php  echo $this->language->tLine('YOUR ORDER'); ?>
                </h3>
            </div>
            <!--            <div class="checkout-table__single-element checkout-table__single-element--header">-->
            <!--                <div class='checkout-table__num-order'>-->
            <!--                    <b>#</b>-->
            <!--                </div>-->
            <!--                <div class='checkout-table__product-details'>-->
            <!--                    <p>Name</p>-->
            <!--                </div>-->
            <!--                <div class="checkout-table__numbers">-->
            <!--                    <div class="checkout-table__quantity">-->
            <!--                        <span class='checkout-table__number-of-products'>Quantity</span>-->
            <!--                    </div>-->
            <!--                    <div class="checkout-table__price">-->
            <!--                        <p>Price</p>-->
            <!--                    </div>-->

            <!--                </div>-->
            <!--            </div>-->
                        <!-- end checkout table header -->


            <div class="checkout-table-content">
                <?php
                    $countInputs = 0;
                    $count = 0;
                    $orderTotal = 0;
                    $total = 0;
                    foreach ($orderDetails as $key => $details) {
                        $product = reset($details);
                        $productExtendedId = array_keys($details)[0];
                        $count++;
                        $countInputs++;
                        $mainProductId = 'input_quantity_' . $countInputs;
                        $removeClass = 'removeClass_' . $mainProductId;
                        ?>
                        <!-- start checkout single element -->
                        <div class="checkout-table__single-element <?php echo $removeClass; ?> borderColor">
                            <div class='checkout-table__product-details'>                              	
                               	<div>
									<p class="checkout-table__price markedButtons">
										<span id="price_<?php echo $countInputs; ?>">
											<?php echo number_format($product['amount'], 2, ".", ","); ?>
										</span>&nbsp;&euro;
										<?php $orderTotal += filter_var($product['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>
									</p>
                                    <p style="margin: 5% 0px 0px 35%;">
                                        <span
                                            class="fa-stack makeOrder makeOrder-edit"
                                            <?php
                                                $editRedirect  = base_url() . 'make_order?vendorid=' . $vendor['vendorId'];
                                                $editRedirect .= '&spotid=' . $spotId .'&category=' . $product['categorySlide'];
                                                $editRedirect .= '&' . $orderDataGetKey .'=' . $orderRandomKey;
                                            ?>
                                            onclick="redirectToMakeOrder('<?php echo $editRedirect; ?>')"
                                        >
                                            <i class="fa fa-edit editIcon"></i>
                                        </span>
                                    </p>
								</div>
							   	<!-- end price -->
   
                               	<div>
                                <p class="productName"><?php echo $product['name']; ?></p>
                                <?php
                                    if (!empty($product['allergies']))  {
                                        $productAllergies = explode($this->config->item('allergiesSeparator'), $product['allergies']);
                                        $baseUrl = base_url();
                                        echo '<div style="padding: 5px 0px">';
                                        foreach ($productAllergies as $allergy) {
                                            ?>
                                                <img
                                                    src="<?php echo $baseUrl . 'assets/images/allergies/' . str_replace(' ', '_', $allergy); ?>.png"
                                                    alt="<?php echo $allergy; ?>"
                                                    class="ingredients"
                                                    height='24px'
                                                    width='24px'
                                                    style="display:inline; margin:0px 2px 3px 0px"
                                                />
                                            <?php
                                        }
                                        echo '</div>';
                                    }
                                ?>
                                <small class="categoryName"><?php echo $product['category']; ?></small>
                                <?php if (isset($product['remark'])) { ?>
                                    <div>
                                        <?php if ($product['remark']) { ?>
                                            <label><?php echo $this->language->tLine('Remarks');?> </label>
                                            <p><?php echo $product['remark']; ?></p>
                                        <?php } ?>
                                        <!-- <label for="orderExtended_<?php #echo $countInputs; ?>_<?php #echo $productExtendedId; ?>_remark">Remark</label>
                                        <textarea
                                            data-order-session-index="<?php #echo $key; ?>"
                                            data-product-extended-id="<?php #echo $productExtendedId; ?>"
                                            class="form-control"
                                            rows="1"
                                            maxlength="200"
                                            id="orderExtended_<?php #echo $countInputs; ?>_<?php #echo $productExtendedId; ?>_remark"
                                            name="orderExtended[<?php #echo $countInputs; ?>][<?php #echo $productExtendedId; ?>][remark]"
                                            onchange="updateSessionRemarkMainProduct(this)"
                                        ><?php #echo $product['remark']; ?></textarea> -->
                                    </div>
                                <?php } ?>
                                </div>
                                <!-- end title and description-->
                            </div>
                            <!-- end details -->
                            
                            <div class='checkout-table__numbers'>
                                <!-- end edit -->
                                
                                <div class="checkout-table__quantity">
                                    <span
                                        class="fa-stack makeOrder plusAndMinus"
                                        <?php if ($product['onlyOne'] === '0') { ?>
                                            onclick='changeQuantityAndPriceById("<?php echo $mainProductId; ?>", "+")'
                                        <?php } elseif ($product['onlyOne'] === '1') { ?>
                                            style="visibility: hidden;"
                                        <?php } ?>
                                    >
                                        <i class="fa fa-plus plusAndMinusColor"></i>
                                    </span>
                                    <span class='checkout-table__number-of-products markedButtons' id="quantity_<?php echo $countInputs; ?>">
                                        <!-- <span class="quantity">Quantity:&nbsp;</span> -->
                                        <?php echo $product['quantity']; ?>
                                    </span>
                                    <span
                                        class="fa-stack makeOrder plusAndMinus"
                                        <?php if ($product['onlyOne'] === '0') { ?>
                                            onclick='changeQuantityAndPriceById("<?php echo $mainProductId; ?>", "-")'
                                        <?php } elseif ($product['onlyOne'] === '1') { ?>
                                            style="visibility: hidden;"
                                        <?php } ?>
                                    >
                                        <i class="fa fa-minus plusAndMinusColor"></i>
                                    </span>
                                    <input
                                        id="<?php echo $mainProductId; ?>"
                                        class="calculateTotal"
                                        data-order-session-index="<?php echo $key; ?>"
                                        data-product-extended-id="<?php echo $productExtendedId; ?>"
                                        data-product-type="main"
                                        data-quantity-element-id="quantity_<?php echo $countInputs; ?>"
                                        data-price-element-id="price_<?php echo $countInputs; ?>"
                                        data-price="<?php echo $product['price']; ?>"
                                        min="1"
                                        type="number"
                                        step="1"
                                        name="orderExtended[<?php echo $countInputs; ?>][<?php echo $productExtendedId; ?>][quantity]"
                                        value="<?php echo $product['quantity']; ?>"
                                        required
                                        hidden
                                        <?php if ($product['onlyOne'] === '1') { ?>
                                            readonly
                                        <?php } ?>
                                    />
                                    <?php if (!empty($product['addons'])) { ?>
                                        <input
                                            name="orderExtended[<?php echo $countInputs; ?>][<?php echo $productExtendedId; ?>][mainPrductOrderIndex]"
                                            value="<?php echo $count; ?>"
                                            required
                                            hidden
                                            readonly
                                        />
                                    <?php } ?>

                                    <?php if (isset($product['remark'])) { ?>
                                        <input
                                            name="orderExtended[<?php echo $countInputs; ?>][<?php echo $productExtendedId; ?>][remark]"
                                            value="<?php echo $product['remark']; ?>"
                                            required
                                            hidden
                                            readonly
                                        />
                                    <?php } ?>
                                </div>
                                
                                <!--<div class='checkout-table__num-order shop__single-item__add-to-cart'>
									<b class="counterClass productCount"><?php echo $count; ?></b>
								</div>-->
                         		<!-- end counter -->
                         		
                          		<div class="checkout-table__trash">
                          			<i
									class="fa fa-trash trashIcon"
									data-class="<?php echo $removeClass; ?>";
									data-order-session-index="<?php echo $key ; ?>"
									onclick="unsetSessionOrderElement(this.dataset)"
									>
									</i>
                          		</div>
                           		<!-- end trash -->
                            </div>
                        </div>
                        <!-- end checkout single element -->
                        <?php
                            if (!empty($product['addons'])) {
                                $countAddons = 0;
                                foreach ($product['addons'] as $addonExtendedId => $addon) {
                                    $countAddons++;
                                    $countInputs++;
                                    $addonId = 'addon_' . $countInputs;
                                ?>
                                    <div
                                        id="<?php echo $addonId; ?>"
                                        class="checkout-table__single-element  <?php echo $removeClass; ?> borderColor" 
                                    >
                                        <!--<div class='checkout-table__num-order'>
                                             <b class="counterClass" style="padding-left: 20px;"><?php #echo $countAddons; ?>.</b> 
                                        </div>-->
                                        <!-- num order -->
                                        <div class='checkout-table__product-details checkout-table__product-details--addons'>
                                            <!--<b class="counterClass"><?php echo $count; ?>.</b>-->
                                            <!-- added wrapper -->
									   		<div>
												<p class="checkout-table__price markedButtons">
													<span id="price_<?php echo $countInputs; ?>">
														<?php echo number_format($addon['amount'], 2, ".", ","); ?>
													</span>&nbsp;&euro;
													<?php $orderTotal += filter_var($addon['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>
												</p>
                                                <p style="margin: 5% 0px 0px 35%">
                                                    <i
                                                        class="fa fa-paperclip"
                                                        aria-hidden="true"
                                                        data-toggle="popover"
                                                        data-trigger="hover"
                                                        data-placement="bottom"
                                                        data-content="Addon on <?php echo $product['name'] ?>"
                                                        >
                                                    </i>

                                                            
                                                </p>
									   		</div>                                           
                                             <!-- addon price -->
                                            <div class='checkout-table__addons-wrapper'>
                                                <p  class="productName">
                                                    <?php echo $addon['name']; ?>
                                                </p>
                                                <?php
                                                    if (!empty($addon['allergies']))  {
                                                        $addonAllergies = explode($this->config->item('allergiesSeparator'), $addon['allergies']);
                                                        $baseUrl = base_url();
                                                        echo '<div style="padding: 5px 0px">';
                                                        foreach ($addonAllergies as $allergy) {
                                                            ?>
                                                                <img
                                                                    src="<?php echo $baseUrl . 'assets/images/allergies/' . str_replace(' ', '_', $allergy); ?>.png"
                                                                    alt="<?php echo $allergy; ?>"
                                                                    height='24px'
                                                                    width='24px'
                                                                    style="display:inline; margin:0px 2px 3px 0px"
                                                                />
                                                            <?php
                                                        }
                                                        echo '</div>';
                                                    }
                                                ?>
                                                <small class="categoryName"><?php echo $addon['category']; ?></small>
                                                <?php if (isset($addon['remark'])) { ?>
                                                    <div>
                                                        <?php if ($addon['remark']) { ?>
                                                            <label><?php echo $this->language->tLine('Remarks');?> </label>
                                                            <p><?php echo $addon['remark']; ?></p>
                                                        <?php } ?>
                                                        <!-- <label for="orderExtended_<?php #echo $countInputs; ?>_<?php #echo $addonExtendedId; ?>_remark">Remark</label>
                                                        <textarea
                                                            id="orderExtended_<?php #echo $countInputs; ?>_<?php #echo $addonExtendedId; ?>_remark"
                                                            class="form-control"
                                                            data-order-session-index="<?php #echo $key; ?>"
                                                            data-product-extended-id="<?php #echo $productExtendedId; ?>"
                                                            data-addon-extended-id="<?php #echo $addonExtendedId; ?>"
                                                            rows="1"
                                                            maxlength="200"
                                                            name="orderExtended[<?php #echo $countInputs; ?>][<?php #echo $addonExtendedId; ?>][remark]"
                                                            onchange="updateSessionRemarkAddon(this)"
                                                        ><?php #echo $addon['remark']; ?></textarea> -->
                                                    </div>
                                                <?php } ?>
                                            </div>
										</div>
                                        <div class='checkout-table__numbers'>
                                            <div class="checkout-table__quantity">
                                                <span class="fa-stack makeOrder plusAndMinus" onclick='changeQuantityAndPriceById("input_quantity_<?php echo $countInputs; ?>", "+")'>
                                                    <i class="fa fa-plus plusAndMinusColor"></i>
                                                </span>
                                                <span class='checkout-table__number-of-products markedButtons' id="quantity_<?php echo $countInputs; ?>">
                                                    <!-- <span class="quantity">Quantity:&nbsp;</span> -->
                                                    <?php echo $addon['quantity']; ?>
                                                </span>
                                                <span class="fa-stack makeOrder plusAndMinus" onclick='changeQuantityAndPriceById("input_quantity_<?php echo $countInputs; ?>", "-")'>
                                                    <i class="fa fa-minus plusAndMinusColor"></i>
                                                </span>
                                                <input
                                                    id="input_quantity_<?php echo $countInputs; ?>"
                                                    class="calculateTotal"
                                                    data-order-session-index="<?php echo $key; ?>"
                                                    data-main-product-id="<?php echo $mainProductId; ?>"
                                                    data-product-extended-id="<?php echo $productExtendedId; ?>"
                                                    data-addon-extended-id="<?php echo $addonExtendedId; ?>"
                                                    data-product-type="addon"
                                                    data-quantity-element-id="quantity_<?php echo $countInputs; ?>"
                                                    data-price-element-id="price_<?php echo $countInputs; ?>"
                                                    data-price="<?php echo $addon['price']; ?>"
                                                    data-initial-min="<?php echo $addon['initialMinQuantity']; ?>"
                                                    data-initial-max="<?php echo $addon['initialMaxQuantity']; ?>"
                                                    data-initial-value="<?php echo $addon['quantity']; ?>"
                                                    type="number"
                                                    step="<?php echo $addon['step']; ?>"
                                                    min="<?php echo $addon['minQuantity']; ?>"
                                                    max="<?php echo $addon['maxQuantity']; ?>"
                                                    name="orderExtended[<?php echo $countInputs; ?>][<?php echo $addonExtendedId; ?>][quantity]"
                                                    value="<?php echo $addon['quantity']; ?>"
                                                    required
                                                    hidden
                                                />
                                                <input
                                                    name="orderExtended[<?php echo $countInputs; ?>][<?php echo $addonExtendedId; ?>][subMainPrductOrderIndex]"
                                                    value="<?php echo $count; ?>"
                                                    required
                                                    hidden
                                                    readonly
                                                />
                                                <?php if (isset($addon['remark'])) { ?>
                                                    <input
                                                        name="orderExtended[<?php echo $countInputs; ?>][<?php echo $addonExtendedId; ?>][remark]"
                                                        value="<?php echo $addon['remark']; ?>"
                                                        required
                                                        hidden
                                                        readonly
                                                    />
                                                <?php } ?>
                                            </div>
                                            <div class="checkout-table__trash">
                                                <i
                                                    class="fa fa-trash trashIcon"
                                                    data-addon-id="<?php echo $addonId; ?>"
                                                    data-order-session-index="<?php echo $key; ?>"
                                                    data-product-extended-id="<?php echo $productExtendedId; ?>"
                                                    data-addon-extended-id="<?php echo $addonExtendedId; ?>"
                                                    onclick="unsetSessionOrderElement(this.dataset)"
                                                    >
                                                </i>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                        ?>
                        <?php
                    }
                ?>
            </div>
            <!-- end table content -->
