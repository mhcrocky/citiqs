<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if($vendor['vendorId'] == 1162 ){?>
<body style="background-color: white">
<?php } else {?>
<body style="background-color: navajowhite">
<?php } ?>

<?php if($vendor['vendorId'] == 1162 ){?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/slickCss/slick.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/slickCss/slick-theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/slickCss/th_custom.css">

<?php } ?>

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

    function createAddonString($product, $mainProductExtendedId, $ordered) {
        $return = [];
        if (isset($ordered[$product['productExtendedId']]['mainProduct'][$mainProductExtendedId])) {
            $orderedProduct = $ordered[$product['productExtendedId']]['mainProduct'][$mainProductExtendedId];
            $return['mainProductExtendedId'] = $mainProductExtendedId;
        }

        $addons = '';
        $type = strtoupper($product['productType']);

		if ($product['longDescription']!= 'NA') {
			$longDescription = '<i class="fa fa-info-circle" aria-hidden="true" data-toggle="popover" data-trigger="hover"  data-placement="bottom" data-content="' . $product['longDescription'] . '"></i>';
		} else {
			$longDescription = '';
		}

        // if ($product['longDescription']) {
        //     $longDescription = '<i class="fa fa-info-circle" aria-hidden="true" data-toggle="popover" data-trigger="hover"  data-placement="bottom" data-content="' . $product['longDescription'] . '"></i>';
        // } else {
        //     $longDescription = '';
        // }


            
        $formElement = '';
        $addons .= 
            "
            <div class='product__list'>
                <div class='product'>
                    <div class='product__img'></div>
                    <div class='product__actions'>
                        <div class='product__actions-box'>
                            <div class='pab pab-1'>
                                <div class='product__name'>
                                    {$product['name']} <span style='font-size:12px;'>({$type})</span>
                                    {$longDescription}
                                    <span
                                        id='showOrderedQuantity{$product['productExtendedId']}_{$mainProductExtendedId}'
                                        style=\"
                                            display: inline-flex;
                                            justify-content: center;
                                            align-items: center;
                                            font-size: 18px;
                                            border: 2px solid #6c6c6a;
                                            height: 30px;
                                            width: 30px;
                                            border-radius: 100px;\"
                                        >";
                                        $addons .= (isset( $orderedProduct['quantity'][0])) ? $orderedProduct['quantity'][0] : '0';
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
                                        \"productPrice{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                        \"showOrderedQuantity{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                        \"productId{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                        false
                                    )'
                                    >
                                    <i class='fa fa-minus' style></i>
                                </a>
                                <a
                                    class='pab-plus refresh-me add-to-cart'
                                    style=''
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
                                        \"productPrice{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                        \"showOrderedQuantity{$product['productExtendedId']}_{$mainProductExtendedId}\",
                                        \"productId{$product['productExtendedId']}_{$mainProductExtendedId}\",
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
        $formElement .= (isset($orderedProduct['amount'][0])) ? 'value="' .  $orderedProduct['amount'][0] . '" ' : 'value="0" '; 
        $formElement .= 'min="0" step="0.01" ';
        $formElement .= 'name="' . $product['productExtendedId'] . '[mainProduct][' . $mainProductExtendedId . '][amount][]" ';
        $formElement .= 'id="amount' . $product['productExtendedId'] . '_' . $mainProductExtendedId . '" class="hideInput" ';
        $formElement .= (isset($orderedProduct)) ? '/>' : 'disabled />';

        $formElement .= '<input type="number" ';
        $formElement .= (isset($orderedProduct['quantity'][0])) ? 'value="' .  $orderedProduct['quantity'][0] . '" ' : 'value="0" '; 
        $formElement .= 'min="0" step="1" ';
        $formElement .= 'name="' . $product['productExtendedId'] . '[mainProduct][' . $mainProductExtendedId . '][quantity][]" ';
        $formElement .= 'id="quantity' . $product['productExtendedId'] . '_' . $mainProductExtendedId . '" class="hideInput" ';
        $formElement .= (isset($orderedProduct)) ? '/>' : 'disabled />';
        $formElement .= '<input type="text" readonly ';
        $formElement .= 'name="' . $product['productExtendedId'] . '[mainProduct][' . $mainProductExtendedId . '][category][]" ';
        $formElement .= 'id="category' . $product['productExtendedId'] . '_' . $mainProductExtendedId . '" ';
        $formElement .= 'value="' . $product['category'] . '" class="hideInput" ';
        $formElement .= (isset($orderedProduct)) ? '/>' : 'disabled />';
        $formElement .= '<input type="text"  readonly ';
        $formElement .= 'name="' . $product['productExtendedId'] . '[mainProduct][' . $mainProductExtendedId . '][name][]" ';
        $formElement .= 'id="name' . $product['productExtendedId'] . '_' . $mainProductExtendedId . '" ';
        $formElement .= 'value="' . $product['name'] . '" class="hideInput" ';
        $formElement .= (isset($orderedProduct)) ? '/>' : 'disabled />';
        // $formElement .= '<input type="text"  readonly ';
        // $formElement .= 'name="' . $product['productExtendedId'] . '[mainProduct][' . $mainProductExtendedId . '][shortDescription][]" ';
        // $formElement .= 'id="shortDescription' . $product['productExtendedId'] . '_' . $mainProductExtendedId . '" ';
        // $formElement .= 'value="' . $product['shortDescription'] . '" class="hideInput" ';
        // $formElement .= (isset($orderedProduct)) ? '/>' : 'disabled />';
        $formElement .= '<input type="text"  readonly ';
        $formElement .= 'name="' . $product['productExtendedId'] . '[mainProduct][' . $mainProductExtendedId . '][price][]" ';
        $formElement .= 'id="productPrice' . $product['productExtendedId'] . '_' . $mainProductExtendedId . '" ';
        $formElement .= 'value="' . filter_var($product['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . '" class="hideInput" ';
        $formElement .= (isset($orderedProduct)) ? '/>' : 'disabled />';

        $formElement .= '<input type="text"  readonly ';
        $formElement .= 'name="' . $product['productExtendedId'] . '[mainProduct][' . $mainProductExtendedId . '][productId][]" ';
        $formElement .= 'id="productId' . $product['productExtendedId'] . '_' . $mainProductExtendedId . '" ';
        $formElement .= 'value="' . $product['productId'] . '" class="hideInput" ';
        $formElement .= (isset($orderedProduct)) ? '/>' : 'disabled />';

        $return['addons'] = $addons;
        $return['form'] = $formElement;
        return $return;
    }

?>

<?php if($vendor['vendorId'] == 1162 ){?>
<main class="container" style="text-align:left; background-color: white">
<?php } else {?>
<main class="container" style="text-align:left; background-color: navajowhite">
<?php } ?>


    <?php 
        // include_once FCPATH . 'application/views/includes/sessionMessages.php';
    ?>
    <?php if (!empty($categoryProducts) ) { ?>
<!--		--><?php //echo $vendor['logo']; ?>
<!--        <h1>--><?php //echo $vendor['vendorName']; ?><!--</h1>-->
<!--		https://tiqs.com/alfred/assets/images/vendorLogos/1162_1595838163.png -->
		<div style="text-align:center">
			<img src=<?php echo "https://tiqs.com/alfred/assets/images/vendorLogos/".$vendor['logo']; ?> alt="" width="300" height="auto">
		</div>

<!--		<div style="text-align:right; padding-top:5px;">-->
<!--			<a href="--><?php //echo base_url() ?><!--make_order?vendorid=--><?php //echo $vendor['vendorId']; ?><!--">-->
<!--				<i aria-hidden="true">CHANGE SPOT</i>-->
<!--			</a>-->
<!--		</div>-->

		<h5 style="text-align:center; font-size: xx-small">SWIPE &lt; LINKS EN RECHTS &gt; VOOR ANDERE CATEGORIE</h5>

		<?php if($vendor['vendorId'] == 1162 ){?>
			<div class="main-slider container" style='overflow-x:hidden; overflow-y: hidden; margin-top: 20px; margin-bottom: 20px; background-color: white'>
		<?php } else {?>
			<div class="main-slider container" style='overflow-x:hidden; overflow-y: hidden; margin-top: 20px; margin-bottom: 20px; background-color: navajowhite'>
		<?php } ?>

		    <?php
                $form = '';
                foreach($categoryProducts as $category => $productsRawData) {
                    $productsRawData =  Utility_helper::resetArrayByKeyMultiple($productsRawData, 'productId');
                ?>
                    <div class="item-category">
                        <div class="filter-sidebar">
							<?php if($vendor['vendorId'] == 1162 ){?>
								<a href="javascript:void(0);"  style="color: black; background-color: white" class="go-category left-side selected"><?php echo $category;?></a>
							<?php } else {?>
								<a href="javascript:void(0);"  style="color: black; background-color: navajowhite" class="go-category left-side selected"><?php echo $category;?></a>
							<?php } ?>
                        </div>
                        <?php
                            foreach($productsRawData as $productId => $productRaw) {
                                
                                $productRaw = reset($productRaw);
                                if (
                                    $productRaw['productActive'] === '0'
                                    || is_null($productRaw['productTimes'])
                                    || !checkTime($day, $hours, $productRaw['productTimes'])
                                    || !is_array($productRaw['productSpots'])
                                    || !in_array($spotId, array_keys($productRaw['productSpots']))
                                ) continue;
                                $products = $productRaw['productDetails'];
                                $products = Utility_helper::resetArrayByKeyMultiple($products, 'productTypeIsMain');
                                
                                if (!isset($products[1])) continue;

                                $product = $products[1][0];

                                if ($product['showInPublic'] === '0') continue;

                                $form .= '<input type="number" ';
                                $form .= (isset( $ordered[$product['productExtendedId']]['amount'][0])) ? 'value="' .  $ordered[$product['productExtendedId']]['amount'][0] . '" ' : 'value="0" '; 
                                $form .= 'min="0" step="0.01" ';
                                $form .= 'name="' . $product['productExtendedId'] . '[amount][]" ';
                                $form .= 'id="amount' . $product['productExtendedId'] . '" class="hideInput" ';
                                $form .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                                $form .= '<input type="number" ';
                                $form .= (isset($ordered[$product['productExtendedId']]['quantity'][0])) ? 'value="' .  $ordered[$product['productExtendedId']]['quantity'][0] . '" ' : 'value="0" '; 
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
                                // $form .= '<input type="text"  readonly ';
                                // $form .= 'name="' . $product['productExtendedId'] . '[shortDescription][]" ';
                                // $form .= 'id="shortDescription' . $product['productExtendedId'] . '" ';
                                // $form .= 'value="' . $product['shortDescription'] . '" class="hideInput" ';
                                // $form .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';
                                $form .= '<input type="text"  readonly ';
                                $form .= 'name="' . $product['productExtendedId'] . '[price][]" ';
                                $form .= 'id="productPrice' . $product['productExtendedId'] . '" ';
                                $form .= 'value="' . filter_var($product['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) . '" class="hideInput" ';
                                $form .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';   
                                $form .= '<input type="text"  readonly ';
                                $form .= 'name="' . $product['productExtendedId'] . '[productId][]" ';
                                $form .= 'id="productId' . $product['productExtendedId'] . '" ';
                                $form .= 'value="' . $productId . '" class="hideInput" ';
                                $form .= (isset($ordered[$product['productExtendedId']])) ? '/>' : 'disabled />';   

                                $mainProductExtendedId = $product['productExtendedId'];                                     

                                
                                ?>

								<?php if($vendor['vendorId'] == 1162 ){?>
									<div class="product__list" style="background-color: white">
								<?php } else {?>
									<div class="product__list" style="background-color: navajowhite">
								<?php } ?>



                                    <div class="product">
                                        <div class="product__img">
                                            <!-- <img src="https://tiqs.com/shop/attachments/shop_images/Heinikentap.jpg" alt="Heineken tap (25cl)"> -->
                                        </div>
                                        <div class="product__actions">
                                            <div class="product__actions-box">
                                                <div class="pab pab-1">
                                                    <div class="product__name">
														<?php if ($product['longDescription']!= 'NA') { ?>
															<i style="font-size: large; margin-bottom: -30px" class="fa fa-info-circle" aria-hidden="true" data-toggle="popover" data-trigger="hover"  data-placement="bottom" data-content="<?php echo $product['longDescription']; ?>"></i>
														<?php } ?>
                                                        <?php echo $product['name']; ?>

                                                        <span
                                                            id="showOrderedQuantity<?php echo $product['productExtendedId']; ?>"
                                                            style=
                                                            "display: inline-flex;
                                                            color: #6c6c6a;
                                                            justify-content: center;
                                                            align-items: center;
                                                            font-size: 18px;
                                                            border: 2px solid #6c6c6a;
                                                            height: 30px;
                                                            width: 30px;
                                                            border-radius: 100px;"
                                                            >
                                                            <?php echo (isset($ordered[$product['productExtendedId']]['quantity'][0])) ? $ordered[$product['productExtendedId']]['quantity'][0] : '0'; ?>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="solo_price">
                                                            &euro;<span><?php echo $product['price']; ?></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="pab pab-2">
                                                    <?php if (!is_null($productRaw['addons'])) { ?>
                                                        <a
                                                            class="pab-options"
                                                            href="javascript:void(0);"
                                                            onclick="showAddOns('addOns<?php echo $product['productExtendedId']; ?>')"
                                                            id="toogleAddons<?php echo $product['productExtendedId']; ?>"
                                                            >
                                                            <i class="fa fa-chevron-down" > </i>
                                                        </a>
                                                    <?php } ?>
                                                    <a
                                                        class="pab-minus"
														style="margin-left: 4px"
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
                                                            'productId<?php echo $product['productExtendedId']; ?>',
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
                                                            'productId<?php echo $product['productExtendedId']; ?>',
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
                                <div class="addOns<?php echo $product['productExtendedId']; ?> addOnsFill" id="addons<?php echo $mainProductExtendedId;?>" style="display:none; margin: 0px 7%; height: auto">
                                    <?php
                                        if (!is_null($productRaw['addons'])) {
                                            $toogle = false;
                                            $addons = $productRaw['addons'];
                                            if ($addons) {
                                                foreach($addons as $addon) {
                                                    if (
                                                        !is_array($productsRawData[$addon[1]][0]['productSpots'])
                                                        || !in_array($spotId, array_keys($productsRawData[$addon[1]][0]['productSpots']))
                                                    ) continue;
                                                    $addonDetails = $productsRawData[$addon[1]][0]['productDetails'];
                                                    foreach($addonDetails as $addonSingle) {
                                                        if ($addonSingle['showInPublic'] === '1' && $addonSingle['productExtendedId'] === $addon[2] && $addonSingle['activeStatus'] === '1') {
                                                            if (!$toogle) $toogle = true;
                                                            $strings = createAddonString($addonSingle, $mainProductExtendedId, $ordered);
                                                            if (isset($strings['mainProductExtendedId'])) {
                                                                ?>
                                                                    <script>
                                                                        document.getElementById('addons<?php echo $strings['mainProductExtendedId']; ?>').style.display = 'block';
                                                                    </script>
                                                                <?php
                                                            }
                                                            echo $strings['addons'];
                                                            $form .= $strings['form'];
                                                        }
                                                    }
                                                }
                                            }

                                            if (!$toogle) {
                                                ?>
                                                    <script>
                                                        document.getElementById("toogleAddons<?php echo $product['productExtendedId']; ?>").style.display = 'none';
                                                    </script>
                                                <?php
                                            }
                                        }
                                    ?>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                <?php
                }
            ?>
            <?php if (isset($termsAndConditions) && $termsAndConditions) { ?>
                <div class="item-category">
                    <div class="filter-sidebar">
                        <a href="javascript:void(0);" class="go-category left-side selected">INFO</a>
                    </div>
                    <div class="product__list">
                        <?php echo $termsAndConditions; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if ($form) { ?>
            <!-- footer basket -->
            <div class="footer-basket">
        
                <div class="footer-top">
					<?php if ($vendor['requireReservation'] === '1' ) { ?>
						<a href="<?php echo base_url(); ?>check424/<?php echo $vendor['vendorId']; ?>" style="margin-left:10px">
							<i style="font-size: 40px;color: white" class="fa fa-home"></i>
						</a>
					<?php } ?>
                    <div class="fb-left">

						<!--                        <h4>Your Basket</h4>-->
                        <h5 onclick="submitMakeOrderForm('makeOrder', 'orderAmount', 'orderQuantity')" >Betaal
                            <?php
                                $orderedQuantity = 0;
                                $orderedAmount = 0;
                                if (isset($ordered)) {
                                    foreach ($ordered as $id => $data) {
                                        if (isset($data['mainProduct']))  {
                                            $data = reset($data['mainProduct']);
                                        }
                                        $orderedQuantity = (isset($data['quantity'][0])) ? $orderedQuantity + intval($data['quantity'][0]) : $orderedQuantity;
                                        $orderedAmount = (isset($data['amount'][0])) ? $orderedAmount + floatval($data['amount'][0]) : $orderedAmount;
                                    }
                                }
                            ?>
                            <span id="orderQuantity"><?php echo $orderedQuantity; ?></span>
                        </h5>
                    </div>
                    <div class="fb-mid submitOrder" onclick="submitMakeOrderForm('makeOrder', 'orderAmount', 'orderQuantity')">
                        <span class="fb-price">€  <span id="orderAmount"><?php echo number_format($orderedAmount, 2, '.', ',') ; ?></span></span>
                    </div>

                    <div class="fb-right submitOrder" onclick="submitMakeOrderForm('makeOrder', 'orderAmount', 'orderQuantity')">
                        <i style="font-size: 40px" class="fa fa-credit-card-alt"></i>

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
<script>
    var makeOldOrderGlobals = (function(){
        let askId = '<?php echo THGROUP; ?>';
        let vendorId = '<?php echo $vendor['vendorId'] ?>';
        let condition = (askId === vendorId) ? true : false;

        let globals = {
            'thGroup': condition,
        }
        Object.freeze(globals);
        return globals;        
    }());
</script>