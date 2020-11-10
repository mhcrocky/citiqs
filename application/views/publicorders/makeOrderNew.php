<div class="container shop-container selectedSpotBackground" style="width:100%">
    <div class="row selectedSpotBackground">
        <?php if (!empty($mainProducts)) { ?>        	
			    <?php if ($vendor['logo']) { ?>
					<div id="vendorLogo" style="text-align:center" >
						<img src=<?php echo base_url() . 'assets/images/vendorLogos/' . $vendor['logo']; ?> alt="" width="100%" height="auto" />
					</div>
				<?php }?>
            <?php
                if ($vendor['showMenu'] === '1') {
                    $categories = array_keys($mainProducts);
                    $categoryList = '<ul class="list-group categoryNav selectedSpotBackground">';
                    $count = 0;
                    foreach ($categories as $categoryName) {
                        $count++;
                        $categoryList .= '<li class="list-group-item selectedSpotBackground">';
                        $categoryList .=    '<a class="menuColor" href="#" data-index="' . $count . '">' . $categoryName . '</a>';
                        $categoryList .= '</li>';
                    }
                    $categoryList .= '</ul>';
                }              
            ?>
            <div class="selectedSpotBackground">
                <div class="col-12 col-md-8 selectedSpotBackground" id="categoryContainer" style="padding-left:0px; padding-right:0px; text-align:center">
                    <div class="items-slider selectedSpotBackground" style="margin-left:0px; margin-right:0px">
                        <?php if ($vendor['showMenu'] === '1') { ?>
                            <div class="shop__items selectedSpotBackground">
                                <div class="shop__item-list-heading" id="categoryNav">
                                    <h2 class="categoryName" style="text-align:center; text-transform: uppercase; margin-bottom:30px;">
                                        <?php echo $vendor['vendorName'] ?>
                                    </h2>
                                    <?php echo $categoryList; ?>
                                </div>
                                <!-- end item list -->
                            </div>
                        <?php } ?>
                        <?php foreach ($mainProducts as $category => $products) { ?>
                            <div class="shop__items selectedSpotBackground">
                                <div class="shop__item-list-heading" id='<?php echo $category; ?>'>
                                    <h2 class="categoryName"><?php echo $category; ?></h2>
                                </div>
                                <div class="shop__item-list selectedSpotBackground">
                                    <?php foreach ($products as $product) { ?>
                                        <?php
                                            $productDetails = reset($product['productDetails']);
                                        ?>
                                        <div class="shop__single-item">
                                            <div class="shop__single-item__info">
                                                <!-- wrapped long description and title -->
                                                <div>
                                                    <strong class='shop__single-item__info--title productName'><?php echo $productDetails['name']; ?></strong>
                                                    <?php if ($productDetails['longDescription'] && $productDetails['longDescription'] !== 'NA') { ?>
                                                        <i
                                                            style="width: 15px"
                                                            class="fa fa-info-circle infoCircle"
                                                            aria-hidden="true"
                                                            data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom"
                                                            data-content="<?php echo $productDetails['longDescription']; ?>"
                                                        ></i>
                                                    <?php } ?>
                                                </div>
                                                <?php if (trim($productDetails['name']) !== trim($productDetails['shortDescription']) ) { ?>
                                                    <p class='shop__single-item__info--description productDescription'><?php echo $productDetails['shortDescription']; ?></p>
                                                <?php } ?>
                                                <?php
                                                    $productAllergies = null;
                                                    $baseUrl = base_url();
                                                    if ($vendor['showAllergies'] === '1')  {
                                                        $product['allergies'] = unserialize($product['allergies']);
                                                        if (!empty($product['allergies']['productAllergies'])) {
                                                            $productAllergies = $product['allergies']['productAllergies'];
                                                            echo '<div class="shop__single-item__alergies">';
                                                            foreach ($productAllergies as $allergy) {
                                                                ?>
                                                                    <img
                                                                        src="<?php echo $baseUrl . 'assets/images/allergies/' . str_replace(' ', '_', $allergy); ?>.png"
                                                                        alt="<?php echo $allergy; ?>"
                                                                        height='24px'
                                                                        width='24px'
                                                                        style="display:inline; margin:5px 2px"
                                                                    />
                                                                <?php
                                                            }
                                                            echo '</div>';
                                                        }
                                                    }
                                                ?>
                                            </div>
                                            <?php if ($vendor['showProductsImages'] === '1') { ?>
                                                <div class="shop__single-item__image">
                                                    <img
                                                        <?php if ($product['productImage'] && file_exists($uploadProductImageFolder . $product['productImage'])) { ?>
                                                            src="<?php echo base_url() . 'assets/images/productImages/' . $product['productImage']; ?>"
                                                        <?php } else { ?>
                                                            src="<?php echo base_url() . 'assets/images/defaultProductsImages/' . $vendor['defaultProductsImage']; ?>"
                                                        <?php } ?>
                                                        alt="<?php echo $productDetails['name']; ?>"
                                                    />
                                                </div>
                                            <?php } ?>
                                            <!-- ADDED DIV FOR + PRICE - -->
                                            <div class='shop__single-item__cart-wrapper'>
                                                <div class="shop__single-item__price priceQuantity">
                                                    <span><?php echo $productDetails['price']; ?></span>
                                                </div>
                                                <div class="shop__single-item__quanitity-buttons">
                                                    <div
                                                        class="shop__single-item__add-to-cart priceQuantity"
                                                        <?php if ($product['addons'] || $productDetails['addRemark'] === '1') { ?>
                                                            onclick="focusOnOrderItems('<?php echo $product['productId']; ?>')"
                                                        <?php } else { ?>
                                                            onclick="trigerRemoveOrderedClick('removeOrdered_<?php echo $product['productId']; ?>')"
                                                        <?php } ?>
                                                        >
                                                        <span style="font-size:16px; vertical-align: middle; text-align:center">
                                                            <i class="fa fa-minus priceQuantity" aria-hidden="true"></i>
                                                        </span>
                                                    </div>
                                                    <div class="shop__single-item__quiantity">
                                                        <div class="shop__single-item__add-to-cart priceQuantity">
                                                            <span id="orderQuantityValue_<?php echo $product['productId']; ?>" class="countOrdered priceQuantity" style="font-size:14px;">0</span>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="shop__single-item__add-to-cart priceQuantity"
                                                        <?php if ($product['addons'] || $productDetails['addRemark'] === '1') { ?>
                                                            data-toggle="modal" data-target="#single-item-details-modal<?php echo $product['productId']; ?>"
                                                        <?php } else { ?>
                                                            onclick="triggerModalClick('modal_buuton_<?php echo 'single-item-details-modal' . $product['productId']; ?>_<?php echo $productDetails['productExtendedId']?>')"
                                                        <?php } ?>
                                                        >
                                                        <span style="font-size:16px; vertical-align: middle; text-align:center">
                                                            <i class="fa fa-plus priceQuantity" aria-hidden="true"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <!-- end quantity buttons -->
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (isset($termsAndConditions) && $termsAndConditions) { ?>
                            <div class="shop__items selectedSpotBackground">
                                <div class="shop__item-list-heading">
                                    <h2>TERMS AND CONDITIONS</h2>
                                </div>
                                <div class="shop__item-list selectedSpotBackground">
                                    <p style="padding-left:10px">
                                        <?php echo $termsAndConditions; ?>
                                    </p>
                                </div>
                                <!-- end item list -->
                            </div>
                        <?php } ?>
                    </div>
                    <!-- end slider -->
                </div>
                <!-- end left side -->
                <!-- <div class="col-12 col-md-4">
                    <div class="shopping-cart" id='shopping-cart'>
                        <h3>Items</h3>
                        <div class="shopping-cart__list" id='shopping-cart__list'>
                            <?php #echo $shoppingList; ?>
                        </div>
                        <div class="shopping-cart__total">
                                <p>Total:</p>
                                <p>&euro;&nbsp;<span class="shopping-cart__total-price totalPrice">0</span></p>
                            </div>
                        <button class='checkout-button button-main button-primary' onclick="checkout()">checkout</button>
                    </div>
                </div> -->
            </div>
            <!-- end right side -->
        <?php } else { ?>
            No available products
        <?php } ?>
    </div>
</div>
<!-- end shop container -->

<?php if (!empty($mainProducts)) { ?>
    <!-- bottom bar for smaller screens -->
    <div class='bottom-bar footer'>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 text-center text-left-md">
                    <div class="totalButton">
                        <?php if (
                                $vendor['requireReservation'] === '1'
                                && !empty($_SESSION['visitorReservationId'])
                                && intval($spotTypeId) === $localTypeId
                            ) { ?>
                            <a href="<?php echo base_url(); ?>check424/<?php echo $vendor['vendorId']; ?>" style="margin:0px 20px 0px 10px;">
                                <i style="font-size: 40px;color: white" class="fa fa-home"></i>
                            </a>
                        <?php } ?>
                        <p class='button-main button-secondary bottom-bar__checkout totalButton'>TOTAL: <span class='bottom-bar__total-price'>&euro;&nbsp;<span class="totalPrice">0</span></span> </p>
                        <!-- <button class='button-main button-secondary' onclick="focusCheckOutModal('modal__checkout__list')">Order List</button> -->
                    </div>
                </div>
                <div class="col-12 col-md-6 text-center text-right-md">
                    <button class='button-main button-secondary bottom-bar__checkout payButton' onclick="checkout()">PAY</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end bottom bar -->

    <!-- Modal checkout -->
    <?php include_once FCPATH . 'application/views/publicorders/includes/modals/makeOrderPos/checkoutModals.php'; ?>
    <!-- end modal checkout -->
    <?php include_once FCPATH . 'application/views/publicorders/includes/modals/makeOrderPos/productModals.php'; ?>
<?php } ?>

<!-- IMAGE MODAL -->
<!-- Image Modal -->
<div class="modal fade image-modal selectedSpotBackground"  tabindex="-1" id="image-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content selectedSpotBackground">
			<div class='modal-image-container selectedSpotBackground'>
				<img src="" alt="" id='modal-image'>
			</div>
			<button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
				<p aria-hidden="true">&times;</p>
			</button>
		</div>

	</div>
</div>
<!-- end modal image -->

<script>
    var makeOrderGlobals = (function(){
        let globals = {
            'checkoutModal' : 'checkout-modal',
            'modalCheckoutList' : 'modal__checkout__list',
            'checkProduct' : 'checkProduct',
            'checkAddons' : 'checkAddons',
            'shoppingCartList' : 'shopping-cart__list',
            'orderedProducts' : 'orderedProducts',
            'spotId' : '<?php echo $spotId; ?>',
            'vendorId': '<?php echo $vendor['vendorId']; ?>',
            'orderDataRandomKey' : '<?php echo $orderDataRandomKey; ?>',
            'orderDataGetKey' : '<?php echo $orderDataGetKey; ?>',
            'logoImageId' : 'vendorLogo'
        }

        <?php if (!empty($returnCategorySlide)) { ?>
            globals['categorySlide'] = '<?php echo $returnCategorySlide; ?>';
        <?php } ?>

        Object.freeze(globals);
        return globals;
    }());
</script>

<script>

	$(document).ready(function(){
		$(".shop__single-item__image").click(function(){
			$("#image-modal").modal({
				backdrop: 'static',
				keyboard: false
			});
		});
	});

	var open_modal = $('.shop__single-item__image');
	var img_src = '';
	var modal_img_src = $('#modal-image');

	open_modal.on('click tap', function(){
		img_src = $(this).children('img').attr('src');
		modal_img_src.attr('src', img_src);
	})
</script>
