<div class="row d-flex justify-content-center">
    <div class='col-sm-12 col-lg-9'>
        <div class="checkout-table">
            <div class="checkout-table__header">
                <h3 class='mb-0' style="text-align:center">Your order</h3>
            </div>
            <div class="checkout-table__single-element checkout-table__single-element--header">
                <div class='checkout-table__num-order'>
                    <b>#</b>
                </div>
                <!-- end number of product -->
                <div class='checkout-table__product-details'>
                    <p>Name</p>
                </div>
                <!-- end product details -->
                <div class="checkout-table__numbers">
                    <div class="checkout-table__quantity">
                        <span class='checkout-table__number-of-products'>Quantity</span>
                    </div>
                    <!-- end quantity -->
                    <div class="checkout-table__price">
                        <p>Price</p>
                    </div>
                    <!-- end price -->
                </div>
            </div>
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
                        <div class="checkout-table__single-element <?php echo $removeClass; ?>">
                            <div class='checkout-table__num-order shop__single-item__add-to-cart'>
                                <b class="counterClass productCount"><?php echo $count; ?>.</b>
                            </div>
                            <div class='checkout-table__product-details'>
                                <p><?php echo $product['name']; ?></p>
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
                                                    height='24px'
                                                    width='24px'
                                                    style="display:inline; margin:0px 2px 3px 0px"
                                                />
                                            <?php
                                        }
                                        echo '</div>';
                                    }
                                ?>
                                <small><?php echo $product['category']; ?></small>
                                <?php if (isset($product['remark'])) { ?>
                                    <div>
                                        <?php if ($product['remark']) { ?>
                                            <label>Remark</label>
                                            <p><?php echo $product['remark']; ?></p>
                                        <?php } ?>
                                        <!-- <label for="orderExtended_<?php #echo $countInputs; ?>_<?php# echo $productExtendedId; ?>_remark">Remark</label>
                                        <textarea
                                            data-order-session-index="<?php #echo $key; ?>"
                                            data-product-extended-id="<?php# echo $productExtendedId; ?>"
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
                            <div class='checkout-table__numbers'>
                                <div class="checkout-table__quantity">
                                    <span
                                        class="fa-stack makeOrder"
                                        <?php if ($product['onlyOne'] === '0') { ?>
                                            onclick='changeQuantityAndPriceById("<?php echo $mainProductId; ?>", "+")'
                                        <?php } elseif ($product['onlyOne'] === '1') { ?>
                                            style="visibility: hidden;"
                                        <?php } ?>
                                    >
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    <span class='checkout-table__number-of-products' id="quantity_<?php echo $countInputs; ?>">
                                        <!-- <span class="quantity">Quantity:&nbsp;</span> -->
                                        <?php echo $product['quantity']; ?>
                                    </span>
                                    <span
                                        class="fa-stack makeOrder"
                                        <?php if ($product['onlyOne'] === '0') { ?>
                                            onclick='changeQuantityAndPriceById("<?php echo $mainProductId; ?>", "-")'
                                        <?php } elseif ($product['onlyOne'] === '1') { ?>
                                            style="visibility: hidden;"
                                        <?php } ?>
                                    >
                                        <i class="fa fa-minus"></i>
                                    </span>
                                    <span
                                        class="fa-stack makeOrder makeOrder-edit"
                                        onclick="redirectToMakeOrder('<?php echo base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spotId .'&category=' . $product['categorySlide'];?>')"
                                        style="margin-left:20px"
                                        redirect();
                                    >
                                        <i class="fa fa-edit"></i>
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
                                </div>
                                <div class="checkout-table__price">
                                    <p>
                                        <span id="price_<?php echo $countInputs; ?>">
                                            <?php echo number_format($product['amount'], 2, ".", ","); ?>
                                        </span>&nbsp;&euro;
                                        <?php $orderTotal += filter_var($product['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>
                                    </p>
                                    <i
                                        class="fa fa-trash"
                                        data-class="<?php echo $removeClass; ?>";
                                        data-order-session-index="<?php echo $key ; ?>"
                                        onclick="unsetSessionOrderElement(this.dataset)"
                                        >
                                    </i>
                                </div>
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
                                        class="checkout-table__single-element  <?php echo $removeClass; ?>"
                                        style="padding-left: 35px;"
                                    >
                                        <div class='checkout-table__num-order'>
                                            <!-- <b class="counterClass" style="padding-left: 20px;"><?php #echo $countAddons; ?>.</b> -->
                                        </div>
                                        <div class='checkout-table__product-details checkout-table__product-details--addons'>                                    <b class="counterClass"><?php echo $count; ?>.</b>
                                           
                                           <!-- added wrapper -->
                                           <div class='checkout-table__addons-wrapper'>
                                            <p>
                                                <i class="fa fa-paperclip" aria-hidden="true"></i>
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
                                            <small><?php echo $addon['category']; ?></small>
                                            <?php if (isset($addon['remark'])) { ?>
                                                <div>
                                                    <?php if ($addon['remark']) { ?>
                                                        <label>Remark</label>
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
                                                <span class="fa-stack makeOrder" onclick='changeQuantityAndPriceById("input_quantity_<?php echo $countInputs; ?>", "+")'>
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                                <span class='checkout-table__number-of-products' id="quantity_<?php echo $countInputs; ?>">
                                                    <!-- <span class="quantity">Quantity:&nbsp;</span> -->
                                                    <?php echo $addon['quantity']; ?>
                                                </span>
                                                <span class="fa-stack makeOrder" onclick='changeQuantityAndPriceById("input_quantity_<?php echo $countInputs; ?>", "-")'>
                                                    <i class="fa fa-minus"></i>
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
                                                    required hidden
                                                />
                                                <input
                                                    name="orderExtended[<?php echo $countInputs; ?>][<?php echo $addonExtendedId; ?>][subMainPrductOrderIndex]"
                                                    value="<?php echo $count; ?>"
                                                    required
                                                    hidden
                                                    readonly
                                                />
                                            </div>
                                            <div class="checkout-table__price">
                                                <p>
                                                    <span id="price_<?php echo $countInputs; ?>">
                                                        <?php echo number_format($addon['amount'], 2, ".", ","); ?>
                                                    </span>&nbsp;&euro;
                                                    <?php $orderTotal += filter_var($addon['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>
                                                </p>
                                                <i
                                                    class="fa fa-trash"
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

            
            <!-- YOUR ORDER NEW -->
            <div style='width: 100%;background: gray;margin-top: 50px;color: white;padding: 20px'><h1>Your Order new</h1></div>
            <div class="checkout-table-content checkout-table-content__your-order">
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
                        <div class="checkout-table__single-element <?php echo $removeClass; ?>">
                           	<div class="checkout-table__price-wrapper">
							 	<div class="checkout-table__price">
									<p>
										<span id="price_1">
										3.00
										</span>&nbsp;€
									</p>
								</div>
								<div class='checkout-table__product-details'>
									<p><?php echo $product['name']; ?></p>
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
														height='24px'
														width='24px'
														style="display:inline; margin:0px 2px 3px 0px"
													/>
												<?php
											}
											echo '</div>';
										}
									?>
									<small><?php echo $product['category']; ?></small>
									<?php if (isset($product['remark'])) { ?>
										<div>
											<?php if ($product['remark']) { ?>
												<label>Remark</label>
												<p><?php echo $product['remark']; ?></p>
											<?php } ?>
											<!-- <label for="orderExtended_<?php #echo $countInputs; ?>_<?php# echo $productExtendedId; ?>_remark">Remark</label>
											<textarea
												data-order-session-index="<?php #echo $key; ?>"
												data-product-extended-id="<?php# echo $productExtendedId; ?>"
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
                           	</div>
                           <!-- end price wrapper -->

                            <div class='checkout-table__numbers'>
								<div class="shop__single-item__quiantity">
									<div class="shop__single-item__add-to-cart">
										<span id="orderQuantityValue_1970" class="countOrdered" style="font-size:14px;">3</span>
									</div>
								</div>
								<i class="fa fa-trash" data-class="removeClass_input_quantity_1" ;="" data-order-session-index="1_kgfluvotahzbsrdpcmwjxyeniq" onclick="unsetSessionOrderElement(this.dataset)">
								</i>
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
                                        class="checkout-table__single-element checkout-table__addon-element <?php echo $removeClass; ?>"
                                        style="padding-left: 35px;"
                                    >
                                        <div class='checkout-table__num-order'>
                                            <b class="counterClass"><?php echo $count; ?>.</b>
                                        </div>
                                        <div class='checkout-table__product-details checkout-table__product-details--addons'>                                    
                                           
                                           <!-- added wrapper -->
                                           <div class='checkout-table__addons-wrapper'>
                                            <p>
                                                <i class="fa fa-paperclip" aria-hidden="true"></i>
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
                                            <small><?php echo $addon['category']; ?></small>
                                            <?php if (isset($addon['remark'])) { ?>
                                                <div>
                                                    <?php if ($addon['remark']) { ?>
                                                        <label>Remark</label>
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
                                            <div class="checkout-table__price">
                                                <p>
                                                    <span id="price_<?php echo $countInputs; ?>">
                                                        <?php echo number_format($addon['amount'], 2, ".", ","); ?>
                                                    </span>&nbsp;&euro;
                                                    <?php $orderTotal += filter_var($addon['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>
                                                </p>
                                                <i
                                                    class="fa fa-trash"
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
            <!-- END YOUR ORDER-->
           
          
          	<!-- YOUR CHOICE NEW -->
            <div style='width: 100%;background: gray;margin-top: 50px;color: white;padding: 20px'><h1>Your Choice new</h1></div>
             <div class="checkout-table-content checkout-table-content__your-choice">
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
                        <div class="checkout-table__single-element <?php echo $removeClass; ?>">
                            <div class='checkout-table__product-details'>
                               	<div class="checkout-table__price">
									<p>
										<span id="price_1">
										3.00
										</span>&nbsp;€
									</p>
								</div>
                                <div class='name-and-category'>
                                <p><?php echo $product['name']; ?></p>
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
                                                    height='24px'
                                                    width='24px'
                                                    style="display:inline; margin:0px 2px 3px 0px"
                                                />
                                            <?php
                                        }
                                        echo '</div>';
                                    }
                                ?>
                                <small><?php echo $product['category']; ?></small>
                                <?php if (isset($product['remark'])) { ?>
                                    <div>
                                        <?php if ($product['remark']) { ?>
                                            <label>Remark</label>
                                            <p><?php echo $product['remark']; ?></p>
                                        <?php } ?>
                                        <!-- <label for="orderExtended_<?php #echo $countInputs; ?>_<?php# echo $productExtendedId; ?>_remark">Remark</label>
                                        <textarea
                                            data-order-session-index="<?php #echo $key; ?>"
                                            data-product-extended-id="<?php# echo $productExtendedId; ?>"
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
                            </div>
                            <div class='checkout-table__numbers'>
                                <div class="checkout-table__quantity">
                                   <span
                                        class="fa-stack makeOrder"
                                        <?php if ($product['onlyOne'] === '0') { ?>
                                            onclick='changeQuantityAndPriceById("<?php echo $mainProductId; ?>", "-")'
                                        <?php } elseif ($product['onlyOne'] === '1') { ?>
                                            style="visibility: hidden;"
                                        <?php } ?>
                                    >
                                        <i class="fa fa-minus"></i>
                                    </span>
                                    <span class='checkout-table__number-of-products' id="quantity_<?php echo $countInputs; ?>">
                                        <!-- <span class="quantity">Quantity:&nbsp;</span> -->
                                        <?php echo $product['quantity']; ?>
                                    </span>
                                     <span
                                        class="fa-stack makeOrder"
                                        <?php if ($product['onlyOne'] === '0') { ?>
                                            onclick='changeQuantityAndPriceById("<?php echo $mainProductId; ?>", "+")'
                                        <?php } elseif ($product['onlyOne'] === '1') { ?>
                                            style="visibility: hidden;"
                                        <?php } ?>
                                    >
                                        <i class="fa fa-plus"></i>
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
                                </div>
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
                                        class="checkout-table__single-element checkout-table__addon-element   <?php echo $removeClass; ?>"
                                        style="padding-left: 35px;"
                                    >
                                        <div class='checkout-table__num-order'>
                                            <b class="counterClass" style="padding-left: 20px;"><?php #echo $countAddons; ?>.</b>
                                        </div>
                                        <div class='checkout-table__product-details checkout-table__product-details--addons'>           
                                           <!-- added wrapper -->
                                           <div class='checkout-table__addons-wrapper'>
                                            <p>
                                                <i class="fa fa-paperclip" aria-hidden="true"></i>
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
                                            <small><?php echo $addon['category']; ?></small>
                                            <?php if (isset($addon['remark'])) { ?>
                                                <div>
                                                    <?php if ($addon['remark']) { ?>
                                                        <label>Remark</label>
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
                                                <span class="fa-stack makeOrder" onclick='changeQuantityAndPriceById("input_quantity_<?php echo $countInputs; ?>", "+")'>
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                                <span class='checkout-table__number-of-products' id="quantity_<?php echo $countInputs; ?>">
                                                    <!-- <span class="quantity">Quantity:&nbsp;</span> -->
                                                    <?php echo $addon['quantity']; ?>
                                                </span>
                                                <span class="fa-stack makeOrder" onclick='changeQuantityAndPriceById("input_quantity_<?php echo $countInputs; ?>", "-")'>
                                                    <i class="fa fa-minus"></i>
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
                                                    required hidden
                                                />
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
