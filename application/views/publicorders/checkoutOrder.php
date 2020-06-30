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
                            foreach ($orderDetails as $productExtendedId => $prodcut) {
                                
                                $count++;
                        ?>
                        <!-- start checkout single element -->
                        <div class="checkout-table__single-element" id="element<?php echo $productExtendedId; ?>">
                            <div class='checkout-table__num-order'>
                                <b class="counterClass"><?php echo $count; ?>.</b>
                            </div>
                            <div class='checkout-table__product-details'>
                                <p><?php echo $prodcut['name'][0]; ?></p>
                                <small><?php echo $prodcut['category'][0]; ?></small>
                            </div>
                            <div class='checkout-table__numbers'>
                                <div class="checkout-table__quantity">
                                    <span
                                        class="fa-stack makeOrder"
                                        onclick="changeQuantity(
                                            true,
                                            <?php echo $prodcut['price'][0]; ?>,
                                            'quantity<?php echo $productExtendedId; ?>',
                                            'amount<?php echo $productExtendedId; ?>',                                            
                                            'serviceFee',
                                            'totalAmount',
                                            'orderExtended<?php echo $productExtendedId; ?>'
                                        )"
                                        >
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    <span class='checkout-table__number-of-products' id="quantity<?php echo $productExtendedId; ?>">
                                        <?php echo $prodcut['quantity'][0]; ?>
                                    </span>
                                    <span
                                        class="fa-stack makeOrder"
                                        onclick="changeQuantity(
                                            false,
                                            <?php echo $prodcut['price'][0]; ?>,
                                            'quantity<?php echo $productExtendedId; ?>',
                                            'amount<?php echo $productExtendedId; ?>',                                            
                                            'serviceFee',
                                            'totalAmount',
                                            'orderExtended<?php echo $productExtendedId; ?>'
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
                                        value="<?php echo $prodcut['quantity'][0]; ?>"
                                        required hidden />
                                </div>
                                <div class="checkout-table__price">
                                    <p>
                                        <span id="amount<?php echo $productExtendedId; ?>">
                                            <?php echo number_format($prodcut['amount'][0], 2, ",", "."); ?>
                                        </span>&nbsp;&euro;
                                        <?php $orderTotal += filter_var($prodcut['amount'][0], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>
                                    </p>
                                    <i class="fa fa-trash" onclick="removeElement('element<?php echo $productExtendedId; ?>', 'counterClass', 'amount<?php echo $productExtendedId; ?>', 'serviceFee', 'totalAmount')"></i>
                                </div>
                            </div>
                        </div>
                        <!-- end checkout single element -->
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
                                    $serviceFee = $orderTotal * 0.045;
                                    if ($serviceFee > 3.50) $serviceFee = 3.50;
                                    echo number_format($serviceFee, 2, ",", "."); ?> &euro;
                            </span>
                        </div>
                    </div>
                    <div class="checkout-table__single-element checkout-table__single-element--total">
                        <div class="checkout-table__total">
                            <b>TOTAL:</b>
                            <span id="totalAmount">
                                <?php
                                    $total = $orderTotal + $serviceFee;
                                    echo number_format($total, 2, ",", ".");
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
                        <input id="firstNameInput" class="form-control" name="user[username]" value="" type="text" placeholder="Name" required />
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="emailAddressInput">Email address <sup>*</sup></label>
                        <input id="emailAddressInput" class="form-control" name="user[email]" value="" type="text" placeholder="Email address" required />
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="country-code">Country Code <sup>*</sup></label>
                        <select name="user[country]" class='form-control'>
                            <?php foreach ($countries as $countryCode => $country) { ?>
                                <option
                                    value="<?php echo $countryCode; ?>"
                                    <?php if ( $countryCode === 'NL')  echo 'selected'; ?> 
                                    >
                                    <?php echo $country; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="phoneInput">Phone <sup>*</sup></label>
                        <input id="phoneInput" class="form-control" name="user[mobile]" value="" type="text" placeholder="Phone" required />
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="notesInput">Remarks</label>
                        <textarea id="notesInput" class="form-control" name="order[notes]" rows="3"></textarea>
                    </div>
                </div>
                <div class="checkout-btns">
                    <a href="<?php echo base_url() . 'make_order?spotid=' . $spotId; ?>" class="button">
                        <i class="fa fa-arrow-left"></i>
                        Back to list                    </a>
                    <a href="javascript:void(0);" class="button" onclick="submitForm('goOrder', 'serviceFeeInput', 'orderAmountInput');">
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
    'use strict';
    function changeQuantity(plus, price, quantityId, amountId, serviceFeeId, totalAmountId, orderExtendedId) {
        let quantityElement = document.getElementById(quantityId);
        let quantityElementValue = parseInt(quantityElement.innerHTML);

        let amountElement = document.getElementById(amountId);
        let amountElementValue = parseFloat(amountElement.innerHTML.replace(',','.'));

        let orderExtendedInput = document.getElementById(orderExtendedId);
        let orderExtendedInputValue = parseInt(orderExtendedInput.value);
        
        let newQuantity;
        let newPrice;
        let newQuantityValue;

        if (plus) {
            newQuantity = quantityElementValue + 1;
            newPrice = (amountElementValue + price);
            newQuantityValue = orderExtendedInputValue + 1;

            quantityElement.innerHTML = newQuantity;
            amountElement.innerHTML = newPrice.toFixed(2);
            orderExtendedInput.setAttribute('value', newQuantityValue);
            orderExtendedInput.disabled = (newQuantityValue === 0) ? true : false;

            changeServiceFeeAndTotal(plus, price, serviceFeeId, totalAmountId)
        }

        if (!plus && quantityElementValue > 0 && amountElementValue > 0) {
            newQuantity = quantityElementValue - 1;
            newPrice = (amountElementValue - price);
            newQuantityValue = orderExtendedInputValue - 1;

            quantityElement.innerHTML = newQuantity;
            amountElement.innerHTML = newPrice.toFixed(2);
            orderExtendedInput.setAttribute('value', newQuantityValue);
            orderExtendedInput.disabled = (newQuantityValue === 0) ? true : false;

            changeServiceFeeAndTotal(plus, price, serviceFeeId, totalAmountId)
        }

        
    }

    function changeServiceFeeAndTotal(plus, price, serviceFeeId, totalAmountId) {
        let serviceFee = document.getElementById(serviceFeeId);
        let serviceFeeValue = parseFloat(serviceFee.innerHTML);

        let totalAmount = document.getElementById(totalAmountId);
        let totalAmountValue = parseFloat(totalAmount.innerHTML);

        let amount = totalAmountValue - serviceFeeValue;
        if (plus) {
            amount = amount + price;
        } else {
            amount = amount - price;
        }

        serviceFeeValue = calcualteServiceFee(amount);
        serviceFee.innerHTML = serviceFeeValue;

        totalAmountValue = amount + parseFloat(serviceFeeValue);
        totalAmount.innerHTML = totalAmountValue.toFixed(2);

        if (amount >= 0 && serviceFeeValue >= 0 ) {
            document.getElementById('serviceFeeInput').setAttribute('value', serviceFeeValue);
            document.getElementById('orderAmountInput').setAttribute('value', amount);
        }
    }

    function calcualteServiceFee(amount) {
        let serviceFee = amount * 0.045;
        if (serviceFee > 3.50) {
            serviceFee = 3.50;
        }
        return serviceFee.toFixed(2);
    }

    function removeElement(elementId, counterClass, amountId, serviceFee, totalAmount) {
        let amountToRemove = parseFloat(document.getElementById(amountId).innerHTML)
        let element = document.getElementById(elementId);
        element.remove();

        let counterElement;
        let counterElements = document.getElementsByClassName(counterClass);
        let counterElementsLength = counterElements.length;
        let i;
        let count;

        for (i = 0; i < counterElementsLength; i++) {
            counterElement = counterElements[i];
            count = i + 1;
            counterElement.innerHTML = count + '.';
        }

        changeServiceFeeAndTotal(false, amountToRemove, serviceFee, totalAmount)
    }

    function submitForm(formId, serviceFeeInputId, orderAmountInputId) {
        let serviceFee = parseFloat(document.getElementById(serviceFeeInputId).value);
        let orderTotal = parseFloat(document.getElementById(orderAmountInputId).value);

        if (serviceFee > 0 && orderTotal > 0 ) {
            document.getElementById(formId).submit();
        }
    }
</script>
