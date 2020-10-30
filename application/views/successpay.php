<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link rel="stylesheet" href="<?php base_url('assets/css/extra/all.min.css') ?>" />
<script src="<?php base_url('assets/js/extra/all.min.js') ?>"></script>

<!-- Third party styles and scripts -->
<script src="<?php base_url('assets/js/extra/jquery-3.3.1.slim.min.js') ?>"></script>
<link rel="stylesheet" href="<?php base_url('assets/css/extra/select2.min.css') ?>" />

<!-- Style -->
<link rel="stylesheet" href="<?php base_url('assets/css/extra/style.min.css') ?>" />


<style>
	#shopping-cart .pay-header {
		background-color: #ff4f00;
		color:white;
	}
	#shopping-cart {
		z-index:1;
		position: relative;
	}

	body #shopping-cart .mobile-menu .button {
		background-color: rgba(255, 0, 0, 0.05);
	}
	.payment-title {
		font-size:2.8rem;
		font-weight:bold;
		color:black;
	}

	#shopping-cart form .btn {
		background-color: #ff4f00;
		border-color: #ff4f00;
		color:white;
	}

	#shopping-cart form .btn:hover,
	#shopping-cart form .btn:active {
		background-color: rgba(255, 0, 0, 0.75) !important;
		border-color: rgba(255, 0, 0, 0.75) !important;
	}

	#shopping-cart form .btn {
		color: #fff;
		width: 100%;
	}

	#shopping-cart form .btn:hover,
	#shopping-cart form .btn:active {
		color: #000000 !important
	}
	#shopping-cart .order-details {
		float:unset;
		display:block;
		border-bottom:1px solid #dadada;
		padding-top:0;
	}
	form {
		padding: 20px 25px 25px;
	}

	@media only screen and (max-width: 768px) {
		#page-wrapper #area-container .page-container .heading {
			position: relative;
		}

		#page-wrapper #area-container .footer,
		.mobile-menu {
			position: relative;
		}

		#page-wrapper #area-container .payment-container.methods {
			margin-bottom: 0;
		}
	}

	.button {
		border: none;
		color: white;
		padding: 15px 32px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;
	}

	.button2 {background-color: #008CBA;} /* Blue */

	#area-container .payment-container .table-in3 td.calendar {
		background-image: url('<?php base_url('assets/imgs/extra/in3-calendar.png') ?>') !important;
	}
	.bar2 {
		padding-top:2px !important;
		padding-bottom:2px !important;
		border:none !important;
		display: flex;
		justify-content: flex-end;
	}

</style>


<div id="wrapper">
	<div class="container">

		<div class="page-container">

			<div class="payment-container">
				<!--	--><?//= purchase_steps(1, 2, 3) ?>
				<!--    <div class="alert alert-success">--><?//= lang('c_o_d_order_completed') ?><!--</div>-->
				<div class="row" style="margin: 10px 10px 10px 10px">
					<p style="font-family:'Arial Black'; font-size: x-large"  >
						Bedankt voor je bestelling: nummer: <?php echo $orderid ?>
					<p style="font-family:'Arial Black'; font-size: x-large"  >
						Zodra de order klaar is wordt hij bij je bezorgd.
					</p>
					</p>
					</p>
				</div>
			</div>

			<div class="payment-container" align="center">
				<!--	--><?//= purchase_steps(1, 2, 3) ?>
				<!--    <div class="alert alert-success">--><?//= lang('c_o_d_order_completed') ?><!--</div>-->
				<div class="row" style="margin: 10px 10px 10px 10px">
					<p style="font-family:'Arial Black'; font-size: x-large">
						<?php
						$vendor_id=$this->session->userdata('vendor_id');
						//						// NIEUWE CODE OM DE SHOPPING CARD TE LEGEN
						unset($_SESSION['shopping_cart']);
						unset($_COOKIE['shopping_cart']);
						//						setcookie('shopping_cart', null, -1, '/');
						//						// @delete_cookie('shopping_cart');
						//						if ($this->CI->input->is_ajax_request()) {
						//							echo 1;
						//						}
						// EINDE NIEUWE CODE
						if(empty($vendor_id)){
							$vendor_id=2;
						}
						?>
						<a type="button" href="https://tiqs.com/charlatan/?vendor_id=<?php echo $vendor_id ?>&spot_id=999999" class="button button2">Terug naar bestellen. </a>
					</p>
					</p>
				</div>
			</div>
		</div>
	</div>

	<?php
	$terminal = (strpos($_SERVER['HTTP_USER_AGENT'], 'R330') !== false);
	if ($terminal)
	{
		?>
		<script type="text/javascript">

			function invokeCSCode(data) {
				try {
					invokeCSharpAction(data);
				} catch (err) {
					alert(err);
				}
			}

			(function () {
				setTimeout(function () {
					invokeCSCode('<?php $orderid ?>');
				}, 1000)
			})();

		</script>
		<?php
	}
	?>
