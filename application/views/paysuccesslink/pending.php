<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class='checkout-message' style='margin-top: 100px; margin-bottom: 100px;'>
	<?php include_once FCPATH . 'application/views/paysuccesslink/animation/animation.php'; ?>
	<h2><?php echo $this->language->tLine('CONFIRMATION'); ?></h2>
	<div class="checkout-btns">
		<?php if (isset($order)) { ?>
			<a
					href="<?php echo $backSuccess; ?>"
					style="background-color: #948b6f"
					class="button"
			>
				<?php echo $this->language->tLine('Make new order'); ?><i class="fa fa-arrow-right"></i>
			</a>
		<?php } else { ?>
			<a href="<?php echo $backSuccess; ?>" style="background-color: #948b6f" class="button">
				<?php echo $this->language->tLine('Back'); ?><i class="fa fa-arrow-right"></i>
			</a>
		<?php } ?>
		<?php if (isset($justPrintLink)) { ?>
			<a
					href="<?php echo $justPrintLink; ?>"
					style="background-color: #948b6f"
					class="button"
					target='_blank'
			>
				<?php echo $this->language->tLine('PRINT'); ?><i class="fa fa-print"></i>
			</a>
		<?php } ?>
	</div>

	<div class="checkout-message__content">
		<h3>Your&nbsp;Order is</h3>
		<p class='order-status order-status--true'>Payment in process</p>
		<?php if (isset($order)) { ?>
			<div class='checkout-message__details'>
				<h3>spot: table<span class='checkout-message__spot'></span>&nbsp;<?php echo $order['spotName']; ?></h3>
				<h3>order n<sup>o</sup>: <span class='checkout-message__order'><?php echo $order['orderId']; ?></span></h3>
				<?php
				$amount = floatval($order['orderAmount']) + floatval($order['serviceFee']);
				?>

				<?php if ($analytics['facebookPixelId']) { ?>
					<script>
						fbq('track', 'Purchase', {currency: "EUR", value: "<?php echo number_format($amount, 2, '.', ''); ?>"});
					</script>
				<?php } ?>

				<h3>amount: <span class='checkout-message__amount'><?php echo number_format($amount, 2, '.', ''); ?></span></h3>
				<?php if (floatval($order['waiterTip'])) { ?>
					<h3>tip: <span class='checkout-message__amount'><?php echo number_format($order['waiterTip'], 2, '.', ''); ?></span></h3>
				<?php } ?>
			</div>
		<?php } ?>
		<h3 class='order-status order-status--true'>We are now working on your payment</h3>
	</div>
	<div class="checkout-btns">
		<?php if (isset($order)) { ?>
			<a
					href="<?php echo $backSuccess; ?>"
					style="background-color: #948b6f"
					class="button">
				Make new order<i class="fa fa-arrow-right"></i>
			</a>
		<?php } else { ?>
			<a href="<?php echo $backSuccess; ?>" style="background-color: #948b6f" class="button">
				Back<i class="fa fa-arrow-right"></i>
			</a>
		<?php } ?>
		<?php if (isset($justPrintLink)) { ?>
			<a
					href="<?php echo $justPrintLink; ?>"
					style="background-color: #948b6f"
					class="button"
					target='_blank'
			>
				PRINT<i class="fa fa-print"></i>
			</a>
		<?php } ?>
	</div>
</div>
