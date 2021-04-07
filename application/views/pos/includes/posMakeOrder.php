<div class="col-lg-4" id="posMakeOrderId">
    <div style="height:7vh; margin:0px 0px 10px 10px;">
        <div class="col-sm-9 form-inline">
            <label
                for='selectSaved'
                class="selectSavedOrdersList"
            >
                Select holded order:&nbsp;&nbsp;
            </label>
            <select
                onchange="fetchSavedOrder(this)"
                class="form-control selectSavedOrdersList"
                id="selectSaved"
            >
                <option value="">Select</option>
                <?php if ($spotPosOrders) { ?>
                    <?php foreach ($spotPosOrders as $saveOrder) { ?>
                        <option
                            id='<?php echo $saveOrder['randomKey']; ?>'
                            value="<?php echo $saveOrder['randomKey']; ?>"
                            <?php
                                if (!empty($orderDataRandomKey) && $saveOrder['randomKey'] === $orderDataRandomKey) {
                                    $selected = 'selected';
                                    echo $selected;
                                }
                            ?>
                        >
                            <?php echo $saveOrder['saveName'] . ' (' . $saveOrder['lastChange'] . ')'; ?>
                        </option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
        <div class="col-sm-3">
            <a href="<?php echo base_url() . 'orders'; ?>">
                <button>
                    <i class="fa fa-hand-o-left" aria-hidden="true"></i>
                    BACK
                </button>
            </a>
        </div>
    </div>

    <div style="height:70vh;" class="pos-sidebar">
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
    <div style="height:14vh; margin-left:20px">
        <div class="col-sm-6" style="padding-left:0px; padding-right:0px;">
            <div class="col-sm-12" style="padding-left:0px; padding-right:7px;">
                <div class="col-sm-6" style="padding-left:0px; padding-right:0px;">
                    <a
                        href="javascript:void(0)"
                        onclick="cancelPosOrder()"
                        class="btn btn-danger"
                        style="width: 100%; margin:5px 5px 5px 0px; padding: 24% 24% 24% 20%;"
                    >
                        Cancel
                    </a>
                </div>
                <div class="col-sm-6" style="padding-left:0px; padding-right:0px;">
                    <a
                        href="javascript:void(0)"
                        id="saveHoldOrder"
                        data-toggle="modal"
                        data-target="#holdOrder"
                        class="btn btn-success"
                        style="width: 100%; margin:5px 0px 5px 5px; padding: 24% 24%;"
                    >
                        Save
                    </a>
                </div>
            </div>
            <div class="col-sm-12" style="padding-left:0px; padding-right:7px;">
                <div class="col-sm-6" style="padding-left:0px; padding-right:0px;">
                    <a
                        href="javascript:void(0)"
                        onclick="resetPosOrder()"
                        class="btn btn-primary"
                        style="width: 100%; margin:5px 5px 5px 0px; padding: 24% 24%; background-color:#ff7f50;"
                    >
                        New
                    </a>
                </div>
                <div class="col-sm-6" style="padding-left:0px; padding-right:0px;">
                    <a
                        href="javascript:void(0)"
                        onclick="lockPos()"
                        class="btn btn-primary"
                        style="width: 100%; margin:5px 0px 5px 5px; padding: 24% 24%"
                    >
                        Logout
                    </a>
                </div>
            </div>
        </div>



        <div class="col-sm-6" style="padding-left:0px; padding-right:0px;">
            <a
                href="javascript:void(0)"
                class='pos-checkout__button'
                data-toggle="modal"
                data-target="#selectPaymentMethod"
                style="width: 100%; margin:5px 5px 5px 5px; padding: 11% 11%"
            >
                Pay (<span class="totalPrice">0</span>&nbsp;&euro;)
            </a>

            
            <a
                id="posPrintButton"
                href="javascript:void(0)"
                class='pos-checkout__button'
                onclick="posPayOrder(this)"
                data-locked="0"
                data-paid="0"
                style="width: 100%; margin:5px 5px 5px 5px; padding: 11% 11%"
            >
                Print
            </a>
        </div>
    </div>
</div>
<!-- onclick="saveAndPrint(this)" -->
<div class="col-lg-4" id="posResponse" style="display:none; padding-top:40px"></div>
