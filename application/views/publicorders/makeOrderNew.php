<?php
    $shoppingList = '';
    $checkoutList = '';
    if  (!is_null($ordered)) {
        $count = 0;
        foreach ($ordered as $product) {
            $count++;
            $price = 0;
            $productExtendedId = array_keys($product)[0];
            $product = reset($product);
            $randomId = 'product_' . $product['productId'] . '_' . $count;




            $checkoutList .= '<div id="' . $randomId . '" class="orderedProducts" style="margin-bottom: 30px; padding-left: 0px; display: initial;">';
            $checkoutList .=    '<div class="alert alert-dismissible" style="padding-left: 0px; margin-bottom: 10px;">';
            $checkoutList .=        '<a href="#" onclick="removeOrdered(\'' . $randomId . '\')" class="close" data-dismiss="alert" aria-label="close">×</a>';
            $checkoutList .=        '<h4>' . $product['name'] . ' (€' . $product['price'] . ')</h4>';
            $checkoutList .=    '</div>';
            $checkoutList .=    '<div class="modal__content">';
            $checkoutList .=        '<div class="modal__adittional">';
            $checkoutList .=            '<h6>Quantity</h6>';
            $checkoutList .=            '<div class="form-check modal__additional__checkbox  col-lg-7 col-sm-12" style="margin-bottom:3px">';
            $checkoutList .=                '<label class="form-check-label">' . $product['name'] . '</label>';
            $checkoutList .=            '</div>';
            $checkoutList .=            '<div class="modal-footer__quantity col-lg-4 col-sm-12" style="margin-bottom:3px">';
            $checkoutList .=                '<span 
                                                class="modal-footer__buttons modal-footer__quantity--plus" 
                                                style="margin-right:5px;" 
                                                data-type="minus"
                                                onclick="changeProductQuayntity(this, \'addonQuantity\')">';
            $checkoutList .=                ' -';
            $checkoutList .=                '</span>';
            $checkoutList .=                '<input
                                                type="number"
                                                min="1"
                                                step="1"
                                                value="' . $product['quantity'] . '"
                                                data-name="' . $product['name'] . '"
                                                data-add-product-price="' . $product['price'] . '"
                                                data-category="' . $product['category'] . '"
                                                data-product-extended-id="' . $productExtendedId . '"
                                                data-product-id="' . $product['productId'] . '"
                                                class="form-control checkProduct"
                                                style="display:inline-block"
                                            />';
            $checkoutList .=                '<span
                                                class="modal-footer__buttons modal-footer__quantity--minus"
                                                style="margin-left:5px;"
                                                data-type="plus"
                                                onclick="changeProductQuayntity(this, \'addonQuantity\')"
                                            >';
            $checkoutList .=                ' +';
            $checkoutList .=                '</span>';
            $checkoutList .=            '</div>';
            $checkoutList .=        '</div>';

            if (!isset($product['addons'])) continue;

            $checkoutList .=        '<div class="modal__adittional">';
            $checkoutList .=            '<h6>Additional</h6>';
            $checkoutList .=            '<div class="modal__adittional__list">';

            foreach ($product['addons'] as $addonExtendedId => $addon) {
                $checkoutList .=            '<div class="form-check modal__additional__checkbox  col-lg-7 col-sm-12" style="margin-bottom:3px">';
                $checkoutList .=                '<label class="form-check-label">';
                $checkoutList .=                    '<input type="checkbox" class="form-check-input checkAddons" onchange="toggleElement(this)" checked>&nbsp;';
                $checkoutList .=                    $addon['name'] . ' € ' . $addon['price'] . ' (min per unit ' . $addon['minQuantity'] . ' / max  per unit ' . $addon['maxQuantity'] . ')';
                $checkoutList .=                '</label>';
                $checkoutList .=            '</div>';
                $checkoutList .=            '<div class="modal-footer__quantity col-lg-4 col-sm-12" style="visibility: visible; margin-bottom: 3px;">';
                $checkoutList .=                '<span 
                                                    class="modal-footer__buttons modal-footer__quantity--plus"
                                                    style="margin-right:5px;"
                                                    data-type="minus"
                                                    onclick="changeAddonQuayntity(this)"
                                                >';
                $checkoutList .=                    ' -';
                $checkoutList .=                '</span>';
                $checkoutList .=                '<input
                                                    type="number"
                                                    min="' . $addon['minQuantity'] . '"
                                                    max="' . $addon['maxQuantity'] . '"
                                                    data-addon-price="' . $addon['price'] . '"
                                                    data-addon-name="' . $addon['name'] . '"
                                                    data-category="' . $addon['category'] . '"
                                                    data-product-extended-id="' . $productExtendedId . '"
                                                    data-addon-extended-id="' . $addonExtendedId . '"
                                                    data-min="' . $addon['minQuantity'] . '"
                                                    data-max="' . $addon['maxQuantity'] . '"
                                                    step="' . $addon['step'] . '"
                                                    value="' . $addon['quantity'] . '"
                                                    class="form-control addonQuantity"  
                                                    style="display:inline-block"
                                                />';

                $checkoutList .=                '<span
                                                    class="modal-footer__buttons modal-footer__quantity--minus"
                                                    style="margin-left:5px;"
                                                    data-type="plus"
                                                    onclick="changeAddonQuayntity(this)"
                                                >';
                $checkoutList .=                    ' +';
                $checkoutList .=                '</span>';
                $checkoutList .=            '</div>';
            }
            $checkoutList .=            '</div>';
            $checkoutList .=        '</div>';
            $checkoutList .=    '</div>';
            $checkoutList .= '</div>';


            // <div id="product_1252_1599334732396_648" class="orderedProducts" style="margin-bottom: 30px; padding-left: 0px; display: initial;">
            //     <div class="alert alert-dismissible" style="padding-left: 0px; margin-bottom: 10px;">            
            //         <a href="#" onclick="removeOrdered('product_1252_1599334732396_648')" class="close" data-dismiss="alert" aria-label="close">×</a>

            //         <h4>COCA COLA (€2.00)</h4>
            //     </div>
            //      <div class="modal__content">
            //         <div class="modal__adittional">
            //             <h6>Quantity</h6>
            //             <div class="form-check modal__additional__checkbox  col-lg-7 col-sm-12" style="margin-bottom:3px">
            //                 <label class="form-check-label">
            //                     COCA COLA
            //                 </label>
            //             </div>
            //             <div class="modal-footer__quantity col-lg-4 col-sm-12" style="margin-bottom:3px">
            //                 <span 
                                    // class="modal-footer__buttons modal-footer__quantity--plus"
                                    // style="margin-right:5px;"
                                    // data-type="minus" onclick="changeProductQuayntity(this, 'addonQuantity')">
            //                 -
            //                 </span>
            //                 <input
                                //     type="number"
                                //     min="1"
                                //     step="1"
                                //     value="2"
                                //     data-name="COCA COLA"
                                //     data-add-product-price="2.00"
                                //     data-category="DRINKS"
                                //     data-product-extended-id="2848"
                                //     data-product-id="1252"
                                //     class="form-control checkProduct"
                                //     style="display:inline-block"
                                // >
            //                 <span class="modal-footer__buttons modal-footer__quantity--minus" style="margin-left:5px;" data-type="plus" onclick="changeProductQuayntity(this, 'addonQuantity')">
            //                 +
            //                 </span>
            //             </div>
            //         </div>                                
            //         <div class="modal__adittional">
            //             <h6>Additional</h6>
            //             <div class="modal__adittional__list">
            //                 <div class="form-check modal__additional__checkbox  col-lg-7 col-sm-12" style="margin-bottom:3px">
            //                     <label class="form-check-label">
            //                         <input type="checkbox" class="form-check-input checkAddons" onchange="toggleElement(this)">
            //                         HAMBURGER € 4.00 (min per unit 1 / max  per unit 1)
            //                     </label>
            //                 </div>
            //                 <div class="modal-footer__quantity col-lg-4 col-sm-12" style="visibility: visible; margin-bottom: 3px;">
            //                     <span class="modal-footer__buttons modal-footer__quantity--plus" style="margin-right:5px;" data-type="minus" onclick="changeAddonQuayntity(this)">
            //                         -
            //                     </span>
            //                     <input
            //                         type="number"
            //                         min="2"
            //                         max="2"
            //                         data-addon-price="4.00"
            //                         data-addon-name="HAMBURGER"
            //                         data-category="FOOD"
            //                         data-product-extended-id="2848"
            //                         data-addon-extended-id="2845"
            //                         data-min="1"
            //                         data-max="1"
            //                         step="2"
            //                         value="2"
            //                         class="form-control addonQuantity"
            //                         style="display:inline-block"
            //                     >
            //                     <span class="modal-footer__buttons modal-footer__quantity--minus" style="margin-left:5px;" data-type="plus" onclick="changeAddonQuayntity(this)">
            //                         +
            //                     </span>
            //                 </div>
            //                 <div class="form-check modal__additional__checkbox  col-lg-7 col-sm-12" style="margin-bottom:3px">
            //                     <label class="form-check-label">
            //                         <input type="checkbox" class="form-check-input checkAddons" onchange="toggleElement(this)">
            //                         EXTRA ICE € 0.02 (min per unit 1 / max  per unit 13)
            //                     </label>
            //                 </div>
            //                 <div class="modal-footer__quantity col-lg-4 col-sm-12" style="visibility: visible; margin-bottom: 3px;">
            //                     <span class="modal-footer__buttons modal-footer__quantity--plus" style="margin-right:5px;" data-type="minus" onclick="changeAddonQuayntity(this)">
            //                         -
            //                     </span>
            //                     <input
            //                         type="number"
            //                         min="2"
            //                         max="26"
            //                         data-addon-price="0.02"
            //                         data-addon-name="EXTRA ICE"
            //                         data-category="DRINKS"
            //                         data-product-extended-id="2848"
            //                         data-addon-extended-id="2844"
            //                         data-min="1"
            //                         data-max="13"
            //                         step="2"
            //                         value="2"
            //                         class="form-control addonQuantity"
            //                         style="display:inline-block"
            //                     >
            //                     <span class="modal-footer__buttons modal-footer__quantity--minus" style="margin-left:5px;" data-type="plus" onclick="changeAddonQuayntity(this)">
            //                         +
            //                     </span>
            //                 </div>
            //             </div>
            //         </div>
            //     </div>
            // </div>



            $price += floatval($product['amount']);
            if (isset($product['addons'])) {
                $addonsArray = [];
                foreach($product['addons'] as $addon) {
                    $price += floatval($addon['amount']);
                    $addonString = $addon['name']  . '(' . $addon['price'] . ')';
                    array_push($addonsArray, $addonString);
                }
            }
            $shoppingList .= '<div class="shopping-cart__single-item ' . $randomId . '" data-ordered-id="' . $randomId . '">';
            $shoppingList .=     '<div class="shopping-cart__single-item__details">';
            $shoppingList .=         '<p>';
            $shoppingList .=             '<span class="shopping-cart__single-item__quantity">' . $product['quantity'] . '</span>';
            $shoppingList .=             ' x ';
            $shoppingList .=             '<span class="shopping-cart__single-item__name">' . $product['name'] . '</span>';
            $shoppingList .=         '</p>';
            $shoppingList .=         '<p class="shopping-cart__single-item__additional">' . implode(', ', $addonsArray) . '</p>';
            $shoppingList .=         '<p>&euro; <span class="shopping-cart__single-item__price">' . number_format($price, 2, '.', ',').'</span></p>';
            $shoppingList .=     '</div>';
            $shoppingList .=     '<div class="shopping-cart__single-item__remove" onclick="focusOnOrderItem(\'modal__checkout__list\', \'' . $randomId . '\')">';
            $shoppingList .=         '<i class="fa fa-info-circle" aria-hidden="true"></i>';
            $shoppingList .=     '</div>';
            $shoppingList .= '</div>';
        }
    }
