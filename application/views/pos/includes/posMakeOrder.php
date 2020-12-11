<div class="col-lg-4" id="posMakeOrderId">    
    <div class="pos-sidebar">
        <div class="pos-checkout">
            <div class="pos-checkout__header">
                <h3>
                    Checkout
                    <?php
                        if (!empty($posOrderName)) { 
                            $posOrderName = trim(substr($posOrderName, (strpos($posOrderName, ')') + 1)));
                            echo '"' . $posOrderName . '"';
                        }
                    ?>
                </h3>
                <div class="pos-checkout-row pos-checkout-row--top pos-checkout-list" id="modal__checkout__list">
                    <?php if (isset($checkoutList)) echo $checkoutList; ?>
                </div>
                <!-- end checkout row -->
            </div>
            <!-- end checout list -->
        </div>
    </div>
    <a href="javascript:void(0)" class='pos-checkout__button' onclick="posPayment()">Pay (<span class="totalPrice">0</span>&nbsp;&euro;)</a>
</div>

<div class="col-lg-4" id="posResponse" style="dipslay:none; padding-top:40px"></div>
