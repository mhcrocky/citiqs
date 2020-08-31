
<div class="container shop-container">
    <div class="row">
        <?php if (!empty($mainProducts)) { ?>
            <div class="col-12 col-md-8">
                <div class="items-slider">
                    <?php
                        $categories = array_keys($mainProducts);
                        $navigation = '';
                        foreach ($categories as $categoryName) {                        
                            $navigation .= '<a href="#' . $categoryName . '">' .  $categoryName . '</a>';
                        }
                    ?>
                    <?php foreach ($mainProducts as $category => $products) { ?>
                        <div class="shop__items">
                            <div class="shop__navigation">
                                <?php echo $navigation; ?>
                            </div>
                            <div class="shop__item-list-heading" id='<?php echo $category; ?>'>
                                <h2><?php echo $category; ?></h2>
                            </div>
                            <div class="shop__item-list">
                                <?php
                                    foreach ($products as $product) {
                                        $productDetails = reset($product['productDetails']);
                                        ?>
                                        <div class="shop__single-item" data-toggle="modal" data-target="#single-item-details-modal<?php echo $product['productId']; ?>">
                                            <div class="shop__single-item__image">
                                                <img
                                                    src="<?php echo base_url() . '/assets/images/productImages/' . $product['productImage']; ?>"
                                                    alt="<?php echo $productDetails['name']; ?>">
                                            </div>
                                            <div class="shop__single-item__info">
                                                <strong class='shop__single-item__info--title'><?php echo $productDetails['name']; ?></strong>
                                                <p class='shop__single-item__info--description'><?php echo $productDetails['shortDescription']; ?></p>
                                            </div>
                                            <div class="shop__single-item__price">
                                                <span><?php echo $productDetails['price']; ?></span>
                                            </div>
                                            <div class="shop__single-item__add-to-cart">
                                                <span>+</span>
                                            </div>
                                        </div>
                                        <!-- end single item -->                                    
                                        <?php
                                    }
                                ?>
                                
                            </div>
                            <!-- end item list -->
                            
                        </div>
                    <?php } ?>

                </div>
                <!-- end slider -->
            </div>
            <!-- end left side -->
            <div class="col-12 col-md-4">
                <div class="shopping-cart" id='shopping-cart'>
                    <h3>Items</h3>
                    <div class="shopping-cart__list" id='shopping-cart__list'>
                        <div class="shopping-cart__single-item">
                            <div class='shopping-cart__single-item__details'>
                                <p>
                                    <span class='shopping-cart__single-item__quantity'>1</span>
                                        x 
                                        <span class='shopping-cart__single-item__name'>Coca Cola</span>
                                    </p>
                                    <p class='shopping-cart__single-item__additional'>Ham (200gr), Cheese(200gr), Coca Cola (1l), Coca Cola (1l), Coca Cola (1l), Coca Cola (1l)</p>
                                    
                                <p>$ 
                                    <span class='shopping-cart__single-item__price'>7,00</span>
                                </p>
                            </div>
                            <div class="shopping-cart__single-item__remove">
                                <span>+</span>
                            </div>
                        </div>
                        <!-- end shoping cart single item -->
                        <div class="shopping-cart__single-item">
                            <div class='shopping-cart__single-item__details'>
                                <p>
                                    <span class='shopping-cart__single-item__quantity'>1</span>
                                        x 
                                        <span class='shopping-cart__single-item__name'>Coca Cola</span>
                                    </p>
                                    <p class='shopping-cart__single-item__additional'>Ham (200gr), Cheese(200gr), Coca Cola (1l), Coca Cola (1l), Coca Cola (1l), Coca Cola (1l)</p>
                                    
                                <p>$ 
                                    <span class='shopping-cart__single-item__price'>7,00</span>
                                </p>
                            </div>
                            <div class="shopping-cart__single-item__remove">
                                <span>+</span>
                            </div>
                        </div>
                        <!-- end shoping cart single item -->
                        <div class="shopping-cart__single-item">
                            <div class='shopping-cart__single-item__details'>
                                <p>
                                    <span class='shopping-cart__single-item__quantity'>1</span>
                                        x 
                                        <span class='shopping-cart__single-item__name'>Coca Cola</span>
                                    </p>
                                    <p class='shopping-cart__single-item__additional'>Ham (200gr), Cheese(200gr), Coca Cola (1l), Coca Cola (1l), Coca Cola (1l), Coca Cola (1l)</p>
                                    
                                <p>$ 
                                    <span class='shopping-cart__single-item__price'>7,00</span>
                                </p>
                            </div>
                            <div class="shopping-cart__single-item__remove">
                                <span>+</span>
                            </div>
                        </div>
                        <!-- end shoping cart single item -->
                        <div class="shopping-cart__single-item">
                            <div class='shopping-cart__single-item__details'>
                                <p>
                                    <span class='shopping-cart__single-item__quantity'>1</span>
                                        x 
                                        <span class='shopping-cart__single-item__name'>Coca Cola</span>
                                    </p>
                                    <p class='shopping-cart__single-item__additional'>Ham (200gr), Cheese(200gr), Coca Cola (1l), Coca Cola (1l), Coca Cola (1l), Coca Cola (1l)</p>
                                    
                                <p>$ 
                                    <span class='shopping-cart__single-item__price'>7,00</span>
                                </p>
                            </div>
                            <div class="shopping-cart__single-item__remove">
                                <span>+</span>
                            </div>
                        </div>
                        <!-- end shoping cart single item -->
                        <div class="shopping-cart__single-item">
                            <div class='shopping-cart__single-item__details'>
                                <p>
                                    <span class='shopping-cart__single-item__quantity'>1</span>
                                        x 
                                        <span class='shopping-cart__single-item__name'>Coca Cola</span>
                                    </p>
                                    <p class='shopping-cart__single-item__additional'>Ham (200gr), Cheese(200gr), Coca Cola (1l), Coca Cola (1l), Coca Cola (1l), Coca Cola (1l)</p>
                                    
                                <p>$ 
                                    <span class='shopping-cart__single-item__price'>7,00</span>
                                </p>
                            </div>
                            <div class="shopping-cart__single-item__remove">
                                <span>+</span>
                            </div>
                        </div>
                        <!-- end shoping cart single item -->
                        <div class="shopping-cart__single-item">
                            <div class='shopping-cart__single-item__details'>
                                <p>
                                    <span class='shopping-cart__single-item__quantity'>1</span>
                                        x 
                                        <span class='shopping-cart__single-item__name'>Coca Cola</span>
                                    </p>
                                <p>$ 
                                    <span class='shopping-cart__single-item__price'>7,00</span>
                                </p>
                            </div>
                            <div class="shopping-cart__single-item__remove">
                                <span>+</span>
                            </div>
                        </div>
                        <!-- end shoping cart single item -->
                        <div class="shopping-cart__single-item">
                            <div class='shopping-cart__single-item__details'>
                                <p>
                                    <span class='shopping-cart__single-item__quantity'>1</span>
                                        x 
                                        <span class='shopping-cart__single-item__name'>Coca Cola</span>
                                    </p>
                                <p>$ 
                                    <span class='shopping-cart__single-item__price'>7,00</span>
                                </p>
                            </div>
                            <div class="shopping-cart__single-item__remove">
                                <span>+</span>
                            </div>
                        </div>
                        <!-- end shoping cart single item -->
                        <div class="shopping-cart__single-item">
                            <div class='shopping-cart__single-item__details'>
                                <p>
                                    <span class='shopping-cart__single-item__quantity'>1</span>
                                        x 
                                        <span class='shopping-cart__single-item__name'>Coca Cola</span>
                                    </p>
                                <p>$ 
                                    <span class='shopping-cart__single-item__price'>7,00</span>
                                </p>
                            </div>
                            <div class="shopping-cart__single-item__remove">
                                <span>+</span>
                            </div>
                        </div>
                        <!-- end shoping cart single item -->
                    </div>
                    <!-- end shoping cart list -->
                    <div class="shopping-cart__total">
                            <p>Total:</p>
                            <p>$<span class="shopping-cart__total-price">999</span></p>
                        </div>
                    <button class='checkout-button button-main button-primary'>checkout</button>
                </div>
            </div>
            <!-- end right side -->
        <?php } else { ?>
            No available products
        <?php } ?>
    </div>
