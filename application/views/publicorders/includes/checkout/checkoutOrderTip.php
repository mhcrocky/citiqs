<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
            <div class="checkout-table__single-element checkout-table__single-element--total checkoutOrderBody borderColor">
                <div class="checkout-table__total">
                    <b class="feeTotalTip"><?php echo $this->language->tLine('FEE');?></b>
                    <span id="serviceFee">
                        <?php
                            $serviceFee = $orderTotal * $serviceFeePercent / 100 + $minimumOrderFee;
                            if ($serviceFee > $serviceFeeAmount) $serviceFee = $serviceFeeAmount;
                            echo number_format($serviceFee, 2, ".", ","); ?> &euro;
                    </span>
                </div>
            </div>
            <div class="checkout-table__single-element checkout-table__single-element--total checkoutOrderBody borderColor">
                <div class="checkout-table__total checkoutOrderBody">
                    <b class="feeTotalTip"><?php echo $this->language->tLine('AMOUNT');?></b>
                    <span id="totalAmount">
                        <?php
                            $total = $orderTotal + $serviceFee;
                            echo number_format($total, 2, ".", ",");
                        ?> &euro;
                    </span>
                </div>
            </div>
            <?php if ($vendor['tipWaiter'] === '1') { ?>
                <div class="checkout-table__single-element checkout-table__single-element--total checkoutOrderBody borderColor">
                    <div class="checkout-table__total checkoutOrderBody" style="text-align:right">
                        <b class="feeTotalTip"><?php echo $this->language->tLine('TIP');?></b>
                        <span>
                            <input
                                type="number"
                                min="0"
                                value="<?php echo $waiterTip; ?>"
                                step="0.01"
                                id="waiterTip"
                                name="order[waiterTip]"
                                class="form-control inputFieldCheckout"
                                oninput="addTip(this)"
                                style="width:25%; display:inline"
                            /> &euro;
                        </span>
                    </div>
                </div>
                <div class="checkout-table__single-element checkout-table__single-element--total checkoutOrderBody borderColor" style="text-align:right">
                    <div class="checkout-table__total ">
                        <b class="feeTotalTip"><?php echo $this->language->tLine('TOTAL');?> </b>
                        <span>
                            <input
                                type="number"
                                min="<?php echo round($total, 2); ?>"
                                <?php
                                    $totalWithTip = $total + $waiterTip;
                                ?>
                                value="<?php echo round($totalWithTip, 2); ?>"
                                step="0.01"
                                id="totalWithTip"
                                placeholder="<?php echo $this->language->tLine('Waiter tip');?>"
                                class="form-control inputFieldCheckout"
                                oninput="addTotalWithTip(this)"
                                onchange="checkValue(this)"
                                style="width:25%; display:inline"
                            /> &euro;
                        </span>
                    </div>
                </div>
            <?php } ?>
            <?php if ($vendor['requireRemarks'] === '1') { ?>
                <div class="form-group col-sm-12 checkoutOrderBody borderColor">
                    <label class="labelColorCheckout" for="notesInput"><?php echo $this->language->tLine('Remarks');?> </label>
                    <input
                        type="text"
                        id="notesInput"
                        class="form-control inputFieldCheckout"
                        name="order[remarks]"
                        rows="3"
                        maxlength="<?php echo $maxRemarkLength; ?>"
                        placeholder="<?php echo $this->language->tLine('Allowed') . ' ' . $maxRemarkLength . ' ' . $this->language->tLine('characters'); ?>"
                    />
                </div>
            <?php } ?>
            <?php
                if ($vendor['termsAndConditions'] && $vendor['showTermsAndPrivacy'] === '1') {
                    $return = base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spot['spotId'] . '&' . $orderDataGetKey . '=' . $orderRandomKey;
                    ?>
                    <div class="form-group col-sm-12 checkbox">
                        <label>
                            <input
                                type="checkbox"
                                value="1"
                                name="order[termsAndConditions]"
                                <?php echo $termsAndConditions; ?>
                                id="termsAndConditions"
                                class="inputFieldCheckout"
                            />
                            <?php echo $this->language->tLine('I read and accept the');?>
                            <a href="<?php echo $return; ?>">
                                <?php echo $this->language->tLine('Terms and conditions');?>
                            </a>
                        </label>
                    </div>
                    <div class="form-group col-sm-12 checkbox">
                        <label>
                            <input
                                type="checkbox"
                                value="1"
                                name="order[privacyPolicy]"
                                <?php echo $privacyPolicy; ?>
                                id="privacyPolicy"
                                class="inputFieldCheckout"
                            />
                            <?php echo $this->language->tLine('I took notice of');?>&nbsp;
                            <a href="<?php echo $return; ?>">
                                <?php echo $this->language->tLine('Privacy policy');?>
                            </a>
                        </label>
                    </div>
                    <?php
                }
            ?>
            <!-- end total sum-->
        </div>
        <!-- end checkout table -->
    </div>
</div>
