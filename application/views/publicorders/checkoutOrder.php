<main class="container" style="text-align:left; margin-bottom:20px">
    <form id="goOrder" method="post" action="<?php echo base_url() . 'publicorders/submitOrder'; ?>">

        <?php
            if ($vendor['preferredView'] === $oldMakeOrderView) {
                include_once FCPATH . 'application/views/publicorders/includes/checkoutOrderFirstVresion.php';
            } elseif ($vendor['preferredView'] === $newMakeOrderView) {
                include_once FCPATH . 'application/views/publicorders/includes/checkoutOrderSecondVresion.php';
            }
            include_once FCPATH . 'application/views/publicorders/includes/checkoutOrderTip.php';
        ?>

        <div class="row d-flex justify-content-center" id="checkout">
            <div class="col-sm-12 col-lg-9 left-side">
                <?php if (isset($workingTime)) { ?>
                    <div class="checkout-title">
                        <span><?php echo $spot['spotType']; ?> period and time</span>
                    </div>
                    <div class="row">                        
                        <?php if (intval($spot['spotTypeId']) === $this->config->item('deliveryType')) { ?>
                            <div class="form-group col-sm-6">
                                <label for="city">City <sup>*</sup></label>
                                <input
                                    type="teyt"
                                    id="city"
                                    class="form-control"
                                    name="user[city]"
                                    value="<?php echo $city; ?>"
                                    placeholder="City"
                                    required
                                />
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="zipcode">Zip code <sup>*</sup></label>
                                <input
                                    type="text"
                                    id="zipcode"
                                    class="form-control"
                                    name="user[zipcode]"
                                    value="<?php echo $zipcode; ?>"
                                    placeholder="Zip code"
                                    required
                                />
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="address">Address <sup>*</sup></label>
                                <input
                                    type="text"
                                    id="address"
                                    class="form-control"
                                    name="user[address]"
                                    value="<?php echo $address; ?>"
                                    placeholder="Delivery address"
                                    required
                                />
                            </div>                            
                        <?php } ?>
                        <div class="form-group col-sm-6">
                            <label for="periodTime" >Select <?php echo lcfirst($spot['spotType']); ?> period <sup>*</sup></label>
                            <div>
                                <select
                                    id="periodTime"
                                    name="order[date]"
                                    class="form-control"
                                    style="text-align:center"
                                    onchange="buyerSelectTime(this.value, 'orderTimeDiv', 'orderTimeInput')"
                                    >
                                    <?php
                                        $now = now();
                                        foreach ($workingTime as $date => $time) {
                                            foreach ($time as $hours) {
                                                // checking time from and time to for current date
                                                if ($date === date('Y-m-d', $now)) {
                                                    $userTimeSubstract = $delayTime + $busyTime;

                                                    // first check time to, is period in past
                                                    $subtractTime = strtotime($hours['timeTo']) - $userTimeSubstract * 60;
                                                    $checkTimeTo = date('H:i:s', $subtractTime);
                                                    if (date('H:i:s', $now) > $checkTimeTo) continue;

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
                                                        <?php echo $date . ' (' . $hours['day'] . ') From: ' . $hours['timeFrom'] . ' To: ' . $hours['timeTo'] ?>
                                                    </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6" id="orderTimeDiv">
                            <label for="orderTime">Select <?php echo lcfirst($spot['spotType']); ?> time (<sup>*</sup>)</label>
                            <input type="text" id="orderTimeInput" class="form-control timepicker" name="order[time]" />
                        </div>
                    </div>
                <?php } ?>
                <div class="checkout-btns">
                    <a href="<?php echo base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spotId; ?>" style="background-color: #948b6f" class="button">
                        <i class="fa fa-arrow-left"></i>
                        Back to list                    </a>
                    <a href="javascript:void(0);" style="background-color: #349171" class="button" onclick="submitForm('goOrder', 'serviceFeeInput', 'orderAmountInput');">
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
<script>
    var checkoutOrdedGlobals = (function(){
        let askId = '<?php echo THGROUP; ?>';
        let vendorId = '<?php echo $vendor['vendorId'] ?>';
        let condition = (askId === vendorId) ? true : false;

        let globals = {
            'minimumOrderFee' : parseFloat('<?php echo $vendor['minimumOrderFee']; ?>'),
            'serviceFeePercent': parseFloat('<?php echo $vendor['serviceFeePercent']; ?>'),
            'serviceFeeAmount': parseFloat('<?php echo $vendor['serviceFeeAmount']; ?>'),
            'serviceFeeSpanId' : 'serviceFee',
            'totalAmountSpanId': 'totalAmount',
            'serviceFeeInputId' : 'serviceFeeInput',
            'orderAmountInputId' : 'orderAmountInput',
            'calculateTotalClass' : 'calculateTotal',
            'thGroup': condition,
            'periodTime' : 'periodTime',
            'orderTimeDiv' : 'orderTimeDiv',
            'orderTimeInput' : 'orderTimeInput',
        }
        Object.freeze(globals);
        return globals;
    }());
</script>