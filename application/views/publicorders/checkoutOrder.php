<main class="container checkoutOrderBody" style="text-align:left; margin-bottom:20px">
    <form id="goOrder" method="post" onsubmit="return submitForm">
        <input type="text" name="orderRandomKey" value="<?php echo $orderRandomKey; ?>" required readonly hidden />
        <input type="text" name="vendorId" value="<?php echo $vendor['vendorId']; ?>" required readonly hidden />
        <input type="text" name="spotId" value="<?php echo $spot['spotId']; ?>" required readonly hidden />
        <input type="text" name="spotTypeId" value="<?php echo $spot['spotTypeId']; ?>" required readonly hidden />
        <!--BUYER DATA-->
        <input type="text" name="user[roleid]" value="<?php echo $buyerRole; ?>" required readonly hidden />
        <input type="text" name="user[usershorturl]" value="<?php echo $buyershorturl; ?>" required readonly hidden />
        <input type="text" name="user[salesagent]" value="<?php echo $salesagent; ?>" required readonly hidden /> 
        <?php if ($vendor['requireEmail'] === '0' ) { ?>                    
            <input
                type="email"
                name="user[email]"
                value="<?php echo 'anonymus_' . strval(time()) . '_' . rand(1, 1000000) . '@tiqs.com'; ?>"
                required
                readonly
                hidden
            />
        <?php } ?>
        <?php if ($vendor['requireName'] === '0' ) { ?>                    
            <input
                type="email"
                name="user[username]"
                value="<?php echo 'no name ' . date('Y-m-d H:i:s');; ?>"
                required
                readonly
                hidden
            />
        <?php } ?>

        <?php
            if ($vendor['preferredView'] === $oldMakeOrderView) {
                include_once FCPATH . 'application/views/publicorders/includes/modals/checkout/checkoutOrderFirstVresion.php';
            } elseif ($vendor['preferredView'] === $newMakeOrderView) {
                include_once FCPATH . 'application/views/publicorders/includes/modals/checkout/checkoutOrderSecondVresion.php';
            }
            include_once FCPATH . 'application/views/publicorders/includes/modals/checkout/checkoutOrderTip.php';
        ?>

        <div class="row d-flex justify-content-center" id="checkout">
            <div class="col-sm-12 col-lg-9 left-side">
                <?php if (isset($workingTime)) { ?>
                    <div class="checkout-title">
                        <span><?php echo $spot['spotType']; ?>&nbsp;<?php echo $this->language->line("PAYMENT-C0010",'period and time');?> </span>
                    </div>
                    <div class="row">                        
                        <?php if (intval($spot['spotTypeId']) === $this->config->item('deliveryType')) { ?>
                            <div class="form-group col-sm-6">
                                <label class="labelColorCheckout" for="city"><?php echo $this->language->line("PAYMENT-C0020",'City');?><sup>*</sup></label>
                                <input
                                    type="teyt"
                                    id="city"
                                    class="form-control inputFieldCheckout"
                                    name="user[city]"
                                    value="<?php echo $city; ?>"
                                    placeholder="<?php echo $this->language->line("PAYMENT-C0020",'City');?>"
                                    required
                                    data-name='City'
                                />
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="labelColorCheckout" for="zipcode"><?php echo $this->language->line("PAYMENT-C0020",'Zipcode');?><sup>*</sup></label>
                                <input
                                    type="text"
                                    id="zipcode"
                                    class="form-control inputFieldCheckout"
                                    name="user[zipcode]"
                                    value="<?php echo $zipcode; ?>"
                                    placeholder="<?php echo $this->language->line("PAYMENT-C0020",'Zipcode');?>"
                                    required
                                    data-name='Zipcode'
                                />
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="labelColorCheckout" for="address"><?php echo $this->language->line("PAYMENT-C0020",'Address');?><sup>*</sup></label>
                                <input
                                    type="text"
                                    id="address"
                                    class="form-control inputFieldCheckout"
                                    name="user[address]"
                                    value="<?php echo $address; ?>"
                                    placeholder="<?php echo $this->language->line("PAYMENT-C0020",'Address');?>"
                                    required
                                    data-name='Address'
                                />
                            </div>                            
                        <?php } ?>
                        <div class="form-group col-sm-6">
                            <label class="labelColorCheckout" for="periodTime" ><?php echo $this->language->line("PAYMENT-PC00120",'Choose');?>&nbsp;<?php echo lcfirst($spot['spotType']); ?>&nbsp;<?php echo $this->language->line("PAYMENT-PC0020",'period');?><sup>*</sup></label>
                            <div>
                                <select
                                    id="periodTime"
                                    name="order[date]"
                                    class="form-control inputFieldCheckout"
                                    style="text-align:center"
                                    onchange="buyerSelectTime(this.value, 'orderTimeDiv', 'orderTimeInput')"
                                    >
                                    <?php
                                        $now = now();
                                        $today = date('Y-m-d', $now);
                                        $currentTime = date('H:i:s', now());
                                        $tomorrow = date('Y-m-d', strtotime($today . "+1 days"));
                                        $skip = 0;
                                        foreach ($workingTime as $date => $time) {
                                            if ($vendor['cutTime'] && $vendor['cutTime'] !== '00:00:00') {
                                                if ($vendor['skipDate'] === '1') {
                                                    if ($date === $today || ($currentTime >= $vendor['cutTime'] && $date === $tomorrow)) {
                                                        continue;
                                                    }
                                                } elseif ($vendor['skipDate'] === '0') {
                                                    if ($skip === 0 || ($currentTime >= $vendor['cutTime'] && $skip === 1)) {
                                                        $skip++;
                                                        continue;
                                                    }
                                                }
                                            }
                                            foreach ($time as $hours) {
                                                // checking time from and time to for current date
                                                if ($date === date('Y-m-d', $now)) {
                                                    $userTimeSubstract = $delayTime + $busyTime;

                                                    // first check time to, is period in past
                                                    $subtractTime = strtotime($hours['timeTo']) - $userTimeSubstract * 60;
                                                    $checkTimeTo = date('H:i:s', $subtractTime);
                                                    if ($currentTime > $checkTimeTo) continue;

                                                    // check time to and set new if needed
                                                    $checkTimeFrom = date('Y-m-d H:i:s', strtotime('+' . $userTimeSubstract . ' minutes', $now));
                                                    if (date($date . ' ' . $hours['timeFrom']) < $checkTimeFrom) {
                                                        $hours['timeFrom'] = date('H:i:s', strtotime($checkTimeFrom));
                                                    }
                                                }
                                                ?>
                                                    <option
                                                        value="<?php echo $date . ' ' . $hours['timeFrom']. ' ' . $hours['timeTo']; ?>"
                                                    >
                                                        <?php echo $this->language->line($date . ' (' . $hours['day'] . ')',$date . ' (' . $hours['day'] . ')'). ' '.$this->language->line("PAYMENT-ABC0035"," from ").' '. $hours['timeFrom'] . " ".$this->language->line("PAYMENT-ABC0045"," to ")." " . $hours['timeTo'] ?>
                                                    </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6" id="orderTimeDiv">
                            <label class="labelColorCheckout" for="orderTime"><?php echo $this->language->line("PAYMENT-PC0110",'Select ');?>&nbsp;<?php echo lcfirst($spot['spotType']); ?>&nbsp;<?php echo $this->language->line("PAYMENT-PC0120",'time');?> (<sup>*</sup>)</label>
                            <input type="text" id="orderTimeInput" class="form-control timepicker inputFieldCheckout" name="order[time]" readonly />
                        </div>
                    </div>
                <?php } ?>
                <div class="checkout-btns">
                    <a
                        id="checkoutBack"
                        href="<?php echo base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spotId . '&' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                        style="background-color: #948b6f" class="button"
                        >
                        <i class="fa fa-arrow-left"></i>
                        Back to list                    </a>
                    <a
                        id="checkoutContinue"
                        href="javascript:void(0);"
                        style="background-color: #349171"
                        class="button"
                        onclick="submitForm()"
                        >
                        Continue
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>     
        <input type="number" name="order[spotId]"     value="<?php echo $spotId; ?>" readonly required hidden />
        <input type="number" name="order[serviceFee]" value="<?php echo round($serviceFee, 2); ?>" id="serviceFeeInput" min="0" step="0.01"  readonly required hidden />
        <input type="number" name="order[amount]"     value="<?php echo round($orderTotal, 2); ?>" id="orderAmountInput" min="0" step="0.01"  readonly required hidden />
    </form>
</main>

<div class="modal" id="modalDelivery">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Delivery notice</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
				&nbsp;<?php echo $this->language->line("DELIVERY-A0001",'Sorry, but we do not deliver to given address, due to the distance. Please change delivery location.');?>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modalPickup">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Delivery notice</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                Sorry, but we do not deliver to given address.
                <br style="display:initial"/>
                You can click cancel and change delivery location or you can select pickup option.
                In that case you order details will be reset.
                <i
                    class="fa fa-info-circle" aria-hidden="true"
                    data-toggle="pickupPopover"

					data-content="<?php echo $this->language->line("DELIVERY-A0010",'We will reset your order because the selected products may be not available in pick-up option or can be differently priced.');?>
"
                >
                </i>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <a
                    href="<?php echo base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&typeId=' . $pickupTypeId; ?>"
                    class="btn btn-primary btn-lg active"
                    role="button"
                    aria-pressed="true">Select pickup
                </a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
    var checkoutOrdedGlobals = (function(){
        let askId = '<?php echo THGROUP; ?>';
        let vendorId = '<?php echo $vendor['vendorId'] ?>';
        let condition = (askId === vendorId) ? true : false;

        let globals = {
            'serviceFeePercent': parseFloat('<?php echo $serviceFeePercent; ?>'),
            'serviceFeeAmount': parseFloat('<?php echo $serviceFeeAmount; ?>'),
            'minimumOrderFee' : parseFloat('<?php echo $minimumOrderFee; ?>'),
            'serviceFeeSpanId' : 'serviceFee',
            'totalAmountSpanId': 'totalAmount',
            'serviceFeeInputId' : 'serviceFeeInput',
            'orderAmountInputId' : 'orderAmountInput',
            'calculateTotalClass' : 'calculateTotal',
            'thGroup': condition,
            'periodTime' : 'periodTime',
            'orderTimeDiv' : 'orderTimeDiv',
            'orderTimeInput' : 'orderTimeInput',
            'orderDataGetKey' : '<?php echo $orderDataGetKey; ?>',
            'orderRandomKey' : '<?php echo $orderRandomKey; ?>',
            'formId': 'goOrder',
            'cityId': 'city',
            'zipcodeId': 'zipcode',
            'addressId': 'address',
            'privacyPolicy' : 'privacyPolicy',
            'termsAndConditions' : 'termsAndConditions',
            
        }
        Object.freeze(globals);
        return globals;
    }());
    
</script>
