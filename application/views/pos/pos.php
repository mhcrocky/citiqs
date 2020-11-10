<div class='pos-template'>
	<div class="container container-large pos-container">
		<div class="row d-flex">
			<div class="col-lg-8">
				<div class="pos-main">
					<div class="pos-main__top-bar">
						<div class="pos-main__add-item">
							<button class='pos-main__add-new-button'>+ ADD NEW ITEM</button>
						</div>
						<div class="pos-main__search">
							<input type="text" class='form-control'>
							<button class="pos-main__search__button"><i class="fas fa-search"></i></button>
						</div>
					</div>
					<!-- end pos top bar -->

					<div class="pos-main__grid-content">
						<?php
							foreach ($mainProducts as $category => $products) {
								$categoryId = str_replace(['\'', '"', ' ', '*', '/'], '', $category)
							?>
								<div
									class="pos-main__overflow categories"
									id="<?php echo $categoryId; ?>"
									<?php if (array_key_first($mainProducts) !== $category) echo 'style="display:none"'; ?>
								>
									<div class="pos-main__grid">
										<?php foreach ($products as $product) { ?>										
											<div class="pos-item">
												<?php $productDetails = reset($product['productDetails']); ?>
												<div class='pos-item__image'>
													<img src="cocacola.jpg" alt="">
												</div>
												<p class='pos-item__title'><?php echo $productDetails['name']; ?></p>
												<p class='pos-item__price'><?php echo $productDetails['price']; ?>&nbsp;&euro;</p>
											</div>
											<!-- end single pos item-->
										<?php } ?>
									</div>
								</div>
							<?php
							}
						?>
					</div>
	            </div>
				<!-- end pos main-->
				<div class="pos_categories">
					<div class="pos_categories__grid">
						<?php
							foreach ($categories as $index => $category) {
								$categoryId = str_replace(['\'', '"', ' ', '*', '/'], '', $category)
							?>
								<div class="pos_categories__single-item <?php if (array_key_first($categories) === $index) echo 'pos_categories__single-item--active'; ?>">
									<p onclick="showCategory('<?php echo $categoryId; ?>')">
										<?php echo  $category; ?>
									</p>
								</div>
							<?php
							}
						?>
					</div>
				</div>
				<!-- end categories -->
				<div class="pos_categories__footer">
					<a href="#" class='pos_categories__button pos_categories__button--secondary'>Cancel Order</a>
					<a href="#" class='pos_categories__button pos_categories__button--primary'>Hold Order</a>
				</div>
				<!-- end pos footer -->
			</div>
			<div class="col-lg-4">
				<div class="pos-sidebar">
					<div class="pos-checkout">
						<div class="pos-checkout__header">
							<h3>Checkout</h3>
							<div class="pos-checkout-row pos-checkout-row--top">
								<div class="pos-checkout-delete">
								</div>
								<div class="pos-checkout-name">
									<span>Name</span>
								</div>
								<div class="pos-checkout-quantity">
									<span>QTY</span>
								</div>
								<div class="pos-checkout-price">
									<span>Price</span>
								</div>
							</div>
							<!-- end checkout row -->
						</div>
						<!-- end post header -->
						<div class="pos-checkout-list">
							<div class="pos-checkout-row">
								<div class="pos-checkout-delete">
									<i class="fa fa-trash"></i>
								</div>
								<div class="pos-checkout-name">
									<span>Coca Cola</span>
								</div>
								<div class="pos-checkout-quantity">
									<span class="fa-stack">
										<i class="fa fa-plus"></i>
									</span>
									<span class="pos-checkout-quantity__number">1</span>
									<span class="fa-stack">
										<i class="fa fa-minus"></i>
									</span>
								</div>
								<div class="pos-checkout-price">
									<span>Price</span>
								</div>
							</div>
							<!-- end checkout row -->
							<div class="pos-checkout-row">
								<div class="pos-checkout-delete">
									<i class="fa fa-trash"></i>
								</div>
								<div class="pos-checkout-name">
									<span>Coca Cola</span>
								</div>
								<div class="pos-checkout-quantity">
									<span class="fa-stack">
										<i class="fa fa-plus"></i>
									</span>
									<span class="pos-checkout-quantity__number">1</span>
									<span class="fa-stack">
										<i class="fa fa-minus"></i>
									</span>
								</div>
								<div class="pos-checkout-price">
									<span>Price</span>
								</div>
							</div>
							<!-- end checkout row -->
							<div class="pos-checkout-row">
								<div class="pos-checkout-delete">
									<i class="fa fa-trash"></i>
								</div>
								<div class="pos-checkout-name">
									<span>Coca Cola</span>
								</div>
								<div class="pos-checkout-quantity">
									<span class="fa-stack">
										<i class="fa fa-plus"></i>
									</span>
									<span class="pos-checkout-quantity__number">1</span>
									<span class="fa-stack">
										<i class="fa fa-minus"></i>
									</span>
								</div>
								<div class="pos-checkout-price">
									<span>Price</span>
								</div>
							</div>
							<!-- end checkout row -->
							<div class="pos-checkout-row">
								<div class="pos-checkout-delete">
									<i class="fa fa-trash"></i>
								</div>
								<div class="pos-checkout-name">
									<span>Coca Cola</span>
								</div>
								<div class="pos-checkout-quantity">
									<span class="fa-stack">
										<i class="fa fa-plus"></i>
									</span>
									<span class="pos-checkout-quantity__number">1</span>
									<span class="fa-stack">
										<i class="fa fa-minus"></i>
									</span>
								</div>
								<div class="pos-checkout-price">
									<span>Price</span>
								</div>
							</div>
							<!-- end checkout row -->
							<div class="pos-checkout-row">
								<div class="pos-checkout-delete">
									<i class="fa fa-trash"></i>
								</div>
								<div class="pos-checkout-name">
									<span>Coca Cola</span>
								</div>
								<div class="pos-checkout-quantity">
									<span class="fa-stack">
										<i class="fa fa-plus"></i>
									</span>
									<span class="pos-checkout-quantity__number">1</span>
									<span class="fa-stack">
										<i class="fa fa-minus"></i>
									</span>
								</div>
								<div class="pos-checkout-price">
									<span>Price</span>
								</div>
							</div>
							<!-- end checkout row -->
							<div class="pos-checkout-row">
								<div class="pos-checkout-delete">
									<i class="fa fa-trash"></i>
								</div>
								<div class="pos-checkout-name">
									<span>Coca Cola</span>
								</div>
								<div class="pos-checkout-quantity">
									<span class="fa-stack">
										<i class="fa fa-plus"></i>
									</span>
									<span class="pos-checkout-quantity__number">1</span>
									<span class="fa-stack">
										<i class="fa fa-minus"></i>
									</span>
								</div>
								<div class="pos-checkout-price">
									<span>Price</span>
								</div>
							</div>
							<!-- end checkout row -->
							<div class="pos-checkout-row">
								<div class="pos-checkout-delete">
									<i class="fa fa-trash"></i>
								</div>
								<div class="pos-checkout-name">
									<span>Coca Cola</span>
								</div>
								<div class="pos-checkout-quantity">
									<span class="fa-stack">
										<i class="fa fa-plus"></i>
									</span>
									<span class="pos-checkout-quantity__number">1</span>
									<span class="fa-stack">
										<i class="fa fa-minus"></i>
									</span>
								</div>
								<div class="pos-checkout-price">
									<span>Price</span>
								</div>
							</div>
							<!-- end checkout row -->
							<div class="pos-checkout-row">
								<div class="pos-checkout-delete">
									<i class="fa fa-trash"></i>
								</div>
								<div class="pos-checkout-name">
									<span>Coca Cola</span>
								</div>
								<div class="pos-checkout-quantity">
									<span class="fa-stack">
										<i class="fa fa-plus"></i>
									</span>
									<span class="pos-checkout-quantity__number">1</span>
									<span class="fa-stack">
										<i class="fa fa-minus"></i>
									</span>
								</div>
								<div class="pos-checkout-price">
									<span>Price</span>
								</div>
							</div>
							<!-- end checkout row -->
							<div class="pos-checkout-row">
								<div class="pos-checkout-delete">
									<i class="fa fa-trash"></i>
								</div>
								<div class="pos-checkout-name">
									<span>Coca Cola</span>
								</div>
								<div class="pos-checkout-quantity">
									<span class="fa-stack">
										<i class="fa fa-plus"></i>
									</span>
									<span class="pos-checkout-quantity__number">1</span>
									<span class="fa-stack">
										<i class="fa fa-minus"></i>
									</span>
								</div>
								<div class="pos-checkout-price">
									<span>Price</span>
								</div>
							</div>
							<!-- end checkout row -->
							<div class="pos-checkout-row">
								<div class="pos-checkout-delete">
									<i class="fa fa-trash"></i>
								</div>
								<div class="pos-checkout-name">
									<span>Coca Cola</span>
								</div>
								<div class="pos-checkout-quantity">
									<span class="fa-stack">
										<i class="fa fa-plus"></i>
									</span>
									<span class="pos-checkout-quantity__number">1</span>
									<span class="fa-stack">
										<i class="fa fa-minus"></i>
									</span>
								</div>
								<div class="pos-checkout-price">
									<span>Price</span>
								</div>
							</div>
							<!-- end checkout row -->
							<div class="pos-checkout-row">
								<div class="pos-checkout-delete">
									<i class="fa fa-trash"></i>
								</div>
								<div class="pos-checkout-name">
									<span>Coca Cola</span>
								</div>
								<div class="pos-checkout-quantity">
									<span class="fa-stack">
										<i class="fa fa-plus"></i>
									</span>
									<span class="pos-checkout-quantity__number">1</span>
									<span class="fa-stack">
										<i class="fa fa-minus"></i>
									</span>
								</div>
								<div class="pos-checkout-price">
									<span>Price</span>
								</div>
							</div>
							<!-- end checkout row -->
							<div class="pos-checkout-row">
								<div class="pos-checkout-delete">
									<i class="fa fa-trash"></i>
								</div>
								<div class="pos-checkout-name">
									<span>Coca Cola</span>
								</div>
								<div class="pos-checkout-quantity">
									<span class="fa-stack">
										<i class="fa fa-plus"></i>
									</span>
									<span class="pos-checkout-quantity__number">1</span>
									<span class="fa-stack">
										<i class="fa fa-minus"></i>
									</span>
								</div>
								<div class="pos-checkout-price">
									<span>Price</span>
								</div>
							</div>
							<!-- end checkout row -->
							<div class="pos-checkout__summary">
								<div class="pos-checkout__summary__row  pos-checkout__summary__discount">
									<div class="pos-checkout__summary__label">
									<span>Discount</span>
									</div>
									<div class="pos-checkout__summary__ammout">
										<span>20%</span>
									</div>
								</div>
								<!-- end row -->
								<div class="pos-checkout__summary__row">
									<div class="pos-checkout__summary__label">
									<span>Sub Total</span>
									</div>
									<div class="pos-checkout__summary__ammout">
										<span>$34.33</span>
									</div>
								</div>
								<!-- end row -->
								<div class="pos-checkout__summary__row">
									<div class="pos-checkout__summary__label">
									<span>Tax</span>
									<span class='pos-checkout__summary__tax'>1.5%</span>
									</div>
									<div class="pos-checkout__summary__ammout">
										<span>$3.33</span>
									</div>
								</div>
								<!-- end row -->
								
							</div>
							<!-- end summary -->
						</div>
						<!-- end checout list -->
					</div>
				</div>
				<a href="#" class='pos-checkout__button'>Pay <span>(10.00$)</span></a>
			</div>
			<!-- end pos sidebar -->
		</div>
		<!-- end row item grid -->
	</div>
</div>