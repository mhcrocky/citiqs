<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- load font awesome -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/extra/all.min.css') ?>" />
<script src="<?php echo base_url('assets/js/extra/all.min.js') ?>"></script>

<!-- Third party styles and scripts -->
<script src="<?php echo base_url('assets/js/extra/jquery-3.3.1.slim.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/extra/select2.min.css') ?>" />

<!-- Style -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/extra/style.min.css') ?>" />

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

	#area-container .payment-container .table-in3 td.calendar {
		background-image: url('<?php echo base_url('assets/imgs/extra/in3-calendar.png') ?>') !important;
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
	<div id="content">
		<div class="container" id="shopping-cart">
			<div class="container" id="page-wrapper">
				<div class="row">
					<div class="col-md-12">
						<div id="area-container">

							<div class="logo-container">
							  <img src="./extra_includes/img/logoWI_side_white.png">
							</div>

							<div class="page-container">
								<div class="heading pay-header">
								</div>
								<!-- /.heading -->

								<div class="bar bar2">
									<div class="language">
										<a href="#">
											<span class="selectedLanguage">NL</span>
											<i class="fa fa-angle-down" aria-hidden="true"></i>
										</a>

										<div class="menu hidden">
											<ul>
												<li class="selected">NL</li>
												<li>EN</li>
												<li>FR</li>
											</ul>
										</div>
									</div>
								</div>

								<div class="order-details">
									<table>
										<tbody>
												<tr class="shipment">
													<td align="left" >
                                                        <p><?php echo ($this->language->Line("SELECT_PAYMENT_TYPE-0002", "RESERVERING")) ? $this->language->Line("SELECT_PAYMENT_TYPE-0002", "RESERVERING") : "RESERVERING"; ?></p>
                                                        <p><?php echo ($this->language->Line("SELECT_PAYMENT_TYPE-0003", "RESERVERINGS FEE")) ? $this->language->Line("SELECT_PAYMENT_TYPE-0003", "RESERVERINGS FEE") : "RESERVERINGS FEE"; ?></p>
                                                        <p><?php echo ($this->language->Line("SELECT_PAYMENT_TYPE-0004", "TOTAL")) ? $this->language->Line("SELECT_PAYMENT_TYPE-0004", "TOTAL") : "TOTAL"; ?></p>
													</td>
													<td>
														<p>
														<?php
														echo my_money_format("de_DE", $finalbedragexfee);
														?>
														</p>
														<p>
														<?php
														echo my_money_format("de_DE", $finalbedragfee);
														?>
														</p>
														<p>
														<?php
														echo my_money_format("de_DE", $finalbedrag);
														?>
														</p>
													</td>

												</tr>

										</tbody>
									</table>
								</div>
								<div class="bar">
								
									<div class="bar-title"><span data-trans="" data-trn-key="Kies een betaalmethode">Kies een
                        betaalmethode</span></div>
									<span class="bar-title-original hidden"><span data-trans=""
																				  data-trn-key="Kies een betaalmethode">Kies een
                        betaalmethode</span></span>
								</div>
								<!-- /.bar -->

								<div class="content-container clearfix">

									<div class="payment-container methods">
										<a href="#" class="paymentMethod method-ideal" data-payment-type="ideal">
											<img src="<?php echo base_url('assets/imgs/extra/ideal.png') ?>" alt="iDEAL">
											<span>iDEAL</span>
										</a>
										<a href="<?php echo base_url('bookingpay/selectedCCPaymenttype') ?>" class="paymentMethod method-card" data-payment-type="card">
											<img src="<?php echo base_url('assets/imgs/extra/creditcard.png') ?>" alt="Creditcard">
											<span data-trans="" data-trn-key="Creditcard">Creditcard</span>
										</a>
										<!-- <span class="paymentMethod no-mobile"></span> -->

										<div class="clearfix"></div>
									</div>
									<!-- /.payment-container -->

									<div class="method method-ideal hidden">
										<div class="title hidden"><span data-trans="" data-trn-key="Kies een bank">Kies een bank</span>
										</div>

										<div class="payment-container">
											<a href="<?php echo base_url('bookingpay/selectediDealPaymenttype/1') ?>" class="bank paymentMethod abn_amro">
												<img src="<?php echo base_url('assets/imgs/extra/abn_amro.png') ?>" alt="ABN AMRO">
												<span>ABN AMRO</span>
											</a>
											<a href="<?php echo base_url('bookingpay/selectediDealPaymenttype/8') ?>" class="bank paymentMethod asn_bank">
												<img src="<?php echo base_url('assets/imgs/extra/asn_bank.png') ?>" alt="ASN Bank">
												<span>ASN Bank</span>
											</a>
											<a href="<?php echo base_url('bookingpay/selectediDealPaymenttype/5080') ?>" class="bank paymentMethod bunq">
												<img src="<?php echo base_url('assets/imgs/extra/bunq.png') ?>" alt="Bunq">
												<span>Bunq</span>
											</a>
											<a href="<?php echo base_url('bookingpay/selectediDealPaymenttype/5082') ?>" class="bank paymentMethod handelsbanken">
												<img src="<?php echo base_url('assets/imgs/extra/handelsbanken.png') ?>" alt="Handelsbanken">
												<span>Handelsbanken</span>
											</a>
											<a href="<?php echo base_url('bookingpay/selectediDealPaymenttype/4') ?>" class="bank paymentMethod ing">
												<img src="<?php echo base_url('assets/imgs/extra/ing.png') ?>" alt="ING">
												<span>ING</span>
											</a>
											<a href="<?php echo base_url('bookingpay/selectediDealPaymenttype/12') ?>" class="bank paymentMethod knab">
												<img src="<?php echo base_url('assets/imgs/extra/knab(1).png') ?>" alt="Knab">
												<span>Knab</span>
											</a>
											<a href="<?php echo base_url('bookingpay/selectediDealPaymenttype/5081') ?>" class="bank paymentMethod moneyou">
												<img src="<?php echo base_url('assets/imgs/extra/moneyou.png') ?>" alt="Moneyou">
												<span>Moneyou</span>
											</a>
											<a href="<?php echo base_url('bookingpay/selectediDealPaymenttype/2') ?>" class="bank paymentMethod rabobank">
												<img src="<?php echo base_url('assets/imgs/extra/rabobank.png') ?>" alt="Rabobank">
												<span>Rabobank</span>
											</a>
											<a href="<?php echo base_url('bookingpay/selectediDealPaymenttype/9') ?>" class="bank paymentMethod regiobank">
												<img src="<?php echo base_url('assets/imgs/extra/regiobank.png') ?>" alt="RegioBank">
												<span>RegioBank</span>
											</a>
											<a href="<?php echo base_url('bookingpay/selectediDealPaymenttype/5') ?>" class="bank paymentMethod sns_bank">
												<img src="<?php echo base_url('assets/imgs/extra/sns_bank.png') ?>" alt="SNS Bank">
												<span>SNS Bank</span>
											</a>
											<a href="<?php echo base_url('bookingpay/selectediDealPaymenttype/10') ?>" class="bank paymentMethod triodos_bank">
												<img src="<?php echo base_url('assets/imgs/extra/triodos_bank.png') ?>" alt="Triodos Bank">
												<span>Triodos Bank</span>
											</a>
											<a href="<?php echo base_url('bookingpay/selectediDealPaymenttype/11') ?>" class="bank paymentMethod van_lanschot">
												<img src="<?php echo base_url('assets/imgs/extra/van_lanschot.png') ?>" alt="van Lanschot">
												<span>van Lanschot</span>
											</a>

											<div class="clearfix"></div>
										</div>
										<!-- /.payment-container -->
									</div>
									<!-- /.method.method-ideal -->

									<div class="method method-card hidden">
										<!-- /.payment-container -->
									</div>
									<!-- /.method.method-card -->

									<div class="method method-paypal hidden">
										<div class="title hidden">
											<a href="<?php echo base_url('bookingpay/selectedPayPalPaymenttype') ?>"><img src="<?php echo base_url('assets/imgs/extra/paypal(1).png') ?>"></a>
										</div>

										<div class="payment-container">
											<form>
												<a href="<?php echo base_url('bookingpay/selectedPayPalPaymenttype') ?>">PayPal</a>
											</form>
										</div>
										<!-- /.payment-container -->
									</div>
									<!-- /.method.method-paypal -->

									<div class="method method-in3 hidden">
										<div class="title hidden">
											<img src="<?php echo base_url('assets/imgs/extra/in3(1).png') ?>">
										</div>

										<div class="payment-container">
											<form>

												<table class="table table-in3">
													<tbody>
													<tr class="font-weight-bold">
														<td class="calendar">
															<span class="month">JAN</span>
															<span class="day">7</span>
														</td>
														<td data-trans="" data-trn-key="Eerste termijn">
															Eerste termijn</td>
														<td>€ 166,62</td>
													</tr>
													<tr>
														<td class="calendar">
															<span class="month">FEB</span>
															<span class="day">14</span>
														</td>
														<td data-trans="" data-trn-key="Tweede termijn">
															Tweede termijn</td>
														<td>€ 166,62</td>
													</tr>
													<tr>
														<td class="calendar">
															<span class="month">MAR</span>
															<span class="day">21</span>
														</td>
														<td data-trans="" data-trn-key="Laatste termijn">Laatste
															termijn</td>
														<td>€ 166,61</td>
													</tr>
													</tbody>
												</table>

												<div class="form-group">
													<label for="in3_geboortedatum" data-trans=""
														   data-trn-key="Geboortedatum">Geboortedatum</label>
													<input type="date" class="form-control" id="in3_geboortedatum" name="birthday"
														   placeholder="Vul geboortedatum in" data-trans="" data-trn-key=""
														   placeholder-trn-key="Vul geboortedatum in">
												</div>
												<div class="form-group">
													<label for="in3_phone" data-trans="" data-trn-key="Telefoonnummer">Telefoonnummer</label>
													<input type="tel" class="form-control" id="in3_phone" name="phone"
														   placeholder="Vul telefoonnummer in" data-trans="" data-trn-key=""
														   placeholder-trn-key="Vul telefoonnummer in">
												</div>

												<button type="submit" class="btn btn-primary" data-trans="" data-trn-key="Kies je bank">Kies
													je bank</button>
											</form>
										</div>
										<!-- /.payment-container -->
									</div>
									<!-- /.method.method-in3 -->

									<div class="method method-afterpay hidden">
										<div class="title hidden">
											<img src="<?php echo base_url('assets/imgs/extra/afterpay(1).png') ?>">
										</div>

										<div class="payment-container">
											<form>
												<div class="form-group">
													<label for="afterpay_geboortedatum" data-trans=""
														   data-trn-key="Geboortedatum">Geboortedatum</label>
													<input type="date" class="form-control" id="afterpay_geboortedatum" name="birthday"
														   placeholder="Vul geboortedatum in" data-trans="" data-trn-key=""
														   placeholder-trn-key="Vul geboortedatum in">
												</div>
												<div class="form-group">
													<label for="afterpay_phone" data-trans=""
														   data-trn-key="Telefoonnummer">Telefoonnummer</label>
													<input type="tel" class="form-control" id="afterpay_phone" name="phone"
														   placeholder="Vul telefoonnummer in" data-trans="" data-trn-key=""
														   placeholder-trn-key="Vul telefoonnummer in">
												</div>

												<button type="submit" class="btn btn-primary" data-trans="" data-trn-key="Afronden met
                                                AfterPay">Afronden met
													AfterPay</button>
											</form>
										</div>
										<!-- /.payment-container -->
									</div>
									<!-- /.method.method-in3 -->

									<div class="method method-bancontact hidden">
										<div class="title hidden">
											<img src="<?php echo base_url('assets/imgs/extra/bancontact(2).png') ?>">
										</div>

										<div class="payment-container">
											<form>
												<div class="form-group">
													<label for="bancontact_cardholder" data-trans=""
														   data-trn-key="Kaarthouder">Kaarthouder</label>
													<input type="text" class="form-control" id="bancontact_cardholder" name="cardholder"
														   placeholder="Naam zoals op de kaart staat" data-trans="" data-trn-key=""
														   placeholder-trn-key="Naam zoals op de kaart staat">
												</div>

												<div class="row">
													<div class="col-md-8">
														<div class="form-group">
															<label for="bancontact_cardnumber" data-trans=""
																   data-trn-key="Kaartnummer">Kaartnummer</label>
															<input type="tel" class="form-control" id="bancontact_cardnumber" name="cardnumber"
																   placeholder="0000 0000 0000 0000">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="bancontact_valid_thru" data-trans=""
																   data-trn-key="Vervaldatum">Vervaldatum</label>
															<input type="text" class="form-control" id="bancontact_valid_thru" name="valid_thru"
																   placeholder="MM / YY" data-trans="" data-trn-key="" placeholder-trn-key="MM / YY">
														</div>
													</div>
												</div>

												<button type="submit" class="btn btn-primary" data-trans=""
														data-trn-key="Betalen"><?php echo $this->language->Line("SELECT_PAYMENT_TYPE-0001", "PAY"); ?></button>

											</form>
										</div>
										<!-- /.payment-container -->
									</div>
									<!-- /.method.method-bancontact -->


									<div class="method method-sepa hidden">
										<div class="title hidden">
											<img src="<?php echo base_url('assets/imgs/extra/sepa.png') ?>">
										</div>

										<div class="payment-container">
											<form>
												SEPA
											</form>
										</div>
										<!-- /.payment-container -->
									</div>
									<!-- /.method.method-sepa -->

									<div class="method method-giropay hidden">
										<div class="title hidden">
											<img src="<?php echo base_url('assets/imgs/extra/giropay(1).png') ?>">
										</div>

										<div class="payment-container">
											<form>
												<div class="form-group">
													<label for="giropay_bank" data-trans="" data-trn-key="Bank">Bank</label>
													<div class="select2-outer">
														<select class="dropdownn select2-hidden-accessible" id="giropay_bank" name="giropay_bank"
																data-select2-id="giropay_bank" tabindex="-1" aria-hidden="true">
															<option data-select2-id="2">10050000 - LBB -
																Berliner Sparkasse</option>
															<option>10090000 - Berliner VB Berlin</option>
															<option>26261693 - Volksbank Solling Hardegsen
															</option>
															<option>59291000 - Unsere Volksbank St. Wendel
															</option>
															<option>10050000 - LBB - Berliner Sparkasse
															</option>
															<option>10090000 - Berliner VB Berlin</option>
															<option>26261693 - Volksbank Solling Hardegsen
															</option>
															<option>59291000 - Unsere Volksbank St. Wendel
															</option>
															<option>10050000 - LBB - Berliner Sparkasse
															</option>
															<option>10090000 - Berliner VB Berlin</option>
															<option>26261693 - Volksbank Solling Hardegsen
															</option>
															<option>59291000 - Unsere Volksbank St. Wendel
															</option>
															<option>10050000 - LBB - Berliner Sparkasse
															</option>
															<option>10090000 - Berliner VB Berlin</option>
															<option>26261693 - Volksbank Solling Hardegsen
															</option>
															<option>59291000 - Unsere Volksbank St. Wendel
															</option>
															<option>10050000 - LBB - Berliner Sparkasse
															</option>
															<option>10090000 - Berliner VB Berlin</option>
															<option>26261693 - Volksbank Solling Hardegsen
															</option>
															<option>59291000 - Unsere Volksbank St. Wendel
															</option>
															<option>10050000 - LBB - Berliner Sparkasse
															</option>
															<option>10090000 - Berliner VB Berlin</option>
															<option>26261693 - Volksbank Solling Hardegsen
															</option>
															<option>59291000 - Unsere Volksbank St. Wendel
															</option>
															<option>10050000 - LBB - Berliner Sparkasse
															</option>
															<option>10090000 - Berliner VB Berlin</option>
															<option>26261693 - Volksbank Solling Hardegsen
															</option>
															<option>59291000 - Unsere Volksbank St. Wendel
															</option>
														</select>
													</div>
												</div>

												<button type="submit" class="btn btn-primary" data-trans=""
														data-trn-key="Betalen"><?php echo $this->language->Line("SELECT_PAYMENT_TYPE-0001", "PAY"); ?></button>
											</form>
										</div>
										<!-- /.payment-container -->
									</div>
									<!-- /.method.method-giropay -->

								</div>
								<!-- /.content-container -->

								<div class="footer">

									<a href="<?php echo base_url('agenda_booking/pay') ?>" class="btn-cancel">
										<i class="fa fa-arrow-left"></i>
										<span data-trans="" data-trn-key="Annuleren">Annuleren</span>
									</a>
									<a href="#" class="btn-back hidden">
										<i class="fa fa-arrow-left"></i>
										<span data-trans="" data-trn-key="Kies andere betaalmethode">Kies andere
                        betaalmethode</span>
									</a>

									<div class="poweredBy" data-trans="" data-trn-key="Betaling veilig verwerkt door pay.nl">Betaling
										veilig
										verwerkt door pay.nl</div>

									<div class="poweredBy delivery" data-trans="" data-trn-key="Levering gegarandeerd door pay.nl">
										Levering
										gegarandeerd door pay.nl</div>
								</div>
								<!-- /.footer -->
							</div>
							<!-- /.page-container -->
						</div>
						<!-- /#area-container -->
					</div>
					<!-- /.col-md-12 -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.container -->
		</div>
	</div>
</div>
<script src="<?php echo base_url('assets/js/extra/select2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/extra/script.min.js') ?>"></script>
