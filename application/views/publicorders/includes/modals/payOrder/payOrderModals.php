<!-- modals -->
<?php if ($localType === intval($spot['spotTypeId'])) { ?>
    <?php if (in_array($prePaid, $paymentMethodsKey)) { ?>
        <!-- Modal -->
        <div id="prePaid" class="modal" role="dialog">
            <div class="modal-dialog modal-sm modalPayOrder" style="text-align:center">
                <!-- Modal content-->
                <div class="modal-content modalPayOrder">
                    <div class="modal-body modalPayOrder">
                        <button
                            class="btn btn-success btn-lg modalPayOrderButton"
                            style="border-radius:50%; margin-right:5%; font-size:24px"
                            data-clicked="0"
                            <?php
                                $cashRedirect  = base_url() . 'cashPayment/' . $this->config->item('orderNotPaid');
                                $cashRedirect .= '/' . $this->config->item('prePaid');
                                $cashRedirect .= '?' . $orderDataGetKey . '=' . $orderRandomKey;
                            ?>
                            onclick="payRedirect(this, '<?php echo $cashRedirect; ?>')"
                            >
                            <i class="fa fa-check modalPayOrderButton" aria-hidden="true"></i>
                        </button>
                        <button
                            class="btn btn-danger btn-lg modalPayOrderButton"
                            style="border-radius:50%; margin-left:5%; font-size:24px"
                            data-dismiss="modal"
                            >
                            <i class="fa fa-times modalPayOrderButton" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>            
        </div>
    <?php } ?>
    <?php if (in_array($postPaid, $paymentMethodsKey)) { ?>
        <!-- Modal -->
        <div id="postPaid" class="modal" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content modalPayOrder">
                    <div class="modal-body modalPayOrder" style="text-align:center">
						<div>
							<h2><?php echo $this->language->tLine("Confirm with checkmark.");?></h2>
						</div>
                        <button
                            class="btn btn-success btn-lg modalPayOrderButton"
                            style="border-radius:50%; margin-right:5%; font-size:24px"
                            data-clicked="0"
                            <?php
                                $cashRedirect  = base_url() . 'cashPayment/' . $this->config->item('orderPaid');
                                $cashRedirect .= '/' . $this->config->item('postPaid');
                                $cashRedirect .= '?' . $orderDataGetKey . '=' . $orderRandomKey;
                            ?>
                            onclick="payRedirect(this, '<?php echo $cashRedirect; ?>')"
                            >
                            <i class="fa fa-check modalPayOrderButton" aria-hidden="true"></i>
                        </button>
                        <button
                            class="btn btn-danger btn-lg modalPayOrderButton"
                            style="border-radius:50%; margin-left:5%; font-size:24px"
                            data-dismiss="modal"
                            >
                            <i class="fa fa-times modalPayOrderButton" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<?php if (in_array($voucherPayment, $paymentMethodsKey)) { ?>
    <!-- Modal -->
    <div id="voucher" class="modal" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content modalPayOrder">
                <div class="modal-body modalPayOrder" style="text-align:center">
                    <label for="codeId" class="payOrderInputFieldsLabel">Insert code from voucher</label>
                    <input
                        type="text"
                        id="codeId"
                        class="form-control payOrderInputFields"
                        data-<?php echo $orderDataGetKey; ?>="<?php echo $orderRandomKey; ?>"
                    />
                    <br/>
                    <button
                        class="btn btn-success btn-lg modalPayOrderButton"
                        style="border-radius:50%; margin:30px 5% 0px 0px; font-size:24px"
                        onclick="voucherPay('codeId')"
                    >
                        <i class="fa fa-check modalPayOrderButton" aria-hidden="true"></i>
                    </button>
                    <button
                        class="btn btn-danger btn-lg closeModal modalPayOrderButton"
                        style="border-radius:50%; margin:30px 5% 0px 0px; font-size:24px"
                        data-dismiss="modal"
                    >
                        <i class="fa fa-times modalPayOrderButton" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
