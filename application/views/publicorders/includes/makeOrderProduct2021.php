<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="menu-list__item">

    <!--show image only on mobile, add conatiner -->
    <div class='menu-list__name'>
        <b class='menu-list__title'>
            <?php echo $productDetails['name']; ?>
            <?php if ($productDetails['longDescription'] && $productDetails['longDescription'] !== 'NA') { ?>
            <i style="width: 15px" class="fa fa-info-circle infoCircle" aria-hidden="true"
                data-toggle="popover" data-trigger="hover" data-placement="bottom"
                data-content="<?php echo $productDetails['longDescription']; ?>"></i>
            <?php } ?>
        </b>
        <?php if (trim($productDetails['name']) !== trim($productDetails['shortDescription'])) { ?>
            <p class='menu-list__ingredients'>
                <?php echo $productDetails['shortDescription']; ?>
            </p>
        <?php } ?>

        <?php
            $baseUrl = base_url();
            if ($vendor['showAllergies'] === '1') {
                $productAllergies = unserialize($product['allergies']);
                if (!empty($productAllergies['productAllergies'])) {
                    ?>
                        <!-- product allergies -->
                        <div>
                            <?php
                                $productAllergies = $productAllergies['productAllergies'];
                                foreach ($productAllergies as $allergy) {
                                    ?>
                                        <img
                                            src="<?php echo $baseUrl . 'assets/images/allergies/' . str_replace(' ', '_', $allergy); ?>.png"
                                            class="ingredients"
                                            alt="<?php echo $allergy; ?>"
                                            style="display:inline; margin:5px 2px"
                                            width="20"
                                            height="20"
                                        />
                                    <?php
                                } ?>
                        </div>
                        <!-- product allergies -->
                    <?php
                }
            }
        ?>
    </div>

    <!-- product price and button -->
    <div class='menu-list__right-col'>
        <div class='menu-list__price'>
            <b class='menu-list__price'><?php echo $productDetails['price']; ?>&euro; </b>
            <!--
                <b class='menu-list__price--stroke'>6.00$ </b>
                <b class='menu-list__price--discount'>4.00$</b>
            -->
        </div>
        <!-- <b class='menu-list__type'>vegan</b> -->
        <div class="quantity-section">
            <button
                class='quantity-button quantity-button--minus'
                <?php if ($product['addRemark'] === '1' || !empty($product['addons'])) { ?>
                <?php } else { ?>
                    onclick="mainProductQuantity(this, false)"
                <?php } ?>
            >
                -
            </button>
            <input
                type="number"
                value='0'
                placeholder='0'
                min="0"
                max="1000000"
                class='quantity-input'
                step="1"
                data-id="<?php echo $productDetails['productExtendedId']; ?>"
            />
            <button
                type="button"
                class='quantity-button quantity-button--plus'
                <?php if ($product['addRemark'] === '1' || !empty($product['addons'])) { ?>
                    data-toggle="modal"
                    data-target="#modal-additional-options_<?php echo $productDetails['productExtendedId']; ?>"
                <?php } else { ?>
                    onclick="mainProductQuantity(
                                                    this,
                                                    true,
                                                    '<?php echo $productDetails['name']; ?>',
                                                    '<?php echo $productDetails['price']; ?>'
                                                )"
                <?php } ?>
            >
                +
            </button>
        </div>
    </div>
    <!-- end product price and button -->
</div>

