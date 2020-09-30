
            <div class="checkout-table__single-element checkout-table__single-element--total">
                <div class="checkout-table__total">
                    <b>SERVICE FEE:</b>
                    <span id="serviceFee">
                        <?php
                            $serviceFee = $orderTotal * $vendor['serviceFeePercent'] / 100 + $vendor['minimumOrderFee'];
                            if ($serviceFee > $vendor['serviceFeeAmount']) $serviceFee = $vendor['serviceFeeAmount'];
                            echo number_format($serviceFee, 2, ".", ","); ?> &euro;
                    </span>
                </div>
            </div>
            <div class="checkout-table__single-element checkout-table__single-element--total">
                <div class="checkout-table__total">
                    <b>TOTAL:</b>
                    <span id="totalAmount">
                        <?php
                            $total = $orderTotal + $serviceFee;
                            echo number_format($total, 2, ".", ",");
                        ?> &euro;
                    </span>
                </div>
            </div>
            <?php if ($vendor['tipWaiter'] === '1') { ?>
                <div class="checkout-table__single-element checkout-table__single-element--total">
                    <div class="checkout-table__total" style="text-align:right">
                        <b>WAITER TIP:</b>
                        <span>
                            <input
                                type="number"
                                min="0"
                                value="<?php echo (empty($_SESSION['postOrder']['order']['waiterTip'])) ? '0.00' : $_SESSION['postOrder']['order']['waiterTip']; ?>"
                                step="0.01"
                                id="waiterTip"
                                name="order[waiterTip]"
                                class="form-control"
                                oninput="addTip(this)"
                                style="width:25%; display:inline"
                            /> &euro;
                        </span>
                    </div>
                </div>
                <div class="checkout-table__single-element checkout-table__single-element--total" style="text-align:right">
                    <div class="checkout-table__total">
                        <b>TOTAL WITH TIP:</b>
                        <span>
                            <input
                                type="number"
                                min="<?php echo round($total, 2); ?>"
                                <?php
                                    if (!empty($_SESSION['postOrder']['order']['waiterTip'])) {
                                        $totalWithTip = $_SESSION['postOrder']['order']['waiterTip'] + $total;
                                    } else {
                                        $totalWithTip = $total;
                                    }
                                ?>
                                value="<?php echo round($totalWithTip, 2); ?>"
                                step="0.01"
                                id="totalWithTip"
                                placeholder="Waiter tip"
                                class="form-control"
                                oninput="addTotalWithTip(this)"
                                onchange="checkValue(this)"
                                style="width:25%; display:inline"
                            /> &euro;
                        </span>
                    </div>
                </div>
            <?php } ?>
            <?php if ($vendor['requireRemarks'] === '1') { ?>
                <div class="form-group col-sm-12">
                    <label for="notesInput">Remark</label>
                    <textarea id="notesInput" class="form-control" name="order[remarks]" rows="3" maxlength="250"></textarea>
                </div>
            <?php } ?>
            <!-- end total sum-->
        </div>
        <!-- end checkout table -->
    </div>
</div>
