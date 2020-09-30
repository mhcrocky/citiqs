<div class="row d-flex justify-content-center">
    <div class='col-sm-12 col-lg-9'>
        <div class="checkout-table">
            <div class="checkout-table__header">
                <h3 class='mb-0'>Checkout list</h3>
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
                            <div class='checkout-table__num-order'>
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
                                    <!-- <span
                                        class="fa-stack makeOrder"
                                        <?php #if ($product['onlyOne'] === '0') { ?>
                                            onclick='changeQuantityAndPriceById("<?php #echo $mainProductId; ?>", "+")'
                                        <?php #} elseif ($product['onlyOne'] === '1') { ?>
                                            style="visibility: hidden;"
                                        <?php #} ?>
                                    >
                                        <i class="fa fa-plus"></i>
                                    </span> -->
                                    <span class='checkout-table__number-of-products' id="quantity_<?php echo $countInputs; ?>">
                                        <span class="quantity">Quantity:&nbsp;</span>
                                        <?php echo $product['quantity']; ?>
                                    </span>
                                    <!-- <span
                                        class="fa-stack makeOrder"
                                        <?php #if ($product['onlyOne'] === '0') { ?>
                                            onclick='changeQuantityAndPriceById("<?php #echo $mainProductId; ?>", "-")'
                                        <?php #} elseif ($product['onlyOne'] === '1') { ?>
                                            style="visibility: hidden;"
                                        <?php #} ?>
                                    >
                                        <i class="fa fa-minus"></i>
                                    </span> -->
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
                                <div class="checkout-table__price">
                                    <p>
                                        <span id="price_<?php echo $countInputs; ?>">
                                            <?php echo number_format($product['amount'], 2, ".", ","); ?>
                                        </span>&nbsp;&euro;
                                        <?php $orderTotal += filter_var($product['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>
                                    </p>
                                    <!-- <i
                                        class="fa fa-trash"
                                        data-class="<?php #echo $removeClass; ?>";
                                        data-order-session-index="<?php #echo $key ; ?>"
                                        onclick="unsetSessionOrderElement(this.dataset)"
                                        >
                                    </i> -->
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
                                        <div class='checkout-table__product-details'>                                            
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
                                        <div class='checkout-table__numbers'>
                                            <div class="checkout-table__quantity">
                                                <!-- <span class="fa-stack makeOrder" onclick='changeQuantityAndPriceById("input_quantity_<?php #echo $countInputs; ?>", "+")'                                                >
                                                    <i class="fa fa-plus"></i>
                                                </span> -->
                                                <span class='checkout-table__number-of-products' id="quantity_<?php echo $countInputs; ?>">
                                                    <span class="quantity">Quantity:&nbsp;</span>
                                                    <?php echo $addon['quantity']; ?>
                                                </span>
                                                <!-- <span class="fa-stack makeOrder" onclick='changeQuantityAndPriceById("input_quantity_<?php #echo $countInputs; ?>", "-")'                                                >
                                                    <i class="fa fa-minus"></i>
                                                </span> -->
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
                                            <div class="checkout-table__price">
                                                <p>
                                                    <span id="price_<?php echo $countInputs; ?>">
                                                        <?php echo number_format($addon['amount'], 2, ".", ","); ?>
                                                    </span>&nbsp;&euro;
                                                    <?php $orderTotal += filter_var($addon['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>
                                                </p>
                                                <!-- <i
                                                    class="fa fa-trash"
                                                    data-addon-id="<?php #echo $addonId; ?>"
                                                    data-order-session-index="<?php #echo $key; ?>"
                                                    data-product-extended-id="<?php #echo $productExtendedId; ?>""
                                                    data-addon-extended-id="<?php #echo $addonExtendedId; ?>"
                                                    onclick="unsetSessionOrderElement(this.dataset)"
                                                    >
                                                </i> -->
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
            <div class="checkout-table__single-element checkout-table__single-element--total">
                <div class="checkout-table__total">
                    <b>SERVICE FEE:</b>
                    <span id="serviceFee">
                        <?php
                            $serviceFee = $orderTotal * $vendor['serviceFeePercent'] / 100 + $vendor['minimumOrderFee'];
                            if ($serviceFee > $vendor['serviceFeeAmount']) $serviceFee = $vendor['serviceFeeAmount'];
                            echo number_format($serviceFee, 2, ".", ","); ?> &euro;
                    </span>
                </div>
            </div>
            <div class="checkout-table__single-element checkout-table__single-element--total">
                <div class="checkout-table__total">
                    <b>TOTAL:</b>
                    <span id="totalAmount">
                        <?php
                            $total = $orderTotal + $serviceFee;
                            echo number_format($total, 2, ".", ",");
                        ?> &euro;
                    </span>
                </div>
            </div>
            <?php if ($vendor['tipWaiter'] === '1') { ?>
                <div class="checkout-table__single-element checkout-table__single-element--total">
                    <div class="checkout-table__total" style="text-align:right">
                        <b>WAITER TIP:</b>
                        <span>
                            <input
                                type="number"
                                min="0"
                                value="<?php echo (empty($_SESSION['postOrder']['order']['waiterTip'])) ? '0.00' : $_SESSION['postOrder']['order']['waiterTip']; ?>"
                                step="0.50"
                                id="waiterTip"
                                name="order[waiterTip]"
                                placeholder="Waiter tip"
                                class="form-control"
                                oninput="checkValue(this)"
                                style="width:25%; display:inline"
                            /> &euro;
                        </span>
                    </div>
                </div>
                <div class="checkout-table__single-element checkout-table__single-element--total" style="visibility: hidden;" id="tipShowContainer">
                    <div class="checkout-table__total">
                        <b>TOTAL WITH TIP:</b>
                        <span id="totalWithTip"></span>
                    </div>
                </div>
            <?php } ?>
            <!-- end total sum-->
        </div>
        <!-- end checkout table -->
    </div>
</div>
