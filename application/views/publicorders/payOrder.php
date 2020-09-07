<?php
    $tableRows = '';
    $totalOrder = 0;
    $total = 0;
    $quantiy = 0;

    if ($vendor['preferredView'] === $oldMakeOrderView) {
        foreach($ordered as $productExtendedId => $data) {
            if (!isset($data['mainProduct'])) {
                $mainExtendedId = $productExtendedId;
            } else {
                $data = $data['mainProduct'][$mainExtendedId ];
            }
            $quantiy = $quantiy + intval($data['quantity'][0]);
            $totalOrder = $totalOrder + floatval($data['amount'][0]);
    
            $tableRows .= '<tr>';
            $tableRows .=   '<td>' . $data['quantity'][0] . ' x ' .  $data['name'][0] . '</td>';
            $tableRows .=   '<td>' . number_format($data['amount'][0], 2, '.', ',') . ' &euro;</td>';
            $tableRows .= '</tr>';
        }
    } elseif ($vendor['preferredView'] === $newMakeOrderView) {
        
        foreach($ordered as $data) {
            $data = reset($data);            
            $quantiy = $quantiy + intval($data['quantity']);
            $totalOrder = $totalOrder + floatval($data['amount']);
    
            $tableRows .= '<tr>';
            $tableRows .=   '<td>' . $data['quantity'] . ' x ' .  $data['name'] . '</td>';
            $tableRows .=   '<td>' . number_format($data['amount'], 2, '.', ',') . ' &euro;</td>';
            $tableRows .= '</tr>';

            if (!empty($data['addons'])) {
                foreach ($data['addons'] as $addon) {
                    $quantiy = $quantiy + intval($addon['quantity']);
                    $totalOrder = $totalOrder + floatval($addon['amount']);
            
                    $tableRows .= '<tr>';
                    $tableRows .=   '<td>' . $addon['quantity'] . ' x ' .  $addon['name'] . '</td>';
                    $tableRows .=   '<td>' . number_format($addon['amount'], 2, '.', ',') . ' &euro;</td>';
                    $tableRows .= '</tr>';
                }
            }
        }
    } 

    

    $serviceFee = $totalOrder * $vendor['serviceFeePercent'] / 100 + $vendor['minimumOrderFee'];
    if ($serviceFee > $vendor['serviceFeeAmount']) $serviceFee = $vendor['serviceFeeAmount'];
    $total = $totalOrder + $serviceFee;

