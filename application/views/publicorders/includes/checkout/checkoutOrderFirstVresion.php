<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
                                        <!-- <span
                                            class="fa-stack makeOrder"
                                            onclick="changeQuantity(
                                                true,
                                                <?php #echo $product['price'][0]; ?>,
                                                'quantity<?php #echo $productExtendedId; ?>',
                                                'amount<?php #echo $productExtendedId; ?>',
                                                'serviceFee',
                                                'totalAmount',
                                                'orderExtended<?php #echo $productExtendedId; ?>',
                                                '<?php #echo $productExtendedId; ?>',
                                                '<?php #echo $serviceFeePercent; ?>',
                                                '<?php #echo $serviceFeeAmount; ?>',
                                            )"
                                        >
                                            <i class="fa fa-plus"></i>
                                        </span> -->
                                        <span class='checkout-table__number-of-products' id="quantity<?php echo $productExtendedId; ?>">
                                            <span class="quantity">Quantity:&nbsp;</span>
                                            <?php echo $product['quantity'][0]; ?>
                                        </span>
                                        <!-- <span
                                            class="fa-stack makeOrder"
                                            onclick="changeQuantity(
                                                false,
                                                <?php #echo $product['price'][0]; ?>,
                                                'quantity<?php #echo $productExtendedId; ?>',
                                                'amount<?php #echo $productExtendedId; ?>',
                                                'serviceFee',
                                                'totalAmount',
                                                'orderExtended<?php #echo $productExtendedId; ?>',
                                                '<?php #echo $productExtendedId; ?>',
                                                '<?php #echo $serviceFeePercent; ?>',
                                                '<?php #echo $serviceFeeAmount; ?>',
                                            )"
                                            >
                                            <i class="fa fa-minus"></i>
                                        </span> -->
                                        <input
                                            type="number"
                                            min="0"
                                            step="1"
                                            name="orderExtended[<?php echo $productExtendedId; ?>][quantity]"
                                            id = "orderExtended<?php echo $productExtendedId; ?>"
                                            value="<?php echo $product['quantity'][0]; ?>"
                                            required hidden
                                        />
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
                                            data-service-fee-percent = "<?php echo $serviceFeePercent; ?>"
                                            data-service-fee-amount = "<?php echo $serviceFeeAmount; ?>"
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
                                style="padding-left:30px"
                                >
                                <!-- <div class='checkout-table__num-order'>
                                    <b class="counterClass"></b>
                                </div> -->
                                <div class='checkout-table__product-details'>
                                    <p>
                                        <i class="fa fa-paperclip" aria-hidden="true"></i>
                                        <?php echo $product['name'][0] . ' (' . $mainName . ')'; ?>
                                    </p>
                                    <small><?php echo $product['category'][0]; ?></small>
                                </div>
                                <div class='checkout-table__numbers'>
                                    <div class="checkout-table__quantity">
                                        <!-- <span
                                            class="fa-stack makeOrder"
                                            onclick="changeQuantity(
                                                true,
                                                <?php #echo $product['price'][0]; ?>,
                                                'quantity<?php #echo $productExtendedId; ?>',
                                                'amount<?php #echo $productExtendedId; ?>',
                                                'serviceFee',
                                                'totalAmount',
                                                'orderExtended<?php #echo $productExtendedId; ?>',
                                                '<?php #echo $productExtendedId; ?>',
                                                '<?php #echo $serviceFeePercent; ?>',
                                                '<?php #echo $serviceFeeAmount; ?>',
                                                '<?php #echo $mainExtendedId; ?>'
                                            )"
                                        >
                                            <i class="fa fa-plus"></i>
                                        </span> -->
                                        <span class='checkout-table__number-of-products' id="quantity<?php echo $productExtendedId; ?>">
                                            <span class="quantity">Quantity:&nbsp;</span>
                                            <?php echo $product['quantity'][0]; ?>
                                        </span>
                                        <!-- <span
                                            class="fa-stack makeOrder"
                                            onclick="changeQuantity(
                                                false,
                                                <?php #echo $product['price'][0]; ?>,
                                                'quantity<?php #echo $productExtendedId; ?>',
                                                'amount<?php #echo $productExtendedId; ?>',
                                                'serviceFee',
                                                'totalAmount',
                                                'orderExtended<?php #echo $productExtendedId; ?>',
                                                '<?php #echo $productExtendedId; ?>',
                                                '<?php #echo $serviceFeePercent; ?>',
                                                '<?php #echo $serviceFeeAmount; ?>',
                                                '<?php #echo $mainExtendedId; ?>'
                                            )"
                                        >
                                            <i class="fa fa-minus"></i>
                                        </span> -->
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
                                            data-service-fee-percent = "<?php echo $serviceFeePercent; ?>"
                                            data-service-fee-amount = "<?php echo $serviceFeeAmount; ?>"
                                            onclick="removeElement(this)"
                                        >
                                        </i>
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
