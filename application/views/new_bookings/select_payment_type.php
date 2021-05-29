<?php 
$idealPaymentFee = isset($idealPayment) ? $idealPayment : 0;
$bancontactPaymentFee = isset($bancontactPayment) ? $bancontactPayment : 0;
$creditCardPaymentFee = isset($creditCardPayment) ? $creditCardPayment : 0;
$voucherPaymentFee = isset($voucher) ? $voucher : 0;
$myBankPaymentFee = isset($myBank) ? $myBank : 0;
$payconiqPaymentFee = isset($payconiqPayment) ? $payconiqPayment : 0;
$giroPaymentFee = isset($giroPayment) ? $giroPayment : 0;
$pinMachinePaymentFee = isset($pinMachine) ? $pinMachine : 0;
$activePayments = array_values($activePayments);
?>
<div class="col-md-12 payOrderBackgroundColor">
    <div id="area-container" class="payOrderBackgroundColor">
        <div class="page-containe payOrderBackgroundColorr">

        <div  id="choosePaymentMethod" class="bar" style="width:100 vw; height:100">
                <div class="bar-title">
                    <span data-trans="" data-trn-key="Kies een betaalmethode">
                            <?php echo $this->language->tline('Kies een betaalmethode');?>
                    </span>
                </div>
                <span class="bar-title-original hidden">
                    <span data-trans="" data-trn-key="Kies een betaalmethode"><?php echo $this->language->line("PAYMENT-050",'Kies een betaalmethode');?></span>
                </span>
            </div>
            <div class="content-container clearfix" id="paymentMethodsContainer">
            <div id="paymentContainer" class="payment-container methods">
					<?php if (in_array($payconiqPaymentText, $activePayments)) { ?>
						<a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $payconiqPaymentType; ?>/0<?php echo '?order=' . $orderRandomKey; ?>" class="paymentMethod method-card addTargetBlank">
							<img src="https://tiqs.com/alfred/assets/home/imgs/extra/payconiq.png" alt="Payconiq">
                            <p class="paymentFee"><?php echo ($payconiqPaymentFee == 0) ? '&nbsp' : '€'.$payconiqPaymentFee; ?></p>
							<span class="paymentMethodText">Payconiq</span>
						</a>
					<?php } ?>
                    <?php if (in_array($idealPaymentText, $activePayments)) { ?>
                        <a href="javascript:void(0)" onclick="toogleElements('idealBanks', 'paymentMethodsContainer', 'hidden')" class="paymentMethod method-card" >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/ideal.png" alt="iDEAL">
                            <p class="paymentFee"><?php echo ($idealPaymentFee == 0) ? '&nbsp' : '€'.$idealPaymentFee; ?></p>
                            <span class="paymentMethodText">iDEAL</span>
                        </a>
                    <?php } ?>
                    <?php if (in_array($creditCardPaymentText, $activePayments)) { ?>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $creditCardPaymentType; ?>/0<?php echo '?order=' . $orderRandomKey; ?>" class="paymentMethod method-card addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/creditcard.png" alt="Creditcard">
                            <p class="paymentFee"><?php echo ($creditCardPaymentFee == 0) ? '&nbsp' : '€'.$creditCardPaymentFee; ?></p>
                            <span class="paymentMethodText">Creditcard</span>
                        </a>
                    <?php } ?>

                    <?php if (in_array($bancontactPaymentText, $activePayments)) { ?>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $bancontactPaymentType; ?>/0<?php echo '?order=' . $orderRandomKey; ?>" class="paymentMethod method-card addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/bancontact.png" alt="bancontact">
                            <p class="paymentFee"><?php echo ($bancontactPaymentFee == 0) ? '&nbsp' : '€'.$bancontactPaymentFee; ?></p>
                            <span class="paymentMethodText">Bancontact</span>
                        </a>
                    <?php } ?>
                    <?php if (in_array($myBankPaymentText, $activePayments)) { ?>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $myBankPaymentType; ?>/0<?php echo '?order=' . $orderRandomKey; ?>" class="paymentMethod method-card addTargetBlank">
                            <img src="https://static.pay.nl/payment_profiles/100x100/1588.png" alt="bancontact">
                            <p class="paymentFee"><?php echo ($myBankPaymentFee == 0) ? '&nbsp' : '€'.$myBankPaymentFee; ?></p>
                            <span class="paymentMethodText">My Bank</span>
                        </a>
                    <?php } ?>
                    <?php if (in_array($giroPaymentText, $activePayments)) { ?>
                        <a href="javascript:void(0)" onclick="toogleElements('giroBanks', 'paymentMethodsContainer', 'hidden')" class="paymentMethod method-card" >
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/giropay(1).png" alt="bancontact">
                            <p class="paymentFee"><?php echo ($myBankPaymentFee == 0) ? '&nbsp' : '€'.$myBankPaymentFee; ?></p>
                            <span class="paymentMethodText" data-trans="" data-trn-key="Bancontact">Giropay</span>
                        </a>
                    <?php } ?>

                    <?php if (in_array($voucherPaymentText, $activePayments)) { ?>
                        <a href="javascript:;" data-toggle="modal" data-target="#voucher" class="paymentMethod method-card" >
                            <img src="<?php echo base_url() . 'assets/home/images/voucher.png'; ?>" alt="voucher" >
                            <p class="paymentFee"><?php echo ($voucherPaymentFee == 0) ? '&nbsp' : '€'.$voucherPaymentFee; ?></p>
                            <span class="paymentMethodText"><?php echo $this->language->tline('Use Voucher');?></span>
                        </a>
                    <?php } ?>

                    <div class="clearfix"></div>
                </div>

            </div>

            <?php if (in_array($idealPaymentText, $activePayments)) { ?>
                <div class="method method-ideal text-center hidden"  id="idealBanks">
                    <div class="title hidden"><span data-trans="" data-trn-key="Kies een bank"><?php echo $this->language->line("PAYMENT-030",'Choose your bank');?></span>
                    </div>                                        
                    <div class="payment-container">
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/1<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod abn_amro addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/abn_amro.png" alt="ABN AMRO">
                            <span class="paymentMethodText">ABN AMRO</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/8<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod asn_bank addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/asn_bank.png" alt="ASN Bank">
                            <span class="paymentMethodText">ASN Bank</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/5080<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod bunq addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/bunq.png" alt="Bunq">
                            <span class="paymentMethodText">Bunq</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/5082<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod handelsbanken addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/handelsbanken.png" alt="Handelsbanken">
                            <span class="paymentMethodText">Handelsbanken</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/4<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod ing addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/ing.png" alt="ING">
                            <span class="paymentMethodText">ING</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/12<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod knab addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/knab(1).png" alt="Knab">
                            <span class="paymentMethodText">Knab</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/5081<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod moneyou addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/moneyou.png" alt="Moneyou">
                            <span class="paymentMethodText">Moneyou</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/2<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod rabobank addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/rabobank.png" alt="Rabobank">
                            <span class="paymentMethodText">Rabobank</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/9<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod regiobank addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/regiobank.png" alt="RegioBank">
                            <span class="paymentMethodText">RegioBank</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/5<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod sns_bank addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/sns_bank.png" alt="SNS Bank">
                            <span class="paymentMethodText">SNS Bank</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/10<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod triodos_bank addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/triodos_bank.png" alt="Triodos Bank">
                            <span class="paymentMethodText">Triodos Bank</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $idealPaymentType; ?>/11<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod van_lanschot addTargetBlank">
                            <img src="https://tiqs.com/alfred/assets/home/imgs/extra/van_lanschot.png" alt="van Lanschot">
                            <span class="paymentMethodText">van Lanschot</span>
                        </a>
                        
                        <div class="clearfix"></div>
                        <a
                            href="javascript:void(0)"                                                
                            onclick="toogleElements('paymentMethodsContainer', 'idealBanks', 'hidden')"
                            >
                            <?php echo $this->language->line("PAYMENT-910",'Back to payment methods');?>

                        </a>
                    </div>
                </div>

                <?php } ?>

                <?php if (in_array($giroPayment, $activePayments)) { ?>
                <div class="method method-ideal hidden"  id="giroBanks">
                    <div class="title hidden"><span data-trans="" data-trn-key="Kies een bank"><?php echo $this->language->line("PAYMENT-030",'Choose your bank');?></span>
                    </div>
                    <div class="payment-container">
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod addTargetBlank">
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">Sparkasse</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod addTargetBlank">
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">Volksbanken Raiffeisenbanken</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod addTargetBlank">
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">Postbank</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod addTargetBlank">
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">Comdirect</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod addTargetBlank">
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">BB Bank</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod addTargetBlank">
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">MLP Bank</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod addTargetBlank">
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">PSD Bank</span>
                        </a>
                        <a href="<?php echo base_url(); ?>bookingpay/onlinepayment/<?php echo $giroPaymentType; ?>/0<?php echo '?order=' . $orderRandomKey; ?>" class="bank paymentMethod addTargetBlank">
                            <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                            <span class="paymentMethodText">Deutsche Kreditbank AG</span>
                        </a>
                        <div class="clearfix"></div>
                        <a
                            href="javascript:void(0)"
                            onclick="toogleElements('paymentMethodsContainer', 'giroBanks', 'hidden')"
                            >
                            <?php echo $this->language->line("PAYMENT-910",'Back to payment methods');?>
                        </a>
                    </div>
                </div>
                <?php } ?>

            <p class="voucher" style="display:none; margin:0px; background-color:#fff; text-align:left; color:#000; font-weight:900; padding:5px">Pay with voucher: <span id="voucherAmount"></span> &euro;</p>
            <p class="voucher" style="display:none; margin:0px; background-color:#fff; text-align:left; color:#000; font-weight:900; padding:5px">Left amount: <span id="leftAmount"></span> &euro;</p>
            <div id="payFooter" class="footer" style="text-align:left">
                <a id="backLink" href="<?php echo base_url(); ?>agenda_booking/pay?order=<?php echo $orderRandomKey; ?>" class="btn btn-cancel">
                    <i class="fa fa-arrow-left"></i>
                    <span data-trans="" data-trn-key="Annuleren">BACK</span>
                </a>
            </div>
            
            

        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/home/js/utility.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/payOrderNew.js"></script>