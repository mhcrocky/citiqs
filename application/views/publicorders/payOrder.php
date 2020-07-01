<?php
    $tableRows = '';
    $totalOrder = 0;
    $total = 0;
    $quantiy = 0;
    foreach($ordered as $productExtendedId => $data) {
        $quantiy = $quantiy + intval($data['quantity'][0]);
        $totalOrder = $totalOrder + floatval($data['amount'][0]);

        $tableRows .= '<tr style="text-align:left">';
        $tableRows .=   '<td>' .  $data['quantity'][0] . ' x ' .  $data['name'][0] . '</td>';
        $tableRows .=   '<td>' .  $data['amount'][0] . '</td>';
        $tableRows .= '</tr>';
    }
    $serviceFee = $totalOrder * 0.045;
    if ($serviceFee > 3.50) $serviceFee = 3.50;
    $total = $totalOrder + $serviceFee;
?>
<div class="container" id="shopping-cart">
    <div class="container" id="page-wrapper">
        <div class="row">
            <!-- <div class="col-xs-12">
                <span class="payment-title">Select payment type</span>
                <hr>
            </div> -->
            <div class="col-md-12">
                <div id="area-container">

                    <!-- <div class="logo-container">
                        <img src="./extra_includes/img/logoWI_side_white.png">
                    </div> -->

                    <div class="page-container">
                        <div class="heading pay-header">
                            <div class="amount centered"><?php echo number_format($total, '2', '.', ','); ?>&nbsp;&euro;</div>
                            <div class="info">
                                <b>THUISHAVEN</b>
                                <span>bestelling</span>
                            </div>
                        </div>
                        <!-- /.heading -->
                        <div class="bar bar2">
                            <div class="language">
                                <a href="#">
                                    <span class="selectedLanguage">NL</span>
                                    <svg class="svg-inline--fa fa-angle-down fa-w-10" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z"></path></svg><!-- <i class="fa fa-angle-down" aria-hidden="true"></i> -->
                                </a>
                                <div class="menu hidden">
                                    <ul>
                                        <li class="selected">NL</li>
                                        <li>EN</li>
                                        <li>FR</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="order-details">
                            <table style="margin-left: auto;margin-right: auto; width:50%">
                                <thead>
                                    <tr>
                                        <th data-trans="" data-trn-key="Productnaam">Productnaam</th>
                                        <th data-trans="" data-trn-key="Totaal">Totaal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $tableRows; ?>
                                    <tr style="text-align:left">
                                        <td>
                                            <p>Bestellingen</p>
                                            <p>Terrasfee</p>
                                            <p>TOTAAL</p>
                                        </td>
                                        <td>
                                            <p><?php echo number_format($totalOrder, '2', '.', ','); ?></p>
                                            <p><?php echo number_format($serviceFee, '2', '.', ','); ?></p>
                                            <p><?php echo number_format($total, '2', '.', ','); ?></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bar">
                            <div class="bar-title"><span data-trans="" data-trn-key="Kies een betaalmethode">Kies een betaalmethode</span></div>
                            <span class="bar-title-original hidden"><span data-trans="" data-trn-key="Kies een betaalmethode">Kies een betaalmethode</span></span>
                        </div>
                        <div class="content-container clearfix">
                            <div class="payment-container methods">
                                <a href="<?php echo base_url(); ?>publicorders/paymentEngine" class="paymentMethod method-ideal" data-payment-type="ideal">
                                    <img src="https://tiqs.com/shop/assets/imgs/extra/ideal.png" alt="iDEAL">
                                    <span>iDEAL</span>
                                </a>
                                <!-- <a href="https://tiqs.com/shop/checkout/selectedCCPaymenttype" class="paymentMethod method-card" data-payment-type="card">
                                    <img src="https://tiqs.com/shop/assets/imgs/extra/creditcard.png" alt="Creditcard">
                                    <span data-trans="" data-trn-key="Creditcard">Creditcard</span>
                                </a> -->
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <!-- /.content-container -->
                        <div class="footer">
                            <a href="<?php echo base_url(); ?>checkout_order" class="btn-cancel">
                                <svg class="svg-inline--fa fa-arrow-left fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="arrow-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"></path></svg><!-- <i class="fa fa-arrow-left"></i> -->
                                <span data-trans="" data-trn-key="Annuleren">Annuleren</span>
                            </a>
                            <a href="#" class="btn-back hidden">
                                <svg class="svg-inline--fa fa-arrow-left fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="arrow-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"></path></svg><!-- <i class="fa fa-arrow-left"></i> -->
                                <span data-trans="" data-trn-key="Kies andere betaalmethode">Kies andere betaalmethode</span>
                            </a>
                            <div class="poweredBy" data-trans="" data-trn-key="Betaling veilig verwerkt door pay.nl">Betaling veilig verwerkt door pay.nl</div>
                            <div class="poweredBy delivery" data-trans="" data-trn-key="Levering gegarandeerd door pay.nl">Levering gegarandeerd door pay.nl</div>
                        </div>
                        <!-- /.footer -->
                    </div>
                    <!-- /.page-container -->
                </div>
                <!-- /#area-container -->
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->
    </div>
