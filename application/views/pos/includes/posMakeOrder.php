<div class="col-md-4 px-0" id="posMakeOrderId">
    <div style="height:7vh; margin:0px 0px 10px 10px;" class='pos-settings'>
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
        <div class="col-sm-3" style="padding-right:0px; height: 100%;">
            <button
                id="managerButton"
                class="btn btn-primary"
                style="display: none; height: 100%; width: 100%; padding: 16% 12% 16% 12%;"
                data-toggle="modal" data-target="#managerModal"
            >
                <i class="fa fa-cogs" aria-hidden="true" style="font-size:24px"></i>
            </button>
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
    <div style="margin: 0 -8px 0 -10px !important" class='pos-buttons d-flex row mx-0'>
        <div class="col-7 col-lg-6" style="padding-left:0px; padding-right:0px;">
            <div class="col-sm-12 px-0" >
                <div class="col-sm-6 px-3 pb-3">
                    <a
                        href="javascript:void(0)"
                        onclick="cancelPosOrder()"
                        class="btn btn-danger"
                        style="width: 100%;"
                    >
                        Cancel
                    </a>
                </div>
                <div class="col-sm-6 px-3 pb-3" >
                    <a
                        href="javascript:void(0)"
                        id="saveHoldOrder"
                        data-toggle="modal"
                        data-target="#holdOrder"
                        class="btn btn-success"
                        style="width: 100%;"
                    >
                        Save
                    </a>
                </div>
            </div>
            <div class="col-sm-12 px-0">
                <div class="col-sm-6 px-3 pt-3">
                    <a
                        href="javascript:void(0)"
                        onclick="resetPosOrder()"
                        class="btn btn-primary"
                        style="width: 100%; background-color:#ff7f50;"
                    >
                        New
                    </a>
                </div>
                <div class="col-sm-6 px-3 pr-0 pt-3" >
                    <a
                        href="javascript:void(0)"
                        onclick="lockPos()"
                        class="btn btn-primary"
                        style="width: 100%;"
                    >
                        Logout
                    </a>
                </div>
            </div>
        </div>



        <div class="col-5 col-lg-6 px-3">
            <a
                href="javascript:void(0)"
                class='pos-checkout__button mb-3'
                data-toggle="modal"
                data-target="#selectPaymentMethod"
                style="width: 100%;"
            >
                Pay (<span class="totalPrice">0</span>&nbsp;&euro;)
            </a>

            
            <a
                id="posPrintButton"
                href="javascript:void(0)"
                class='pos-checkout__button mt-3'
                onclick="posPayOrder(this)"
                data-locked="0"
                data-paid="0"
                style="width: 100%;"
            >
                Print
            </a>
        </div>
    </div>
</div>
<!-- onclick="saveAndPrint(this)" -->
<div class="col-md-4" id="posResponse" style="display:none; padding-top:40px"></div>
