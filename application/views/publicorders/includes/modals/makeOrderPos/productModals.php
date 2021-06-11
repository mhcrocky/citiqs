<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $counter = 0;
    $categorySlide = 0;
    foreach ($mainProducts as $category => $products) {
        $categorySlide++;
        foreach ($products as $product) {
            $productDetails = reset($product['productDetails']);
            $counter++;
            $remarkProductId = ($product['addRemark'] === '1') ? 'remark_' . $counter . '_' . $product['productId'] : '0';
            ?>
                <!-- start modal single item details -->
                <div
                    class="modal modal__item"
                    id="single-item-details-modal<?php echo $product['productId']; ?>"
                    role="dialog"
                >
                    <div class="modal-content selectedSpotBackground">
                        <div
                            class="modal-header selectedSpotBackground"
                            <?php if ($product['onlyOne'] === '1') { ?>
                                style="border-bottom:0px"
                            <?php } ?>
                            >
                            <div class="modal-header__content selectedSpotBackground">
                                <div class='modal-header__details'  style="margin-top:17px;">
                                    <h4 class="modal-header__title productName"><?php echo $productDetails['name']; ?></h4>
                                    <h4 class='modal-price productName productName'>&euro; <?php echo $productDetails['price']; ?></h4>
                                </div>
                                <!-- <h6 class="modal-header__description productDescription"><?php #echo $productDetails['shortDescription']; ?></h6> -->
                                <!-- <p class='modal__category productCategory'>Category: <a href='#' class='productCategory'><?php #echo $product['category']; ?></a></p> -->
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span style="color:#000;">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body selectedSpotBackground">
                            <div class="modal__content <?php echo $productDetails['productExtendedId']; ?>" id="product_<?php echo $product['productId']; ?>" >

                                <div class="modal__adittional">
                                    <?php if ($product['onlyOne'] === '0') { ?>
                                        <h6 class="labelsMain"><?php echo $this->language->tLine('Quantity');?></h6>
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
                                                class='modal-footer__buttons modal-footer__quantity--plus priceQuantity'
                                                style="margin-right:5px;"
                                                data-type="minus"
                                                onclick="changeProductQuayntity(this, 'addonQuantity')"
                                                >
                                                -
                                            </span>
                                    <?php } ?>
                                    <input
                                        type="number"
                                        min="1"
                                        step="1"
                                        value="1"
                                        data-name="<?php echo htmlspecialchars($productDetails['name']); ?>"
                                        data-add-product-price="<?php echo $productDetails['price']; ?>"
                                        data-category="<?php echo htmlspecialchars($product['category']); ?>"
                                        data-product-extended-id="<?php echo $productDetails['productExtendedId']; ?>"
                                        data-product-id="<?php echo $product['productId']; ?>"
                                        data-only-one="<?php echo $product['onlyOne']; ?>"
                                        data-remark-id="<?php echo $remarkProductId ?>"
                                        data-order-quantity-value="orderQuantityValue_<?php echo $product['productId']; ?>"
                                        data-category-slide="<?php echo $categorySlide; ?>"
                                        data-printed="0"
                                        readonly
                                        oninput="reloadPageIfMinus(this)"
                                        onchange="reloadPageIfMinus(this)"
                                        <?php if ($product['onlyOne'] === '0') { ?>
                                            class="form-control checkProduct inputFieldsMakeOrder"
                                            style="display:inline-block"
                                        <?php } elseif ($product['onlyOne'] === '1') { ?>
                                            hidden
                                        <?php } ?>
                                        <?php
                                            if ($vendor['showAllergies'] === '1')  {
                                                $product['allergies'] = unserialize($product['allergies']);
                                                if (!empty($product['allergies']['productAllergies'])) {
                                                    $productAllergiesModal = $product['allergies']['productAllergies'];
                                                    ?>
                                                        data-allergies="<?php echo implode($this->config->item('allergiesSeparator'), $productAllergiesModal); ?>"
                                                    <?php
                                                }
                                            }
                                        ?>
                                    />
                                    <?php if ($product['onlyOne'] === '0') { ?>
                                                <span
                                                    class='modal-footer__buttons modal-footer__quantity--minus priceQuantity'
                                                    style="margin-left:5px;"
                                                    data-type="plus"
                                                    onclick="changeProductQuayntity(this, 'addonQuantity')"
                                                    >
                                                    +
                                                </span>
                                            </div>
                                    <?php } ?>
                                    <?php
                                        if (isset($productAllergiesModal))  {
                                            foreach ($productAllergiesModal as $allergy) {
                                                ?>
                                                    <img
                                                        src="<?php echo $baseUrl . 'assets/images/allergies/' . str_replace(' ', '_', $allergy); ?>.png"
                                                        alt="<?php echo $allergy; ?>"
                                                        class="ingredients imgAlergies"
                                                        style="display:inline; margin:0px 2px 3px 0px"
                                                    />
                                                <?php
                                            }
                                            unset($productAllergiesModal);
                                        }
                                    ?>
                                    <?php if ($product['addRemark'] === '1') { ?>
                                        <h6 class="remark remarkStyle"><?php echo $this->language->tLine('Remarks');?> </h6>
                                        <div class="form-check modal__additional__checkbox  col-lg-12 col-sm-12" style="margin-bottom:3px">
                                            <input
                                                type="text"
                                                maxlength="<?php echo $maxRemarkLength; ?>"
                                                data-product-remark-id="<?php echo $remarkProductId; ?>"
                                                placeholder="Allowed <?php echo $maxRemarkLength; ?> characters"
                                                class="posKeyboard form-control ui-widget-content ui-corner-all ui-autocomplete-input ui-keyboard-preview form-control remarks inputFieldsMakeOrder"
                                                tabindex='-1'
                                                autocomplete="off"
                                            />
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if ($product['addons']) { ?>
                                    <div class="modal__adittional">
                                        <?php
                                            $productAddons = $product['addons'];
                                            $countAddons = 0;
                                            $collectAddons = [];
                                            foreach ($productAddons as $productAddon) {
                                                $countAddons++;
                                                $addonId = $productAddon[0][0];
                                                $addonAllowedQuantity = $productAddon[0][1];
                                                if (empty($addons[$addonId])) continue;
                                                $addon = $addons[$addonId][0];
                                                $addon['addonAllowedQuantity'] = $addonAllowedQuantity;
                                                array_push($collectAddons, $addon);
                                            }

                                            $collectAddons = Utility_helper::resetArrayByKeyMultiple($collectAddons, 'productType');
                                            $countAddons = 0;
                                            echo '<div class="modal__adittional__list" style="width:100%">';
                                                foreach ($collectAddons as $key => $elements) {
                                                    echo '<h6 style="width:100%" class="labelsMain">' . $key . '</h6>';
                                                    
                                                    foreach ($elements as $addon) {
                                                        $countAddons++;
                                                        $addonAllowedQuantity = $addon['addonAllowedQuantity'];
                                                        $remarkAddonId = $addon['addRemark'] === '1' ? $remarkProductId . '_' . $countAddons : '0';                                                        
                                                        ?>
                                                        <div class="form-check modal__additional__checkbox  col-lg-7 col-sm-12" style="width:50%; margin-bottom:3px">
                                                            <label class="form-check-label labelItems" style="word-wrap: break-word;">
                                                                <input
                                                                    type="checkbox"
                                                                    class="form-check-input checkAddons inputFieldsMakeOrder"
                                                                    data-addon-type-id-check="<?php echo $addon['productTypeId']; ?>"
                                                                    onchange="toggleElement(this)"
                                                                />
                                                                &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $addon['name']; ?>
                                                                <?php if (floatval($addon['price']) > 0) { ?>
                                                                    &euro;&nbsp;<?php echo $addon['price']; ?>
                                                                <?php } ?>
                                                                <!-- (min per unit 1 / max  per unit --><?php //echo $addonAllowedQuantity; ?><!--) -->
                                                            </label>
                                                            <?php
                                                                if ($vendor['showAllergies'] === '1')  {
                                                                    $addon['allergies'] = unserialize($addon['allergies']);
                                                                    if (!empty($addon['allergies']['productAllergies'])) {
                                                                        $addonAllergies = $addon['allergies']['productAllergies'];
                                                                        $baseUrl = base_url();
                                                                        echo '<div>';
                                                                        foreach ($addonAllergies as $allergy) {
                                                                            ?>
                                                                                <img
                                                                                    src="<?php echo $baseUrl . 'assets/images/allergies/' . str_replace(' ', '_', $allergy); ?>.png"
                                                                                    alt="<?php echo $allergy; ?>"
                                                                                    class="ingredients imgAlergies"
                                                                                    style="display:inline; margin:0px 2px 3px 0px"
                                                                                />
                                                                            <?php
                                                                        }
                                                                        echo '</div>';
                                                                    }
                                                                }
                                                            ?>

                                                        </div>
                                                        <div
                                                            class="modal-footer__quantity col-lg-4 col-sm-12"
                                                            style="visibility: hidden; margin:0px 0px 3px 0px; padding:0px"
                                                            >
                                                            <span
                                                                class='modal-footer__buttons modal-footer__quantity--plus priceQuantity'
                                                                <?php if ($addonAllowedQuantity !== '1') { ?>
                                                                    onclick="changeAddonQuayntity(this)"
                                                                    style="margin-right:5px;"
                                                                <?php } else { ?>
                                                                    style="visibility:hidden; height:0px"
                                                                <?php }?>
                                                                data-type="minus"                                                                
                                                            >
                                                                -
                                                            </span>
                                                            
                                                            <input
                                                                readonly
                                                                oninput="reloadPageIfMinus(this)"
                                                                onchange="reloadPageIfMinus(this)"
                                                                type="number"
                                                                min="1"
                                                                max="<?php echo $addonAllowedQuantity; ?>"
                                                                data-addon-price="<?php echo $addon['price']; ?>"
                                                                data-addon-name="<?php echo htmlspecialchars($addon['name']); ?>"
                                                                data-category="<?php echo htmlspecialchars($addon['category']); ?>"
                                                                data-product-extended-id="<?php echo $productDetails['productExtendedId']; ?>"
                                                                data-addon-extended-id="<?php echo $addon['productExtendedId']; ?>"
                                                                data-initial-min-quantity="1"
                                                                data-initial-max-quantity="<?php echo $addonAllowedQuantity; ?>"
                                                                data-addon-product-id="<?php echo $addon['productId']; ?>"
                                                                data-min = "1"
                                                                data-max="<?php echo $addonAllowedQuantity; ?>"
                                                                data-remark-id="<?php echo $remarkAddonId ?>"
                                                                data-product-type="<?php echo $addon['productType']; ?>"
                                                                data-addon-type-id="<?php echo $addon['productTypeId']; ?>"
                                                                data-is-boolean="<?php echo $addon['isBoolean']; ?>"
                                                                data-allowed-choices="<?php echo $addon['additionalNumber']; ?>"
                                                                data-printed="0"
                                                                <?php if (isset($addonAllergies)) { ?>
                                                                    data-allergies="<?php echo implode($this->config->item('allergiesSeparator'), $addonAllergies); ?>"
                                                                    <?php unset($addonAllergies); ?>
                                                                <?php } else { ?>
                                                                    data-allergies=""
                                                                <?php } ?>
                                                                step="1"
                                                                value="1"
                                                                class="form-control addonQuantity inputFieldsMakeOrder"
                                                                disabled                                                                
                                                                <?php if ($addonAllowedQuantity !== '1') { ?>
                                                                    style="display:inline-block; border:0px; background-color: #fff;"
                                                                <?php } else { ?>
                                                                    style="display:inline-block; border:0px; background-color: #fff; margin-left:7px"
                                                                <?php } ?>
                                                            />
                                                            <span
                                                                class='modal-footer__buttons modal-footer__quantity--minus priceQuantity'                                                                
                                                                data-type="plus"
                                                                <?php if ($addonAllowedQuantity !== '1') { ?>
                                                                    onclick="changeAddonQuayntity(this)"
                                                                    style="margin-left:5px;"
                                                                <?php } else { ?>
                                                                    style="visibility:hidden; height:0px"
                                                                <?php }?>
                                                                >
                                                                +
                                                            </span>
                                                        </div>
                                                        <?php if ($addon['addRemark'] === '1') { ?>
                                                            <div class="form-check modal__additional__checkbox  col-lg-12 col-sm-12" style="margin-bottom:3px">
                                                                <h6 class="remarkStyle" style="margin-top:0px;">Remark</h6>
                                                                <div class="col-lg-12 col-sm-12" style="margin-bottom:3px">
                                                                    <input
                                                                        type="text"
                                                                        maxlength="<?php echo $maxRemarkLength; ?>"
                                                                        data-addon-remark-id="<?php echo $remarkAddonId ?>"
                                                                        placeholder="Allowed <?php echo $maxRemarkLength; ?> characters"
                                                                        class="posKeyboard form-control ui-widget-content ui-corner-all ui-autocomplete-input ui-keyboard-preview form-control remarks inputFieldsMakeOrder"
                                                                        tabindex='-1'
                                                                        autocomplete="off"
                                                                    />
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php
                                                    }
                                                    
                                                }
                                            echo '</div>';
                                        ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div
                            class="modal-footer selectedSpotBackground"
                            <?php if ($product['onlyOne'] === '1') { ?>
                                style="border-top:0px"
                            <?php } ?>
                        >
                            <button
                                type="button"
                                class="button-main button-primary addProductOnList"
                                data-dismiss="modal"
                                data-product-id="<?php echo $product['productId']; ?>"
                                data-product-name="<?php echo $productDetails['name']; ?>"
                                data-product-price="<?php echo $productDetails['price']; ?>"
                                onclick="cloneProductAndAddons(this)"
                                id="modal_buuton_<?php echo 'single-item-details-modal' . $product['productId']; ?>_<?php echo $productDetails['productExtendedId']?>"
                            >
                                <?php echo $this->language->tLine('Add to list');?>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- end modal single item details -->
            <?php
        }
    }
?>