</div>
		
<footer>
    <div class="footer-basket">
        <div class="footer-top">
            <div class="fb-left">
                <h4>Your Basket</h4>
                <h5>Your order <span><?php echo $quantiy; ?></span></h5>
            </div>
            
            <div class="fb-mid">
                <span class="fb-price"><?php echo number_format($total, '2', '.', ','); ?>&nbsp;&euro;</span>
            </div>
            <div class="fb-right">
                <svg class="svg-inline--fa fa-shopping-cart fa-w-18" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="shopping-cart" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"></path></svg><!-- <i class="fa fa-shopping-cart"></i> -->
            </div>
        </div>
        <div class="footer-order" style="display:none;">
            <div class="cart">
                <div class="cart-row">
                    <div class="cart-item">
                        <div class="cart-item-amount">
                            7x
                        </div>
                        <div class="cart-item-name">
                            Tap (25cl)                    </div>
                        <div class="cart-item-actions">
                            <a class="white-border refresh-me add-to-cart disabled" data-id="7" href="javascript:void(0);">
                                <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-plus"></i> -->
                            </a>
                            <button class="white-border" onclick="removeProduct(7, true)">
                                <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-minus"></i> -->
                            </button>
                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                        </div>
                        <div class="cart-item-sum">
                            € 21.00                    </div>
                        <div class="cart-item-remove">
                            <input type="hidden" name="id[]" value="7">
                            <input type="hidden" name="quantity[]" value="7">
                            <a href="https://tiqs.com/shop/home/removeFromCart?delete-product=7&amp;back-to=home">
                                <svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg><!-- <i class="fa fa-trash"></i> -->
                            </a>
                        </div>
                    </div>
                </div>
                            <div class="cart-row">
                    <div class="cart-item">
                        <div class="cart-item-amount">
                            2x
                        </div>
                        <div class="cart-item-name">
                            Tap (50cl)                    </div>
                        <div class="cart-item-actions">
                            <a class="white-border refresh-me add-to-cart disabled" data-id="8" href="javascript:void(0);">
                                <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-plus"></i> -->
                            </a>
                            <button class="white-border" onclick="removeProduct(8, true)">
                                <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-minus"></i> -->
                            </button>
                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                        </div>
                        <div class="cart-item-sum">
                            € 11.00                    </div>
                        <div class="cart-item-remove">
                            <input type="hidden" name="id[]" value="8">
                            <input type="hidden" name="quantity[]" value="2">
                            <a href="https://tiqs.com/shop/home/removeFromCart?delete-product=8&amp;back-to=home">
                                <svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg><!-- <i class="fa fa-trash"></i> -->
                            </a>
                        </div>
                    </div>
                </div>
                            <div class="cart-row">
                    <div class="cart-item">
                        <div class="cart-item-amount">
                            1x
                        </div>
                        <div class="cart-item-name">
                            Desperados | fles                    </div>
                        <div class="cart-item-actions">
                            <a class="white-border refresh-me add-to-cart disabled" data-id="13" href="javascript:void(0);">
                                <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-plus"></i> -->
                            </a>
                            <button class="white-border" onclick="removeProduct(13, true)">
                                <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-minus"></i> -->
                            </button>
                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                        </div>
                        <div class="cart-item-sum">
                            € 5.00                    </div>
                        <div class="cart-item-remove">
                            <input type="hidden" name="id[]" value="13">
                            <input type="hidden" name="quantity[]" value="1">
                            <a href="https://tiqs.com/shop/home/removeFromCart?delete-product=13&amp;back-to=home">
                                <svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg><!-- <i class="fa fa-trash"></i> -->
                            </a>
                        </div>
                    </div>
                </div>
                            <div class="cart-row">
                    <div class="cart-item">
                        <div class="cart-item-amount">
                            1x
                        </div>
                        <div class="cart-item-name">
                            Oedipus - Manneliefde | fles (33cl)                    </div>
                        <div class="cart-item-actions">
                            <a class="white-border refresh-me add-to-cart disabled" data-id="14" href="javascript:void(0);">
                                <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-plus"></i> -->
                            </a>
                            <button class="white-border" onclick="removeProduct(14, true)">
                                <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-minus"></i> -->
                            </button>
                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                        </div>
                        <div class="cart-item-sum">
                            € 5.00                    </div>
                        <div class="cart-item-remove">
                            <input type="hidden" name="id[]" value="14">
                            <input type="hidden" name="quantity[]" value="1">
                            <a href="https://tiqs.com/shop/home/removeFromCart?delete-product=14&amp;back-to=home">
                                <svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg><!-- <i class="fa fa-trash"></i> -->
                            </a>
                        </div>
                    </div>
                </div>
                            <div class="cart-row">
                    <div class="cart-item">
                        <div class="cart-item-amount">
                            1x
                        </div>
                        <div class="cart-item-name">
                            Oedipus - Mama | fles                     </div>
                        <div class="cart-item-actions">
                            <a class="white-border refresh-me add-to-cart disabled" data-id="15" href="javascript:void(0);">
                                <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-plus"></i> -->
                            </a>
                            <button class="white-border" onclick="removeProduct(15, true)">
                                <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-minus"></i> -->
                            </button>
                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                        </div>
                        <div class="cart-item-sum">
                            € 5.00                    </div>
                        <div class="cart-item-remove">
                            <input type="hidden" name="id[]" value="15">
                            <input type="hidden" name="quantity[]" value="1">
                            <a href="https://tiqs.com/shop/home/removeFromCart?delete-product=15&amp;back-to=home">
                                <svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg><!-- <i class="fa fa-trash"></i> -->
                            </a>
                        </div>
                    </div>
                </div>
                            <div class="cart-row">
                    <div class="cart-item">
                        <div class="cart-item-amount">
                            1x
                        </div>
                        <div class="cart-item-name">
                            Lagunitas - IPA | fles                    </div>
                        <div class="cart-item-actions">
                            <a class="white-border refresh-me add-to-cart disabled" data-id="16" href="javascript:void(0);">
                                <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-plus"></i> -->
                            </a>
                            <button class="white-border" onclick="removeProduct(16, true)">
                                <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-minus"></i> -->
                            </button>
                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                        </div>
                        <div class="cart-item-sum">
                            € 5.00                    </div>
                        <div class="cart-item-remove">
                            <input type="hidden" name="id[]" value="16">
                            <input type="hidden" name="quantity[]" value="1">
                            <a href="https://tiqs.com/shop/home/removeFromCart?delete-product=16&amp;back-to=home">
                                <svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg><!-- <i class="fa fa-trash"></i> -->
                            </a>
                        </div>
                    </div>
                </div>
                            <div class="cart-row">
                    <div class="cart-item">
                        <div class="cart-item-amount">
                            1x
                        </div>
                        <div class="cart-item-name">
                            Chardonnay Semillion | glas                    </div>
                        <div class="cart-item-actions">
                            <a class="white-border refresh-me add-to-cart disabled" data-id="22" href="javascript:void(0);">
                                <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-plus"></i> -->
                            </a>
                            <button class="white-border" onclick="removeProduct(22, true)">
                                <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-minus"></i> -->
                            </button>
                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                        </div>
                        <div class="cart-item-sum">
                            € 4.50                    </div>
                        <div class="cart-item-remove">
                            <input type="hidden" name="id[]" value="22">
                            <input type="hidden" name="quantity[]" value="1">
                            <a href="https://tiqs.com/shop/home/removeFromCart?delete-product=22&amp;back-to=home">
                                <svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg><!-- <i class="fa fa-trash"></i> -->
                            </a>
                        </div>
                    </div>
                </div>
                            <div class="cart-row">
                    <div class="cart-item">
                        <div class="cart-item-amount">
                            1x
                        </div>
                        <div class="cart-item-name">
                            Chardonnay Semillion - | fles                    </div>
                        <div class="cart-item-actions">
                            <a class="white-border refresh-me add-to-cart disabled" data-id="23" href="javascript:void(0);">
                                <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-plus"></i> -->
                            </a>
                            <button class="white-border" onclick="removeProduct(23, true)">
                                <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-minus"></i> -->
                            </button>
                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                        </div>
                        <div class="cart-item-sum">
                            € 21.50                    </div>
                        <div class="cart-item-remove">
                            <input type="hidden" name="id[]" value="23">
                            <input type="hidden" name="quantity[]" value="1">
                            <a href="https://tiqs.com/shop/home/removeFromCart?delete-product=23&amp;back-to=home">
                                <svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg><!-- <i class="fa fa-trash"></i> -->
                            </a>
                        </div>
                    </div>
                </div>
                            <div class="cart-row">
                    <div class="cart-item">
                        <div class="cart-item-amount">
                            1x
                        </div>
                        <div class="cart-item-name">
                            Rose - Berry Bush | fles                    </div>
                        <div class="cart-item-actions">
                            <a class="white-border refresh-me add-to-cart disabled" data-id="25" href="javascript:void(0);">
                                <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-plus"></i> -->
                            </a>
                            <button class="white-border" onclick="removeProduct(25, true)">
                                <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-minus"></i> -->
                            </button>
                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                        </div>
                        <div class="cart-item-sum">
                            € 21.50                    </div>
                        <div class="cart-item-remove">
                            <input type="hidden" name="id[]" value="25">
                            <input type="hidden" name="quantity[]" value="1">
                            <a href="https://tiqs.com/shop/home/removeFromCart?delete-product=25&amp;back-to=home">
                                <svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg><!-- <i class="fa fa-trash"></i> -->
                            </a>
                        </div>
                    </div>
                </div>
                            <div class="cart-row">
                    <div class="cart-item">
                        <div class="cart-item-amount">
                            1x
                        </div>
                        <div class="cart-item-name">
                            Vodka | 2 shots                    </div>
                        <div class="cart-item-actions">
                            <a class="white-border refresh-me add-to-cart disabled" data-id="65" href="javascript:void(0);">
                                <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-plus"></i> -->
                            </a>
                            <button class="white-border" onclick="removeProduct(65, true)">
                                <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-minus"></i> -->
                            </button>
                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                        </div>
                        <div class="cart-item-sum">
                            € 9.00                    </div>
                        <div class="cart-item-remove">
                            <input type="hidden" name="id[]" value="65">
                            <input type="hidden" name="quantity[]" value="1">
                            <a href="https://tiqs.com/shop/home/removeFromCart?delete-product=65&amp;back-to=home">
                                <svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg><!-- <i class="fa fa-trash"></i> -->
                            </a>
                        </div>
                    </div>
                </div>
                            <div class="cart-row">
                    <div class="cart-item">
                        <div class="cart-item-amount">
                            1x
                        </div>
                        <div class="cart-item-name">
                            VEGAN PITA FALAFAL                    </div>
                        <div class="cart-item-actions">
                            <a class="white-border refresh-me add-to-cart disabled" data-id="75" href="javascript:void(0);">
                                <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-plus"></i> -->
                            </a>
                            <button class="white-border" onclick="removeProduct(75, true)">
                                <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-minus"></i> -->
                            </button>
                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                        </div>
                        <div class="cart-item-sum">
                            € 8.50                    </div>
                        <div class="cart-item-remove">
                            <input type="hidden" name="id[]" value="75">
                            <input type="hidden" name="quantity[]" value="1">
                            <a href="https://tiqs.com/shop/home/removeFromCart?delete-product=75&amp;back-to=home">
                                <svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg><!-- <i class="fa fa-trash"></i> -->
                            </a>
                        </div>
                    </div>
                </div>
                            <div class="cart-row">
                    <div class="cart-item">
                        <div class="cart-item-amount">
                            3x
                        </div>
                        <div class="cart-item-name">
                            VEGETARISCHE PIZZA                    </div>
                        <div class="cart-item-actions">
                            <a class="white-border refresh-me add-to-cart disabled" data-id="78" href="javascript:void(0);">
                                <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-plus"></i> -->
                            </a>
                            <button class="white-border" onclick="removeProduct(78, true)">
                                <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-minus"></i> -->
                            </button>
                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                        </div>
                        <div class="cart-item-sum">
                            € 43.50                    </div>
                        <div class="cart-item-remove">
                            <input type="hidden" name="id[]" value="78">
                            <input type="hidden" name="quantity[]" value="3">
                            <a href="https://tiqs.com/shop/home/removeFromCart?delete-product=78&amp;back-to=home">
                                <svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg><!-- <i class="fa fa-trash"></i> -->
                            </a>
                        </div>
                    </div>
                </div>
                            <div class="cart-row">
                    <div class="cart-item">
                        <div class="cart-item-amount">
                            1x
                        </div>
                        <div class="cart-item-name">
                            AMERICANO                    </div>
                        <div class="cart-item-actions">
                            <a class="white-border refresh-me add-to-cart " data-id="87" href="javascript:void(0);">
                                <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-plus"></i> -->
                            </a>
                            <button class="white-border" onclick="removeProduct(87, true)">
                                <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg><!-- <i class="fa fa-minus"></i> -->
                            </button>
                            <!-- <a href="#"><i class="fa fa-pencil"></i></a> -->
                        </div>
                        <div class="cart-item-sum">
                            € 2.65                    </div>
                        <div class="cart-item-remove">
                            <input type="hidden" name="id[]" value="87">
                            <input type="hidden" name="quantity[]" value="1">
                            <a href="https://tiqs.com/shop/home/removeFromCart?delete-product=87&amp;back-to=home">
                                <svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg><!-- <i class="fa fa-trash"></i> -->
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
        <div class="footer-bot">
            <a href="<?php echo base_url(); ?>checkout_order">Make order <svg class="svg-inline--fa fa-arrow-right fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="arrow-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path></svg><!-- <i class="fa fa-arrow-right"></i> --></a>
        </div>
    </div>
</footer>
