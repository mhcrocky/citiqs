<?php
    $tableRows = '';
    $totalOrder = 0;
    $total = 0;
    $quantiy = 0;

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

    $serviceFee = $totalOrder * $vendor['serviceFeePercent'] / 100;
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
                                <div class="content-container clearfix">
                                    <div class="payment-container methods">
                                        <a href="<?php echo base_url(); ?>insertorder/<?php echo $idealPaymentType; ?>" class="paymentMethod method-ideal" >
                                            <img src="https://tiqs.com/shop/assets/imgs/extra/ideal.png" alt="iDEAL">
                                            <span>iDEAL</span>
                                        </a>
                                        <a href="<?php echo base_url(); ?>insertorder/<?php echo $creditCardPaymentType; ?>" class="paymentMethod method-card" >
											<img src="https://tiqs.com/qrzvafood/assets/imgs/extra/creditcard.png" alt="Creditcard">
											<span data-trans="" data-trn-key="Creditcard">Creditcard</span>
										</a>
                                        <a href="<?php echo base_url(); ?>insertorder/<?php echo $bancontactPaymentType; ?>" class="paymentMethod method-card" >
											<img src="https://tiqs.com/qrzvafood/assets/imgs/extra/bancontact.png" alt="bancontact">
											<span data-trans="" data-trn-key="Bancontact">Bancontact</span>
										</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
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