?>
<div id="wrapper">
    <div id="content">
        <div class="container" id="shopping-cart">
            <div class="container" id="page-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <div id="area-container">
                            <div class="page-container">
                                <div class="heading pay-header">
                                    <div class="amount"><?php echo number_format($total, 2, ',', '.'); ?> EUR</div>
                                    <div class="info">
                                        <b>bestelling</b>
                                    </div>
                                </div>
                                <div class="bar bar2">
                                    <div class="language">
                                        <a href="#">
                                            <span class="selectedLanguage">NL</span>
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        </a>
                                        <div class="menu hidden">
                                            <ul>
                                                <li class="selected">NL</li>
                                                <!-- <li>EN</li>
                                                <li>FR</li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-details" style="background-color: white">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th data-trans="" data-trn-key="Productnaam">Productnaam
                                            </th>
                                            <th data-trans="" data-trn-key="Totaal">Totaal</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $tableRows; ?>
                                            <tr>
                                                <td style="text-align:left">
                                                    <p>Bestellingen</p>
                                                    <p>Service</p>
                                                    <p>TOTAAL</p>
                                                </td>
                                                <td>
                                                    <p><?php echo number_format($totalOrder, 2, ',', '.'); ?> &euro;</p>
                                                    <p><?php echo number_format($serviceFee, 2, ',', '.'); ?> &euro;</p>
                                                    <p><?php echo number_format($total, 2, ',', '.'); ?> &euro;</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="bar">
                                    <div class="bar-title">
                                        <span data-trans="" data-trn-key="Kies een betaalmethode">
                                            Kies een betaalmethode
                                        </span>
                                    </div>
                                    <span class="bar-title-original hidden">
                                        <span data-trans="" data-trn-key="Kies een betaalmethode">Kies een betaalmethode</span>
                                    </span>
                                </div>
                                <div class="content-container clearfix" id="paymentMethodsContainer">
                                    <div class="payment-container methods">
                                        <?php if ($vendor['ideal'] === '1') { ?>
                                            <a
                                                href="javascript:void(0)"
                                                class="paymentMethod method-ideal"
                                                onclick="toogleElements('idealBanks', 'paymentMethodsContainer', 'hidden')">
                                                <img src="https://tiqs.com/shop/assets/imgs/extra/ideal.png" alt="iDEAL">
                                                <span>iDEAL</span>
                                            </a>
                                        <?php } ?>
                                        <?php if ($vendor['creditCard'] === '1') { ?>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $creditCardPaymentType; ?>/0" class="paymentMethod method-card" >
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/creditcard.png" alt="Creditcard">
                                                <span data-trans="" data-trn-key="Creditcard">Creditcard</span>
                                            </a>
                                        <?php } ?>
										<?php if ($vendor['payconiq'] === '1') { ?>
											<a href="<?php echo base_url(); ?>insertorder/<?php echo $payconiqPaymentType; ?>/0" class="paymentMethod method-card" >
												<img src="https://tiqs.com/qrzvafood/assets/imgs/extra/payconiq.png" alt="Creditcard">
												<span data-trans="" data-trn-key="Creditcard">Creditcard</span>
											</a>
										<?php } ?>
                                        <?php if ($vendor['bancontact'] === '1') { ?>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $bancontactPaymentType; ?>/0" class="paymentMethod method-card" >
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/bancontact.png" alt="bancontact">
                                                <span data-trans="" data-trn-key="Bancontact">Bancontact</span>
                                            </a>
                                        <?php } ?>
                                        <?php if ($vendor['giro'] === '1') { ?>
                                            <a
                                                href="javascript:void(0)"
                                                class="paymentMethod method-ideal"
                                                onclick="toogleElements('giroBanks', 'paymentMethodsContainer', 'hidden')"
                                                >
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/giropay(1).png" alt="bancontact">
                                                <span data-trans="" data-trn-key="Bancontact">Giropay</span>
                                            </a>
                                        <?php } ?>
                                        <?php if ($localType === intval($spot['spotTypeId'])) { ?>
                                            <?php if ($vendor['prePaid'] === '1') { ?>
                                                <!-- <a href="<?php #echo base_url() . 'cashPayment/' . $this->config->item('orderNotPaid') . '/' . $this->config->item('prePaid'); ?>" class="paymentMethod method-card" > -->
                                                <p class="paymentMethod method-card" data-toggle="modal" data-target="#prePaid">
                                                    <img src="<?php echo base_url() . 'assets/images/waiter.png'; ?>" alt="Service by waiter" />
                                                    <span>Service by waiter</span>
                                                </p>
                                            <?php } ?>
                                            <?php if ($vendor['postPaid'] === '1') { ?>
                                                <!-- <a href="<?php #echo base_url() . 'cashPayment/' . $this->config->item('orderPaid') . '/' . $this->config->item('postPaid'); ?>" class="paymentMethod method-card" > -->
                                                <p class="paymentMethod method-card" data-toggle="modal" data-target="#postPaid">
                                                    <img src="<?php echo base_url() . 'assets/images/waiter.png'; ?>" alt="Service by waiter" />
                                                    <span>Service by waiter</span>
                                                </p>
                                            <?php } ?>
                                        <?php } ?>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>
                                <?php if ($vendor['ideal'] === '1') { ?>
                                    <div class="method method-ideal hidden"  id="idealBanks">
                                        <div class="title hidden"><span data-trans="" data-trn-key="Kies een bank">Kies een bank</span>
                                        </div>                                        
                                        <div class="payment-container">
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $idealPaymentType; ?>/1" class="bank paymentMethod abn_amro">
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO">
                                                <span>ABN AMRO</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $idealPaymentType; ?>/8" class="bank paymentMethod asn_bank">
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/asn_bank.png" alt="ASN Bank">
                                                <span>ASN Bank</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $idealPaymentType; ?>/5080" class="bank paymentMethod bunq">
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra//bunq.png" alt="Bunq">
                                                <span>Bunq</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $idealPaymentType; ?>/5082" class="bank paymentMethod handelsbanken">
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/handelsbanken.png" alt="Handelsbanken">
                                                <span>Handelsbanken</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $idealPaymentType; ?>/4" class="bank paymentMethod ing">
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/ing.png" alt="ING">
                                                <span>ING</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $idealPaymentType; ?>/12" class="bank paymentMethod knab">
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/knab(1).png" alt="Knab">
                                                <span>Knab</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $idealPaymentType; ?>/5081" class="bank paymentMethod moneyou">
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/moneyou.png" alt="Moneyou">
                                                <span>Moneyou</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $idealPaymentType; ?>/2" class="bank paymentMethod rabobank">
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/rabobank.png" alt="Rabobank">
                                                <span>Rabobank</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $idealPaymentType; ?>/9" class="bank paymentMethod regiobank">
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/regiobank.png" alt="RegioBank">
                                                <span>RegioBank</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $idealPaymentType; ?>/5" class="bank paymentMethod sns_bank">
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/sns_bank.png" alt="SNS Bank">
                                                <span>SNS Bank</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $idealPaymentType; ?>/10" class="bank paymentMethod triodos_bank">
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/triodos_bank.png" alt="Triodos Bank">
                                                <span>Triodos Bank</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $idealPaymentType; ?>/11" class="bank paymentMethod van_lanschot">
                                                <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/van_lanschot.png" alt="van Lanschot">
                                                <span>van Lanschot</span>
                                            </a>
                                            <div class="clearfix"></div>
                                            <a
                                                href="javascript:void(0)"                                                
                                                onclick="toogleElements('paymentMethodsContainer', 'idealBanks', 'hidden')"
                                                >
                                                Back to payment methods
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($vendor['giro'] === '1') { ?>
                                    <div class="method method-ideal hidden"  id="giroBanks">
                                        <div class="title hidden"><span data-trans="" data-trn-key="Kies een bank">Kies een bank</span>
                                        </div>
                                        <div class="payment-container">
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $giroPaymentType; ?>/0" class="bank paymentMethod">
                                                <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                                                <span>Sparkasse</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $giroPaymentType; ?>/0" class="bank paymentMethod">
                                                <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                                                <span>Volksbanken Raiffeisenbanken</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $giroPaymentType; ?>/0" class="bank paymentMethod">
                                                <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                                                <span>Postbank</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $giroPaymentType; ?>/0" class="bank paymentMethod">
                                                <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                                                <span>Comdirect</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $giroPaymentType; ?>/0" class="bank paymentMethod">
                                                <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                                                <span>BB Bank</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $giroPaymentType; ?>/0" class="bank paymentMethod">
                                                <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                                                <span>MLP Bank</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $giroPaymentType; ?>/0" class="bank paymentMethod">
                                                <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                                                <span>PSD Bank</span>
                                            </a>
                                            <a href="<?php echo base_url(); ?>insertorder/<?php echo $giroPaymentType; ?>/0" class="bank paymentMethod">
                                                <!-- <img src="https://tiqs.com/qrzvafood/assets/imgs/extra/abn_amro.png" alt="ABN AMRO"> -->
                                                <span>Deutsche Kreditbank AG</span>
                                            </a>
                                            <div class="clearfix"></div>
                                            <a
                                                href="javascript:void(0)"
                                                onclick="toogleElements('paymentMethodsContainer', 'giroBanks', 'hidden')"
                                                >
                                                Back to payment methods
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($localType === intval($spot['spotTypeId'])) { ?>
                                    <?php if ($vendor['prePaid'] === '1') { ?>
                                        <!-- Modal -->
                                        <div id="prePaid" class="modal" role="dialog">
                                        <div class="modal-dialog modal-sm">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <button
                                                            class="btn btn-success btn-lg"
                                                            style="border-radius:50%; margin-right:5%; font-size:24px"
                                                            onclick="redirect('<?php echo base_url() . 'cashPayment/' . $this->config->item('orderNotPaid') . '/' . $this->config->item('prePaid'); ?>')"
                                                            >
                                                            <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                        </button>
                                                        <button
                                                            class="btn btn-danger btn-lg"
                                                            style="border-radius:50%; margin-left:5%; font-size:24px"
                                                            data-dismiss="modal"
                                                            >
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ($vendor['postPaid'] === '1') { ?>
                                        <!-- Modal -->
                                        <div id="postPaid" class="modal" role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <button
                                                            class="btn btn-success btn-lg"
                                                            style="border-radius:50%; margin-right:5%; font-size:24px"
                                                            onclick="redirect('<?php echo base_url() . 'cashPayment/' . $this->config->item('orderPaid') . '/' . $this->config->item('postPaid'); ?>')"
                                                            >
                                                            <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                        </button>
                                                        <button
                                                            class="btn btn-danger btn-lg"
                                                            style="border-radius:50%; margin-left:5%; font-size:24px"
                                                            data-dismiss="modal"
                                                            >
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>

                                <div class="footer" style="text-align:left">
                                    <a href="<?php echo base_url(); ?>checkout_order" class="btn-cancel">
                                        <i class="fa fa-arrow-left"></i>
                                        <span data-trans="" data-trn-key="Annuleren">Annuleren</span>
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.content-container -->
<?php if ($vendor['ideal'] === '1') { ?>
<script>

    function toogleElements(showId, hideId, className) {
        document.getElementById(showId).classList.toggle(className)
        document.getElementById(hideId).classList.toggle(className)
    }

    function redirect(url) {
        window.location.href = url;
    }
</script>
<?php } ?>
