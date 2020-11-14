<div class="modal modal__checkout selectedSpotBackground" id="checkout-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content selectedSpotBackground">
            <div class="modal-header selectedSpotBackground">
                <div class="modal-header__content selectedSpotBackground">
                    
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span style="color:#000;">&times;</span>
                </button>
            </div>
            <div class="modal-body selectedSpotBackground">
                <div>
                    <div class="modal__checkout__list selectedSpotBackground" id='modal__checkout__list' style="margin: 0px 10px; overflow-y: scroll !important;">
                        <?php echo $checkoutList; ?>
                    </div>
                    <!-- <div class="modal-footer">
                        <p>TOTAL:
                            <span class="bottom-bar__total-price"></span>
                        </p>
                        <button class='button-main button-primary' onclick="checkout()">
                            CHECKOUT &euro;&nbsp;<span class="totalPrice">0</span>
                        </button>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
