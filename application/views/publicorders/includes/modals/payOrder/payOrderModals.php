<!-- modals -->
<?php if ($localType === intval($spot['spotTypeId'])) { ?>
    <?php if (in_array($prePaid, $paymentMethodsKey)) { ?>
        <!-- Modal -->
        <div id="prePaid" class="modal"  tabindex="-1" role="dialog">
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
                            data-href="<?php echo $cashRedirect; ?>"
                            onclick="payRedirect(this)"
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
        <div id="postPaid" class="modal" role="dialog"  tabindex="-1">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content modalPayOrder">
                    <div class="modal-body modalPayOrder" style="text-align:center">
						<div>
							<h1 style="font-size: large"><?php echo $this->language->tLine("CONFIRM");?></h1>
						</div>
						<button
								class="btn btn-danger btn-lg modalPayOrderButton"
								style="border-radius:50%; margin-left:5%; font-size:24px"
								data-dismiss="modal"
						>
							<i class="fa fa-times modalPayOrderButton" aria-hidden="true"></i>
						</button>
                        <button
                            class="btn btn-success btn-lg modalPayOrderButton"
                            style="border-radius:50%; margin-right:5%; font-size:24px"
                            data-clicked="0"
                            <?php
                                $cashRedirect  = base_url() . 'cashPayment/' . $this->config->item('orderPaid');
                                $cashRedirect .= '/' . $this->config->item('postPaid');
                                $cashRedirect .= '?' . $orderDataGetKey . '=' . $orderRandomKey;
                            ?>
                            data-href="<?php echo $cashRedirect; ?>"
                            onclick="payRedirect(this)"
                        >
                            <i class="fa fa-check modalPayOrderButton" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<?php if (in_array($voucherPayment, $paymentMethodsKey) &&  $vendor['voucherPaymentCode'] === '0') { ?>

        <div class="modal" id="voucher" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content modalPayOrder">
                
                    <div class="modal-body modalPayOrder" style="text-align:center">
                        <label for="codeId2" class="payOrderInputFieldsLabel"><?php echo $this->language->tLine('Insert code from voucher');?></label>
                        <input
                            type="text"
                            id="codeId2"
                            class="form-control payOrderInputFields voucherClass"
                            data-<?php echo $orderDataGetKey; ?>="<?php echo $orderRandomKey; ?>"
                            autocomplete="off"
                        />
                        <br/>
                        <button
                            type="button"
                            class="btn btn-success btn-lg modalPayOrderButton"
                            style="border-radius:50%; margin:30px 5% 0px 0px; font-size:24px"
                            onclick="voucherPay('codeId2')"
                        >
                            <i class="fa fa-check modalPayOrderButton" aria-hidden="true"></i>
                        </button>
                        <button
                            type="button"
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