</div>
<!-- end shop container -->




<?php
    if (!empty($mainProducts)) {
        ?>
            <!-- bottom bar for smaller screens -->
            <div class='bottom-bar'>
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6 text-center text-left-md">
                            <div class="bottom-bar__summary">
                                <p>TOTAL: <span class='bottom-bar__total-price'>$9,99</span> </p>
                                <button class='button-main button-secondary' data-toggle='modal' data-target='#checkout-modal'>Order List</button>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 text-center text-right-md">
                            <button class='button-main button-secondary bottom-bar__checkout'>CHECKOUT $</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end bottom bar -->


            <!-- end modal single item details -->

            <!-- Modal checkout -->
            <div class="modal fade modal__checkout" id="checkout-modal" tabindex="-1" role="dialog" aria-labelledby="single-item-details-modalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <div class="modal-header__content">
                        <div class='modal-header__details'>
                            <!--<h4 class="modal-header__title" id="">Total price:</h4>
                            <h4 class='modal-price'>$9,00</h4>-->
                            <h4 class="modal-header__title">Order List:</h4>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <div class="modal__content">
                        <div class="modal__checkout__list" id='modal__checkout__list'>
                        
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <p>TOTAL: <span class="bottom-bar__total-price">$9,99</span> </p>
                    <button class='button-main button-primary'>CHECKOUT $</button>
                    </div>
                </div>
                </div>
            </div>
            <!-- end modal checkout -->
        <?php        
        foreach ($mainProducts as $category => $products) {
            foreach ($products as $product) {
                $productDetails = reset($product['productDetails']);            
                ?>
                    <!-- start modal single item details -->
                    <div
                        class="modal modal__item"
                        id="single-item-details-modal<?php echo $product['productId']; ?>"
                        role="dialog"
                        aria-hidden="true"
                        >
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <div class="modal-header__content">
                                <div class='modal-header__details'>
                                    <h4 class="modal-header__title"><?php echo $productDetails['name']; ?></h4>
                                    <h4 class='modal-price'>&euro; <?php echo $productDetails['price']; ?></h4>
                                </div>
                                <h6 class="modal-header__description"><?php echo $productDetails['shortDescription']; ?></h6>
                                <p class='modal__category'>Category: <a href='#'><?php echo $product['category']; ?></a></p>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <?php if ($product['addons']) { ?>
                                    <div class="modal__content">
                                        <div class="modal__adittional">
                                            <h6>Additional</h6>
                                            <div class="modal__adittional__list">
                                                <?php
                                                    $productAddons = $product['addons'];
                                                    foreach ($productAddons as $productAddon) {
                                                        $addonId = $productAddon[0][0];
                                                        $addonQuantity = $productAddon[0][1];
                                                        ?>
                                                            <div class="form-group form-check modal__additional__checkbox" style="width:70%; margin-bottom:3px">                                                        
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" class="form-check-input" onchange="toogleElement(this, 'addon_<?php echo $product['productId'] . '_'. $addonId; ?>')">
                                                                    <?php echo $addons[$addonId][0]['name'] ?>
                                                                    &euro; <?php echo $addons[$addonId][0]['price'] ?>
                                                                    (min 1 / max <?php echo $addonQuantity; ?>)
                                                                </label>
                                                            </div>
                                                            <div
                                                                class="modal-footer__quantity"
                                                                style="visibility: hidden; width:20%; margin-bottom:3px"
                                                                id="addon_<?php echo $product['productId'] . '_'. $addonId; ?>"
                                                                >
                                                                <span
                                                                    class='modal-footer__buttons modal-footer__quantity--plus'
                                                                    style="margin-right:5px;"
                                                                    data-type="minus"
                                                                    onclick="changeQuayntity(this, 'input_<?php echo $product['productId'] . '_'. $addonId; ?>')"
                                                                    >
                                                                    -
                                                                </span>
                                                                <input
                                                                    type="number"
                                                                    id='input_<?php echo $product['productId'] . '_'. $addonId; ?>'
                                                                    min="1"
                                                                    max="<?php echo $addonQuantity; ?>"
                                                                    data-price="<?php echo $addons[$addonId][0]['price']; ?>"
                                                                    step="1"
                                                                    value="1"
                                                                    class="form-control"
                                                                    style="display:inline-block"
                                                                    />
                                                                <span
                                                                    class='modal-footer__buttons modal-footer__quantity--minus'
                                                                    style="margin-left:5px;"
                                                                    data-type="plus"
                                                                    onclick="changeQuayntity(this, 'input_<?php echo $product['productId'] . '_'. $addonId; ?>')"
                                                                    >
                                                                    +
                                                                </span>
                                                            </div>
                                                        <?php
                                                    }
                                                ?>                                                      
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="button-main button-primary"
                                    data-dismiss="modal"
                                    data-product-id="<?php echo $product['productId']; ?>"
                                    data-product-name="<?php echo $productDetails['name']; ?>"
                                    data-product-price="<?php echo $productDetails['price']; ?>"
                                    data-product-addon-element-id="addon_<?php echo $product['productId'] . '_'. $addonId; ?>"
                                    onclick="cloneProductAndAddons(this)"
                                    >Continue</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- end modal single item details -->
                <?php
            }

        }
    }
?>


<!-- appending items list in modal for testing purposes -->
<script>
    function toogleElement(element, containerId) {
        let container = document.getElementById(containerId);
        let inputField = container.children[1];
        let checked = element.checked;
        container.style.visibility = checked ? 'visible' : 'hidden';
        inputField.disabled = !checked;
    }

    function changeQuayntity(element, inputId) {
        let type = element.dataset.type;
        let inputField = document.getElementById(inputId);
        let value = parseInt(inputField.value);
        let minValue = parseInt(inputField.min);
        let maxValue = parseInt(inputField.max);

        if (type === 'minus' && value > minValue) {
            value = value - 1;
        }
        if (type === 'plus' && value < maxValue) {
            value = value + 1;
        }
        inputField.setAttribute('value', value);
    }

    function cloneProductAndAddons(element) {
        console.dir(element.dataset);

    }

	// var shoping_cart_list = $('#shopping-cart__list');
	// $(shoping_cart_list).clone().appendTo( "#modal__checkout__list" );
	$(document).ready(function(){
	  $('.items-slider').slick({
		  arrows: true,
		  infinite: true,
		  speed: 300,
		  slidesToShow: 1,
		  adaptiveHeight: true
	  });
	});
	
</script>