<main class="container" style="text-align:left">
    <?php if (!empty($categoryProducts) ) { ?>
        <h1>Make an order</h1>
        <div class="main-slider container" style='overflow-x:hidden; overflow-y: hidden; margin-top: 20px; margin-bottom: 20px'>
            <?php
                $form = '';
                $productsHtml = '';
                foreach($categoryProducts as $category => $products) {
                    ?>
                 
                        <div class="item-category">
                            <div class="filter-sidebar">
                            <a href="javascript:void(0);" class="go-category left-side selected"><?php echo $category;?></a>
                            </div>
                            <?php foreach ($products as $product) { ?>
                                <div class="product__list">
                                    <div class="product">
                                        <div class="product__img">
                                            <!-- <img src="https://tiqs.com/shop/attachments/shop_images/Heinikentap.jpg" alt="Heineken tap (25cl)"> -->
                                        </div>
                                        <div class="product__actions">
                                            <div class="product__actions-box">
                                                <div class="pab pab-1">
                                                    <div class="product__name">
                                                        <?php echo $product['name']; ?>
                                                        <span
                                                            id="showOrderedQuantity<?php echo $product['productExtendedId']; ?>"
                                                            style=
                                                            "display: inline-flex;
                                                            justify-content: center;
                                                            align-items: center;
                                                            font-size: 18px;
                                                            border: 2px solid #ff4f00;
                                                            height: 30px;
                                                            width: 30px;
                                                            border-radius: 100px;"
                                                            >
                                                            <?php echo (isset($ordered[$product['productExtendedId']])) ? $ordered[$product['productExtendedId']]['quantity'][0] : '0'; ?>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="solo_price">
                                                            &euro;<span><?php echo $product['price']; ?></span>
                                                        </span>
                                                    </div>
                                                    <!-- <div class="button">
                                                        <a href="#">Options <i class="fa fa-list"></i></a>
                                                    </div> -->
                                                </div>
                                                <div class="pab pab-2">
                                                    <a
                                                        class="pab-minus"
                                                        href="javascript:void(0);"
                                                        onclick="addToOrder(
                                                            'amount<?php echo  $product['productExtendedId']; ?>',
                                                            'quantity<?php echo $product['productExtendedId']; ?>',                            
                                                            '<?php echo filter_var($product['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>',
                                                            'orderAmount',
                                                            'orderQuantity',
                                                            'category<?php echo  $product['productExtendedId']; ?>',
                                                            'name<?php echo  $product['productExtendedId']; ?>',
                                                            'shortDescription<?php echo  $product['productExtendedId']; ?>',
                                                            'productPrice<?php echo  $product['productExtendedId']; ?>',
                                                            'showOrderedQuantity<?php echo $product['productExtendedId']; ?>',
                                                            false
                                                        )"
                                                        >
                                                        <i class="fa fa-minus"></i>
                                                    </a>
                                                    <a
                                                        class="pab-plus refresh-me add-to-cart"
                                                        style="margin-top: 4px"
                                                        data-id="7"
                                                        href="javascript:void(0);"
                                                        onclick="addToOrder(
                                                            'amount<?php echo  $product['productExtendedId']; ?>',
                                                            'quantity<?php echo  $product['productExtendedId']; ?>',
                                                            '<?php echo filter_var($product['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>',
                                                            'orderAmount',
                                                            'orderQuantity',
                                                            'category<?php echo  $product['productExtendedId']; ?>',
                                                            'name<?php echo  $product['productExtendedId']; ?>',
                                                            'shortDescription<?php echo  $product['productExtendedId']; ?>',
                                                            'productPrice<?php echo  $product['productExtendedId']; ?>',
                                                            'showOrderedQuantity<?php echo $product['productExtendedId']; ?>',
                                                            true
                                                        )"
                                                        >
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    $form .= '<input type="number" ';
                                    $form .= (isset($ordered[$product['productExtendedId']])) ? 'value="' .  $ordered[$product['productExtendedId']]['amount'][0] . '" ' : 'value="0" '; 
                                    $form .= 'min="0" step="0.01" ';
                                    $form .= 'name="' . $product['productExtendedId'] . '[amount][]" ';
                                    $form .= 'id="amount' . $product['productExtendedId'] . '" class="hideInput" ';
                                    $form .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                                    $form .= '<input type="number" ';
                                    $form .= (isset($ordered[$product['productExtendedId']])) ? 'value="' .  $ordered[$product['productExtendedId']]['quantity'][0] . '" ' : 'value="0" '; 
                                    $form .= 'min="0" step="1" ';
                                    $form .= 'name="' . $product['productExtendedId'] . '[quantity][]" ';
                                    $form .= 'id="quantity' . $product['productExtendedId'] . '" class="hideInput" ';
                                    $form .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                                    $form .= '<input type="text" readonly ';
                                    $form .= 'name="' . $product['productExtendedId'] . '[category][]" ';
                                    $form .= 'id="category' . $product['productExtendedId'] . '" ';
                                    $form .= 'value="' . $product['category'] . '" class="hideInput" ';
                                    $form .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                                    $form .= '<input type="text"  readonly ';
                                    $form .= 'name="' . $product['productExtendedId'] . '[name][]" ';
                                    $form .= 'id="name' . $product['productExtendedId'] . '" ';
                                    $form .= 'value="' . $product['name'] . '" class="hideInput" ';
                                    $form .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                                    $form .= '<input type="text"  readonly ';
                                    $form .= 'name="' . $product['productExtendedId'] . '[shortDescription][]" ';
                                    $form .= 'id="shortDescription' . $product['productExtendedId'] . '" ';
                                    $form .= 'value="' . $product['shortDescription'] . '" class="hideInput" ';
                                    $form .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                                    $form .= '<input type="text"  readonly ';
                                    $form .= 'name="' . $product['productExtendedId'] . '[price][]" ';
                                    $form .= 'id="productPrice' . $product['productExtendedId'] . '" ';
                                    $form .= 'value="' . filter_var($product['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . '" class="hideInput" ';
                                    $form .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                                ?>
                            <?php } ?>
                        </div>
                    <?php
                }
            ?>
        </div>
        <?php if (isset($form)) { ?>
            <!-- footer basket -->
            <div class="footer-basket">
                <div class="footer-top">
                    <div class="fb-left">
                        <h4>Your Basket</h4>
                        <h5>Your order 
                            <?php
                                $orderedQuantity = 0;
                                $orderedAmount = 0;
                                if (isset($ordered)) {
                                    foreach ($ordered as $id => $data) {
                                        $orderedQuantity = $orderedQuantity + intval($data['quantity'][0]);
                                        $orderedAmount = $orderedAmount + floatval($data['amount'][0]);
                                    }
                                }
                            ?>
                            <span id="orderQuantity"><?php echo $orderedQuantity; ?></span>
                        </h5>
                    </div>
                    <div class="fb-mid">
                        <span class="fb-price">€  <span id="orderAmount"><?php echo number_format($orderedAmount, 2, '.', ',') ; ?></span></span>
                    </div>

                    <div class="fb-right" id="submitForm" onclick="submitMakeOrderForm('makeOrder', 'orderAmount', 'orderQuantity')">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="footer-order">
                    <div class="cart">
                    </div>
                </div>
                <div class="footer-bot">
                    <form method="post" id="makeOrder" action="<?php echo base_url() . 'checkout_order' ?>"> 
                        <input type="text" name="spotId" value="<?php echo $spotId; ?>" readonly required hidden />
                        <?php echo $form; ?>
                    </form>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="container" style='overflow-x:hidden; overflow-y: hidden; margin-top: 20px; margin-bottom: 20px'>
            <h1>Sorry!</h1>
            <p>No available products</p>
        </div>
    <?php } ?>
</main>