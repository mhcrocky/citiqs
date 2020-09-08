<main class="container" style="text-align:left; margin-bottom:20px">
    <form id="goOrder" method="post" action="<?php echo base_url() . 'publicorders/submitOrder'; ?>">

        <?php
            if ($vendor['preferredView'] === $oldMakeOrderView) {
                include_once FCPATH . 'application/views/publicorders/includes/checkoutOrderFirstVresion.php';
            } elseif ($vendor['preferredView'] === $newMakeOrderView) {
                include_once FCPATH . 'application/views/publicorders/includes/checkoutOrderSecondVresion.php';
            }
        ?>

        <div class="row d-flex justify-content-center" id="checkout">
            <div class="col-sm-12 col-lg-9 left-side">
                <div class="checkout-title">
                    <span>Checkout</span>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="firstNameInput">Name (<sup>*</sup>)</label>
                        <input id="firstNameInput" class="form-control" name="user[username]" value="<?php echo $username; ?>" type="text" placeholder="Name" required />
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="emailAddressInput">Email address <sup>*</sup></label>
                        <input
                            type="email"
                            id="emailAddressInput"
                            class="form-control"
                            name="user[email]"
                            value="<?php echo $email; ?>"
                            placeholder="Email address"
                            required
                            oninput="checkUserNewsLetter(this.id)"
                        />
                    </div>
                    <!-- <div class="form-group col-sm-6" style="display:none">
                        <label for="country-code">Country Code <sup>*</sup></label>
                        <select name="user[country]" class='form-control'>
                            <?php #foreach ($countries as $countryCode => $country) { ?>
                                <option
                                    value="<?php #echo $countryCode; ?>"
                                    <?php
                                        // if ( 
                                        //     (!$userCountry && $countryCode === 'NL') 
                                        //     || ($userCountry && $countryCode === $userCountry)
                                        // ) {
                                        //     echo 'selected';
                                        // }
                                    ?>
                                    >
                                    <?php #echo $country; ?>
                                </option>
                            <?php #} ?>
                        </select>
                    </div> -->
                    <?php if ($vendor['requireMobile'] === '1') { ?>
                        <div class="form-group col-sm-6">
                            <label for="phoneInput">Phone <sup>*</sup></label>
                            <div>
                                <select class="form-control" style="width:22% !important; display:inline-block !important" name="phoneCountryCode" style="text-align:center">
                                    <?php foreach ($countryCodes as $code => $data) { ?>                                
                                        <option
                                            value="<?php $value = '00' . $data['code']; echo $value ?>"
                                            <?php
                                                if (
                                                    ($phoneCountryCode && $code === $phoneCountryCode)
                                                    || ($phoneCountryCode && $value === $phoneCountryCode)
                                                    || (!$phoneCountryCode && $code === $vendor['vendorCountry'])
                                                ) echo 'selected';
                                            ?>
                                            >
                                            <?php echo $code; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <input id="phoneInput" class="form-control" style="width:76% !important; display:inline-block !important" name="user[mobile]" value="<?php echo $mobile; ?>" type="text" placeholder="Phone" required />
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group col-sm-12">
                        <label for="notesInput">Remarks</label>
                        <textarea id="notesInput" class="form-control" name="order[remarks]" rows="3" maxlength="250"></textarea>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Recive our newsletter</label>
                        <label class="radio-inline" for="newsLetterYes">
                            <input type="radio" id="newsLetterYes" name="user[newsletter]" value="1" />
                            Yes
                        </label>
                        <label class="radio-inline" for="newsLetterNo">
                            <input type="radio" id="newsLetterNo" name="user[newsletter]"  value="0" checked />
                            No
                        </label>
                    </div>
                    <?php
                        if (isset($workingTime)) {
                            ?>
                            <div class="form-group col-sm-6">
                                <label for="typeTime">Select <?php echo $spotType ?> period <sup>*</sup></label>
                                <div>
                                    <select
                                        name="order[date]"
                                        class="form-control"
                                        style="text-align:center"
                                        onchange="buyerSelectTime(this.value, 'orderTimeDiv', 'orderTimeInput')"
                                        >
                                        <option value="">Select</option>
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
                            <div class="form-group col-sm-12" id="orderTimeDiv" style="display:none">
                                <label for="orderTime">Select  <?php echo $spotType ?> time (<sup>*</sup>)</label>
                                <input type="text" id="orderTimeInput" class="form-control timepicker" name="order[time]" />
                            </div>
                        <?php
                        }
                    ?>

                </div>

                <div class="checkout-btns">
                    <a href="<?php echo base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spotId; ?>" style="background-color: #948b6f" class="button">
                        <i class="fa fa-arrow-left"></i>
                        Back to list                    </a>
                    <a href="javascript:void(0);" style="background-color: #349171" class="button" onclick="submitForm('goOrder', 'serviceFeeInput', 'orderAmountInput');">
                        Pay
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <input type="text"      name="user[roleid]"         value="<?php echo $buyerRole; ?>" required readonly hidden />
        <input type="text"      name="user[usershorturl]"   value="<?php echo $usershorturl; ?>" required readonly hidden />
        <input type="text"      name="user[salesagent]"     value="<?php echo $buyerRole; ?>" required readonly hidden />      
        <input type="number"    name="order[spotId]"        value="<?php echo $spotId; ?>" readonly required hidden />
        <input type="number"    name="order[serviceFee]"    value="<?php echo $serviceFee; ?>" id="serviceFeeInput" min="0" step="0.01"  readonly required hidden />
        <input type="number"    name="order[amount]"        value="<?php echo $orderTotal; ?>" id="orderAmountInput" min="0" step="0.01"  readonly required hidden />
    </form>
</main>
<script>
    var checkoutOrdedGlobals = (function(){
        let globals = {
            'minimumOrderFee' : parseFloat('<?php echo $vendor['minimumOrderFee']; ?>'),
            'serviceFeePercent': parseFloat('<?php echo $vendor['serviceFeePercent']; ?>'),
            'serviceFeeAmount': parseFloat('<?php echo $vendor['serviceFeeAmount']; ?>'),
            'serviceFeeSpanId' : 'serviceFee',
            'totalAmountSpanId': 'totalAmount',
            'serviceFeeInputId' : 'serviceFeeInput',
            'orderAmountInputId' : 'orderAmountInput',
            'calculateTotalClass' : 'calculateTotal'
        }
        Object.freeze(globals);
        return globals;
    }());
</script>