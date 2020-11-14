<div class='checkout-message' style='margin-top: 100px; margin-bottom: 100px;'>
	<img src="http://localhost:8080/alfred/alfred/assets/images/defaultProductsImages/coca-cola.png" alt="">
	<h2>CONFIRMATION</h2>
	<div class="checkout-message__content">
		<h3>You Order was</h3>
		<?php if ($order['orderPaidStatus'] === $paid) { ?>
			<p class='order-status order-status--true'>successful</p>
		<?php } else { ?>
			<p class='order-status order-status--false'>not successful</p>
		<?php } ?>
		<div class='checkout-message__details'>
			<h3>spot: table<span class='checkout-message__spot'></span>&nbsp;<?php echo $order['spotName']; ?></h3>
			<h3>order n<sup>o</sup>: <span class='checkout-message__order'><?php echo $order['orderId']; ?></span></h3>
			<?php
				$amount = floatval($order['orderAmount']) + floatval($order['serviceFee']);
			?>
			<h3>amount: <span class='checkout-message__amount'><?php echo number_format($amount, 2, '.', ''); ?></span></h3>
			<?php if (floatval($order['waiterTip'])) { ?>
				<h3>tip: <span class='checkout-message__amount'><?php echo number_format($order['waiterTip'], 2, '.', ''); ?></span></h3>
			<?php } ?>
		</div>
		<?php if ($order['orderPaidStatus'] === $paid) { ?>
		<h3 class='order-status order-status--true'>please be patiente we are now working on that</h3>
		<?php } else { ?>
			<h3 class='order-status order-status--false'>(2003) Please try again</h3>
		<?php } ?>
	</div>
	<div class="checkout-btns">
	<a href="<?php echo base_url() . 'make_order?vendorid=' . $order['vendorId'] . '&spotid=' . $order['spotId']; ?>" style="background-color: #948b6f" class="button">
		order again<i class="fa fa-arrow-right"></i>
	</a>
	</div>
</div>
