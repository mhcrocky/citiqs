<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Modals -->
<div id="holdOrder" class="modal" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body" style="text-align:center">
                <label for="codeId" class="">Save order</label>
                <input
                    type="text"
                    id="posOrderName"
                    class="posKeyboard form-control ui-widget-content ui-corner-all ui-autocomplete-input ui-keyboard-preview"
                    role="textbox"
                    tabindex='-1'
                    autocomplete="off"
                />
                <br/>
                <button
                    id="holdOrderId"
                    class="btn btn-success btn-lg"
                    style="border-radius:50%; margin:30px 5% 0px 0px; font-size:24px"
                    data-locked="0"
                    data-paid="0"
                    onclick="holdOrder(this)"
                >
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </button>
                <button
                    class="btn btn-danger btn-lg closeModal"
                    style="border-radius:50%; margin:30px 5% 0px 0px; font-size:24px"
                    data-dismiss="modal"
                >
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="confirmCancel" class="modal" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body" style="text-align:center">
                <label for="codeId" class="">This order will be removed. Are you sure?</label>
                <br/>
                <button
                    class="btn btn-success btn-lg"
                    style="border-radius:50%; margin:30px 5% 0px 0px; font-size:24px"
                    onclick="deletePosOrder()"
                >
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </button>
                <button
                    class="btn btn-danger btn-lg closeModal"
                    style="border-radius:50%; margin:30px 5% 0px 0px; font-size:24px"
                    data-dismiss="modal"
                >
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="posLoginModal" tabindex="-1" role="dialog" aria-labelledby="posLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" onsubmit="return posLogin(this)">
                <input type="number" name="ownerId" value="<?php echo $vendor['vendorId']; ?>" readonly hidden />
                <div class="modal-header">
                    <h5 class="modal-title" id="posLoginModalLabel">POS Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select
                            class="form-control"
                            name="email"id="employeeEmail"
                            data-form-check="1"
                            data-error-message="Email is required"
                            data-min-length="1"
                        >
                            <option value="">Select</option>
                            <?php foreach ($employees as $employee) { ?>
                                <option value="<?php echo $employee['employeeEmail']; ?>"><?php echo $employee['employeeEmail']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input
                            type="password"
                            name="password"
                            id="employeePassword"
                            class="posKeyboard form-control ui-widget-content ui-corner-all ui-autocomplete-input ui-keyboard-preview"
                            role="textbox"
                            tabindex='-1'
                            autocomplete="off"
                            data-form-check="1"
                            data-error-message="Password is required"
                            data-min-length="1"
                        />
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo base_url() ?>orders" class="btn btn-primary">Back</a>
                    <input id="submitPosLogin" type="submit" class="btn btn-primary" value="Login" />
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="selectPaymentMethod" tabindex="-1" role="dialog" aria-labelledby="selectPaymentMethodLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectPaymentMethodLabel">Select payment method</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <figure
                    class="col-lg-4 figure"
                    onclick="posPayOrder(this)"
                    data-locked="0"
                    data-paid="1"
                    data-payment-method="<?php echo $postPaid?>"
                >
                    <img
                        src="<?php echo base_url() . 'assets/images/waiter.png'; ?>"
                        alt="Pay at waiter"
                        class="figure-img img-fluid"
                    />
                </figure>
                <figure
                    class="col-lg-3 figure"
                    onclick="posPayOrder(this)"
                    data-locked="0"
                    data-paid="0"
                    data-payment-method="<?php echo $pinMachinePayment?>"
                >
                    <img
                        src="<?php echo base_url() . 'assets/home/images/pinmachine.png'; ?>"
                        alt="pin machine"
                        class="figure-img img-fluid"
                    />
                </figure>
                <!-- onclick="posPayOrder(this)"
                    data-locked="0"
                    data-paid="1"
                    data-payment-method="<?php #echo $pinMachinePayment?>" -->
                <figure
                    class="col-lg-3 figure"
                >
                    <a href="javascript:;" data-toggle="modal" data-target="#voucher" >
                        <img
                            src="<?php echo base_url() . 'assets/home/images/voucher.png'; ?>"
                            alt="voucher"
                            class="figure-img img-fluid"
                        />
                    </a>
                </figure>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="voucher" class="modal" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body" style="text-align:center">
                <label for="codeId">Insert code from voucher</label>
                <input
                    type="text"
                    id="codeId"
                    class="form-control"
                />
                <br/>
                <button
                    class="btn btn-success btn-lg"
                    style="border-radius:50%; margin:30px 5% 0px 0px; font-size:24px"
                    onclick="posVoucherPay(this, 'codeId')"
                    data-locked="0"
                    data-paid="0"
                    data-payment-method="<?php echo $voucherPayment?>"
                >
                    <i class="fa fa-check" aria-hidden="true"></i>
                </button>
                <button
                    class="btn btn-danger btn-lg closeModal"
                    style="border-radius:50%; margin:30px 5% 0px 0px; font-size:24px"
                    data-dismiss="modal"
                >
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>
