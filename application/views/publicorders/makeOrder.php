<?php
    function checkTime(string $day, string $hours, array $productTimes): bool
    {
        if ( !in_array($day, array_keys($productTimes)) ) {
            return false;
        }

        $dayTimes = $productTimes[$day];

        foreach($dayTimes as $times) {
            $from = strtotime($times[2]);
            $to = strtotime($times[3]);
            if ($from < $hours && $hours < $to) {
                return true;
            }
        }

        return false;
    }

    function getAddonsAndFromString($addons, $formElement, $mainProductExtendedId)
    {
        
        $addons = str_replace('_REPLACE_WITH_MAIN_PRODUCT_EXTENDED_ID', $mainProductExtendedId, $addons);
        $form = str_replace('_REPLACE_WITH_MAIN_PRODUCT_EXTENDED_ID', $mainProductExtendedId, $formElement);

        return [
            'addons' => $addons,
            'form' => $form,
        ];
    }
  
    $addons = '';
    $formElement = '';

    foreach($categoryProducts as $category => $productsRawData) {
        foreach($productsRawData as $productRaw) {
            if (!checkTime($day, $hours, $productRaw['productTimes'])) continue;
            $products = $productRaw['productDetails'];
            $products = Utility_helper::resetArrayByKeyMultiple($products, 'productTypeIsMain');
            $mainProductExtendedId = '_REPLACE_WITH_MAIN_PRODUCT_EXTENDED_ID';


            $addonsArray = $products[0];

            foreach ($addonsArray as $product) {
                if ($product['showInPublic'] === '1') {
                    $addons .= 
                        "
                        <div class='product__list'>
                            <div class='product'>
                                <div class='product__img'></div>
                                <div class='product__actions'>
                                    <div class='product__actions-box'>
                                        <div class='pab pab-1'>
                                            <div class='product__name'>
                                                {$product['name']}
                                                <span
                                                    id='showOrderedQuantity{$product['productExtendedId']}_{$mainProductExtendedId}'
                                                    style=\"
                                                        display: inline-flex;
                                                        justify-content: center;
                                                        align-items: center;
                                                        font-size: 18px;
                                                        border: 2px solid #ff4f00;
                                                        height: 30px;
                                                        width: 30px;
                                                        border-radius: 100px;\"
                                                    >";
                                                    $addons .= (isset($ordered[$product['productExtendedId']])) ? $ordered[$product['productExtendedId']]['quantity'][0] : '0';
                                                    $addons .= 
                                                "</span>
                                            </div>
                                            <div>
                                                <span class='solo_price'>
                                                        &euro;<span>{$product['price']}</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class='pab pab-2'>
                                            <a
                                                class='pab-minus'
                                                href='javascript:void(0);'
                                                onclick='addToOrder(
                                                    \"amount{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                                    \"quantity{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                                    \"" . filter_var($product['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "\",
                                                    \"orderAmount\",
                                                    \"orderQuantity\",
                                                    \"category{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                                    \"name{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                                    \"shortDescription{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                                    \"productPrice{$product['productExtendedId']}\",
                                                    \"showOrderedQuantity{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                                    false
                                                )'
                                                >
                                                <i class='fa fa-minus'></i>
                                            </a>
                                            <a
                                                class='pab-plus refresh-me add-to-cart'
                                                style='margin-top: 4px'
                                                href='javascript:void(0);'
                                                onclick='addToOrder(
                                                    \"amount{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                                    \"quantity{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                                    \"" . filter_var($product['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . "\",
                                                    \"orderAmount\",
                                                    \"orderQuantity\",
                                                    \"category{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                                    \"name{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                                    \"shortDescription{$product['productExtendedId']}\",
                                                    \"productPrice{$product['productExtendedId']}\",
                                                    \"showOrderedQuantity{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                                    true
                                                )'
                                            >
                                                <i class='fa fa-plus'></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ";

                    $formElement .= '<input type="number" ';
                    $formElement .= (isset($ordered[$product['productExtendedId']])) ? 'value="' .  $ordered[$product['productExtendedId']]['amount'][0] . '" ' : 'value="0" '; 
                    $formElement .= 'min="0" step="0.01" ';
                    $formElement .= 'name="' . $product['productExtendedId'] . '[mainProduct][' . $mainProductExtendedId . '][amount][]" ';
                    $formElement .= 'id="amount' . $product['productExtendedId'] . '_' . $mainProductExtendedId . '" class="hideInput" ';
                    $formElement .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                    $formElement .= '<input type="number" ';
                    $formElement .= (isset($ordered[$product['productExtendedId']])) ? 'value="' .  $ordered[$product['productExtendedId']]['quantity'][0] . '" ' : 'value="0" '; 
                    $formElement .= 'min="0" step="1" ';
                    $formElement .= 'name="' . $product['productExtendedId'] . '[mainProduct][' . $mainProductExtendedId . '][quantity][]" ';
                    $formElement .= 'id="quantity' . $product['productExtendedId'] . '_' . $mainProductExtendedId . '" class="hideInput" ';
                    $formElement .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                    $formElement .= '<input type="text" readonly ';
                    $formElement .= 'name="' . $product['productExtendedId'] . '[mainProduct][' . $mainProductExtendedId . '][category][]" ';
                    $formElement .= 'id="category' . $product['productExtendedId'] . '_' . $mainProductExtendedId . '" ';
                    $formElement .= 'value="' . $category . '" class="hideInput" ';
                    $formElement .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                    $formElement .= '<input type="text"  readonly ';
                    $formElement .= 'name="' . $product['productExtendedId'] . '[mainProduct][' . $mainProductExtendedId . '][name][]" ';
                    $formElement .= 'id="name' . $product['productExtendedId'] . '_' . $mainProductExtendedId . '" ';
                    $formElement .= 'value="' . $product['name'] . '" class="hideInput" ';
                    $formElement .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                    $formElement .= '<input type="text"  readonly ';
                    $formElement .= 'name="' . $product['productExtendedId'] . '[mainProduct][' . $mainProductExtendedId . '][shortDescription][]" ';
                    $formElement .= 'id="shortDescription' . $product['productExtendedId'] . '_' . $mainProductExtendedId . '" ';
                    $formElement .= 'value="' . $product['shortDescription'] . '" class="hideInput" ';
                    $formElement .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                    $formElement .= '<input type="text"  readonly ';
                    $formElement .= 'name="' . $product['productExtendedId'] . '[mainProduct][' . $mainProductExtendedId . '][price][]" ';
                    $formElement .= 'id="productPrice' . $product['productExtendedId'] . '_' . $mainProductExtendedId . '" ';
                    $formElement .= 'value="' . filter_var($product['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . '" class="hideInput" ';
                    $formElement .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                }
                

            }
                
        }
    }
?>
<main class="container" style="text-align:left">
    <?php 
        // include_once FCPATH . 'application/views/includes/sessionMessages.php';
    ?>
    <?php if (!empty($categoryProducts) ) { ?>
        <h1>Make an order</h1>
        <div class="main-slider container" style='overflow-x:hidden; overflow-y: hidden; margin-top: 20px; margin-bottom: 20px'>
            <?php
                    $form = '';
                    foreach($categoryProducts as $category => $productsRawData) {
                    ?>
                        <div class="item-category">
                            <div class="filter-sidebar">
                                <a href="javascript:void(0);" class="go-category left-side selected"><?php echo $category;?></a>
                            </div>
                            <?php

                                foreach($productsRawData as $productRaw) {
                                    if (!checkTime($day, $hours, $productRaw['productTimes'])) continue;
                                    $products = $productRaw['productDetails'];
                                    // foreach($products as $product) {
                                        $products = Utility_helper::resetArrayByKeyMultiple($products, 'productTypeIsMain');
                                        #var_dump($products);
                                        $product = $products[1][0];
                                        $mainProductExtendedId = $product['productExtendedId'];                                    
                                        ?>
                                            <?php 
                                                // echo '<pre>';
                                                // print_r($product);
                                                // echo '</pre>';
                                                // var_dump($product['productExtendedId']);
                                            ?>
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
                                                            </div>
                                                            <div class="pab pab-2">
                                                                <a
                                                                    class="pab-minus"
                                                                    href="javascript:void(0);"
                                                                    onclick="showAddOns('addOns<?php echo $product['productExtendedId']; ?>')"
                                                                    
                                                                    >
                                                                    <i class="fa fa-chevron-down"></i>
                                                                </a>
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
                                            <div
                                                class="addOns<?php echo $product['productExtendedId']; ?> addOnsFill"
                                                style="display:none; margin: 0px 7%"
                                                >                                                
                                                    <?php
                                                        $strings = getAddonsAndFromString($addons, $formElement, $mainProductExtendedId);
                                                        echo $strings['addons'];
                                                    ?>
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
                                                $form .= 'value="' . $category . '" class="hideInput" ';
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
                                                $form .= $strings['form'];
                                            ?>
                                        <?php

                                         
                                        
                                }
                            ?>
                        </div>
                    <?php
                }
            ?>
        </div>
        <?php if ($form) { ?>
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
