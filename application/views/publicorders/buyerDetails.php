<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<main
    class="container designBackgroundImage"
    style="text-align:left; margin-bottom:20px; width:100vw; height:100vh" id="buyerDetailsContainer"
 >
    <form id="goBuyerDetails" method="post" onsubmit="return submitBuyerDetails()">
        <input type="text" name="orderRandomKey" value="<?php echo $orderRandomKey; ?>" redonly hidden requried />
        <input type="text" name="vendorId" value="<?php echo $vendor['vendorId']; ?>" redonly hidden requried />
        <input type="text" name="spotTypeId" value="<?php echo $spot['spotTypeId']; ?>" redonly hidden requried />
        <div class="row d-flex justify-content-center" id="checkout">
            <div class="col-sm-12 col-lg-10 col-lg-offset-1">
                <div id="yourDetails" class="checkout-title">
                    <span>
                        <?php echo $this->language->tLine('Your details');?>                        
                    </span>
                </div>
                <div class="row">
                    <?php if ($vendor['requireName'] === '1') { ?>
                        <div class="form-group col-sm-12">
                            <label class="labelColorBuyer" for="firstNameInput"><?php echo $this->language->tLine('Name');?> (<sup>*</sup>)</label>
                            <input
                                id="firstNameInput"
                                class="form-control inputFieldsBuyer"
                                name="user[username]"
                                value="<?php echo $username; ?>"
                                type="text" placeholder="<?php echo $this->language->tLine('Name');?>"
                                required
                                data-name="Name"
                            />
                        </div>
                    <?php } ?>
                    <?php if ($vendor['requireEmail'] === '1' || intval($spot['spotTypeId']) !== $local) { ?>
                        <div class="form-group col-sm-12">
                            <label class="labelColorBuyer" for="emailAddressInput"><?php echo $this->language->tLine('Email address');?>  <sup>*</sup></label>
                            <input
                                type="email"
                                id="emailAddressInput"
                                class="form-control inputFieldsBuyer"
                                name="user[email]"
                                value="<?php echo $email; ?>"
                                placeholder="<?php echo $this->language->tLine('Email address');?>"
                                required
                                oninput="checkUserNewsLetter(this.id)"
                                data-name="Email"
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
                            <label class="labelColorBuyer" for="phoneInput"><?php echo $this->language->tLine('Phone');?><sup>*</sup></label>
                            <div>
                                <select class="form-control inputFieldsBuyer" style="width:35% !important; display:inline-block !important" name="phoneCountryCode" style="text-align:center">
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
                                <input
                                    id="phoneInput"
                                    class="form-control inputFieldsBuyer"
                                    style="width:63% !important; display:inline-block !important"
                                    name="user[mobile]"
                                    value="<?php echo $mobile; ?>"
                                    type="text"
                                    placeholder="<?php echo $this->language->tLine('Phone');?>"
                                    required
                                    data-name="Mobile"
                                />
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($vendor['requireNewsletter'] === '1') { ?>
                        <div class="form-group col-sm-12">
                            <label class="labelColorBuyer" ><?php echo $this->language->tLine('Receive our newsletter');?></label>
                            <label class="radio-inline" for="newsLetterYes">
                                <input type="radio" id="newsLetterYes" name="user[newsletter]" value="1" />
								<?php echo $this->language->tLine('YES');?>
							</label>
                            <label class="radio-inline" for="newsLetterNo">
                                <input type="radio" id="newsLetterNo" name="user[newsletter]"  value="0" checked />
								<?php echo $this->language->tLine('NO');?>
                            </label>
                        </div>
                    <?php } ?>
                    <div class="form-group col-sm-12">
                        <label class="labelColorBuyer" ><?php echo $this->language->tLine('Create TIQS account');?></label>
                        <label class="radio-inline" for="buyerConfirmedYes">
                            <input type="checkbox" id="buyerConfirmedYes" name="user[buyerConfirmed]" value="1" />
                            <?php echo $this->language->tLine('YES');?>
                        </label>
                    </div>
                </div>
                <div class="checkout-btns">
                    <a
                        id="backButton"
                        href="<?php echo base_url() . 'checkout_order?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                        style="background-color: #948b6f"
                        class="button"
                    >
                        <i class="fa fa-arrow-left"></i>
						<?php echo $this->language->tLine('Back to list');?>
                    </a>
                    <a id="payButton" href="javascript:void(0);" style="background-color: #349171" class="button" onclick="submitBuyerDetails();">
						<?php echo $this->language->tLine('Pay');?>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </form>
</main>
<script>
    var buyerDetailsGlobals = (function(){
        let gloabls = {
            'minMobileLength' : '<?php echo $minMobileLength; ?>',
            'formId' : 'goBuyerDetails',
            'emailId' : 'emailAddressInput',
            'firstNameId' : 'firstNameInput', 
            'phoneId' : 'phoneInput'
        }
        Object.freeze(gloabls);
        return gloabls;
    }());
</script>
