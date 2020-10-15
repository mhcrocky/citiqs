<main class="container" style="text-align:left; margin-bottom:20px">
    <form id="goOrder" method="post" action="<?php echo base_url() . 'publicorders/confirmBuyerData'; ?>">
        <div class="row d-flex justify-content-center" id="checkout">
            <div class="col-sm-12 col-lg-9 left-side">
                <div class="checkout-title">
                    <span>Your details</span>
                </div>
                <div class="row">
                    <?php if ($vendor['requireName'] === '1') { ?>
                        <div class="form-group col-sm-6">
                            <label for="firstNameInput">Name (<sup>*</sup>)</label>
                            <input id="firstNameInput" class="form-control" name="user[username]" value="<?php echo $username; ?>" type="text" placeholder="Name" required />
                        </div>
                    <?php } ?>
                    <?php if ($vendor['requireEmail'] === '1' || intval($spot['spotTypeId']) !== $local) { ?>
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
                    <?php } ?>
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
                    <?php if ($vendor['requireMobile'] === '1' || intval($spot['spotTypeId']) !== $local ) { ?>
                        <div class="form-group col-sm-6">
                            <label for="phoneInput">Phone <sup>*</sup></label>
                            <div>
                                <select class="form-control" style="width:22% !important; display:inline-block !important" name="phoneCountryCode" style="text-align:center">
                                    <?php foreach ($countryCodes as $code => $data) { ?>                                
                                        <option
                                            value="<?php $value = '00' . $data['code']; echo $value ?>"0
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
                    <?php if ($vendor['requireNewsletter'] === '1') { ?>
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
                    <?php } ?>
                    <?php if ($vendor['termsAndConditions'] && $vendor['showTermsAndPrivacy'] === '1') { ?>
                    <div class="form-group col-sm-12 checkbox">
                        <label>
                            <input type="checkbox" value="1" name="order[termsAndConditions]"  <?php echo $termsAndConditions; ?> />
                            I read and accept the <a href="<?php echo base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spot['spotId']; ?>">Terms and conditions</a>
                        </label>
                    </div>
                    <div class="form-group col-sm-12 checkbox">
                        <label>
                            <input type="checkbox" value="1"  name="order[privacyPolicy]" <?php echo $privacyPolicy; ?> />
                            I took notice of <a href="<?php echo base_url() . 'make_order?vendorid=' . $vendor['vendorId'] . '&spotid=' . $spot['spotId']; ?>">Privacy policy</a>
                        </label>
                    </div>
                    <?php } ?>
                </div>
                <div class="checkout-btns">
                    <a href="<?php echo base_url() . 'checkout_order'; ?>" style="background-color: #948b6f" class="button">
                        <i class="fa fa-arrow-left"></i>
                        Back to list                    </a>
                    <a href="javascript:void(0);" style="background-color: #349171" class="button" onclick="submitForm('goOrder', 'serviceFeeInput', 'orderAmountInput');">
                        Pay
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </form>
</main>
<script>
    
</script>