<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-12 payOrderBackgroundColor">
    <div id="area-container" class="payOrderBackgroundColor">
        <div class="page-containe payOrderBackgroundColorr">
            <!--            <div id="payHeader" class="heading pay-header payOrderBackgroundColor">-->
            <!--            </div>-->
            <!--            <div class="bar bar2 payOrderBackgroundColor" style="background-color: white; display:none">-->
            <!--            </div>-->
            <div class="order-details" style="background-color: white; display:none">
                <table>
                    <thead>
                    <tr>
                        <th data-trans="" data-trn-key="Productnaam"><?php echo $this->language->tLine('Productname');?>
                        </th>
                        <th data-trans="" data-trn-key="Totaal"><?php echo $this->language->tLine('Total');?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align:left">
                                <p><?php echo $this->language->tLine('Orders');?></p>
                                <p><?php echo $this->language->tLine('Service');?></p>
                                <p><?php echo $this->language->tLine('TOTAAL');?></p>
                                <?php if ($waiterTip) { ?>
                                <p><?php echo $this->language->tLine('Waiter tip');?></p>
                                <p><?php echo $this->language->tLine('TOTAL WITH TIP');?></p>
                                <?php } ?>                                                    
                                <!-- <p class="voucher" style="display:none">Voucher amount</p>
                                <p class="voucher" style="display:none">Pay with other method</p> -->
                            </td>
                            <td>
                                <p><?php echo number_format($amount, 2, ',', '.'); ?> &euro;</p>
                                <p><?php echo number_format($serviceFee, 2, ',', '.'); ?> &euro;</p>
                                <p><?php echo number_format(($amount + $serviceFee), 2, ',', '.'); ?> &euro;</p>
                                <?php if ($waiterTip) { ?>
                                    <p><?php echo number_format($waiterTip, 2, ',', '.'); ?> &euro;</p>
                                    <p><?php echo number_format(($amount + $serviceFee + $waiterTip), 2, ',', '.'); ?> &euro;</p>
                                <?php } ?>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div  id="choosePaymentMethod" class="bar" style="width:100 vw; height:100">
                <div class="bar-title">
                    <span data-trans="" data-trn-key="Kies een betaalmethode">
                            <?php echo $this->language->tline('Choose payment method');?>
                    </span>
                </div>
                <span class="bar-title-original hidden">
                    <span data-trans="" data-trn-key="Kies een betaalmethode"><?php echo $this->language->tline('Choose payment method');?></span>
                </span>
            </div>
            <div class="content-container clearfix" id="paymentMethodsContainer">
                <div id="paymentContainer" class="payment-container methods" style="padding: 0px 10px 0px 10px">
                    <?php if (in_array($voucherPayment, $paymentMethodsKey) && $vendor['voucherPaymentCode'] === '1') { ?>
                        <div style="width:100%">
                            <label for="codeId"><?php echo $this->language->tLine('Insert and confirm code from voucher');?>
                                <input
                                    type="text"
                                    id="codeId"
                                    class="form-control voucherClass"
                                    style="display:inline; width:70%"
                                    data-<?php echo $orderDataGetKey; ?>="<?php echo $orderRandomKey; ?>"
                                    autocomplete="off"
                                />
                                <button
                                    class="btn btn-success btn"
                                    style="border-radius:50%; font-size:24px"
                                    onclick="voucherPay('codeId')"
                                >
                                    <i class="fa fa-check modalPayOrderButton" aria-hidden="true"></i>
                                </button>
                            </label>
                        </div>
                        <br/>
                    <?php } ?>
					<?php if (in_array($payconiqPayment, $paymentMethodsKey)) { ?>
						<a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $payconiqPaymentType; ?>/0<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="paymentMethod method-card addTargetBlank"
                        >
							<img src="https://tiqs.com/alfred/assets/home/imgs/extra/payconiq.png" alt="Payconiq">
							<span class="paymentMethodText">Payconiq</span>
						</a>
					<?php } ?>
                    <?php if (in_array($idealPayment, $paymentMethodsKey)) { ?>
                        <a href="javascript:void(0)" onclick="toogleElements('idealBanks', 'paymentMethodsContainer', 'hidden')" class="paymentMethod method-card" >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/ideal.png" alt="iDEAL">
                            <span class="paymentMethodText">iDEAL</span>
                        </a>
                    <?php } ?>
                    <?php if (in_array($creditCardPayment, $paymentMethodsKey)) { ?>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $creditCardPaymentType; ?>/0<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="paymentMethod method-card addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/creditcard.png" alt="Creditcard">
                            <span class="paymentMethodText">Creditcard</span>
                        </a>
                    <?php } ?>

                    <?php if (in_array($bancontactPayment, $paymentMethodsKey)) { ?>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $bancontactPaymentType; ?>/0<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="paymentMethod method-card addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/bancontact.png" alt="bancontact">
                            <span class="paymentMethodText">Bancontact</span>
                        </a>
                    <?php } ?>
                    <?php if (in_array($myBankPayment, $paymentMethodsKey)) { ?>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $myBankPaymentType; ?>/0<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="paymentMethod method-card addTargetBlank"
                        >
                            <img src="https://static.pay.nl/payment_profiles/100x100/1588.png" alt="bancontact">
                            <span class="paymentMethodText">My Bank</span>
                        </a>
                    <?php } ?>
                    <?php if (in_array($giroPayment, $paymentMethodsKey)) { ?>
                        <a href="javascript:void(0)" onclick="toogleElements('giroBanks', 'paymentMethodsContainer', 'hidden')" class="paymentMethod method-card" >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/giropay(1).png" alt="bancontact">
                            <span class="paymentMethodText" data-trans="" data-trn-key="Bancontact">Giropay</span>
                        </a>
                    <?php } ?>
                    <?php if ($localType === intval($spot['spotTypeId'])) { ?>
                        <?php if (in_array($prePaid, $paymentMethodsKey)) { ?>
                            <a href="javascript:void(0)" class="paymentMethod method-card" data-toggle="modal" data-target="#prePaid">
                                <img src="<?php echo base_url() . 'assets/images/waiter.png'; ?>" alt="Pay at waiter" />
                                <?php if ($vendor['vendorId'] == THGROUP) { ?>
                                    <span class="paymentMethodText">Collect at the bar</span>
                                <?php } else { ?>
                                    <span class="paymentMethodText"><?php echo $this->language->tline('Pay at waiter');?></span>
                                <?php } ?>
                            </a>
                        <?php } ?>
                        <?php if (in_array($postPaid, $paymentMethodsKey)) { ?>
                            <a href="javascript:void(0);" class="paymentMethod method-card" data-toggle="modal" data-target="#postPaid">
                                <img src="<?php echo base_url() . 'assets/images/waiter.png'; ?>" alt="Pay at waiter" />
                                <?php if ($vendor['vendorId'] == THGROUP) { ?>
                                    <span class="paymentMethodText"><?php echo $this->language->tLine('Collect at the bar');?></span>
                                <?php } else { ?>
                                    <span class="paymentMethodText"><?php echo $this->language->tline('Pay at waiter');?></span>
                                <?php } ?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php if (in_array($pinMachinePayment, $paymentMethodsKey)) { ?>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $pinMachinePaymentType; ?>/<?php echo $pinMachineOptionSubId; ?><?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="paymentMethod method-card addTargetBlank"
                        >
                        <img src="<?php echo base_url() . 'assets/home/images/pinmachine.png'; ?>" alt="pin machine">
                            <span class="paymentMethodText"><?php echo $this->language->tLine('Pin machine');?></span>
                        </a>
                    <?php } ?>
                    <?php if (in_array($voucherPayment, $paymentMethodsKey) &&  $vendor['voucherPaymentCode'] === '0') { ?>
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#voucher" class="paymentMethod method-card" >
                            <img
                                src="<?php echo base_url() . 'assets/home/images/voucher.png'; ?>"
                                alt="<?php echo $this->language->tLine('voucher');?>"
                            />
<!--                            <span class="paymentMethodText">--><?php //#echo $this->language->tline('Use Voucher');?><!--</span>-->
							<span class="paymentMethodText">Voucher</span>
                        </a>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
            </div>

            <?php if (in_array($idealPayment, $paymentMethodsKey)) { ?>
                <div class="method method-ideal hidden"  id="idealBanks" style="z-index:1000">
                    <div class="title hidden"><span data-trans="" data-trn-key="Kies een bank"><?php echo $this->language->tLine('Choose your bank');?></span>
                    </div>                                        
                    <div class="payment-container">
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $idealPaymentType; ?>/1<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod abn_amro addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/abn_amro.png" alt="ABN AMRO">
                            <span class="paymentMethodText">ABN AMRO</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $idealPaymentType; ?>/8<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod asn_bank addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/asn_bank.png" alt="ASN Bank">
                            <span class="paymentMethodText">ASN Bank</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $idealPaymentType; ?>/5080<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod bunq addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/bunq.png" alt="Bunq">
                            <span class="paymentMethodText">Bunq</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $idealPaymentType; ?>/5082<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod handelsbanken addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/handelsbanken.png" alt="Handelsbanken">
                            <span class="paymentMethodText">Handelsbanken</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $idealPaymentType; ?>/4<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod ing addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/ing.png" alt="ING">
                            <span class="paymentMethodText">ING</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $idealPaymentType; ?>/12<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod knab addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/knab(1).png" alt="Knab">
                            <span class="paymentMethodText">Knab</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $idealPaymentType; ?>/5081<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod moneyou addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/moneyou.png" alt="Moneyou">
                            <span class="paymentMethodText">Moneyou</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $idealPaymentType; ?>/2<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod rabobank addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/rabobank.png" alt="Rabobank">
                            <span class="paymentMethodText">Rabobank</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $idealPaymentType; ?>/9<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod regiobank addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/regiobank.png" alt="RegioBank">
                            <span class="paymentMethodText">RegioBank</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $idealPaymentType; ?>/5<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod sns_bank addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/sns_bank.png" alt="SNS Bank">
                            <span class="paymentMethodText">SNS Bank</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $idealPaymentType; ?>/10<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod triodos_bank addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/triodos_bank.png" alt="Triodos Bank">
                            <span class="paymentMethodText">Triodos Bank</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $idealPaymentType; ?>/11<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod van_lanschot addTargetBlank"
                        >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/van_lanschot.png" alt="van Lanschot">
                            <span class="paymentMethodText">van Lanschot</span>
                        </a>
                        <div class="clearfix"></div>
                        <span onclick="toogleElements('paymentMethodsContainer', 'idealBanks', 'hidden')" data-clicked="0"
                                            data-href="javascript:void(0);"
                                            class="text-center text-primary mb-1">
                                            
                            <span class="text-primary"><?php echo $this->language->tLine('Back to payment methods');?></span>
                        </span>
                        
                    </div>
                </div>
            <?php } ?>

            <?php if (in_array($giroPayment, $paymentMethodsKey)) { ?>
                <div class="method method-ideal hidden"  id="giroBanks">
                    <div class="title hidden">
                        <span data-trans="" data-trn-key="Kies een bank"><?php echo $this->language->tLine('Choose your bank');?></span>
                    </div>
                    <div class="payment-container">
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod addTargetBlank"
                        >
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">Sparkasse</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod addTargetBlank"
                        >
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">Volksbanken Raiffeisenbanken</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod addTargetBlank"
                        >
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">Postbank</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod addTargetBlank"
                        >
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">Comdirect</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod addTargetBlank"
                        >
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">BB Bank</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod addTargetBlank"
                        >
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">MLP Bank</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod addTargetBlank"
                        >
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">PSD Bank</span>
                        </a>
                        <a
                            href="<?php echo base_url(); ?>onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?' . $orderDataGetKey . '=' . $orderRandomKey; ?>"
                            class="bank paymentMethod addTargetBlank"
                        >
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">Deutsche Kreditbank AG</span>
                        </a>
                        <div class="clearfix"></div>
                        <span onclick="toogleElements('paymentMethodsContainer', 'giroBanks', 'hidden')" data-clicked="0"
                                            data-href="javascript:void(0)"
                                            class="text-center text-primary mb-1">
                                            
                            <span class="text-primary"><?php echo $this->language->tLine('Back to payment methods');?></span>
                        </span>

                    </div>
                </div>
            <?php } ?>

            <p class="voucher" style="display:none; margin:0px; background-color:#fff; text-align:left; color:#000; font-weight:900; padding:5px">
                <?php echo $this->language->tLine('Pay with voucher');?>: <span id="voucherAmount"></span> &euro;
            </p>
            <p class="voucher" style="display:none; margin:0px; background-color:#fff; text-align:left; color:#000; font-weight:900; padding:5px">
                <?php echo $this->language->tLine('Left amount');?>: <span id="leftAmount"></span> &euro;
            </p>
            <div id="payFooter" class="footer" style="text-align:left">
                <a id="backLink" href="<?php echo base_url() . $redirect; ?>" class="btn btn-cancel">
                    <i class="fa fa-arrow-left"></i>
                    <span data-trans="" data-trn-key="Annuleren"><?php echo $this->language->tLine('BACK');?></span>
                </a>
            </div>
            <?php
                include_once FCPATH . 'application/views/publicorders/includes/modals/payOrder/payOrderModals.php';
            ?>
        </div>
    </div>
</div>
