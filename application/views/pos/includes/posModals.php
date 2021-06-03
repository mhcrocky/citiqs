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
        <div class="modal-content"  style="width:280px; text-align:center">
            <table class="" id="posPinCode">
                <thead>
                    <tr>
                        <th colspan="3">
                            <input type="password" class="form-control" id="pinCode" readonly />
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td onclick="fetchValue(1, this)">
                            <p>
                                <span>1</span>
                            </p>
                        </td>
                        <td onclick="fetchValue(2, this)">
                            <p>
                                <span>2</span>
                            </p>
                        </td>
                        <td onclick="fetchValue(3, this)">
                            <p>
                                <span>3</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td onclick="fetchValue(4)">
                            <p>
                                <span>4</span>
                            </p>
                        </td>
                        <td onclick="fetchValue(5)">
                            <p>
                                <span>5</span>
                            </p>
                        </td>
                        <td onclick="fetchValue(6)">
                            <p>
                                <span>6</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td onclick="fetchValue(7)">
                            <p>
                                <span>7</span>
                            </p>
                        </td>
                        <td onclick="fetchValue(8)">
                            <p>
                                <span>8</span>
                            </p>
                        </td>
                        <td onclick="fetchValue(9)">
                            <p>
                                <span>9</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td onclick="clearCode()">
                            <p>
                                <span>Clear</span>
                            </p>
                        </td>
                        <td onclick="fetchValue(0)">
                            <p>
                                <span>0</span>
                            </p>
                        </td>
                        <td onclick="posLogin()">
                            <p>
                                <span>Enter</span>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
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

<div class="modal" id="managerModal" tabindex="-1" role="dialog" aria-labelledby="managerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="managerModalLabel">Reportes</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="pos_categories__footer" style="display:initial">
                    <a
                        href="javascript:void(0)"
                        class='pos_categories__button pos_categories__button--primary'
                        onclick="printReportes('<?php echo $vendor['vendorId']; ?>', '<?php echo $xReport; ?>')"
                    >
                        X reportes
                    </a>
                    <a
                        href="javascript:void(0)"
                        class='pos_categories__button pos_categories__button--third'
                        onclick="printReportes('<?php echo $vendor['vendorId']; ?>', '<?php echo $zReport; ?>')"
                    >
                        Z reportes
                    </a>
                    <a
                        href="<?php echo base_url() . 'orders'; ?>"
                        class='pos_categories__button pos_categories__button--second'
                    >
                        <i class="fa fa-hand-o-left" aria-hidden="true"></i>
                        BACK
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<div id="floorplan" class="modal" role="dialog">
    <div class="modal-dialog modal-lg" >
        <!-- Modal content-->
        <div class="modal-content" style="width:840px">
            <div class="modal-body" style="text-align:center">
                <div class="row mb-5 canvas_row" id="canvas_row">
                    <div class="col-md-12 mh-100" id="floor_image">
                        <canvas id="canvas" width="700" height="700"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
