<main class="container" style="text-align:left; margin-bottom:20px">
    <form id="goOrder" method="post" action="<?php echo base_url() . 'publicorders/submitOrder'; ?>">
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
                            $count = 0;
                            $orderTotal = 0;
                            $total = 0;
                            foreach ($orderDetails as $productExtendedId => $product) {
                                if (!isset($product['mainProduct'])) {
                                    $count++;
                                    $mainExtendedId = $productExtendedId;
                                    $mainName = $product['name'][0];;
                                ?>                                    
                                    <!-- start checkout single element -->
                                    <div class="checkout-table__single-element" id="element<?php echo $productExtendedId; ?>">
                                        <div class='checkout-table__num-order'>
                                            <b class="counterClass"><?php echo $count; ?>.</b>
                                        </div>
                                        <div class='checkout-table__product-details'>
                                            <p><?php echo $product['name'][0]; ?></p>
                                            <small><?php echo $product['category'][0]; ?></small>
                                        </div>
                                        <div class='checkout-table__numbers'>
                                            <div class="checkout-table__quantity">
                                                <span
                                                    class="fa-stack makeOrder"
                                                    onclick="changeQuantity(
                                                        true,
                                                        <?php echo $product['price'][0]; ?>,
                                                        'quantity<?php echo $productExtendedId; ?>',
                                                        'amount<?php echo $productExtendedId; ?>',
                                                        'serviceFee',
                                                        'totalAmount',
                                                        'orderExtended<?php echo $productExtendedId; ?>',
                                                        '<?php echo $productExtendedId; ?>',
                                                        '<?php echo $vendor['serviceFeePercent']; ?>',
                                                        '<?php echo $vendor['serviceFeeAmount']; ?>',
                                                    )"
                                                    >
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                                <span class='checkout-table__number-of-products' id="quantity<?php echo $productExtendedId; ?>">                                                    <?php echo $product['quantity'][0]; ?>
                                                </span>
                                                <span
                                                    class="fa-stack makeOrder"
                                                    onclick="changeQuantity(
                                                        false,
                                                        <?php echo $product['price'][0]; ?>,
                                                        'quantity<?php echo $productExtendedId; ?>',
                                                        'amount<?php echo $productExtendedId; ?>',
                                                        'serviceFee',
                                                        'totalAmount',
                                                        'orderExtended<?php echo $productExtendedId; ?>',
                                                        '<?php echo $productExtendedId; ?>',
                                                        '<?php echo $vendor['serviceFeePercent']; ?>',
                                                        '<?php echo $vendor['serviceFeeAmount']; ?>',
                                                    )"
                                                    >
                                                    <i class="fa fa-minus"></i>
                                                </span>
                                                <input
                                                    type="number"
                                                    min="0"
                                                    step="1"
                                                    name="orderExtended[<?php echo $productExtendedId; ?>][quantity]"
                                                    id = "orderExtended<?php echo $productExtendedId; ?>"
                                                    value="<?php echo $product['quantity'][0]; ?>"
                                                    required hidden />
                                            </div>
                                            <div class="checkout-table__price">
                                                <p>
                                                    <span id="amount<?php echo $productExtendedId; ?>">
                                                        <?php echo number_format($product['amount'][0], 2, ".", ","); ?>
                                                    </span>&nbsp;&euro;
                                                    <?php $orderTotal += filter_var($product['amount'][0], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>
                                                </p>
                                                <i
                                                    class="fa fa-trash" 
                                                    data-element-id = "element<?php echo $productExtendedId; ?>"
                                                    data-counter-class = "counterClass"
                                                    data-amount-id = "amount<?php echo $productExtendedId; ?>"
                                                    data-service-fee = "serviceFee"
                                                    data-total-amount = "totalAmount"
                                                    data-product-ex-id = "<?php echo $productExtendedId; ?>"
                                                    data-service-fee-percent = "<?php echo $vendor['serviceFeePercent']; ?>"
                                                    data-service-fee-amount = "<?php echo $vendor['serviceFeeAmount']; ?>"
                                                    onclick="removeElement(this)"
                                                ></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end checkout single element -->
                                <?php
                                } elseif (isset($product['mainProduct'])) {

                                    if (!isset($mainExtendedId) || !isset($product['mainProduct'][$mainExtendedId])) {
                                        $product = reset($product['mainProduct']);
                                        $this->session->set_flashdata('error', 'You did not order main product for "' . $product['name'][0] . '" ');
                                        $redirect = 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spotId;
                                        redirect($redirect);
                                    }
                                    $product = $product['mainProduct'][$mainExtendedId];
                                ?>
                                    <!-- start checkout single element -->
                                    <div
                                        class="checkout-table__single-element"
                                        id="element<?php echo $productExtendedId; ?>"
                                        >
                                        <!-- <div class='checkout-table__num-order'>
                                            <b class="counterClass"></b>
                                        </div> -->
                                        <div class='checkout-table__product-details'>
                                            <p><?php echo $product['name'][0] . ' (' . $mainName . ')'; ?> </p>
                                            <small><?php echo $product['category'][0]; ?></small>
                                        </div>
                                        <div class='checkout-table__numbers'>
                                            <div class="checkout-table__quantity">
                                                <span
                                                    class="fa-stack makeOrder"
                                                    onclick="changeQuantity(
                                                        true,
                                                        <?php echo $product['price'][0]; ?>,
                                                        'quantity<?php echo $productExtendedId; ?>',
                                                        'amount<?php echo $productExtendedId; ?>',
                                                        'serviceFee',
                                                        'totalAmount',
                                                        'orderExtended<?php echo $productExtendedId; ?>',
                                                        '<?php echo $productExtendedId; ?>',
                                                        '<?php echo $vendor['serviceFeePercent']; ?>',
                                                        '<?php echo $vendor['serviceFeeAmount']; ?>',
                                                        '<?php echo $mainExtendedId; ?>'
                                                    )"
                                                    >
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                                <span class='checkout-table__number-of-products' id="quantity<?php echo $productExtendedId; ?>">
                                                    <?php echo $product['quantity'][0]; ?>
                                                </span>
                                                <span
                                                    class="fa-stack makeOrder"
                                                    onclick="changeQuantity(
                                                        false,
                                                        <?php echo $product['price'][0]; ?>,
                                                        'quantity<?php echo $productExtendedId; ?>',
                                                        'amount<?php echo $productExtendedId; ?>',
                                                        'serviceFee',
                                                        'totalAmount',
                                                        'orderExtended<?php echo $productExtendedId; ?>',
                                                        '<?php echo $productExtendedId; ?>',
                                                        '<?php echo $vendor['serviceFeePercent']; ?>',
                                                        '<?php echo $vendor['serviceFeeAmount']; ?>',
                                                        '<?php echo $mainExtendedId; ?>'
                                                    )"
                                                    >
                                                    <i class="fa fa-minus"></i>
                                                </span>
                                                <input
                                                    type="number"
                                                    min="0"
                                                    step="1"
                                                    name="orderExtended[<?php echo $productExtendedId; ?>][quantity]"
                                                    id = "orderExtended<?php echo $productExtendedId; ?>"
                                                    value="<?php echo $product['quantity'][0]; ?>"
                                                    required hidden />
                                            </div>
                                            <div class="checkout-table__price">
                                                <p>
                                                    <span id="amount<?php echo $productExtendedId; ?>">
                                                        <?php echo number_format($product['amount'][0], 2, ".", ","); ?>
                                                    </span>&nbsp;&euro;
                                                    <?php $orderTotal += filter_var($product['amount'][0], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>
                                                </p>
                                                <i
                                                    class="fa fa-trash children_element<?php echo $mainExtendedId; ?>"
                                                    data-element-id = "element<?php echo $productExtendedId; ?>"
                                                    data-counter-class = "counterClass"
                                                    data-amount-id = "amount<?php echo $productExtendedId; ?>"
                                                    data-service-fee = "serviceFee"
                                                    data-total-amount = "totalAmount"
                                                    data-product-ex-id = "<?php echo $productExtendedId; ?>"
                                                    data-service-fee-percent = "<?php echo $vendor['serviceFeePercent']; ?>"
                                                    data-service-fee-amount = "<?php echo $vendor['serviceFeeAmount']; ?>"
                                                    onclick="removeElement(this)"
                                                ></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end checkout single element -->
                                <?php
                                }
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
                    <!-- end total sum-->
                </div>
                <!-- end checkout table -->
            </div>
        </div>
        <!-- end checkout table -->
        
        <div class="row d-flex justify-content-center">
            <div class="col-sm-12 col-lg-9 left-side">
                <div class="checkout-title">
                    <span>Checkout</span>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="firstNameInput">Name (<sup>*</sup>)</label>
                        <input id="firstNameInput" class="form-control" name="user[username]" value="<?php echo $username; ?>" type="text" placeholder="Name" required />
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="emailAddressInput">Email address <sup>*</sup></label>
                        <input type="email" id="emailAddressInput" class="form-control" name="user[email]" value="<?php echo $email; ?>" placeholder="Email address" required />
                    </div>
                    <!-- <div class="form-group col-sm-6" style="display:none">
                        <label for="country-code">Country Code <sup>*</sup></label>
                        <select name="user[country]" class='form-control'>
                            <?php #foreach ($countries as $countryCode => $country) { ?>
                                <option
                                    value="<?php #echo $countryCode; ?>"
                                    <?php
                                        // if ( 
                                        //     (!$userCountry && $countryCode === 'NL') 
                                        //     || ($userCountry && $countryCode === $userCountry)
                                        // ) {
                                        //     echo 'selected';
                                        // }
                                    ?>
                                    >
                                    <?php #echo $country; ?>
                                </option>
                            <?php #} ?>
                        </select>
                    </div> -->
                    <?php if ($vendor['requireMobile'] === '1') { ?>
                        <div class="form-group col-sm-6">
                            <label for="phoneInput">Phone <sup>*</sup></label>
                            <div>
                                <select class="form-control" style="width:22% !important; display:inline-block !important" name="phoneCountryCode" style="text-align:center">
                                    <?php foreach ($countryCodes as $code => $data) { ?>                                
                                        <option
                                            value="<?php $value = '00' . $data['code']; echo $value ?>"
                                            <?php
                                                if (
                                                    ($phoneCountryCode && $code === $phoneCountryCode)
                                                    || ($phoneCountryCode && $value === $phoneCountryCode)
                                                    || (!$phoneCountryCode && $code === 'NL')
                                                ) echo 'selected';
                                            ?>
                                            >
                                            <?php echo $code; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <input id="phoneInput" class="form-control" style="width:76% !important; display:inline-block !important" name="user[mobile]" value="<?php echo $mobile; ?>" type="text" placeholder="Phone" required />
                            </div>
                        </div>
                    <?php } ?>
                    <!-- <div class="form-group col-sm-12" style="display:none">
                        <label for="notesInput">Remarks</label>
                        <textarea id="notesInput" class="form-control" name="order[notes]" rows="3"></textarea>
                    </div> -->
                </div>
                <div class="checkout-btns">
                    <a href="<?php echo base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spotId; ?>" style="background-color: #948b6f" class="button">
                        <i class="fa fa-arrow-left"></i>
                        Back to list                    </a>
                    <a href="javascript:void(0);" style="background-color: #349171" class="button" onclick="submitForm('goOrder', 'serviceFeeInput', 'orderAmountInput');">
                        Pay
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <input type="text"      name="user[roleid]"         value="<?php echo $buyerRole; ?>" required readonly hidden />
        <input type="text"      name="user[usershorturl]"   value="<?php echo $usershorturl; ?>" required readonly hidden />
        <input type="text"      name="user[salesagent]"     value="<?php echo $buyerRole; ?>" required readonly hidden />      
        <input type="number"    name="order[spotId]"        value="<?php echo $spotId; ?>" readonly required hidden />
        <input type="number"    name="order[serviceFee]"    value="<?php echo $serviceFee; ?>" id="serviceFeeInput" min="0" step="0.01"  readonly required hidden />
        <input type="number"    name="order[amount]"        value="<?php echo $orderTotal; ?>" id="orderAmountInput" min="0" step="0.01"  readonly required hidden />
    </form>
</main>
<script>
    var checkoutOrdedGlobals = (function(){
        let globals = {
            'minimumOrderFee' : parseFloat('<?php echo $vendor['minimumOrderFee']; ?>')
        }
        Object.freeze(globals);
        return globals;
    }());
</script>