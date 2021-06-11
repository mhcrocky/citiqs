<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class='checkout-message' style='margin-top: 100px; margin-bottom: 100px;'>
	<h2><?php echo $this->language->tLine('CONFIRMATION'); ?></h2>
	<div class="checkout-message__content">
		<h3><?php echo $this->language->tLine('Your order was'); ?></h3>
        <p class='order-status order-status--false'>
            <?php echo $this->language->tLine('not successful'); ?>
        </p>
        <?php if (isset($order)) { ?>
            <div class='checkout-message__details'>
                <h3><?php echo $this->language->tLine('spot'); ?>: <?php echo $this->language->tLine('table'); ?><span class='checkout-message__spot'></span>&nbsp;<?php echo $order['spotName']; ?></h3>
                <h3><?php echo $this->language->tLine('order'); ?> n<sup>o</sup>: <span class='checkout-message__order'><?php echo $order['orderId']; ?></span></h3>
                <?php
                    $amount = floatval($order['orderAmount']) + floatval($order['serviceFee']);
                ?>
                <h3><?php echo $this->language->tLine('amount'); ?>: <span class='checkout-message__amount'><?php echo number_format($amount, 2, '.', ''); ?></span></h3>
                <?php if (floatval($order['waiterTip'])) { ?>
                    <h3><?php echo $this->language->tLine('tip'); ?>: <span class='checkout-message__amount'><?php echo number_format($order['waiterTip'], 2, '.', ''); ?></span></h3>
                <?php } ?>
            </div>
        <?php } ?>    
        <h3 class='order-status order-status--false'><?php echo $paynlInfo; ?></h3>
	</div>
	<div class="checkout-btns">
        <?php if (isset($order)) { ?>
            <a
                href="<?php echo $backFailed; ?>"
                style="background-color: #948b6f"
                class="button"
            >
                <?php echo $this->language->tLine('Try again'); ?><i class="fa fa-arrow-right"></i>
            </a>
            <a
                href="<?php echo $changePamyentMethod; ?>"
                style="background-color: #948b6f"
                class="button"
            >
                <?php echo $this->language->tLine('Change payment method'); ?><i class="fa fa-arrow-right"></i>
            </a>
        <?php } else { ?>
            <a href="<?php echo $backFailed; ?>" style="background-color: #948b6f" class="button">
                <?php echo $this->language->tLine('Back'); ?><i class="fa fa-arrow-right"></i>
            </a>
        <?php } ?>
	</div>
</div>