?>
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
                        <?php echo $shoppingList; ?>
                    </div>
                    <!-- end shoping cart list -->
                    <div class="shopping-cart__total">
                            <p>Total:</p>
                            <p>&euro;&nbsp;<span class="shopping-cart__total-price totalPrice">0</span></p>
                        </div>
                    <button class='checkout-button button-main button-primary' onclick="checkout()">checkout</button>
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
                                <p>TOTAL: <span class='bottom-bar__total-price'>&euro;&nbsp;<span class="totalPrice">0</span></span> </p>
                                <button class='button-main button-secondary' onclick="focusCheckOutModal('modal__checkout__list')">Order List</button>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 text-center text-right-md">
                            <button class='button-main button-secondary bottom-bar__checkout' onclick="checkout()">CHECKOUT</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end bottom bar -->

            <!-- Modal checkout -->
            <div class="modal modal__checkout" id="checkout-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-header__content">
                                <div class='modal-header__details'>
                                    <h4 class="modal-header__title">Order List:</h4>
                                </div>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <div class="modal__checkout__list" id='modal__checkout__list' style="margin: 0px 10px; overflow-y: scroll !important;">
                                    <?php echo $checkoutList; ?>
                                </div>
                                <div class="modal-footer">
                                    <p>TOTAL:
                                        <span class="bottom-bar__total-price"></span>
                                    </p>
                                    <button class='button-main button-primary' onclick="checkout()">
                                        CHECKOUT &euro;&nbsp;<span class="totalPrice">0</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal checkout -->
        <?php 
        $counter = 0;
        foreach ($mainProducts as $category => $products) {

            foreach ($products as $product) {
                $productDetails = reset($product['productDetails']);
                $counter++;
                ?>
                    <!-- start modal single item details -->
                    <div
                        class="modal modal__item"
                        id="single-item-details-modal<?php echo $product['productId']; ?>"
                        role="dialog"
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
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="modal__content" id="product_<?php echo $product['productId']; ?>">
                                    <div class="modal__adittional">
                                        <h6>Quantity</h6>
                                        <div class="form-check modal__additional__checkbox  col-lg-7 col-sm-12" style="margin-bottom:3px">                                                        
                                            <label class="form-check-label">                                                
                                                <?php echo $productDetails['name']; ?>
                                            </label>
                                        </div>
                                        <div
                                            class="modal-footer__quantity col-lg-4 col-sm-12"
                                            style="margin-bottom:3px"
                                            >
                                            <span
                                                class='modal-footer__buttons modal-footer__quantity--plus'
                                                style="margin-right:5px;"
                                                data-type="minus"
                                                onclick="changeProductQuayntity(this, 'addonQuantity')"
                                                >
                                                -
                                            </span>
                                            <input
                                                type="number"
                                                min="1"
                                                step="1"
                                                value="1"
                                                data-name="<?php echo $productDetails['name']; ?>"
                                                data-add-product-price="<?php echo $productDetails['price']; ?>"
                                                data-category="<?php echo $product['category']; ?>"
                                                data-product-extended-id="<?php echo $productDetails['productExtendedId']; ?>"
                                                data-product-id="<?php echo $product['productId']; ?>"
                                                class="form-control checkProduct"
                                                style="display:inline-block"
                                                />
                                            <span
                                                class='modal-footer__buttons modal-footer__quantity--minus'
                                                style="margin-left:5px;"
                                                data-type="plus"
                                                onclick="changeProductQuayntity(this, 'addonQuantity')"
                                                >
                                                +
                                            </span>
                                        </div>
                                    </div>                                
                                    <?php if ($product['addons']) { ?>
                                        <div class="modal__adittional">
                                            <h6>Additional</h6>
                                            <div class="modal__adittional__list">
                                                <?php
                                                    $productAddons = $product['addons'];
                                                    foreach ($productAddons as $productAddon) {
                                                        $addonId = $productAddon[0][0];
                                                        $addonQuantity = $productAddon[0][1];
                                                        ?>
                                                        <div class="form-check modal__additional__checkbox  col-lg-7 col-sm-12" style="margin-bottom:3px">
                                                            <label class="form-check-label">
                                                                <input
                                                                    type="checkbox"
                                                                    class="form-check-input checkAddons"
                                                                    onchange="toggleElement(this)"
                                                                />
                                                                <?php echo $addons[$addonId][0]['name']; ?>
                                                                &euro; <?php echo $addons[$addonId][0]['price']; ?>
                                                                (min per unit 1 / max  per unit <?php echo $addonQuantity; ?>)
                                                            </label>
                                                        </div>
                                                        <div
                                                            class="modal-footer__quantity col-lg-4 col-sm-12"
                                                            style="visibility: hidden; margin-bottom:3px"
                                                            >
                                                            <span
                                                                class='modal-footer__buttons modal-footer__quantity--plus'
                                                                style="margin-right:5px;"
                                                                data-type="minus"
                                                                onclick="changeAddonQuayntity(this)"
                                                            >
                                                                -
                                                            </span>
                                                            <input
                                                                type="number"
                                                                min="1"
                                                                max="<?php echo $addonQuantity; ?>"
                                                                data-addon-price="<?php echo $addons[$addonId][0]['price']; ?>"
                                                                data-addon-name="<?php echo $addons[$addonId][0]['name']; ?>"
                                                                data-category="<?php echo $addons[$addonId][0]['category']; ?>"
                                                                data-product-extended-id="<?php echo $productDetails['productExtendedId']; ?>"
                                                                data-addon-extended-id="<?php echo $addons[$addonId][0]['productExtendedId']; ?>"
                                                                data-min = "1"
                                                                data-max="<?php echo $addonQuantity; ?>"
                                                                step="1"
                                                                value="1"
                                                                class="form-control addonQuantity"
                                                                disabled
                                                                style="display:inline-block"
                                                            />
                                                            <span
                                                                class='modal-footer__buttons modal-footer__quantity--minus'
                                                                style="margin-left:5px;"
                                                                data-type="plus"
                                                                onclick="changeAddonQuayntity(this)"
                                                                >
                                                                +
                                                            </span>
                                                        </div>
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="button-main button-primary"
                                    data-dismiss="modal"
                                    data-product-id="<?php echo $product['productId']; ?>"
                                    data-product-name="<?php echo $productDetails['name']; ?>"
                                    data-product-price="<?php echo $productDetails['price']; ?>"
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