<?php
    if ($product['addRemark'] === '1' || $product['onlyOne'] !== '1') {
        $modalId = 'modal-additional-options_' . $productDetails['productExtendedId'];
        ?>
            <!-- MODAL ADDITIONAL OPTIONS -->
            <div
                class="modal fade"
                id="<?php echo $modalId; ?>"
                tabindex="-1"
                role="dialog"
                aria-labelledby="modal-additional-options_label_<?php echo $productDetails['productExtendedId']; ?>"
                aria-hidden="true"
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5
                                class="modal-title"
                                id="modal-additional-options_label_<?php echo $productDetails['productExtendedId']; ?>"
                            >
                                <?php echo $productDetails['name']; ?>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearModal('<?php echo $modalId; ?>')">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <input
                                type="number"
                                value="1"
                                data-price="<?php echo $productDetails['price']; ?>"
                                name="order[<?php echo $productDetails['productExtendedId']; ?>][quantity]"
                                readonly
                                hidden
                            />
                            <?php
                                if ($product['addRemark'] === '1') {
                                    $productRemarkId = 'product_remark_' . $productDetails['productExtendedId'];
                                    ?>
                                        <!-- product remark -->
                                        <div style="width: 100%; margin: 0px 0px 20px 0px">
                                            <label for="<?php echo $productRemarkId; ?>">Add remark:&nbsp;</label>
                                            <input
                                                class="form form-control"
                                                type="text"
                                                value=""
                                                maxlength="<?php echo $maxRemarkLength; ?>"
                                                placeholder="Allowed <?php echo $maxRemarkLength; ?> characters"
                                                name="order[<?php echo $productDetails['productExtendedId']; ?>][remark]"
                                                oninput="setInputAttribte(this, 'value', this.value)"
                                            />
                                        </div>
                                        <!-- end product remark -->
                                    <?php
                                }
                            ?>

                            <?php if ($product['addons']) { ?>
                                <!-- product addons -->
                                <div>
                                    <?php
                                        // prepare product addons
                                        $productAddons = $product['addons'];
                                        $collectAddons = [];
                                        foreach ($productAddons as $productAddonData) {
                                            $addonId = $productAddonData[0][0];
                                            $allowedQuantity = $productAddonData[0][1];
                                            $addon = $addons[$addonId][0];
                                            $addon['addonAllowedQuantity'] = $allowedQuantity;
                                            if (!isset($collectAddons[$addon['productType']])) {
                                                $collectAddons[$addon['productType']] = [];
                                            }
                                            array_push($collectAddons[$addon['productType']], $addon);
                                        }
                                    ?>

                                    <!-- show product addons -->
                                    <?php foreach ($collectAddons as $type => $typeAddons) { ?>
                                        <div class="menu-list" style="margin:30px 0px 0px 0px">
                                            <div class="menu-list__name">
                                                <h6><?php echo $type; ?></h6>
                                            </div>
                                            <?php foreach ($typeAddons as $showAddon) { ?>
                                                <?php
                                                    // echo '<pre>';
                                                    // print_r($showAddon);
                                                    // echo '</pre>';
                                                    // prepare addon allergies
                                                    if ($vendor['showAllergies'] === '1') {
                                                        $addonAllergies = unserialize($showAddon['allergies']);
                                                        $addonAllergies = !empty($addonAllergies['productAllergies']) ? $addonAllergies['productAllergies'] : [];
                                                    }
                                                ?>

                                                <!-- addon name and buttons -->
                                                <div
                                                    class="menu-list__item"
                                                    style="margin:0px 0px 0px 0px; <?php if ($showAddon['addRemark'] === '1' || !empty($addonAllergies)) {echo 'border-bottom:0px #fff;';}?>"
                                                >
                                                    <div class="menu-list__name">
                                                        <label class="form-check-label" style="word-wrap: break-word;">
                                                            <input
                                                                type="checkbox"
                                                                class="form-check-input"
                                                                style="margin: 4px 0px 0px 5px"
                                                                onchange="dipsalyButtons(this)"
                                                            />
                                                            <span style="margin-left: 10px">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $showAddon['name'] . ' (' . $showAddon['price'] . '&euro;)'; ?></span>
                                                        </label>
                                                    </div>
                                                    <div class="menu-list__right-col" style="display:none">
                                                        <div class="quantity-section mt-0">
                                                            <?php if ($showAddon['addonAllowedQuantity'] !== '1') { ?>
                                                                <button
                                                                    type="button"
                                                                    class="quantity-button quantity-button--minus"
                                                                    onclick="changeSiblingValue(this, false)"
                                                                >
                                                                    -
                                                                </button>
                                                            <?php } ?>
                                                            <input
                                                                name="order[<?php echo $productDetails['productExtendedId']; ?>][addons][<?php echo $showAddon['productExtendedId']; ?>][quantity]"
                                                                class="quantity-input"
                                                                type="number"
                                                                value="1"
                                                                placeholder="0"
                                                                max="<?php echo $showAddon['addonAllowedQuantity']; ?>"
                                                                min="1"
                                                                step="1"
                                                                data-price="<?php echo $showAddon['price']; ?>"
                                                                disabled
                                                                <?php if ($showAddon['addonAllowedQuantity'] !== '1') { ?>
                                                                    readonly
                                                                <?php } else { ?>
                                                                    hidden
                                                                <?php } ?>
                                                            />
                                                            <?php if ($showAddon['addonAllowedQuantity'] !== '1') { ?>
                                                                <button
                                                                    type="button"
                                                                    class="quantity-button quantity-button--plus"
                                                                    onclick="changeSiblingValue(this, true)"
                                                                >
                                                                    +
                                                                </button>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end addon name and buttons -->

                                                <?php
                                                    if ($showAddon['addRemark'] === '1') {
                                                        $showAddonRemarkId = 'addon_remark_' . $showAddon['productExtendedId']; ?>
                                                            <!-- addon remark -->
                                                            <div
                                                                class="menu-list__item"
                                                                <?php if (isset($addonAllergies)) {echo 'style="border-bottom: 0px #fff;"';} ?>
                                                            >
                                                                <label for="<?php echo $showAddonRemarkId; ?>">Add remark:&nbsp;</label>
                                                                <input
                                                                    id="<?php echo $showAddonRemarkId; ?>"
                                                                    class="form form-control"
                                                                    type="text"
                                                                    maxlength="<?php echo $maxRemarkLength; ?>"
                                                                    placeholder="Allowed <?php echo $maxRemarkLength; ?> characters"
                                                                    name="order[<?php echo $productDetails['productExtendedId']; ?>][addons][<?php echo $showAddon['productExtendedId']; ?>][remark]"
                                                                    value=""
                                                                    oninput="setInputAttribte(this, 'value', this.value)"
                                                                />
                                                            </div>
                                                            <!-- end addon remark -->
                                                        <?php
                                                    }
                                                ?>
                                                
                                                <?php if (!empty($addonAllergies)) { ?>
                                                    <!-- addon allergies -->
                                                    <div style="border-bottom: 1px solid #cfcfcf">
                                                        <?php foreach ($addonAllergies as $allergy) { ?>
                                                            <img
                                                                src="<?php echo $baseUrl . 'assets/images/allergies/' . str_replace(' ', '_', $allergy); ?>.png"
                                                                alt="<?php echo $allergy; ?>"
                                                                class="ingredients imgAlergies"
                                                                width="20"
                                                                height="20"
                                                                style="display:inline; margin:0px 2px 3px 0px"
                                                            />
                                                        <?php } ?>
                                                    </div>
                                                    <!-- end addon allergies -->
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!-- end product addons -->
                            <?php } ?>
                        </div>

                        <div class="modal-footer">
                            <div>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    onclick="addInCheckoutList(
                                        '<?php echo $modalId; ?>',
                                        '<?php echo $productDetails['productExtendedId'] . ''; ?>',
                                        '<?php echo $productDetails['name']; ?>',
                                        '<?php echo $productDetails['price']; ?>'
                                    )"
                                >
                                    Save
                                </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearModal('<?php echo $modalId; ?>')">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
?>
