<div class="col-lg-4" id="posMakeOrderId">    
    <div class="pos-sidebar">
        <div class="pos-checkout">
            <div class="pos-checkout__header">
                <h3 id="checkoutName">
                    Checkout
                </h3>
                <div class="pos-checkout-row pos-checkout-row--top pos-checkout-list" id="modal__checkout__list">
                    <?php if (isset($checkoutList)) echo $checkoutList; ?>
                </div>
                <!-- end checkout row -->
            </div>
            <!-- end checout list -->
        </div>
    </div>
    <a
        href="javascript:void(0)"
        class='pos-checkout__button'
        onclick="posPayOrder(this)"
        data-locked="0"
        data-paid="1"
    >
        Pay (<span class="totalPrice">0</span>&nbsp;&euro;)
    </a>
    <a
        style="display:none"
        id="posPrintButton"
        href="javascript:void(0)"
        class='pos-checkout__button'
        onclick="posPayOrder(this)"
        data-locked="0"
        data-paid="0"
    >
        Print
    </a>
</div>

<div class="col-lg-4" id="posResponse" style="dipslay:none; padding-top:40px"></div>
